<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treasury_transactions', function (Blueprint $table) {
            $table->id();
            
            // الخزينة
            $table->foreignId('treasury_id')->constrained()->cascadeOnDelete();
            
            // polymorphic relation
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->index(['reference_type', 'reference_id']);
            
            // نوع الحركة: in (داخل) أو out (خارج)
            $table->enum('type', ['in', 'out'])->default('in');
            
            // المبلغ
            $table->decimal('amount', 15, 2)->default(0);
            
            // الوصف
            $table->text('description')->nullable();
            
            // المستخدم
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treasury_transactions');
    }
};