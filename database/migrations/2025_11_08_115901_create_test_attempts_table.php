<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("test_attempts", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("test_id")->constrained()->onDelete("cascade");
            $table->timestamp("started_at");
            $table->timestamp("completed_at")->nullable();
            $table->integer("time_taken_seconds")->nullable();
            $table->integer("score")->default(0);
            $table
                ->integer("total_questions")
                ->comment("Total question attempt");
            $table->integer("correct_answers")->default(0);
            $table->integer("wrong_answers")->default(0); // Number of wrong answers
            $table->integer("skipped_questions")->default(0); // Number of skipped questions
            $table->decimal("percentage", 5, 2)->default(0.0); // Percentage score
            $table->string("grade", 3)->nullable(); // A+, A, B+, etc.
            $table->string("status")->default("in_progress"); // in_progress, completed, abandoned
            $table->json("question_sequence")->nullable(); // Order of questions shown
            $table->json("analytics")->nullable(); // Additional analytics data
            $table->integer("points_earned")->default(0); // Points earned for leaderboard
            $table->timestamps();

            // Index for better query performance
            $table->index(["user_id", "test_id"]);
            $table->index(["user_id", "completed_at"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("test_attempts");
    }
};
