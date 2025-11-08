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
        Schema::table('tests', function (Blueprint $table) {
            // Add missing fields that TestFactory expects
            $table->foreignId('topic_id')->nullable()->constrained()->onDelete('set null')->after('chapter_id');
            $table->boolean('is_public')->default(false)->after('is_active');
            $table->boolean('allow_retries')->default(true)->after('is_public');
            $table->integer('max_attempts')->default(3)->after('allow_retries');
            $table->text('instructions')->nullable()->after('max_attempts');
            $table->timestamp('scheduled_at')->nullable()->after('instructions');
            $table->timestamp('starts_at')->nullable()->after('scheduled_at');
            $table->timestamp('ends_at')->nullable()->after('starts_at');
            $table->boolean('show_results_immediately')->default(true)->after('ends_at');
            $table->boolean('randomize_questions')->default(false)->after('show_results_immediately');
            $table->boolean('negative_marking')->default(false)->after('randomize_questions');
            $table->decimal('negative_marks_per_question', 3, 2)->default(0.00)->after('negative_marking');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('negative_marks_per_question');
            
            // Rename existing fields to match factory expectations
            $table->renameColumn('name', 'title');
            $table->renameColumn('name_en', 'title_en'); 
            $table->renameColumn('duration_minutes', 'duration');
            $table->renameColumn('pass_percentage', 'passing_marks'); // Will need to adjust this calculation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            // Remove added fields
            $table->dropForeign(['topic_id']);
            $table->dropColumn([
                'topic_id', 'is_public', 'allow_retries', 'max_attempts', 'instructions',
                'scheduled_at', 'starts_at', 'ends_at', 'show_results_immediately',
                'randomize_questions', 'negative_marking', 'negative_marks_per_question'
            ]);
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            
            // Rename back to original field names
            $table->renameColumn('title', 'name');
            $table->renameColumn('title_en', 'name_en');
            $table->renameColumn('duration', 'duration_minutes');
            $table->renameColumn('passing_marks', 'pass_percentage');
        });
    }
};
