<?php

use App\Models\Branch;
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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('manager')->nullable();
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('main_branch')->default(false);
            $table->foreignIdFor(Branch::class, 'branch_id')
                ->nullable()
                ->constrained('branches')
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
        Schema::dropIfExists('warehouses');
    }
};
