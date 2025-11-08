<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinimalTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Minimal Test Seeding...');
        
        // 1. Create 1 admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@hscict.edu.bd',
            'role' => 'admin',
        ]);
        $this->command->info('✅ Created admin user');
        
        // 2. Create 1 student
        $student = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
        ]);
        $this->command->info('✅ Created student user');
        
        // 3. Create 1 chapter
        $chapter = Chapter::factory()->create([
            'name' => 'Test Chapter',
            'order' => 1,
        ]);
        $this->command->info('✅ Created chapter');
        
        // 4. Create 1 topic
        $topic = Topic::factory()->create([
            'chapter_id' => $chapter->id,
            'name' => 'Test Topic',
        ]);
        $this->command->info('✅ Created topic');
        
        // 5. Create 1 question
        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'question' => 'What is ICT?',
            'correct_answer' => 'A',
            'type' => QuestionType::MULTIPLE_CHOICE,
            'difficulty_level' => Difficulty::EASY,
        ]);
        $this->command->info('✅ Created question');
        
        // 6. Create question options
        $options = ['Information and Communication Technology', 'Internet Connection Technology', 'International Computer Technology', 'Internal Communication Technology'];
        foreach (['A', 'B', 'C', 'D'] as $key => $optionKey) {
            QuestionOption::factory()->create([
                'question_id' => $question->id,
                'option_key' => $optionKey,
                'option_text' => $options[$key],
            ]);
        }
        $this->command->info('✅ Created question options');
        
        // 7. Create 1 test
        $test = Test::factory()->create([
            'title' => 'Test ICT Quiz',
            'description' => 'A simple test quiz',
            'chapter_id' => $chapter->id,
            'total_questions' => 1,
            'total_marks' => 5,
        ]);
        $this->command->info('✅ Created test');
        
        // 8. Create 1 test attempt
        $attempt = TestAttempt::factory()->create([
            'user_id' => $student->id,
            'test_id' => $test->id,
            'total_questions' => 1,
            'total_marks' => 5,
        ]);
        $this->command->info('✅ Created test attempt');
        
        // 9. Create 1 user answer
        UserAnswer::factory()->create([
            'user_id' => $student->id,
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'user_answer' => 'A',
            'is_correct' => true,
            'points_earned' => 1,
        ]);
        $this->command->info('✅ Created user answer');
        
        $this->command->info('🎉 Minimal seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   Users: ' . User::count());
        $this->command->info('   Chapters: ' . Chapter::count());
        $this->command->info('   Topics: ' . Topic::count());
        $this->command->info('   Questions: ' . Question::count());
        $this->command->info('   Question Options: ' . QuestionOption::count());
        $this->command->info('   Tests: ' . Test::count());
        $this->command->info('   Test Attempts: ' . TestAttempt::count());
        $this->command->info('   User Answers: ' . UserAnswer::count());
    }
}
