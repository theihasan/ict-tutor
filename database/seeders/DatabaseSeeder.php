<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\UserAnswer;
use App\Models\UserProgress;
use App\Models\Leaderboard;
use App\Enums\Period;
use App\Enums\Difficulty;
use App\Enums\QuestionType;
use App\Enums\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting HSC ICT Interactive Database Seeding...');
        
        // Disable foreign key checks for faster seeding (database agnostic)
        $this->disableForeignKeyChecks();
        
        // Clear existing data
        $this->command->info('🧹 Clearing existing data...');
        $this->clearExistingData();
        
        // 1. Create Users
        $this->command->info('👥 Creating users...');
        $users = $this->createUsers();
        
        // 2. Create Chapters and Topics
        $this->command->info('📚 Creating chapters and topics...');
        $chapters = $this->createChaptersAndTopics();
        
        // 3. Create Questions with Options
        $this->command->info('❓ Creating questions and options...');
        $questions = $this->createQuestionsWithOptions($chapters);
        
        // 4. Create Tests
        $this->command->info('📝 Creating tests...');
        $tests = $this->createTests($chapters);
        
        // 5. Create Test Attempts and User Answers
        $this->command->info('🎯 Creating test attempts and user answers...');
        $this->createTestAttemptsAndAnswers($users, $tests, $questions);
        
        // 6. Create User Progress
        $this->command->info('📈 Creating user progress data...');
        $this->createUserProgress($users, $chapters);
        
        // 7. Create Leaderboards
        $this->command->info('🏆 Creating leaderboard data...');
        $this->createLeaderboards($users);
        
        // Re-enable foreign key checks
        $this->enableForeignKeyChecks();
        
        $this->command->info('✅ Database seeding completed successfully!');
        $this->printSeedingSummary();
    }

    /**
     * Disable foreign key checks (database agnostic)
     */
    private function disableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        
        switch ($driver) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys=OFF;');
                break;
            case 'pgsql':
                // PostgreSQL doesn't have a global foreign key check disable
                break;
        }
    }

    /**
     * Enable foreign key checks (database agnostic)
     */
    private function enableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        
        switch ($driver) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys=ON;');
                break;
            case 'pgsql':
                // PostgreSQL doesn't have a global foreign key check disable
                break;
        }
    }

    /**
     * Clear existing data
     */
    private function clearExistingData(): void
    {
        $tables = [
            'leaderboards',
            'user_progress',
            'user_answers',
            'test_attempts',
            'tests',
            'question_options',
            'questions',
            'topics',
            'chapters',
            'users'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }

    /**
     * Create users with realistic HSC student profiles
     */
    private function createUsers(): \Illuminate\Database\Eloquent\Collection
    {
        // Create admin/teacher user (using available fields)
        $adminUser = User::factory()->create([
            'name' => 'HSC ICT Admin',
            'email' => 'admin@hscict.edu.bd',
            'role' => 'admin',
            'level' => 10,
            'total_points' => 10000,
            'institution' => 'HSC ICT Platform',
            'class' => 'Admin',
        ]);

        // Create test user
        $testUser = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'institution' => 'Dhaka College',
            'class' => 'HSC 2024',
        ]);

        // Create diverse student profiles
        $students = collect();
        
        // High-performing students (10%)
        $students = $students->concat(
            User::factory()->count(3)->create([
                'level' => fake()->numberBetween(6, 10),
                'total_points' => fake()->numberBetween(3000, 10000),
            ])
        );
        
        // Average students (60%)
        $students = $students->concat(
            User::factory()->count(12)->create([
                'level' => fake()->numberBetween(2, 6),
                'total_points' => fake()->numberBetween(100, 3000),
            ])
        );
        
        // Struggling students (30%)
        $students = $students->concat(
            User::factory()->count(5)->create([
                'level' => fake()->numberBetween(1, 3),
                'total_points' => fake()->numberBetween(0, 500),
            ])
        );
        
        // Create eloquent collection and merge all users
        $allUsers = new \Illuminate\Database\Eloquent\Collection([$adminUser, $testUser]);
        return $allUsers->concat($students);
    }

    /**
     * Create chapters and topics based on HSC ICT curriculum
     */
    private function createChaptersAndTopics(): \Illuminate\Database\Eloquent\Collection
    {
        $chapters = Chapter::factory()->count(6)->sequence(
            ['name_en' => 'Information and Communication Technology', 'name' => 'তথ্য ও যোগাযোগ প্রযুক্তি', 'order' => 1],
            ['name_en' => 'Communication Systems and Networking', 'name' => 'যোগাযোগ ব্যবস্থা ও নেটওয়ার্কিং', 'order' => 2],
            ['name_en' => 'Number System and Digital Device', 'name' => 'সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস', 'order' => 3],
            ['name_en' => 'Web Design and Development', 'name' => 'ওয়েব ডিজাইন ও উন্নয়ন', 'order' => 4],
            ['name_en' => 'Database Management System', 'name' => 'ডেটাবেস ব্যবস্থাপনা', 'order' => 5],
            ['name_en' => 'Programming Essentials', 'name' => 'প্রোগ্রামিং এর মূলনীতি', 'order' => 6],
        )->create();
        
        // Create topics for each chapter (5 topics per chapter)
        $chapters->each(function ($chapter) {
            Topic::factory()->count(5)->create([
                'chapter_id' => $chapter->id
            ]);
        });
        
        return $chapters;
    }

    /**
     * Create questions with multiple choice options
     */
    private function createQuestionsWithOptions(\Illuminate\Database\Eloquent\Collection $chapters): \Illuminate\Database\Eloquent\Collection
    {
        $questions = new \Illuminate\Database\Eloquent\Collection();
        
        $chapters->each(function ($chapter) use (&$questions) {
            $topics = $chapter->topics;
            
            $topics->each(function ($topic) use (&$questions, $chapter) {
                // Create varied questions for each topic
                $topicQuestions = collect();
                
                // Multiple Choice Questions (60%)
                $mcqQuestions = Question::factory()->count(12)
                    ->multipleChoice()
                    ->create([
                        'topic_id' => $topic->id,
                        'chapter_id' => $chapter->id,
                    ]);
                
                // True/False Questions (20%)
                $tfQuestions = Question::factory()->count(4)
                    ->trueFalse()
                    ->create([
                        'topic_id' => $topic->id,
                        'chapter_id' => $chapter->id,
                    ]);
                
                // Fill in the blanks (10%)
                $fibQuestions = Question::factory()->count(2)
                    ->fillInBlanks()
                    ->create([
                        'topic_id' => $topic->id,
                        'chapter_id' => $chapter->id,
                    ]);
                
                // Short answer (10%)
                $saQuestions = Question::factory()->count(2)
                    ->shortAnswer()
                    ->create([
                        'topic_id' => $topic->id,
                        'chapter_id' => $chapter->id,
                    ]);
                
                $topicQuestions = $topicQuestions
                    ->concat($mcqQuestions)
                    ->concat($tfQuestions)
                    ->concat($fibQuestions)
                    ->concat($saQuestions);
                
                // Create options for MCQ and True/False questions
                $topicQuestions->each(function ($question) {
                    if (in_array($question->type->value, ['multiple_choice', 'true_false'])) {
                        $optionKeys = $question->type->value === 'true_false' ? ['A', 'B'] : ['A', 'B', 'C', 'D'];
                        
                        foreach ($optionKeys as $key) {
                            QuestionOption::factory()->create([
                                'question_id' => $question->id,
                                'option_key' => $key,
                                'is_correct' => $key === $question->correct_answer,
                            ]);
                        }
                    }
                });
                
                $questions = $questions->concat($topicQuestions);
            });
        });
        
        return $questions;
    }

    /**
     * Create various types of tests
     */
    private function createTests(\Illuminate\Database\Eloquent\Collection $chapters): \Illuminate\Database\Eloquent\Collection
    {
        $tests = new \Illuminate\Database\Eloquent\Collection();
        
        // Model tests for each chapter
        $chapters->each(function ($chapter) use (&$tests) {
            $tests = $tests->concat(
                Test::factory()->count(2)->modelTest()->create([
                    'chapter_id' => $chapter->id,
                    'title' => "Chapter {$chapter->chapter_number} Model Test",
                ])
            );
        });
        
        // Practice tests
        $tests = $tests->concat(
            Test::factory()->count(5)->practiceTest()->create()
        );
        
        // Weekly tests
        $tests = $tests->concat(
            Test::factory()->count(3)->weeklyTest()->create()
        );
        
        // Mock board exams
        $tests = $tests->concat(
            Test::factory()->count(2)->mockBoardExam()->create()
        );
        
        // Subject tests
        $tests = $tests->concat(
            Test::factory()->count(2)->subjectTest()->create()
        );
        
        return $tests;
    }

    /**
     * Create test attempts and user answers
     */
    private function createTestAttemptsAndAnswers(\Illuminate\Database\Eloquent\Collection $users, \Illuminate\Database\Eloquent\Collection $tests, \Illuminate\Database\Eloquent\Collection $questions): void
    {
        // Skip first 2 users (admin and test user) and use the rest as students
        $students = $users->skip(2);
        
        $students->each(function ($student) use ($tests, $questions) {
            // Each student attempts only 1 test (for fastest seeding)
            $testsToAttempt = $tests->random(1);
            
            $testsToAttempt->each(function ($test) use ($student, $questions) {
                // Create test attempt with realistic performance
                $attempt = TestAttempt::factory()->create([
                    'user_id' => $student->id,
                    'test_id' => $test->id,
                ]);
                
                // Create answers for questions in this test (limit to 5 questions for fastest seeding)
                $maxQuestions = min(5, $test->question_count, $questions->count());
                $testQuestions = $questions->random($maxQuestions);
                
                $testQuestions->each(function ($question) use ($attempt, $student) {
                    UserAnswer::factory()->create([
                        'user_id' => $student->id,
                        'test_attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                    ]);
                });
            });
        });
    }

    /**
     * Create user progress data
     */
    private function createUserProgress(\Illuminate\Database\Eloquent\Collection $users, \Illuminate\Database\Eloquent\Collection $chapters): void
    {
        // Skip first 2 users (admin and test user) and use the rest as students
        $students = $users->skip(2);
        
        $students->each(function ($student) use ($chapters) {
            // Create chapter-level progress
            $chapters->each(function ($chapter) use ($student) {
                if (rand(1, 100) <= 80) { // 80% chance of having progress
                    UserProgress::factory()->hscStudentPattern()->chapterProgress()->create([
                        'user_id' => $student->id,
                        'chapter_id' => $chapter->id,
                    ]);
                }
            });
            
            // Create topic-level progress for some topics
            $allTopics = Topic::all();
            if ($allTopics->count() > 0) {
                $maxTopics = min(15, $allTopics->count());
                $minTopics = min(5, $allTopics->count());
                $topicsToProgress = $allTopics->random(rand($minTopics, $maxTopics));
            } else {
                $topicsToProgress = collect(); // Empty collection if no topics
            }
            
            $topicsToProgress->each(function ($topic) use ($student) {
                UserProgress::factory()->hscStudentPattern()->topicProgress()->create([
                    'user_id' => $student->id,
                    'topic_id' => $topic->id,
                ]);
            });
        });
    }

    /**
     * Create leaderboard data for different periods
     */
    private function createLeaderboards(\Illuminate\Database\Eloquent\Collection $users): void
    {
        // Skip first 2 users (admin and test user) and use the rest as students
        $students = $users->skip(2);
        
        // Create leaderboard entries for each period
        foreach (Period::cases() as $period) {
            $students->each(function ($student) use ($period) {
                if (rand(1, 100) <= 85) { // 85% chance of having leaderboard entry
                    Leaderboard::factory()->hscStudentPattern()->create([
                        'user_id' => $student->id,
                        'period' => $period,
                    ]);
                }
            });
        }
        
        // Update some existing ALL_TIME entries to be elite performers
        $allTimeEntries = Leaderboard::where('period', Period::ALL_TIME)->get();
        $eliteStudents = $allTimeEntries->random(min(5, $allTimeEntries->count()));
        $eliteStudents->each(function ($leaderboard) {
            $eliteData = Leaderboard::factory()->elite()->make()->toArray();
            unset($eliteData['user_id'], $eliteData['period']); // Don't update these fields
            $leaderboard->update($eliteData);
        });
        
        // Update some existing ALL_TIME entries to be achievement hunters
        $remainingEntries = $allTimeEntries->diff($eliteStudents);
        $achievementHunters = $remainingEntries->random(min(8, $remainingEntries->count()));
        $achievementHunters->each(function ($leaderboard) {
            $hunterData = Leaderboard::factory()->achievementHunter()->make()->toArray();
            unset($hunterData['user_id'], $hunterData['period']); // Don't update these fields
            $leaderboard->update($hunterData);
        });
    }

    /**
     * Print seeding summary
     */
    private function printSeedingSummary(): void
    {
        $this->command->info('');
        $this->command->info('📊 SEEDING SUMMARY:');
        $this->command->info('===================');
        $this->command->info('👥 Users: ' . User::count());
        $this->command->info('📚 Chapters: ' . Chapter::count());
        $this->command->info('📖 Topics: ' . Topic::count());
        $this->command->info('❓ Questions: ' . Question::count());
        $this->command->info('⚪ Question Options: ' . QuestionOption::count());
        $this->command->info('📝 Tests: ' . Test::count());
        $this->command->info('🎯 Test Attempts: ' . TestAttempt::count());
        $this->command->info('✍️ User Answers: ' . UserAnswer::count());
        $this->command->info('📈 User Progress: ' . UserProgress::count());
        $this->command->info('🏆 Leaderboard Entries: ' . Leaderboard::count());
        $this->command->info('');
        $this->command->info('🎉 Ready to serve realistic HSC ICT learning platform data!');
    }
}
