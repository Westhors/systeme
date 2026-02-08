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
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);
            $table->decimal('point_value', 8, 2)->default(1); // كل نقطة قيمتها 1 افتراضي
            $table->integer('silver')->default(0);
            $table->integer('gold')->default(0);
            $table->integer('platinum')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_settings');
    }
};
