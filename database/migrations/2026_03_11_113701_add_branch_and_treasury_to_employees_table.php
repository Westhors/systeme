<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // إضافة branch_id
            if (!Schema::hasColumn('employees', 'branch_id')) {
                $table->foreignId('branch_id')
                    ->nullable()
                    ->after('role_id')
                    ->constrained('branches')
                    ->nullOnDelete();
            }

            // إضافة treasury_id
            if (!Schema::hasColumn('employees', 'treasury_id')) {
                $table->foreignId('treasury_id')
                    ->nullable()
                    ->after('branch_id')
                    ->constrained('treasuries')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['treasury_id']);
            $table->dropColumn(['branch_id', 'treasury_id']);
        });
    }
};