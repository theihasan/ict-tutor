<?php

namespace Database\Factories;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * HSC ICT Questions by topic type and difficulty
     */
    private array $hscQuestions = [
        'theory' => [
            'very_easy' => [
                [
                    'question' => 'ICT এর পূর্ণরূপ কী?',
                    'question_en' => 'What is the full form of ICT?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['Information and Communication Technology', 'Internet and Computer Technology', 'Information Control Technology', 'Integrated Computer Technology'],
                    'correct_answer' => 'A',
                ],
                [
                    'question' => 'কম্পিউটারের মূল অংশ কয়টি?',
                    'question_en' => 'How many main parts does a computer have?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['২টি', '৩টি', '৪টি', '৫টি'],
                    'correct_answer' => 'C',
                ],
                [
                    'question' => 'RAM হলো একটি স্থায়ী মেমোরি।',
                    'question_en' => 'RAM is a permanent memory.',
                    'type' => QuestionType::TRUE_FALSE,
                    'correct_answer' => 'False',
                ],
            ],
            'easy' => [
                [
                    'question' => 'কম্পিউটারের প্রাথমিক মেমোরির নাম কী?',
                    'question_en' => 'What is the name of primary memory in computer?',
                    'type' => QuestionType::FILL_IN_BLANK,
                    'correct_answer' => 'RAM',
                ],
                [
                    'question' => 'ইনপুট ডিভাইসের তিনটি উদাহরণ দিন।',
                    'question_en' => 'Give three examples of input devices.',
                    'type' => QuestionType::SHORT_ANSWER,
                    'correct_answer' => 'Keyboard, Mouse, Scanner',
                ],
            ],
            'medium' => [
                [
                    'question' => 'ডেটা ও ইনফরমেশনের মধ্যে পার্থক্য ব্যাখ্যা করুন।',
                    'question_en' => 'Explain the difference between data and information.',
                    'type' => QuestionType::SHORT_ANSWER,
                    'correct_answer' => 'Data হলো কাঁচা তথ্য যা প্রক্রিয়াজাত হয়নি। Information হলো প্রক্রিয়াজাত ডেটা যা অর্থবহ।',
                ],
            ],
        ],
        'networking' => [
            'easy' => [
                [
                    'question' => 'LAN এর পূর্ণরূপ কী?',
                    'question_en' => 'What is the full form of LAN?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['Local Area Network', 'Large Area Network', 'Limited Access Network', 'Long Area Network'],
                    'correct_answer' => 'A',
                ],
                [
                    'question' => 'ইন্টারনেট হলো একটি WAN।',
                    'question_en' => 'Internet is a WAN.',
                    'type' => QuestionType::TRUE_FALSE,
                    'correct_answer' => 'True',
                ],
            ],
            'medium' => [
                [
                    'question' => 'TCP/IP মডেলে কয়টি স্তর আছে?',
                    'question_en' => 'How many layers are in TCP/IP model?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['৩টি', '৪টি', '৫টি', '৭টি'],
                    'correct_answer' => 'B',
                ],
            ],
        ],
        'programming' => [
            'easy' => [
                [
                    'question' => 'C প্রোগ্রামে main() ফাংশন ____ দিয়ে শুরু হয়।',
                    'question_en' => 'In C program, main() function starts with ____.',
                    'type' => QuestionType::FILL_IN_BLANK,
                    'correct_answer' => 'int',
                ],
            ],
            'medium' => [
                [
                    'question' => 'নিচের কোড আউটপুট কী হবে?\n\n```c\n#include<stdio.h>\nint main() {\n    int x = 5;\n    printf("%d", x++);\n    return 0;\n}\n```',
                    'question_en' => 'What will be the output of the following code?',
                    'type' => QuestionType::CODE_SNIPPET,
                    'correct_answer' => '5',
                ],
            ],
            'hard' => [
                [
                    'question' => 'নিচের অ্যালগরিদমটি সম্পূর্ণ করুন:\n1. Start\n2. Input two numbers a, b\n3. ____\n4. Print result\n5. Stop',
                    'question_en' => 'Complete the following algorithm for finding maximum of two numbers.',
                    'type' => QuestionType::FILL_IN_BLANK,
                    'correct_answer' => 'If a > b then result = a, else result = b',
                ],
            ],
        ],
        'database' => [
            'easy' => [
                [
                    'question' => 'SQL এর পূর্ণরূপ কী?',
                    'question_en' => 'What is the full form of SQL?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['Structured Query Language', 'Simple Query Language', 'System Query Language', 'Standard Query Language'],
                    'correct_answer' => 'A',
                ],
            ],
            'medium' => [
                [
                    'question' => 'একটি টেবিল থেকে সব ডেটা দেখার জন্য কোন SQL কমান্ড ব্যবহার করা হয়?',
                    'question_en' => 'Which SQL command is used to view all data from a table?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['SELECT * FROM table_name', 'SHOW * FROM table_name', 'GET * FROM table_name', 'VIEW * FROM table_name'],
                    'correct_answer' => 'A',
                ],
            ],
        ],
        'hardware' => [
            'easy' => [
                [
                    'question' => 'CPU এর পূর্ণরূপ কী?',
                    'question_en' => 'What is the full form of CPU?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['Central Processing Unit', 'Computer Processing Unit', 'Central Program Unit', 'Computer Program Unit'],
                    'correct_answer' => 'A',
                ],
            ],
            'medium' => [
                [
                    'question' => 'নিচের কোনটি সেকেন্ডারি মেমোরি?',
                    'question_en' => 'Which of the following is secondary memory?',
                    'type' => QuestionType::MULTIPLE_CHOICE,
                    'options' => ['RAM', 'ROM', 'Hard Disk', 'Cache'],
                    'correct_answer' => 'C',
                ],
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
        $topic = Topic::inRandomOrder()->first();
        $topicType = $topic && $topic->type ? strtolower(str_replace('_', '', $topic->type->value)) : 'theory';
        
        // Normalize topic type for question selection
        $questionCategory = match($topicType) {
            'theory', 'mixed' => 'theory',
            'networking' => 'networking',
            'programming' => 'programming',
            'database' => 'database',
            'hardware', 'software' => 'hardware',
            default => 'theory',
        };

        $difficulty = fake()->randomElement(Difficulty::cases());
        $questionType = fake()->randomElement(QuestionType::cases());
        
        // Get questions for this category and difficulty
        $questions = $this->hscQuestions[$questionCategory][strtolower(str_replace('_', '', $difficulty->value))] ?? 
                    $this->hscQuestions['theory']['easy'] ?? [];
        
        if (empty($questions)) {
            // Fallback question
            $selectedQuestion = [
                'question' => 'Sample question for ' . $questionCategory,
                'question_en' => 'Sample question for ' . $questionCategory,
                'type' => QuestionType::MULTIPLE_CHOICE,
                'options' => ['Option A', 'Option B', 'Option C', 'Option D'],
                'correct_answer' => 'A',
            ];
        } else {
            $selectedQuestion = fake()->randomElement($questions);
        }

        // Simple points calculation
        $totalPoints = fake()->numberBetween(1, 5);

        return [
            'chapter_id' => $topic?->chapter_id ?? Chapter::factory(),
            'topic_id' => $topic?->id ?? Topic::factory(),
            'question' => $selectedQuestion['question'] ?? fake()->sentence() . '?',
            'question_en' => $selectedQuestion['question_en'] ?? fake()->sentence() . '?',
            'correct_answer' => $selectedQuestion['correct_answer'] ?? 'A',
            'explanation' => fake()->optional(70)->paragraph(),
            'type' => isset($selectedQuestion['type']) ? $selectedQuestion['type']->value : 'mcq',
            'difficulty_level' => $difficulty->value,
            'marks' => $totalPoints,
            'tags' => fake()->optional(60)->words(3, true), // Store as JSON-compatible array
            'is_active' => fake()->boolean(90), // 90% questions are active
            'usage_count' => fake()->numberBetween(0, 100),
            'success_rate' => fake()->randomFloat(2, 0, 100),
        ];
    }

    /**
     * Create question of specific type
     */
    public function ofType(QuestionType $type): static
    {
        return $this->state([
            'type' => $type->value,
            'points' => $type->defaultPoints(),
        ]);
    }

    /**
     * Create question with specific difficulty
     */
    public function withDifficulty(Difficulty $difficulty): static
    {
        return $this->state([
            'difficulty' => $difficulty->value,
            'time_limit' => $difficulty->timeAllocation(),
        ]);
    }

    /**
     * Create multiple choice question
     */
    public function multipleChoice(): static
    {
        return $this->state([
            'type' => QuestionType::MULTIPLE_CHOICE->value,
            'correct_answer' => fake()->randomElement(['A', 'B', 'C', 'D']),
        ]);
    }

    /**
     * Create true/false question
     */
    public function trueFalse(): static
    {
        return $this->state([
            'type' => QuestionType::TRUE_FALSE->value,
            'correct_answer' => fake()->boolean() ? 'True' : 'False',
        ]);
    }

    /**
     * Create programming question
     */
    public function programming(): static
    {
        return $this->state([
            'type' => QuestionType::CODE_SNIPPET->value,
            'marks' => 5,
        ]);
    }

    /**
     * Create fill in the blank question
     */
    public function fillInBlanks(): static
    {
        return $this->state([
            'type' => QuestionType::FILL_IN_BLANK->value,
            'marks' => 2,
        ]);
    }

    /**
     * Create short answer question
     */
    public function shortAnswer(): static
    {
        return $this->state([
            'type' => QuestionType::SHORT_ANSWER->value,
            'marks' => 3,
        ]);
    }

    /**
     * Create easy question
     */
    public function easy(): static
    {
        return $this->withDifficulty(Difficulty::EASY);
    }

    /**
     * Create medium question
     */
    public function medium(): static
    {
        return $this->withDifficulty(Difficulty::MEDIUM);
    }

    /**
     * Create hard question
     */
    public function hard(): static
    {
        return $this->withDifficulty(Difficulty::HARD);
    }

    /**
     * Create very hard question
     */
    public function veryHard(): static
    {
        return $this->withDifficulty(Difficulty::VERY_HARD);
    }

    /**
     * Create active question
     */
    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    /**
     * Create inactive question
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create question with image
     */
    public function withImage(): static
    {
        return $this->state([
            'type' => QuestionType::IMAGE_BASED->value,
            'image_url' => fake()->imageUrl(640, 480, 'technology'),
        ]);
    }

    /**
     * Create question for specific topic
     */
    public function forTopic(Topic $topic): static
    {
        return $this->state([
            'topic_id' => $topic->id,
        ]);
    }
}