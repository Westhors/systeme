<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\InventoryLogResource;
use App\Interfaces\InventoryRepositoryInterface;
use App\Models\InventoryLog;
use App\Models\Warehouse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InventoryLogController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(InventoryRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $Inventory = InventoryLogResource::collection($this->crudRepository->all(
                ['warehouse', 'product'],
                [],
                ['*']
            ));
            return $Inventory->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

        public function inventoryStore(Request $request)
    {
        DB::beginTransaction();

        try {

            $warehouse = Warehouse::findOrFail($request->warehouse_id);

            foreach ($request->products as $item) {

                $productId     = $item['product_id'];
                $countedStock  = $item['counted_stock'];

                // المنتج في المخزن
                $product = $warehouse->products()
                    ->where('products.id', $productId)
                    ->withPivot('stock')
                    ->first();

                if (!$product) {
                    continue; // أو throw لو تحب
                }

                $systemStock = $product->pivot->stock;
                $difference  = $countedStock - $systemStock;

                // تحديث الكمية للجرد
                $warehouse->products()->updateExistingPivot(
                    $productId,
                    [
                        'stock' => $countedStock
                    ]
                );

                // (اختياري) سجل حركة الجرد
                InventoryLog::create([
                    'warehouse_id'   => $warehouse->id,
                    'product_id'     => $productId,
                    'system_stock'   => $systemStock,
                    'counted_stock'  => $countedStock,
                    'difference'     => $difference,
                    'note'           => $request->note,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'تم تنفيذ الجرد بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
