<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseInvoiceRequest;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\PurchaseInvoiceResource;
use App\Http\Resources\TransferResource;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    public function store(PurchaseInvoiceRequest $request)
    {
        DB::beginTransaction();

        try {
            // Generate invoice number
            $invoiceNumber = 'PI-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            // حساب المجاميع
            $subtotal = collect($request->items)->sum(fn($item) => $item['quantity'] * $item['price']);
            $discountTotal = collect($request->items)->sum(fn($item) => $item['discount'] ?? 0);
            $taxTotal = collect($request->items)->sum(fn($item) => $item['tax'] ?? 0);
            $total = $subtotal - $discountTotal + $taxTotal;

            // إنشاء الفاتورة
            $invoice = PurchaseInvoice::create([
                'invoice_number' => $invoiceNumber,
                'supplier_id' => $request->supplier_id,
                'branch_id' => $request->branch_id,
                'warehouse_id' => $request->warehouse_id,
                'currency_id' => $request->currency_id,
                'tax_id' => $request->tax_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'payment_method' => $request->payment_method,
                'note' => $request->note,

                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'tax_total' => $taxTotal,
                'total_amount' => $total,
            ]);

            // إضافة الأصناف
            foreach ($request->items as $item) {
                PurchaseInvoiceItem::create([
                    'purchase_invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                    'tax' => $item['tax'] ?? 0,
                    'total' => ($item['quantity'] * $item['price']) - ($item['discount'] ?? 0) + ($item['tax'] ?? 0),
                ]);
            }

            DB::commit();

            return new PurchaseInvoiceResource(
                $invoice->load('supplier', 'branch', 'warehouse', 'currency', 'tax', 'items.product')
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create purchase invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function treasuryMovements(Request $request)
{
    try {
        $filters   = $request->input('filters', []);
        $orderBy   = $request->input('orderBy', 'id');
        $orderDir  = $request->input('orderByDirection', 'desc');
        $perPage   = $request->input('perPage', 10);
        $paginate  = $request->boolean('paginate', true);

        $query = Transfer::with([
            'fromTreasury',
            'toTreasury',
            'fromBank',
            'toBank'
        ]);

        // ================= FILTERS =================
        if (!empty($filters['treasury_id'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('from_treasury_id', $filters['treasury_id'])
                  ->orWhere('to_treasury_id', $filters['treasury_id']);
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // ================= SORT =================
        $query->orderBy($orderBy, $orderDir);

        // ================= PAGINATION =================
        if ($paginate) {
            $rows = $query->paginate($perPage);

            return response()->json([
                'data' => TransferResource::collection($rows->items()),

                'links' => [
                    'first' => $rows->url(1),
                    'last'  => $rows->url($rows->lastPage()),
                    'prev'  => $rows->previousPageUrl(),
                    'next'  => $rows->nextPageUrl(),
                ],

                'meta' => [
                    'current_page' => $rows->currentPage(),
                    'from'         => $rows->firstItem(),
                    'last_page'    => $rows->lastPage(),
                    'per_page'     => $rows->perPage(),
                    'total'        => $rows->total(),
                ],

                'result'  => 'Success',
                'message' => 'Treasury movements fetched successfully',
                'status'  => 200,
            ]);
        }

        // ================= NON PAGINATED =================
        $rows = $query->get();

        return response()->json([
            'data' => TransferResource::collection($rows),
            'result'  => 'Success',
            'message' => 'Treasury movements fetched successfully',
            'status'  => 200,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'result' => 'Error',
            'message' => $e->getMessage(),
            'status' => 500,
        ]);
    }
}

    public function show($id)
    {
        try {
            $invoice = PurchaseInvoice::with([
                'supplier',
                'branch',
                'warehouse',
                'currency',
                'tax',
                'items.product'
            ])->findOrFail($id);

            return response()->json([
                'data' => new PurchaseInvoiceResource($invoice),
                'result' => 'Success',
                'message' => 'Purchase invoice fetched successfully',
                'status' => 200,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'result' => 'Error',
                'message' => 'Purchase invoice not found',
                'status' => 404,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ]);
        }
    }
}
