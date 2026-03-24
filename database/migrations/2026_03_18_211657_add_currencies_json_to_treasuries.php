<?php
// database/migrations/xxxx_convert_treasuries_to_multi_currency.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. الأول نضيف العمود الجديد
        Schema::table('treasuries', function (Blueprint $table) {
            $table->json('currencies')->nullable()->after('notes');
        });

        // 2. نحول البيانات القديمة للـ JSON
        DB::table('treasuries')->chunkById(100, function ($treasuries) {
            foreach ($treasuries as $treasury) {
                $currencies = [
                    [
                        'currency_id' => $treasury->currency ?? 1, // لو currency_id مش موجود، استخدم 1
                        'balance' => $treasury->balance ?? 0,
                        'is_main' => true,
                    ]
                ];

                DB::table('treasuries')
                    ->where('id', $treasury->id)
                    ->update(['currencies' => json_encode($currencies)]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            $table->dropColumn('currencies');
        });
    }
};
