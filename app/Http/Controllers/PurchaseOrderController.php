<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function store(PurchaseOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $orderNumber = 'PO-' . now()->format('Ymd') . '-' . rand(1000,9999);

            $total = collect($request->items)->sum(function($item){
                return $item['quantity'] * $item['unit_cost'];
            });

            $order = PurchaseOrder::create([
                'order_number' => $orderNumber,
                'supplier_id' => $request->supplier_id,
                'expected_delivery' => $request->expected_delivery,
                'notes' => $request->notes,
                'total_amount' => $total,
            ]);

            foreach($request->items as $item){
                PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total' => $item['quantity'] * $item['unit_cost'],
                ]);
            }

            DB::commit();

            return new PurchaseOrderResource($order->load('items.product', 'supplier'));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function index(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = PurchaseOrder::with([
                'supplier',
                'items.product',
            ]);

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['order_number'])) {
                $query->where('order_number', 'like', '%' . $filters['order_number'] . '%');
            }

            if (!empty($filters['supplier_id'])) {
                $query->where('supplier_id', $filters['supplier_id']);
            }

            if (!empty($filters['expected_delivery'])) {
                $query->whereDate('expected_delivery', $filters['expected_delivery']);
            }

            if (!empty($filters['min_total'])) {
                $query->where('total_amount', '>=', $filters['min_total']);
            }

            if (!empty($filters['max_total'])) {
                $query->where('total_amount', '<=', $filters['max_total']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            // =========================
            // SORT
            // =========================
            $query->orderBy($orderBy, $orderByDirection);

            // =========================
            // PAGINATION MODE
            // =========================
            if ($paginate) {
                $orders = $query->paginate($perPage);

                return response()->json([
                    'data' => PurchaseOrderResource::collection($orders->items()),

                    'links' => [
                        'first' => $orders->url(1),
                        'last' => $orders->url($orders->lastPage()),
                        'prev' => $orders->previousPageUrl(),
                        'next' => $orders->nextPageUrl(),
                    ],

                    'meta' => [
                        'current_page' => $orders->currentPage(),
                        'from' => $orders->firstItem(),
                        'last_page' => $orders->lastPage(),
                        'path' => $orders->path(),
                        'per_page' => $orders->perPage(),
                        'to' => $orders->lastItem(),
                        'total' => $orders->total(),
                    ],

                    'result' => 'Success',
                    'message' => 'Purchase orders fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================
            $orders = $query->get();

            return response()->json([
                'data' => PurchaseOrderResource::collection($orders),
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Purchase orders fetched successfully',
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $order = PurchaseOrder::with([
                'supplier',
                'items.product',
            ])->findOrFail($id);

            return response()->json([
                'data' => new PurchaseOrderResource($order),
                'result' => 'Success',
                'message' => 'Purchase order fetched successfully',
                'status' => 200,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'result' => 'Error',
                'message' => 'Purchase order not found',
                'status' => 404,
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

}
