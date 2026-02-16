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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('position')->nullable();
            // $table->string('department')->nullable();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->decimal('salary', 10, 2)->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
