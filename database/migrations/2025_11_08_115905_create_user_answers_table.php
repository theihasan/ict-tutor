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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->char('selected_answer', 1)->nullable(); // A, B, C, D or null for skipped
            $table->char('correct_answer', 1); // Store correct answer for quick reference
            $table->boolean('is_correct')->default(false); // Whether answer is correct
            $table->integer('time_taken_seconds')->nullable(); // Time taken for this question
            $table->integer('marks_earned')->default(0); // Marks earned for this question
            $table->boolean('is_flagged')->default(false); // If user flagged for review
            $table->timestamp('answered_at')->nullable(); // When answer was submitted
            $table->timestamps();
            
            // Composite index for better performance
            $table->index(['test_attempt_id', 'question_id']);
            $table->index(['question_id', 'is_correct']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
