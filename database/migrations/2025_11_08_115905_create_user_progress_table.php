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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type')->default('chapter'); // chapter, topic
            $table->decimal('completion_percentage', 5, 2)->default(0.00); // Completion %
            $table->integer('total_attempts')->default(0); // Total attempts in this area
            $table->integer('correct_answers')->default(0); // Total correct answers
            $table->integer('wrong_answers')->default(0); // Total wrong answers
            $table->decimal('accuracy_rate', 5, 2)->default(0.00); // Accuracy percentage
            $table->integer('time_spent_minutes')->default(0); // Total time spent
            $table->timestamp('last_practiced_at')->nullable(); // Last practice time
            $table->boolean('is_weak_area')->default(false); // Identified as weak area
            $table->integer('streak_count')->default(0); // Current streak for this area
            $table->integer('best_score')->default(0); // Best score achieved
            $table->json('performance_trend')->nullable(); // Store performance data
            $table->timestamps();
            
            // Unique constraint to prevent duplicate records
            $table->unique(['user_id', 'chapter_id', 'topic_id', 'type']);
            $table->index(['user_id', 'is_weak_area']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
