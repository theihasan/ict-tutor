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
        Schema::table('user_answers', function (Blueprint $table) {
            // Add missing user_id field
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            
            // Rename fields to match factory expectations
            $table->renameColumn('selected_answer', 'user_answer');
            $table->renameColumn('marks_earned', 'points_earned');
            $table->renameColumn('time_taken_seconds', 'time_spent');
            
            // Add missing fields that factory expects
            $table->integer('confidence_level')->default(3)->after('is_flagged'); // 1-5 scale
            $table->integer('attempt_count')->default(1)->after('confidence_level'); // How many times changed answer
            
            // Drop field that factory doesn't use  
            $table->dropColumn('correct_answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            // Remove added fields
            $table->dropColumn(['user_id', 'confidence_level', 'attempt_count']);
            
            // Rename back to original field names
            $table->renameColumn('user_answer', 'selected_answer');
            $table->renameColumn('points_earned', 'marks_earned');
            $table->renameColumn('time_spent', 'time_taken_seconds');
            
            // Add back dropped field
            $table->char('correct_answer', 1)->after('selected_answer');
        });
    }
};
