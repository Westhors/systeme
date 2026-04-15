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
        Schema::table('product_unit_colors', function (Blueprint $table) {
            $table->dropUnique('product_unit_colors_product_unit_id_color_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('product_unit_colors', function (Blueprint $table) {
            $table->unique(['product_unit_id', 'color_id']);
        });
    }
};
