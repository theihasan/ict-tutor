<?php

namespace Database\Factories;

use App\Enums\TestType;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * HSC ICT Test Templates
     */
    private array $testTemplates = [
        'model_test' => [
            [
                'title' => 'HSC ICT Model Test - 2024',
                'title_en' => 'HSC ICT Model Test - 2024',
                'description' => 'এইচএসসি ICT বোর্ড পরীক্ষার মডেল টেস্ট। সব চ্যাপ্টার থেকে প্রশ্ন রয়েছে।',
            ],
            [
                'title' => 'Board Pattern Model Test',
                'title_en' => 'Board Pattern Model Test',
                'description' => 'বোর্ড পরীক্ষার প্যাটার্ন অনুযায়ী সাজানো মডেল টেস্ট।',
            ],
        ],
        'chapter_test' => [
            [
                'title' => 'তথ্য ও যোগাযোগ প্রযুক্তি - চ্যাপ্টার টেস্ট',
                'title_en' => 'ICT Fundamentals - Chapter Test',
                'description' => 'প্রথম চ্যাপ্টারের সম্পূর্ণ বিষয়বস্তুর উপর টেস্ট।',
            ],
            [
                'title' => 'কমিউনিকেশন ও নেটওয়ার্কিং - চ্যাপ্টার টেস্ট',
                'title_en' => 'Communication & Networking - Chapter Test',
                'description' => 'দ্বিতীয় চ্যাপ্টারের যোগাযোগ ব্যবস্থা ও নেটওয়ার্কিং বিষয়ক টেস্ট।',
            ],
            [
                'title' => 'সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস - চ্যাপ্টার টেস্ট',
                'title_en' => 'Number Systems & Digital Devices - Chapter Test',
                'description' => 'তৃতীয় চ্যাপ্টারের সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস বিষয়ক টেস্ট।',
            ],
        ],
        'topic_test' => [
            [
                'title' => 'HTML ট্যাগ ও অ্যাট্রিবিউট - টপিক টেস্ট',
                'title_en' => 'HTML Tags & Attributes - Topic Test',
                'description' => 'HTML ট্যাগ এবং অ্যাট্রিবিউটের উপর বিশেষ টেস্ট।',
            ],
            [
                'title' => 'বাইনারি সংখ্যা পদ্ধতি - টপিক টেস্ট',
                'title_en' => 'Binary Number System - Topic Test',
                'description' => 'বাইনারি সংখ্যা পদ্ধতি এবং রূপান্তর বিষয়ক টেস্ট।',
            ],
        ],
        'quick_quiz' => [
            [
                'title' => 'দ্রুত কুইজ - ICT মূল ধারণা',
                'title_en' => 'Quick Quiz - ICT Fundamentals',
                'description' => 'ICT এর মূল ধারণা নিয়ে দ্রুত কুইজ।',
            ],
            [
                'title' => 'ডেইলি কুইজ - নেটওয়ার্কিং',
                'title_en' => 'Daily Quiz - Networking',
                'description' => 'নেটওয়ার্কিং বিষয়ক দৈনিক কুইজ।',
            ],
        ],
        'practice_test' => [
            [
                'title' => 'প্রোগ্রামিং প্র্যাকটিস টেস্ট',
                'title_en' => 'Programming Practice Test',
                'description' => 'C প্রোগ্রামিং ভাষার উপর প্র্যাকটিস টেস্ট।',
            ],
            [
                'title' => 'ডেটাবেস প্র্যাকটিস টেস্ট',
                'title_en' => 'Database Practice Test',
                'description' => 'SQL এবং ডেটাবেস ম্যানেজমেন্ট বিষয়ক প্র্যাকটিস টেস্ট।',
            ],
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testType = fake()->randomElement(TestType::cases());
        $templates = $this->testTemplates[strtolower(str_replace('_', '', $testType->value))] ?? 
                    $this->testTemplates['practice_test'];
        
        $selectedTemplate = fake()->randomElement($templates);
        
        $duration = $testType->defaultDuration();
        $questionCount = $testType->defaultQuestionCount();
        
        // Randomize slightly
        $duration += fake()->numberBetween(-10, 10);
        $questionCount += fake()->numberBetween(-5, 5);
        
        $totalMarks = $questionCount * fake()->numberBetween(1, 5);

        return [
            'title' => $selectedTemplate['title'],
            'title_en' => $selectedTemplate['title_en'],
            'description' => $selectedTemplate['description'],
            'type' => $testType->value,
            'duration' => max(5, $duration), // Minimum 5 minutes
            'total_questions' => max(1, $questionCount), // Minimum 1 question
            'question_ids' => [], // Will be populated when test is created with questions
            'total_marks' => $totalMarks,
            'passing_marks' => (int) ($totalMarks * 0.4), // 40% to pass
            'chapter_id' => fake()->boolean(60) ? Chapter::inRandomOrder()->first()?->id : null,
            'topic_id' => fake()->boolean(30) ? Topic::inRandomOrder()->first()?->id : null,
            'is_active' => fake()->boolean(90),
            'is_public' => fake()->boolean(80),
            'allow_retries' => $testType->allowsRetries(),
            'max_attempts' => $testType->allowsRetries() ? fake()->numberBetween(1, 5) : 1,
            'instructions' => $this->generateInstructions($testType),
            'scheduled_at' => fake()->optional(20)->dateTimeBetween('now', '+1 month'),
            'starts_at' => fake()->optional(30)->dateTimeBetween('-1 week', '+1 week'),
            'ends_at' => fake()->optional(30)->dateTimeBetween('+1 week', '+2 months'),
            'show_results_immediately' => fake()->boolean(70),
            'randomize_questions' => fake()->boolean(60),
            'negative_marking' => $testType->isExamLevel() ? fake()->boolean(40) : false,
            'negative_marks_per_question' => fake()->boolean(30) ? 0.25 : 0,
            'created_by' => fake()->boolean(70) ? User::inRandomOrder()->first()?->id : null,
        ];
    }

    /**
     * Generate test instructions based on type
     */
    private function generateInstructions(TestType $testType): string
    {
        $baseInstructions = [
            'এই পরীক্ষায় মোট ' . $testType->defaultQuestionCount() . 'টি প্রশ্ন রয়েছে।',
            'পরীক্ষার সময় ' . $testType->defaultDuration() . ' মিনিট।',
            'প্রতিটি প্রশ্নের জন্য সময় সীমা রয়েছে।',
            'সব প্রশ্নের উত্তর দেওয়ার চেষ্টা করুন।',
        ];

        if ($testType->isExamLevel()) {
            $baseInstructions[] = 'এটি একটি গুরুত্বপূর্ণ পরীক্ষা, মনোযোগ সহকারে উত্তর দিন।';
            $baseInstructions[] = 'ভুল উত্তরের জন্য নেগেটিভ মার্কিং থাকতে পারে।';
        }

        if (!$testType->allowsRetries()) {
            $baseInstructions[] = 'এই পরীক্ষায় শুধুমাত্র একবার অংশগ্রহণ করা যাবে।';
        }

        return implode(' ', $baseInstructions);
    }

    /**
     * Create test of specific type
     */
    public function ofType(TestType $type): static
    {
        return $this->state([
            'type' => $type->value,
            'duration' => $type->defaultDuration(),
            'total_questions' => $type->defaultQuestionCount(),
            'allow_retries' => $type->allowsRetries(),
            'max_attempts' => $type->allowsRetries() ? 3 : 1,
        ]);
    }

    /**
     * Create model test
     */
    public function modelTest(): static
    {
        return $this->ofType(TestType::MODEL_TEST)
            ->state([
                'title' => 'HSC ICT Model Test - ' . date('Y'),
                'title_en' => 'HSC ICT Model Test - ' . date('Y'),
                'description' => 'এইচএসসি ICT বোর্ড পরীক্ষার মডেল টেস্ট। সব চ্যাপ্টার থেকে প্রশ্ন রয়েছে।',
                'is_public' => true,
                'show_results_immediately' => false,
                'negative_marking' => true,
                'negative_marks_per_question' => 0.25,
            ]);
    }

    /**
     * Create chapter test
     */
    public function chapterTest(): static
    {
        return $this->ofType(TestType::CHAPTER_TEST)
            ->state([
                'chapter_id' => Chapter::inRandomOrder()->first()?->id,
                'allow_retries' => true,
                'max_attempts' => 3,
            ]);
    }

    /**
     * Create topic test
     */
    public function topicTest(): static
    {
        return $this->ofType(TestType::TOPIC_TEST)
            ->state([
                'topic_id' => Topic::inRandomOrder()->first()?->id,
                'allow_retries' => true,
                'max_attempts' => 5,
            ]);
    }

    /**
     * Create quick quiz
     */
    public function quickQuiz(): static
    {
        return $this->ofType(TestType::QUICK_QUIZ)
            ->state([
                'duration' => fake()->numberBetween(10, 20),
                'total_questions' => fake()->numberBetween(3, 8),
                'show_results_immediately' => true,
                'randomize_questions' => true,
            ]);
    }

    /**
     * Create practice test
     */
    public function practiceTest(): static
    {
        return $this->ofType(TestType::PRACTICE_TEST)
            ->state([
                'allow_retries' => true,
                'max_attempts' => fake()->numberBetween(3, 10),
                'show_results_immediately' => true,
            ]);
    }

    /**
     * Create final examination
     */
    public function finalExam(): static
    {
        return $this->ofType(TestType::FINAL_EXAM)
            ->state([
                'is_public' => true,
                'show_results_immediately' => false,
                'negative_marking' => true,
                'negative_marks_per_question' => 0.5,
                'allow_retries' => false,
                'max_attempts' => 1,
            ]);
    }

    /**
     * Create weekly test
     */
    public function weeklyTest(): static
    {
        return $this->ofType(TestType::PRACTICE_TEST)
            ->state([
                'title' => 'সাপ্তাহিক পরীক্ষা - ' . date('W'),
                'title_en' => 'Weekly Test - Week ' . date('W'),
                'description' => 'এই সপ্তাহের শেখা বিষয়ের উপর পরীক্ষা।',
                'duration' => 45,
                'total_questions' => 15,
                'is_public' => true,
                'show_results_immediately' => true,
            ]);
    }

    /**
     * Create mock board exam
     */
    public function mockBoardExam(): static
    {
        return $this->ofType(TestType::MOCK_EXAM)
            ->state([
                'title' => 'মক বোর্ড পরীক্ষা - ICT',
                'title_en' => 'Mock Board Exam - ICT',
                'description' => 'HSC বোর্ড পরীক্ষার মতো করে সাজানো মক পরীক্ষা।',
                'is_public' => true,
                'show_results_immediately' => false,
                'negative_marking' => true,
                'negative_marks_per_question' => 0.25,
                'allow_retries' => false,
            ]);
    }

    /**
     * Create subject test
     */
    public function subjectTest(): static
    {
        return $this->ofType(TestType::CHAPTER_TEST)
            ->state([
                'title' => 'বিষয়ভিত্তিক পরীক্ষা',
                'title_en' => 'Subject Test',
                'description' => 'নির্দিষ্ট বিষয়ের উপর বিশেষায়িত পরীক্ষা।',
                'duration' => 60,
                'total_questions' => 25,
                'is_public' => true,
            ]);
    }

    /**
     * Create timed challenge
     */
    public function timedChallenge(): static
    {
        return $this->ofType(TestType::TIMED_CHALLENGE)
            ->state([
                'title' => 'স্পিড চ্যালেঞ্জ - ' . fake()->randomElement(['বাইনারি কনভার্শন', 'HTML ট্যাগ', 'SQL কুয়েরি']),
                'duration' => fake()->numberBetween(5, 15),
                'total_questions' => fake()->numberBetween(8, 12),
                'randomize_questions' => true,
                'show_results_immediately' => true,
            ]);
    }

    /**
     * Create active test
     */
    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    /**
     * Create inactive test
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create public test
     */
    public function public(): static
    {
        return $this->state([
            'is_public' => true,
        ]);
    }

    /**
     * Create private test
     */
    public function private(): static
    {
        return $this->state([
            'is_public' => false,
        ]);
    }

    /**
     * Create scheduled test
     */
    public function scheduled(): static
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');
        
        return $this->state([
            'scheduled_at' => $startDate,
            'starts_at' => $startDate,
            'ends_at' => $endDate,
        ]);
    }

    /**
     * Create test with negative marking
     */
    public function withNegativeMarking(): static
    {
        return $this->state([
            'negative_marking' => true,
            'negative_marks_per_question' => fake()->randomFloat(2, 0.1, 0.5),
        ]);
    }

    /**
     * Create test for specific chapter
     */
    public function forChapter(Chapter $chapter): static
    {
        return $this->state([
            'chapter_id' => $chapter->id,
            'title' => $chapter->name . ' - চ্যাপ্টার টেস্ট',
            'title_en' => $chapter->name_en . ' - Chapter Test',
        ]);
    }

    /**
     * Create test for specific topic
     */
    public function forTopic(Topic $topic): static
    {
        return $this->state([
            'topic_id' => $topic->id,
            'chapter_id' => $topic->chapter_id,
            'title' => $topic->name . ' - টপিক টেস্ট',
            'title_en' => $topic->name_en . ' - Topic Test',
        ]);
    }
}