<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            if ($request->hasFile('image')) {
                $this->crudRepository->AddMediaCollection('image', $product);
            }

            // ✅ تأكد إن units موجودة ومش فاضية
            if (!empty($data['units']) && is_array($data['units'])) {

                foreach ($data['units'] as $unitData) {

                    $productUnit = $product->units()->create([
                        'unit_id'     => $unitData['unit_id'],
                        'cost_price'  => $unitData['cost_price'],
                        'sell_price'  => $unitData['sell_price'],
                        'barcode'     => $unitData['barcode'] ?? null,
                    ]);

                    // ✅ تأكد إن colors موجودة
                    if (!empty($unitData['colors']) && is_array($unitData['colors'])) {
                        foreach ($unitData['colors'] as $colorData) {
                            $productUnit->colors()->create([
                                'color_id' => $colorData['color_id'],
                                'stock'    => $colorData['stock'],
                            ]);
                        }
                    }
                }
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

            if ($request->hasFile('image')) {
                $network = Product::find($product->id);
                $this->crudRepository->AddMediaCollection('image', $network);
            }

            // حذف القديم
            $product->units()->each(function ($unit) {
                $unit->colors()->delete();
                $unit->delete();
            });

            // ✅ تأكد إن units موجودة
            if (!empty($data['units']) && is_array($data['units'])) {

                foreach ($data['units'] as $unitData) {

                    $productUnit = $product->units()->create([
                        'unit_id'     => $unitData['unit_id'],
                        'cost_price'  => $unitData['cost_price'],
                        'sell_price'  => $unitData['sell_price'],
                        'barcode'     => $unitData['barcode'] ?? null,
                    ]);

                    if (!empty($unitData['colors']) && is_array($unitData['colors'])) {
                        foreach ($unitData['colors'] as $colorData) {
                            $productUnit->colors()->create([
                                'color_id' => $colorData['color_id'],
                                'stock'    => $colorData['stock'],
                            ]);
                        }
                    }
                }
            }

            activity()
                ->performedOn($product)
                ->withProperties(['attributes' => $data])
                ->log('update');

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

}
