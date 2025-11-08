<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestAttempt>
 */
class TestAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $test = Test::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        
        // Generate realistic performance based on user role and test difficulty
        $isAdmin = $user && $user->role === 'admin';
        $totalMarks = $test ? $test->total_marks : 100;
        $totalQuestions = $test ? $test->total_questions : 20;
        
        // Admin users tend to perform better
        $performanceMultiplier = $isAdmin ? 0.85 : fake()->randomFloat(1, 0.3, 0.9);
        
        // Calculate realistic scores
        $correctAnswers = (int) ($totalQuestions * $performanceMultiplier);
        $wrongAnswers = fake()->numberBetween(0, $totalQuestions - $correctAnswers);
        $skippedAnswers = $totalQuestions - $correctAnswers - $wrongAnswers;
        
        $obtainedMarks = (int) ($totalMarks * $performanceMultiplier);
        $obtainedMarks += fake()->numberBetween(-5, 5); // Add some randomness
        $obtainedMarks = max(0, min($obtainedMarks, $totalMarks)); // Ensure within bounds
        
        // Calculate percentage
        $percentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;
        
        // Determine pass/fail
        $passingMarks = $test ? $test->passing_marks : ($totalMarks * 0.4);
        $isPassed = $obtainedMarks >= $passingMarks;
        
        // Calculate time taken (some students finish early, some use full time)
        $maxTimeMinutes = $test ? $test->duration : 60;
        $timeTakenMinutes = fake()->numberBetween(
            (int) ($maxTimeMinutes * 0.4), // Minimum 40% of total time
            $maxTimeMinutes // Maximum full time
        );
        
        $startedAt = fake()->dateTimeBetween('-2 months', 'now');
        $completedAt = (clone $startedAt)->modify("+{$timeTakenMinutes} minutes");
        
        return [
            'test_id' => $test?->id ?? Test::factory(),
            'user_id' => $user?->id ?? User::factory(),
            'started_at' => $startedAt,
            'completed_at' => fake()->boolean(85) ? $completedAt : null, // 85% completion rate
            'time_taken' => fake()->boolean(85) ? $timeTakenMinutes : null,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'skipped_answers' => $skippedAnswers,
            'obtained_marks' => $obtainedMarks,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'attempt_number' => fake()->numberBetween(1, 3),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'answers' => $this->generateAnswers($totalQuestions),
            'time_spent_per_question' => $this->generateTimeSpentPerQuestion($totalQuestions, $timeTakenMinutes),
            'notes' => fake()->optional(20)->paragraph(),
        ];
    }

    /**
     * Generate realistic answers for the test
     */
    private function generateAnswers(int $totalQuestions): string
    {
        $answers = [];
        
        for ($i = 1; $i <= $totalQuestions; $i++) {
            $answers[$i] = fake()->randomElement([
                'A', 'B', 'C', 'D', // Multiple choice
                'True', 'False', // True/False
                fake()->word(), // Fill in blank
                fake()->sentence(), // Short answer
                null, // Skipped
            ]);
        }
        
        return json_encode($answers);
    }

    /**
     * Generate time spent per question
     */
    private function generateTimeSpentPerQuestion(int $totalQuestions, ?int $totalTime): ?string
    {
        if (!$totalTime) {
            return null;
        }
        
        $timePerQuestion = [];
        $remainingTime = $totalTime * 60; // Convert to seconds
        
        for ($i = 1; $i <= $totalQuestions; $i++) {
            if ($i === $totalQuestions) {
                // Last question gets remaining time
                $timePerQuestion[$i] = $remainingTime;
            } else {
                // Random time between 30 seconds to 5 minutes
                $questionTime = fake()->numberBetween(30, min(300, $remainingTime));
                $timePerQuestion[$i] = $questionTime;
                $remainingTime -= $questionTime;
            }
        }
        
        return json_encode($timePerQuestion);
    }

    /**
     * Create completed test attempt
     */
    public function completed(): static
    {
        $startedAt = fake()->dateTimeBetween('-1 month', '-1 day');
        $timeTaken = fake()->numberBetween(15, 180); // 15 minutes to 3 hours
        $completedAt = (clone $startedAt)->modify("+{$timeTaken} minutes");
        
        return $this->state([
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'time_taken' => $timeTaken,
        ]);
    }

    /**
     * Create in-progress test attempt
     */
    public function inProgress(): static
    {
        return $this->state([
            'started_at' => fake()->dateTimeBetween('-2 hours', 'now'),
            'completed_at' => null,
            'time_taken' => null,
            'obtained_marks' => 0,
            'percentage' => 0,
            'is_passed' => false,
        ]);
    }

    /**
     * Create passed test attempt
     */
    public function passed(): static
    {
        return $this->state(function (array $attributes) {
            $totalMarks = $attributes['total_marks'] ?? 100;
            $passingMarks = (int) ($totalMarks * 0.6); // 60% to pass
            $obtainedMarks = fake()->numberBetween($passingMarks, $totalMarks);
            $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);
            
            return [
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentage,
                'is_passed' => true,
            ];
        });
    }

    /**
     * Create failed test attempt
     */
    public function failed(): static
    {
        return $this->state(function (array $attributes) {
            $totalMarks = $attributes['total_marks'] ?? 100;
            $passingMarks = (int) ($totalMarks * 0.4); // 40% to pass
            $obtainedMarks = fake()->numberBetween(0, $passingMarks - 1);
            $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);
            
            return [
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentage,
                'is_passed' => false,
            ];
        });
    }

    /**
     * Create high-scoring test attempt
     */
    public function highScore(): static
    {
        return $this->state(function (array $attributes) {
            $totalMarks = $attributes['total_marks'] ?? 100;
            $totalQuestions = $attributes['total_questions'] ?? 20;
            
            $obtainedMarks = fake()->numberBetween((int) ($totalMarks * 0.8), $totalMarks);
            $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);
            
            $correctAnswers = (int) ($totalQuestions * 0.85);
            $wrongAnswers = $totalQuestions - $correctAnswers;
            
            return [
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentage,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'skipped_answers' => 0,
                'is_passed' => true,
            ];
        });
    }

    /**
     * Create low-scoring test attempt
     */
    public function lowScore(): static
    {
        return $this->state(function (array $attributes) {
            $totalMarks = $attributes['total_marks'] ?? 100;
            $totalQuestions = $attributes['total_questions'] ?? 20;
            
            $obtainedMarks = fake()->numberBetween(0, (int) ($totalMarks * 0.3));
            $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);
            
            $correctAnswers = (int) ($totalQuestions * 0.3);
            $wrongAnswers = fake()->numberBetween($correctAnswers, $totalQuestions - $correctAnswers);
            $skippedAnswers = $totalQuestions - $correctAnswers - $wrongAnswers;
            
            return [
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentage,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'skipped_answers' => $skippedAnswers,
                'is_passed' => false,
            ];
        });
    }

    /**
     * Create first attempt
     */
    public function firstAttempt(): static
    {
        return $this->state([
            'attempt_number' => 1,
        ]);
    }

    /**
     * Create retry attempt
     */
    public function retryAttempt(): static
    {
        return $this->state([
            'attempt_number' => fake()->numberBetween(2, 5),
        ]);
    }

    /**
     * Create attempt for specific test
     */
    public function forTest(Test $test): static
    {
        return $this->state([
            'test_id' => $test->id,
            'total_questions' => $test->total_questions,
            'total_marks' => $test->total_marks,
        ]);
    }

    /**
     * Create attempt for specific user
     */
    public function forUser(User $user): static
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create recent attempt (within last week)
     */
    public function recent(): static
    {
        $startedAt = fake()->dateTimeBetween('-1 week', 'now');
        $timeTaken = fake()->numberBetween(15, 120);
        $completedAt = (clone $startedAt)->modify("+{$timeTaken} minutes");
        
        return $this->state([
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'time_taken' => $timeTaken,
        ]);
    }

    /**
     * Create quick attempt (finished early)
     */
    public function quick(): static
    {
        $startedAt = fake()->dateTimeBetween('-1 month', 'now');
        $timeTaken = fake()->numberBetween(5, 30); // Very quick
        $completedAt = (clone $startedAt)->modify("+{$timeTaken} minutes");
        
        return $this->state([
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'time_taken' => $timeTaken,
        ]);
    }

    /**
     * Create slow attempt (used most of the time)
     */
    public function slow(): static
    {
        return $this->state(function (array $attributes) {
            $test = Test::find($attributes['test_id']);
            $maxTime = $test ? $test->duration : 60;
            
            $startedAt = fake()->dateTimeBetween('-1 month', 'now');
            $timeTaken = fake()->numberBetween((int) ($maxTime * 0.8), $maxTime);
            $completedAt = (clone $startedAt)->modify("+{$timeTaken} minutes");
            
            return [
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'time_taken' => $timeTaken,
            ];
        });
    }
}