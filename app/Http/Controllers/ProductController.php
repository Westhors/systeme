<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Imports\ProductImport;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\InvoiceItem;
use App\Models\ProductUnit;
use App\Models\ProductUnitColor;
use App\Models\ProductWarehouse;

class ProductController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(ProductRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $product = ProductResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $product->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

   public function store(ProductRequest $request)
{
    DB::beginTransaction();

    try {
        $data = $request->validated();

        $product = $this->crudRepository->create(
            collect($data)->except('units')->toArray()
        );

        if (!empty($data['units']) && is_array($data['units'])) {
            // إعادة تنظيم الوحدات
            $organizedUnits = [];

            foreach ($data['units'] as $unitData) {
                $unitId = $unitData['unit_id'];

                if (!isset($organizedUnits[$unitId])) {
                    // أول مرة نشوف فيها الـ unit_id
                    $organizedUnits[$unitId] = [
                        'unit_id' => $unitId,
                        'cost_price' => $unitData['cost_price'],
                        'sell_price' => $unitData['sell_price'],
                        'barcode' => $unitData['barcode'] ?? null,
                        'colors' => []
                    ];
                }

                // إضافة الألوان
                if (!empty($unitData['colors'])) {
                    foreach ($unitData['colors'] as $colorData) {
                        $organizedUnits[$unitId]['colors'][] = $colorData;
                    }
                }
            }

            // إدخال الوحدات المنظمة
            foreach ($organizedUnits as $unitData) {
                $productUnit = $product->units()->create([
                    'unit_id'     => $unitData['unit_id'],
                    'cost_price'  => $unitData['cost_price'],
                    'sell_price'  => $unitData['sell_price'],
                    'barcode'     => $unitData['barcode'] ?? null,
                ]);

                if (!empty($unitData['colors'])) {
                    foreach ($unitData['colors'] as $colorData) {
                        $productUnit->colors()->create([
                            'color_id' => $colorData['color_id'],
                            'stock'    => $colorData['stock'],
                        ]);
                    }
                }
            }
        }

        if (request('image') !== null) {
            $this->crudRepository->AddMediaCollection('image', $product);
        }

        DB::commit();

        return new ProductResource($product->load('units.colors'));

    } catch (\Exception $e) {
        DB::rollBack();
        return JsonResponse::respondError($e->getMessage());
    }
}



    public function show(Product $product): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new ProductResource($product));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



