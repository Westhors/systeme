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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->default('cash'); // طريقة الدفع
            $table->string('reference_number')->nullable(); // رقم المرجع
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
