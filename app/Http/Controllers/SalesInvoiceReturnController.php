<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesInvoiceReturnRequest;
use App\Http\Resources\SalesInvoiceReturnResource;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceReturn;
use App\Models\SalesInvoiceReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceReturnController extends Controller
{

public function index(Request $request)
{
    try {
        $filters = $request->input('filters', []);
        $orderBy = $request->input('orderBy', 'id');
        $orderByDirection = $request->input('orderByDirection', 'desc');
        $perPage = $request->input('perPage', 10);
        $paginate = $request->boolean('paginate', true);

        $query = SalesInvoiceReturn::with([
            'invoice.customer',
            'items.product',
        ]);

        // =========================
        // FILTERS
        // =========================

        if (!empty($filters['return_number'])) {
            $query->where('return_number', 'like', '%' . $filters['return_number'] . '%');
        }

        if (!empty($filters['invoice_number'])) {
            $query->whereHas('invoice', function ($q) use ($filters) {
                $q->where('invoice_number', 'like', '%' . $filters['invoice_number'] . '%');
            });
        }

        if (!empty($filters['sales_invoice_id'])) {
            $query->where('sales_invoice_id', $filters['sales_invoice_id']);
        }

        if (!empty($filters['customer_id'])) {
            $query->whereHas('invoice', function ($q) use ($filters) {
                $q->where('customer_id', $filters['customer_id']);
            });
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

        if (!empty($filters['product_id'])) {
            $query->whereHas('items', function ($q) use ($filters) {
                $q->where('product_id', $filters['product_id']);
            });
        }

        // =========================
        // SORT
        // =========================
        $query->orderBy($orderBy, $orderByDirection);

        // =========================
        // PAGINATION
        // =========================
        if ($paginate) {
            $returns = $query->paginate($perPage);

            return response()->json([
                'data' => SalesInvoiceReturnResource::collection($returns->items()),

                'links' => [
                    'first' => $returns->url(1),
                    'last' => $returns->url($returns->lastPage()),
                    'prev' => $returns->previousPageUrl(),
                    'next' => $returns->nextPageUrl(),
                ],

                'meta' => [
                    'current_page' => $returns->currentPage(),
                    'from' => $returns->firstItem(),
                    'last_page' => $returns->lastPage(),
                    'path' => $returns->path(),
                    'per_page' => $returns->perPage(),
                    'to' => $returns->lastItem(),
                    'total' => $returns->total(),
                ],

                'result' => 'Success',
                'message' => 'Sales returns fetched successfully',
                'status' => 200,
            ]);
        }

        $returns = $query->get();

        return response()->json([
            'data' => SalesInvoiceReturnResource::collection($returns),
            'links' => null,
            'meta' => null,
            'result' => 'Success',
            'message' => 'Sales returns fetched successfully',
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


    public function storeReturn(StoreSalesInvoiceReturnRequest $request)
    {
        DB::beginTransaction();

        try {
            $invoice = SalesInvoice::findOrFail($request->sales_invoice_id);

            $returnNumber = 'SR-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            $totalReturn = collect($request->items)->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });

            $return = SalesInvoiceReturn::create([
                'sales_invoice_id' => $invoice->id,
                'return_number' => $returnNumber,
                'return_method' => $request->return_method,
                'total_amount' => $totalReturn,
                'note' => $request->note,
            ]);

            foreach ($request->items as $item) {
                SalesInvoiceReturnItem::create([
                    'sales_invoice_return_id' => $return->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                    'reason' => $item['reason'],
                ]);

                // تحديث المخزون
                $product = Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'data' => $return->load('items.product', 'invoice.customer'),
                'result' => 'Success',
                'message' => 'Sales return created successfully',
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

}
