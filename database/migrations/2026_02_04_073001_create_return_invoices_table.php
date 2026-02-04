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
        Schema::create('return_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique(); // RET-000154
            $table->foreignId('invoice_id')->constrained();

            $table->decimal('total_amount', 10, 2);
            $table->decimal('refunded_amount', 10, 2);

            $table->string('refund_method'); // cash | card | wallet
            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_invoices');
    }
};