public function update(ProductRequest $request, Product $product)
{
    DB::beginTransaction();

    try {
        $data = $request->validated();

        $this->crudRepository->update(
            collect($data)->except('units')->toArray(),
            $product->id
        );

        if (!empty($data['units']) && is_array($data['units'])) {
            // تنظيم الوحدات وإزالة الألوان المكررة
            $organizedUnits = [];

            foreach ($data['units'] as $unitData) {
                $unitId = $unitData['unit_id'];

                if (!isset($organizedUnits[$unitId])) {
                    $organizedUnits[$unitId] = [
                        'unit_id' => $unitId,
                        'cost_price' => $unitData['cost_price'],
                        'sell_price' => $unitData['sell_price'],
                        'barcode' => $unitData['barcode'] ?? null,
                        'colors' => []
                    ];
                }

                // إزالة الألوان المكررة
                if (!empty($unitData['colors'])) {
                    foreach ($unitData['colors'] as $colorData) {
                        $colorExists = false;
                        foreach ($organizedUnits[$unitId]['colors'] as $existingColor) {
                            if ($existingColor['color_id'] == $colorData['color_id']) {
                                $colorExists = true;
                                break;
                            }
                        }

                        if (!$colorExists) {
                            $organizedUnits[$unitId]['colors'][] = $colorData;
                        }
                    }
                }
            }

            // الحصول على الـ unit_ids الموجودة حالياً
            $existingUnitIds = $product->units()->pluck('unit_id')->toArray();
            $newUnitIds = array_keys($organizedUnits);

            // حذف الوحدات التي لم تعد موجودة
            $unitsToDelete = array_diff($existingUnitIds, $newUnitIds);
            if (!empty($unitsToDelete)) {
                $product->units()->whereIn('unit_id', $unitsToDelete)->each(function ($unit) {
                    $unit->colors()->delete();
                    $unit->delete();
                });
            }

            // تحديث أو إضافة الوحدات الجديدة
            foreach ($organizedUnits as $unitId => $unitData) {
                // ✅ استخدام updateOrCreate بدلاً من create
                $productUnit = $product->units()->updateOrCreate(
                    ['unit_id' => $unitId],
                    [
                        'cost_price' => $unitData['cost_price'],
                        'sell_price' => $unitData['sell_price'],
                        'barcode' => $unitData['barcode'] ?? null,
                    ]
                );

                // حذف الألوان القديمة لهذه الوحدة
                $productUnit->colors()->delete();

                // إضافة الألوان الجديدة
                if (!empty($unitData['colors'])) {
                    foreach ($unitData['colors'] as $colorData) {
                        $productUnit->colors()->create([
                            'color_id' => $colorData['color_id'],
                            'stock'    => $colorData['stock'],
                        ]);
                    }
                }
            }
        } else {
            // إذا ما فيش units، احذف كل الحجات القديمة
            $product->units()->each(function ($unit) {
                $unit->colors()->delete();
                $unit->delete();
            });
        }

        DB::commit();

        return JsonResponse::respondSuccess(
            trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY),
            new ProductResource($product->load('units.colors'))
        );

    } catch (\Exception $e) {
        DB::rollBack();
        return JsonResponse::respondError($e->getMessage());
    }
}


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('products', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Product::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Product::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function searchByProductName(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        try {
            $products = Product::with(['category'])
                ->where('name', 'LIKE', '%' . $request->query('name') . '%')
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status'  => false,
                    'message' => "لا توجد منتجات باسم {$request->query('name')}"
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'تم العثور على المنتجات',
                'data'    => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء البحث',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

  public function getProductsByBranch(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $products = Product::with('category')
            ->when($data['branch_id'] ?? null, function ($query) use ($data) {
                $query->whereHas('purchaseInvoiceItems.invoice', function ($q) use ($data) {
                    $q->where('branch_id', $data['branch_id']);
                });
            })
            ->when($data['category_id'] ?? null, function ($query) use ($data) {
                $query->where('category_id', $data['category_id']);
            })
            ->distinct()
            ->get();

        return ProductResource::collection($products);
    }



  public function getRevenueReport(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $branch_id = $data['branch_id'] ?? null;

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfMonth();

        // =========================
        // Query الفواتير
        // =========================
        $itemsQuery = InvoiceItem::with([
            'invoice.branch',
            'product.category'
        ]);

        if ($branch_id) {
            $itemsQuery->whereHas('invoice', function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            });
        }

        $items = $itemsQuery->get();

        // =========================
        // الإيرادات حسب الفترة
        // =========================
        $todayRevenue = $items->filter(function ($item) use ($today) {
            return $item->invoice &&
                $item->invoice->created_at >= $today;
        })->sum('total');

        $monthRevenue = $items->filter(function ($item) use ($startOfMonth) {
            return $item->invoice &&
                $item->invoice->created_at >= $startOfMonth;
        })->sum('total');

        $threeMonthsRevenue = $items->filter(function ($item) use ($threeMonthsAgo) {
            return $item->invoice &&
                $item->invoice->created_at >= $threeMonthsAgo;
        })->sum('total');

        // =========================
        // كل التصنيفات + الكميات
        // =========================
        $categorySales = $items
            ->filter(fn($item) => $item->product)
            ->groupBy(function ($item) {
                return optional($item->product)->category_id;
            })
            ->map(function ($group) {
                return $group->sum('quantity');
            });

        $topCategories = Category::query()
            ->select('id', 'name')
            ->get()
            ->map(function ($category) use ($categorySales) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name, // اسم التصنيف
                    'total_quantity' => $categorySales[$category->id] ?? 0
                ];
            })
            ->sortByDesc('total_quantity')
            ->values();

        // =========================
        // الإيرادات لكل فرع
        // =========================
        $branchRevenues = $items
            ->filter(fn($item) => $item->invoice)
            ->groupBy(function ($item) {
                return $item->invoice->branch_id;
            })
            ->map(function ($group) {
                $branch = optional($group->first()->invoice->branch);

                return [
                    'branch_id' => $branch->id ?? null,
                    'branch_name' => $branch->name ?? 'N/A',
                    'revenue' => $group->sum('total')
                ];
            })
            ->values();

        return response()->json([
            'today_revenue' => $todayRevenue,
            'month_revenue' => $monthRevenue,
            'three_months_revenue' => $threeMonthsRevenue,
            'top_categories' => $topCategories,
            'branch_revenues' => $branchRevenues
        ]);
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {

            Excel::import(new ProductImport, $request->file('file'));

            return response()->json([
                'status' => true,
                'message' => 'The products were imported successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred during import',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function addStock(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.warehouse_id' => 'required|exists:warehouses,id',
            'items.*.unit_id'      => 'nullable|exists:units,id',
            'items.*.color_id'     => 'nullable|exists:colors,id',
            'items.*.stock'        => 'required|numeric|min:1',
            'items.*.cost'         => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            foreach ($request->items as $item) {

                // 1️⃣ المنتج
                $product = Product::findOrFail($item['product_id']);
                $product->increment('stock', $item['stock']);
                $product->cost = $item['cost']; // 👈 إضافة cost
                $product->beginning_balance = 1;
                $product->save();

                // 2️⃣ warehouse
                $productWarehouse = ProductWarehouse::firstOrCreate([
                    'product_id'   => $item['product_id'],
                    'warehouse_id' => $item['warehouse_id'],
                ]);

                $productWarehouse->increment('stock', $item['stock']);

                // 3️⃣ unit
                $productUnit = ProductUnit::firstOrCreate([
                    'product_id' => $item['product_id'],
                    'unit_id'    => $item['unit_id'],
                ]);

                // 4️⃣ color
                $unitColor = ProductUnitColor::firstOrCreate([
                    'product_unit_id' => $productUnit->id,
                    'color_id'        => $item['color_id'],
                ]);

                $unitColor->increment('stock', $item['stock']);
            }

            DB::commit();

            return response()->json([
                'message' => 'Stock added successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
