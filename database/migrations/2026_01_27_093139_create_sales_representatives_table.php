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
        Schema::create('sales_representatives', function (Blueprint $table) {
            $table->id();




                $table->string('name')->nullable();
                $table->string('phone')->unique()->nullable();
                $table->string('email')->nullable()->unique();

                $table->decimal('commission_rate', 5, 2)->default(0); // نسبة العمولة %
                $table->boolean('active')->default(true);

                $table->foreignId('branch_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();


                $table->foreignId('employee_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_representatives');
    }
};
