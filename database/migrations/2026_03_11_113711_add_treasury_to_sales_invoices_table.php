<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_invoices', function (Blueprint $table) {
        $table->foreignId('treasury_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->dropForeign(['treasury_id']);
            $table->dropColumn(['treasury_id']);
        });
    }
};
