<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::table('product_unit_colors', function (Blueprint $table) {
                $table->dropUnique(['product_unit_id', 'color_id']);
            });
        } catch (\Exception $e) {
            // ignore if already dropped
        }
    }
};
