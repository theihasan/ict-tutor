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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('period')->default('all_time'); // weekly, monthly, all_time
            $table->integer('total_points')->default(0); // Total points earned
            $table->integer('tests_completed')->default(0); // Number of tests completed
            $table->decimal('average_score', 5, 2)->default(0.00); // Average score percentage
            $table->integer('current_streak')->default(0); // Current streak
            $table->integer('longest_streak')->default(0); // Longest streak achieved
            $table->integer('rank_position')->nullable(); // Calculated rank position
            $table->timestamp('last_activity_at')->nullable(); // Last activity timestamp
            $table->json('achievements')->nullable(); // Store achieved badges/awards
            $table->integer('level')->default(1); // User level based on points
            $table->timestamps();
            
            // Indexes for leaderboard queries
            $table->index(['period', 'total_points']);
            $table->index(['user_id', 'period']);
            $table->unique(['user_id', 'period']); // One record per user per period
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
