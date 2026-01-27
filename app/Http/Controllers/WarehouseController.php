<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\WarehouseRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WarehouseResource;
use App\Interfaces\WarehouseRepositoryInterface;
use App\Models\InventoryLog;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(WarehouseRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $warehouse = WarehouseResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $warehouse->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(WarehouseRequest $request)
    {
        try {
            $warehouse = $this->crudRepository->create($request->validated());
            return new WarehouseResource($warehouse);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(Warehouse $warehouse): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new WarehouseResource($warehouse));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        try {
            $this->crudRepository->update($request->validated(), $warehouse->id);
            activity()->performedOn($warehouse)->withProperties(['attributes' => $warehouse])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('warehouses', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Warehouse::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Warehouse::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function warehouseProducts(Warehouse $warehouse)
    {
        $products = $warehouse->products()
            ->withPivot('stock')
            ->wherePivot('stock', '>', 0)
            ->get();

        return ProductResource::collection($products);
    }

    public function transfer(Request $request)
    {
        DB::beginTransaction();

        try {

            if ($request->from_warehouse_id == $request->to_warehouse_id) {
                return response()->json([
                    'error' => 'لا يمكن التحويل لنفس المخزن'
                ], 422);
            }

            $fromWarehouse = Warehouse::findOrFail($request->from_warehouse_id);
            $toWarehouse   = Warehouse::findOrFail($request->to_warehouse_id);

            foreach ($request->products as $item) {

                $productId = $item['product_id'];
                $qty       = $item['quantity'];

                // 🔎 تأكد إن المنتج موجود في مخزن المصدر
                $productInFromWarehouse = $fromWarehouse->products()
                    ->where('products.id', $productId)
                    ->withPivot('stock')
                    ->first();

                if (!$productInFromWarehouse) {
                    throw new \Exception('المنتج غير موجود في مخزن المصدر');
                }

                $fromPivot = $productInFromWarehouse->pivot;

                // ❌ كمية غير كافية
                if ($fromPivot->stock < $qty) {
                    throw new \Exception('الكمية غير متاحة للتحويل');
                }

                // 1️⃣ خصم الكمية من مخزن المصدر
                $fromWarehouse->products()->updateExistingPivot(
                    $productId,
                    [
                        'stock' => $fromPivot->stock - $qty
                    ]
                );

                // 🔎 هل المنتج موجود في مخزن الهدف؟
                $productInToWarehouse = $toWarehouse->products()
                    ->where('products.id', $productId)
                    ->withPivot('stock')
                    ->first();

                if ($productInToWarehouse) {
                    // 2️⃣ المنتج موجود → زوّد الكمية
                    $toWarehouse->products()->updateExistingPivot(
                        $productId,
                        [
                            'stock' => $productInToWarehouse->pivot->stock + $qty
                        ]
                    );
                } else {
                    // 3️⃣ المنتج مش موجود → attach جديد
                    $toWarehouse->products()->attach(
                        $productId,
                        [
                            'stock' => $qty
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'تم تحويل المنتجات بنجاح'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }







}
