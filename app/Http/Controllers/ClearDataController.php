<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;

class ClearDataController extends Controller
{
    public function clearAll(Request $request)
    {
        DB::beginTransaction();

        try {
            // حذف الأصناف
            Product::truncate();

            // حذف التصنيفات
            Category::truncate();

            // حذف العملاء
            Customer::truncate();

            // حذف الموردين
            Supplier::truncate();

            // حذف فواتير المبيعات
            SalesInvoice::truncate();

            // حذف فواتير المشتريات
            PurchaseInvoice::truncate();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'تم مسح جميع البيانات بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء المسح',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
