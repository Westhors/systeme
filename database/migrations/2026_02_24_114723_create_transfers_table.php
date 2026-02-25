<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'treasury_to_treasury',
                'treasury_to_bank',
                'bank_to_treasury',
                'bank_to_bank',
                'treasury_deposit',  // إيداع في الخزنة
                'treasury_withdraw', // سحب من الخزنة
                'bank_deposit',      // إيداع في البنك
                'bank_withdraw'      // سحب من البنك
            ]);
            $table->foreignId('from_treasury_id')->nullable()->constrained('treasuries')->nullOnDelete();
            $table->foreignId('to_treasury_id')->nullable()->constrained('treasuries')->nullOnDelete();
            $table->foreignId('from_bank_id')->nullable()->constrained('banks')->nullOnDelete();
            $table->foreignId('to_bank_id')->nullable()->constrained('banks')->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('EGP');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
