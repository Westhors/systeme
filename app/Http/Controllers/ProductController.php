<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Imports\ProductImport;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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


    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {

            Excel::import(new ProductImport, $request->file('file'));

            return response()->json([
                'status' => true,
                'message' => 'تم استيراد المنتجات بنجاح'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء الاستيراد',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
