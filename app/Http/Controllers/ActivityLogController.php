<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['causer']);

        if ($request->model) {
            $query->where('subject_type', $request->model);
        }

        if ($request->event) {
            $query->where('event', $request->event);
        }

        $logs = $query->latest()->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $logs
        ]);
    }

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
