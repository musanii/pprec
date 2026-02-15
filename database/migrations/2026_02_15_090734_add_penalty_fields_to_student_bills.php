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
        Schema::table('student_bills', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('amount');
            $table->integer('grace_days')->default(0)->after('due_date');

            $table->enum('penalty_type', ['fixed', 'percentage'])->nullable();
            $table->decimal('penalty_value', 8, 2)->nullable();

            $table->decimal('penalty_amount', 10, 2)->default(0);
            $table->timestamp('penalty_applied_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_bills', function (Blueprint $table) {
            //
        });
    }
};
