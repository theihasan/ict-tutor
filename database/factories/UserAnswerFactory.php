<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\TestAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAnswer>
 */
class UserAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testAttempt = TestAttempt::inRandomOrder()->first();
        $question = Question::inRandomOrder()->first();
        $user = $testAttempt ? User::find($testAttempt->user_id) : User::inRandomOrder()->first();
        
        // Determine if answer should be correct based on user performance
        $shouldBeCorrect = $this->shouldAnswerBeCorrect($user, $question);
        
        // Generate answer based on question type
        $answerData = $this->generateAnswerForQuestion($question, $shouldBeCorrect);
        
        // Calculate time spent (varies by question difficulty and type)
        $timeSpent = $this->calculateTimeSpent($question);
        
        return [
            'user_id' => $user?->id ?? User::factory(),
            'question_id' => $question?->id ?? Question::factory(),
            'test_attempt_id' => $testAttempt?->id ?? TestAttempt::factory(),
            'user_answer' => $answerData['answer'],
            'is_correct' => $answerData['is_correct'],
            'points_earned' => $answerData['points_earned'],
            'time_spent' => $timeSpent,
            'answered_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'is_flagged' => fake()->boolean(5), // 5% of answers are flagged for review
            'confidence_level' => fake()->numberBetween(1, 5),
            'attempt_count' => fake()->numberBetween(1, 3), // How many times they changed their answer
        ];
    }

    /**
     * Determine if answer should be correct based on user performance
     */
    private function shouldAnswerBeCorrect(?User $user, ?Question $question): bool
    {
        $baseCorrectRate = 0.6; // 60% base correct rate
        
        // Admin users have higher correct rate
        if ($user && $user->role === 'admin') {
            $baseCorrectRate = 0.85;
        }
        
        // Adjust based on question difficulty
        if ($question) {
            $difficulty = $question->difficulty;
            $adjustmentMap = [
                'very_easy' => 0.2,   // +20% chance
                'easy' => 0.1,        // +10% chance
                'medium' => 0,        // No adjustment
                'hard' => -0.15,      // -15% chance
                'very_hard' => -0.25, // -25% chance
            ];
            
            $baseCorrectRate += $adjustmentMap[$difficulty] ?? 0;
        }
        
        // Ensure rate stays within bounds
        $baseCorrectRate = max(0.1, min(0.95, $baseCorrectRate));
        
        return fake()->boolean((int) ($baseCorrectRate * 100));
    }

    /**
     * Generate answer based on question type
     */
    private function generateAnswerForQuestion(?Question $question, bool $shouldBeCorrect): array
    {
        if (!$question) {
            return [
                'answer' => 'A',
                'is_correct' => fake()->boolean(),
                'points_earned' => fake()->numberBetween(0, 5),
            ];
        }
        
        $questionType = $question->type ?? QuestionType::MULTIPLE_CHOICE;
        $points = $question->points ?? $questionType->defaultPoints();
        
        if ($shouldBeCorrect) {
            return [
                'answer' => $question->correct_answer,
                'is_correct' => true,
                'points_earned' => $points,
            ];
        }
        
        // Generate wrong answer based on question type
        $wrongAnswer = $this->generateWrongAnswer($questionType, $question);
        
        return [
            'answer' => $wrongAnswer,
            'is_correct' => false,
            'points_earned' => 0,
        ];
    }

    /**
     * Generate wrong answer based on question type
     */
    private function generateWrongAnswer(QuestionType $questionType, Question $question): string
    {
        return match($questionType) {
            QuestionType::MULTIPLE_CHOICE => $this->generateWrongMultipleChoice($question),
            QuestionType::TRUE_FALSE => $question->correct_answer === 'True' ? 'False' : 'True',
            QuestionType::FILL_IN_BLANK => fake()->word(),
            QuestionType::SHORT_ANSWER => fake()->sentence(),
            QuestionType::CODE_SNIPPET => fake()->randomElement([
                'syntax error code',
                'incomplete code',
                'wrong logic implementation'
            ]),
            QuestionType::IMAGE_BASED => fake()->randomElement(['A', 'B', 'C', 'D']),
            QuestionType::DRAG_DROP => json_encode(['wrong' => 'positions']),
            QuestionType::MATCHING => json_encode(['incorrect' => 'matches']),
        };
    }

    /**
     * Generate wrong multiple choice answer
     */
    private function generateWrongMultipleChoice(Question $question): string
    {
        $options = ['A', 'B', 'C', 'D'];
        $correctAnswer = $question->correct_answer;
        
        // Remove the correct answer from options
        $wrongOptions = array_filter($options, fn($option) => $option !== $correctAnswer);
        
        return fake()->randomElement($wrongOptions);
    }

    /**
     * Calculate time spent on question
     */
    private function calculateTimeSpent(?Question $question): int
    {
        $baseTime = 60; // 60 seconds base
        
        if ($question) {
            // Adjust based on difficulty
            $difficultyMultiplier = [
                'very_easy' => 0.5,
                'easy' => 0.7,
                'medium' => 1.0,
                'hard' => 1.5,
                'very_hard' => 2.0,
            ];
            
            $multiplier = $difficultyMultiplier[$question->difficulty] ?? 1.0;
            $baseTime = (int) ($baseTime * $multiplier);
            
            // Adjust based on question type
            $questionType = $question->type;
            if ($questionType) {
                $typeMultiplier = match($questionType) {
                    QuestionType::MULTIPLE_CHOICE, QuestionType::TRUE_FALSE => 0.8,
                    QuestionType::FILL_IN_BLANK => 1.2,
                    QuestionType::SHORT_ANSWER => 2.0,
                    QuestionType::CODE_SNIPPET => 3.0,
                    QuestionType::IMAGE_BASED => 1.5,
                    QuestionType::DRAG_DROP, QuestionType::MATCHING => 1.8,
                };
                
                $baseTime = (int) ($baseTime * $typeMultiplier);
            }
        }
        
        // Add randomness ±30%
        $variation = fake()->numberBetween(-30, 30) / 100;
        $finalTime = (int) ($baseTime * (1 + $variation));
        
        return max(10, $finalTime); // Minimum 10 seconds
    }

    /**
     * Create correct answer
     */
    public function correct(): static
    {
        return $this->state(function (array $attributes) {
            $question = Question::find($attributes['question_id']);
            $points = $question ? $question->points : 1;
            
            return [
                'user_answer' => $question?->correct_answer ?? 'A',
                'is_correct' => true,
                'points_earned' => $points,
                'confidence_level' => fake()->numberBetween(4, 5), // High confidence
            ];
        });
    }

    /**
     * Create wrong answer
     */
    public function wrong(): static
    {
        return $this->state(function (array $attributes) {
            $question = Question::find($attributes['question_id']);
            $questionType = $question ? $question->type : QuestionType::MULTIPLE_CHOICE;
            
            $wrongAnswer = $questionType ? 
                $this->generateWrongAnswer($questionType, $question) : 
                'Wrong Answer';
            
            return [
                'user_answer' => $wrongAnswer,
                'is_correct' => false,
                'points_earned' => 0,
                'confidence_level' => fake()->numberBetween(1, 3), // Lower confidence
            ];
        });
    }

    /**
     * Create skipped answer
     */
    public function skipped(): static
    {
        return $this->state([
            'user_answer' => null,
            'is_correct' => false,
            'points_earned' => 0,
            'time_spent' => fake()->numberBetween(5, 30), // Minimal time
            'confidence_level' => 1,
            'attempt_count' => 0,
        ]);
    }

    /**
     * Create flagged answer (for review)
     */
    public function flagged(): static
    {
        return $this->state([
            'is_flagged' => true,
            'confidence_level' => fake()->numberBetween(1, 3), // Lower confidence when flagged
        ]);
    }

    /**
     * Create answer with high confidence
     */
    public function confident(): static
    {
        return $this->state([
            'confidence_level' => fake()->numberBetween(4, 5),
            'attempt_count' => 1, // Answered quickly without changes
        ]);
    }

    /**
     * Create answer with low confidence
     */
    public function uncertain(): static
    {
        return $this->state([
            'confidence_level' => fake()->numberBetween(1, 2),
            'attempt_count' => fake()->numberBetween(2, 5), // Changed answer multiple times
            'is_flagged' => fake()->boolean(30), // 30% chance of being flagged
        ]);
    }

    /**
     * Create quick answer (answered fast)
     */
    public function quick(): static
    {
        return $this->state([
            'time_spent' => fake()->numberBetween(10, 30), // 10-30 seconds
            'attempt_count' => 1,
        ]);
    }

    /**
     * Create slow answer (took long time)
     */
    public function slow(): static
    {
        return $this->state([
            'time_spent' => fake()->numberBetween(180, 600), // 3-10 minutes
            'attempt_count' => fake()->numberBetween(2, 4),
        ]);
    }

    /**
     * Create answer for specific question
     */
    public function forQuestion(Question $question): static
    {
        return $this->state([
            'question_id' => $question->id,
        ]);
    }

    /**
     * Create answer for specific user
     */
    public function forUser(User $user): static
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create answer for specific test attempt
     */
    public function forTestAttempt(TestAttempt $testAttempt): static
    {
        return $this->state([
            'test_attempt_id' => $testAttempt->id,
            'user_id' => $testAttempt->user_id,
        ]);
    }

    /**
     * Create recent answer
     */
    public function recent(): static
    {
        return $this->state([
            'answered_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create answer for programming question
     */
    public function programming(): static
    {
        return $this->state([
            'time_spent' => fake()->numberBetween(120, 600), // 2-10 minutes for coding
            'attempt_count' => fake()->numberBetween(1, 3),
        ]);
    }

    /**
     * Create answer for theory question
     */
    public function theory(): static
    {
        return $this->state([
            'time_spent' => fake()->numberBetween(30, 120), // 30 seconds to 2 minutes
            'attempt_count' => fake()->numberBetween(1, 2),
        ]);
    }
}