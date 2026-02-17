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
        Schema::create('exam_aggregates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stream_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('total_marks', 8, 2);
            $table->decimal('mean_score', 5, 2);

            $table->integer('class_rank')->nullable();
            $table->integer('stream_rank')->nullable();

            $table->timestamps();
            $table->unique(['exam_id','student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_aggregates');
    }
};
