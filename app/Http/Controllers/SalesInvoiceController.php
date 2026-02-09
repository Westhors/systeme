<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesInvoiceRequest;
use App\Http\Resources\SalesInvoiceResource;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends Controller
{
    public function store(StoreSalesInvoiceRequest $request)
    {
        DB::beginTransaction();

        try {

            // Generate Invoice Number
            $invoiceNumber = 'SI-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            // Calculate total
            $total = collect($request->items)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            // Create invoice
            $invoice = SalesInvoice::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $request->customer_id,
                'sales_representative_id' => $request->sales_representative_id,
                'branch_id' => $request->branch_id,
                'warehouse_id' => $request->warehouse_id,
                'currency_id' => $request->currency_id,
                'tax_id' => $request->tax_id,
                'payment_method' => $request->payment_method,
                'due_date' => $request->due_date,
                'note' => $request->note,
                'total_amount' => $total,
            ]);

            // Create items
            foreach ($request->items as $item) {
                SalesInvoiceItem::create([
                    'sales_invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            DB::commit();

            return new SalesInvoiceResource(
                $invoice->load('items.product', 'customer', 'salesRepresentative', 'branch', 'warehouse', 'currency', 'tax')
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function invoiceIndex(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = SalesInvoice::with([
                'customer',
                'salesRepresentative',
                'branch',
                'warehouse',
                'currency',
                'tax',
            ]);

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['invoice_number'])) {
                $query->where('invoice_number', 'like', '%' . $filters['invoice_number'] . '%');
            }

            if (!empty($filters['customer_id'])) {
                $query->where('customer_id', $filters['customer_id']);
            }

            if (!empty($filters['sales_representative_id'])) {
                $query->where('sales_representative_id', $filters['sales_representative_id']);
            }

            if (!empty($filters['branch_id'])) {
                $query->where('branch_id', $filters['branch_id']);
            }

            if (!empty($filters['warehouse_id'])) {
                $query->where('warehouse_id', $filters['warehouse_id']);
            }

            if (!empty($filters['payment_method'])) {
                $query->where('payment_method', $filters['payment_method']);
            }

            if (!empty($filters['currency_id'])) {
                $query->where('currency_id', $filters['currency_id']);
            }

            if (!empty($filters['tax_id'])) {
                $query->where('tax_id', $filters['tax_id']);
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
                $invoices = $query->paginate($perPage);

                return response()->json([
                    'data' => SalesInvoiceResource::collection($invoices->items()),

                    'links' => [
                        'first' => $invoices->url(1),
                        'last' => $invoices->url($invoices->lastPage()),
                        'prev' => $invoices->previousPageUrl(),
                        'next' => $invoices->nextPageUrl(),
                    ],

                    'meta' => [
                        'current_page' => $invoices->currentPage(),
                        'from' => $invoices->firstItem(),
                        'last_page' => $invoices->lastPage(),
                        'path' => $invoices->path(),
                        'per_page' => $invoices->perPage(),
                        'to' => $invoices->lastItem(),
                        'total' => $invoices->total(),
                    ],

                    'result' => 'Success',
                    'message' => 'Sales invoices fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================
            $invoices = $query->get();

            return response()->json([
                'data' => SalesInvoiceResource::collection($invoices),
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Sales invoices fetched successfully',
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

            $invoice = SalesInvoice::with([
                'items.product',
                'customer',
                'salesRepresentative',
                'branch',
                'warehouse',
                'currency',
                'tax',
            ])->findOrFail($id);

            return response()->json([
                'data' => new SalesInvoiceResource($invoice),
                'result' => 'Success',
                'message' => 'Sales invoice fetched successfully',
                'status' => 200,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'result' => 'Error',
                'message' => 'Sales invoice not found',
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
