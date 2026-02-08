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
        Schema::create('promotion_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action'); // promoted, graduated, repeated
            $table->unsignedInteger('total_students');
            $table->unsignedInteger('promoted')->default(0);
            $table->unsignedInteger('graduated')->default(0);
            $table->unsignedInteger('repeated')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_logs');
    }
};
