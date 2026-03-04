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
        try {
            // 1️⃣ إيقاف الـ foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 2️⃣ مسح البيانات
            Product::truncate();
            Category::truncate();
            Customer::truncate();
            Supplier::truncate();
            SalesInvoice::truncate();
            PurchaseInvoice::truncate();

            // 3️⃣ تشغيل الـ foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json([
                'status' => true,
                'message' => 'تم مسح جميع البيانات بنجاح'
            ]);

        } catch (\Exception $e) {

            // لو حصل خطأ هنا مش محتاج rollback لأنه خارج transaction
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء المسح',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}