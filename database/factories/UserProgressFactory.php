<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProgress>
 */
class UserProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['chapter', 'topic']);
        
        // Generate performance data
        $totalAttempts = fake()->numberBetween(1, 50);
        $correctAnswers = fake()->numberBetween(0, $totalAttempts);
        $wrongAnswers = $totalAttempts - $correctAnswers;
        $accuracyRate = $totalAttempts > 0 ? ($correctAnswers / $totalAttempts) * 100 : 0;
        
        // Base completion on accuracy and attempts (similar to model logic)
        $accuracyFactor = min(100, $accuracyRate);
        $attemptsFactor = min(100, $totalAttempts * 10);
        $completionPercentage = ($accuracyFactor * 0.7) + ($attemptsFactor * 0.3);
        
        // Generate performance trend (last 3-10 entries)
        $trendEntries = fake()->numberBetween(3, 10);
        $performanceTrend = [];
        
        for ($i = 0; $i < $trendEntries; $i++) {
            $performanceTrend[] = [
                'score' => fake()->numberBetween(0, 100),
                'accuracy' => fake()->numberBetween(0, 100),
                'timestamp' => now()->subDays(fake()->numberBetween(1, 30))->toISOString(),
            ];
        }
        
        return [
            'user_id' => User::factory(),
            'chapter_id' => $type === 'chapter' ? Chapter::factory() : null,
            'topic_id' => $type === 'topic' ? Topic::factory() : null,
            'type' => $type,
            'completion_percentage' => round($completionPercentage, 2),
            'total_attempts' => $totalAttempts,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'accuracy_rate' => round($accuracyRate, 2),
            'time_spent_minutes' => fake()->numberBetween(5, 300), // 5 minutes to 5 hours
            'last_practiced_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'is_weak_area' => $accuracyRate < 60 && $totalAttempts >= 5,
            'streak_count' => fake()->numberBetween(0, 15),
            'best_score' => fake()->numberBetween(max(0, $accuracyRate - 10), 100),
            'performance_trend' => $performanceTrend,
        ];
    }

    /**
     * Create a beginner user progress
     */
    public function beginner(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalAttempts = fake()->numberBetween(1, 10);
            $correctAnswers = fake()->numberBetween(0, (int)($totalAttempts * 0.4)); // Low accuracy
            $wrongAnswers = $totalAttempts - $correctAnswers;
            $accuracyRate = $totalAttempts > 0 ? ($correctAnswers / $totalAttempts) * 100 : 0;
            
            return [
                'completion_percentage' => fake()->numberBetween(0, 25),
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'accuracy_rate' => round($accuracyRate, 2),
                'time_spent_minutes' => fake()->numberBetween(5, 60),
                'is_weak_area' => fake()->boolean(70), // 70% chance of being weak area
                'streak_count' => fake()->numberBetween(0, 3),
                'best_score' => fake()->numberBetween(0, 40),
            ];
        });
    }

    /**
     * Create an intermediate user progress
     */
    public function intermediate(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalAttempts = fake()->numberBetween(10, 25);
            $correctAnswers = fake()->numberBetween((int)($totalAttempts * 0.5), (int)($totalAttempts * 0.75));
            $wrongAnswers = $totalAttempts - $correctAnswers;
            $accuracyRate = ($correctAnswers / $totalAttempts) * 100;
            
            return [
                'completion_percentage' => fake()->numberBetween(25, 75),
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'accuracy_rate' => round($accuracyRate, 2),
                'time_spent_minutes' => fake()->numberBetween(60, 180),
                'is_weak_area' => fake()->boolean(30), // 30% chance of being weak area
                'streak_count' => fake()->numberBetween(2, 8),
                'best_score' => fake()->numberBetween(40, 80),
            ];
        });
    }

    /**
     * Create an advanced user progress
     */
    public function advanced(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalAttempts = fake()->numberBetween(20, 50);
            $correctAnswers = fake()->numberBetween((int)($totalAttempts * 0.8), $totalAttempts);
            $wrongAnswers = $totalAttempts - $correctAnswers;
            $accuracyRate = ($correctAnswers / $totalAttempts) * 100;
            
            return [
                'completion_percentage' => fake()->numberBetween(75, 100),
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'accuracy_rate' => round($accuracyRate, 2),
                'time_spent_minutes' => fake()->numberBetween(120, 300),
                'is_weak_area' => false,
                'streak_count' => fake()->numberBetween(5, 15),
                'best_score' => fake()->numberBetween(80, 100),
            ];
        });
    }

    /**
     * Create a weak area progress
     */
    public function weakArea(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalAttempts = fake()->numberBetween(8, 30); // Sufficient attempts
            $correctAnswers = fake()->numberBetween(0, (int)($totalAttempts * 0.5)); // Low accuracy
            $wrongAnswers = $totalAttempts - $correctAnswers;
            $accuracyRate = ($correctAnswers / $totalAttempts) * 100;
            
            return [
                'completion_percentage' => fake()->numberBetween(0, 40),
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'accuracy_rate' => round($accuracyRate, 2),
                'is_weak_area' => true,
                'streak_count' => fake()->numberBetween(0, 2),
                'best_score' => fake()->numberBetween(0, 50),
            ];
        });
    }

    /**
     * Create a high-performing streak progress
     */
    public function streak(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalAttempts = fake()->numberBetween(15, 40);
            $correctAnswers = fake()->numberBetween((int)($totalAttempts * 0.85), $totalAttempts);
            $wrongAnswers = $totalAttempts - $correctAnswers;
            $accuracyRate = ($correctAnswers / $totalAttempts) * 100;
            
            return [
                'completion_percentage' => fake()->numberBetween(60, 100),
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'accuracy_rate' => round($accuracyRate, 2),
                'is_weak_area' => false,
                'streak_count' => fake()->numberBetween(8, 20),
                'best_score' => fake()->numberBetween(85, 100),
                'last_practiced_at' => fake()->dateTimeBetween('-3 days', 'now'), // Recent activity
            ];
        });
    }

    /**
     * Create chapter-level progress
     */
    public function chapterProgress(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'chapter',
                'chapter_id' => Chapter::factory(),
                'topic_id' => null,
            ];
        });
    }

    /**
     * Create topic-level progress
     */
    public function topicProgress(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'topic',
                'chapter_id' => null,
                'topic_id' => Topic::factory(),
            ];
        });
    }

    /**
     * Create recently practiced progress
     */
    public function recentlyPracticed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'last_practiced_at' => fake()->dateTimeBetween('-7 days', 'now'),
            ];
        });
    }

    /**
     * Create improving performance trend
     */
    public function improvingTrend(): Factory
    {
        return $this->state(function (array $attributes) {
            // Create an improving trend in performance_trend
            $trendEntries = fake()->numberBetween(5, 10);
            $performanceTrend = [];
            $baseScore = fake()->numberBetween(20, 40);
            
            for ($i = 0; $i < $trendEntries; $i++) {
                $score = $baseScore + ($i * fake()->numberBetween(5, 10)); // Increasing scores
                $performanceTrend[] = [
                    'score' => min(100, $score),
                    'accuracy' => min(100, $score + fake()->numberBetween(-5, 5)),
                    'timestamp' => now()->subDays($trendEntries - $i)->toISOString(),
                ];
            }
            
            return [
                'performance_trend' => $performanceTrend,
            ];
        });
    }

    /**
     * Create declining performance trend
     */
    public function decliningTrend(): Factory
    {
        return $this->state(function (array $attributes) {
            // Create a declining trend in performance_trend
            $trendEntries = fake()->numberBetween(5, 10);
            $performanceTrend = [];
            $baseScore = fake()->numberBetween(60, 80);
            
            for ($i = 0; $i < $trendEntries; $i++) {
                $score = $baseScore - ($i * fake()->numberBetween(3, 8)); // Decreasing scores
                $performanceTrend[] = [
                    'score' => max(0, $score),
                    'accuracy' => max(0, $score + fake()->numberBetween(-5, 5)),
                    'timestamp' => now()->subDays($trendEntries - $i)->toISOString(),
                ];
            }
            
            return [
                'performance_trend' => $performanceTrend,
            ];
        });
    }

    /**
     * Create realistic HSC ICT student progress patterns
     */
    public function hscStudentPattern(): Factory
    {
        return $this->state(function (array $attributes) {
            $patterns = [
                // Struggling student
                [
                    'completion_percentage' => fake()->numberBetween(10, 35),
                    'accuracy_rate' => fake()->numberBetween(25, 55),
                    'total_attempts' => fake()->numberBetween(5, 20),
                    'is_weak_area' => fake()->boolean(80),
                    'streak_count' => fake()->numberBetween(0, 2),
                    'time_spent_minutes' => fake()->numberBetween(30, 120),
                ],
                // Average student
                [
                    'completion_percentage' => fake()->numberBetween(40, 70),
                    'accuracy_rate' => fake()->numberBetween(60, 78),
                    'total_attempts' => fake()->numberBetween(15, 35),
                    'is_weak_area' => fake()->boolean(40),
                    'streak_count' => fake()->numberBetween(2, 6),
                    'time_spent_minutes' => fake()->numberBetween(80, 200),
                ],
                // High-achieving student
                [
                    'completion_percentage' => fake()->numberBetween(75, 95),
                    'accuracy_rate' => fake()->numberBetween(80, 95),
                    'total_attempts' => fake()->numberBetween(25, 50),
                    'is_weak_area' => fake()->boolean(15),
                    'streak_count' => fake()->numberBetween(5, 12),
                    'time_spent_minutes' => fake()->numberBetween(150, 300),
                ],
            ];
            
            $pattern = fake()->randomElement($patterns);
            
            // Calculate consistent values
            $totalAttempts = $pattern['total_attempts'];
            $correctAnswers = (int)($totalAttempts * ($pattern['accuracy_rate'] / 100));
            $wrongAnswers = $totalAttempts - $correctAnswers;
            
            return array_merge($pattern, [
                'total_attempts' => $totalAttempts,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'best_score' => fake()->numberBetween((int)$pattern['accuracy_rate'], min(100, (int)$pattern['accuracy_rate'] + 15)),
                'last_practiced_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
            ]);
        });
    }
}