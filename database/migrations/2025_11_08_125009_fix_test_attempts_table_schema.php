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
        Schema::table('test_attempts', function (Blueprint $table) {
            // Rename time_taken_seconds to time_taken to match factory
            $table->renameColumn('time_taken_seconds', 'time_taken');
            
            // Add missing fields that factory expects
            $table->integer('skipped_answers')->default(0)->after('wrong_answers'); // Factory expects this field name
            $table->integer('obtained_marks')->default(0)->after('skipped_answers'); // Factory field
            $table->integer('total_marks')->default(0)->after('obtained_marks'); // Factory field
            $table->boolean('is_passed')->default(false)->after('percentage'); // Factory field
            $table->integer('attempt_number')->default(1)->after('is_passed'); // Factory field
            $table->string('ip_address')->nullable()->after('attempt_number'); // Factory field
            $table->text('user_agent')->nullable()->after('ip_address'); // Factory field
            $table->json('answers')->nullable()->after('user_agent'); // Factory field
            $table->json('time_spent_per_question')->nullable()->after('answers'); // Factory field
            $table->text('notes')->nullable()->after('time_spent_per_question'); // Factory field
            
            // Drop fields that don't match factory
            $table->dropColumn(['score', 'skipped_questions', 'grade', 'status', 'question_sequence', 'analytics', 'points_earned']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            // Reverse all changes
            $table->renameColumn('time_taken', 'time_taken_seconds');
            
            // Remove added fields
            $table->dropColumn([
                'skipped_answers', 'obtained_marks', 'total_marks', 'is_passed', 
                'attempt_number', 'ip_address', 'user_agent', 'answers', 
                'time_spent_per_question', 'notes'
            ]);
            
            // Add back original fields
            $table->integer('score')->default(0);
            $table->integer('skipped_questions')->default(0);
            $table->string('grade', 3)->nullable();
            $table->string('status')->default('in_progress');
            $table->json('question_sequence')->nullable();
            $table->json('analytics')->nullable();
            $table->integer('points_earned')->default(0);
        });
    }
};
