<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Leaderboard;
use App\Enums\Period;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leaderboard>
 */
class LeaderboardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalPoints = fake()->numberBetween(0, 15000);
        $testsCompleted = fake()->numberBetween(1, 200);
        $averageScore = fake()->numberBetween(30, 100);
        $currentStreak = fake()->numberBetween(0, 50);
        $longestStreak = fake()->numberBetween($currentStreak, max($currentStreak, 75));
        
        // Calculate level based on points (matching model logic)
        $level = $this->calculateLevel($totalPoints);
        
        // Generate realistic achievements based on performance
        $achievements = $this->generateAchievements($totalPoints, $testsCompleted, $averageScore, $currentStreak);
        
        return [
            'user_id' => User::factory(),
            'period' => fake()->randomElement(Period::cases()),
            'total_points' => $totalPoints,
            'tests_completed' => $testsCompleted,
            'average_score' => $averageScore,
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'rank_position' => fake()->numberBetween(1, 1000),
            'last_activity_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'achievements' => $achievements,
            'level' => $level,
        ];
    }

    /**
     * Calculate level based on total points (matching Leaderboard model logic)
     */
    private function calculateLevel(int $totalPoints): int
    {
        $thresholds = [
            1 => 0,      // Beginner
            2 => 100,    // Novice
            3 => 300,    // Intermediate
            4 => 600,    // Advanced
            5 => 1000,   // Expert
            6 => 1500,   // Master
            7 => 2500,   // Grandmaster
            8 => 4000,   // Legend
            9 => 6000,   // Mythic
            10 => 10000, // God Tier
        ];
        
        $level = 1;
        foreach ($thresholds as $requiredLevel => $requiredPoints) {
            if ($totalPoints >= $requiredPoints) {
                $level = $requiredLevel;
            } else {
                break;
            }
        }
        
        return $level;
    }

    /**
     * Generate realistic achievements based on performance
     */
    private function generateAchievements(int $totalPoints, int $testsCompleted, float $averageScore, int $currentStreak): array
    {
        $achievements = [];
        
        // Streak achievements
        if ($currentStreak >= 5) {
            $achievements['streak_5'] = [
                'description' => 'Completed 5 tests in a row!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($currentStreak >= 10) {
            $achievements['streak_10'] = [
                'description' => 'Completed 10 tests in a row!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($currentStreak >= 25) {
            $achievements['streak_25'] = [
                'description' => 'Completed 25 tests in a row!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        
        // Tests completed achievements
        if ($testsCompleted >= 10) {
            $achievements['tests_10'] = [
                'description' => 'Completed 10 tests!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($testsCompleted >= 50) {
            $achievements['tests_50'] = [
                'description' => 'Completed 50 tests!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($testsCompleted >= 100) {
            $achievements['tests_100'] = [
                'description' => 'Completed 100 tests!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        
        // Score achievements
        if ($averageScore >= 90) {
            $achievements['perfectionist'] = [
                'description' => 'Maintained 90%+ average score!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($averageScore >= 95) {
            $achievements['master_perfectionist'] = [
                'description' => 'Maintained 95%+ average score!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        
        // Points achievements
        if ($totalPoints >= 1000) {
            $achievements['points_1000'] = [
                'description' => 'Earned 1000 points!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($totalPoints >= 5000) {
            $achievements['points_5000'] = [
                'description' => 'Earned 5000 points!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        if ($totalPoints >= 10000) {
            $achievements['points_10000'] = [
                'description' => 'Earned 10000 points!',
                'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
            ];
        }
        
        return $achievements;
    }

    /**
     * Create a beginner level leaderboard entry
     */
    public function beginner(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalPoints = fake()->numberBetween(0, 200);
            $testsCompleted = fake()->numberBetween(1, 15);
            $averageScore = fake()->numberBetween(30, 60);
            $currentStreak = fake()->numberBetween(0, 3);
            
            return [
                'total_points' => $totalPoints,
                'tests_completed' => $testsCompleted,
                'average_score' => $averageScore,
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, 5)),
                'level' => $this->calculateLevel($totalPoints),
                'achievements' => $this->generateAchievements($totalPoints, $testsCompleted, $averageScore, $currentStreak),
                'rank_position' => fake()->numberBetween(500, 1000),
            ];
        });
    }

    /**
     * Create an intermediate level leaderboard entry
     */
    public function intermediate(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalPoints = fake()->numberBetween(300, 1500);
            $testsCompleted = fake()->numberBetween(15, 50);
            $averageScore = fake()->numberBetween(60, 80);
            $currentStreak = fake()->numberBetween(2, 15);
            
            return [
                'total_points' => $totalPoints,
                'tests_completed' => $testsCompleted,
                'average_score' => $averageScore,
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, 20)),
                'level' => $this->calculateLevel($totalPoints),
                'achievements' => $this->generateAchievements($totalPoints, $testsCompleted, $averageScore, $currentStreak),
                'rank_position' => fake()->numberBetween(100, 500),
            ];
        });
    }

    /**
     * Create an advanced level leaderboard entry
     */
    public function advanced(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalPoints = fake()->numberBetween(1500, 10000);
            $testsCompleted = fake()->numberBetween(50, 150);
            $averageScore = fake()->numberBetween(80, 95);
            $currentStreak = fake()->numberBetween(10, 40);
            
            return [
                'total_points' => $totalPoints,
                'tests_completed' => $testsCompleted,
                'average_score' => $averageScore,
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, 50)),
                'level' => $this->calculateLevel($totalPoints),
                'achievements' => $this->generateAchievements($totalPoints, $testsCompleted, $averageScore, $currentStreak),
                'rank_position' => fake()->numberBetween(10, 100),
            ];
        });
    }

    /**
     * Create a top-tier leaderboard entry
     */
    public function elite(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalPoints = fake()->numberBetween(10000, 25000);
            $testsCompleted = fake()->numberBetween(100, 300);
            $averageScore = fake()->numberBetween(90, 100);
            $currentStreak = fake()->numberBetween(25, 100);
            
            return [
                'total_points' => $totalPoints,
                'tests_completed' => $testsCompleted,
                'average_score' => $averageScore,
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, 150)),
                'level' => 10, // God Tier
                'achievements' => $this->generateAchievements($totalPoints, $testsCompleted, $averageScore, $currentStreak),
                'rank_position' => fake()->numberBetween(1, 10),
                'last_activity_at' => fake()->dateTimeBetween('-3 days', 'now'), // Very active
            ];
        });
    }

    /**
     * Create weekly period leaderboard
     */
    public function weekly(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'period' => Period::WEEKLY,
                'total_points' => fake()->numberBetween(0, 1000), // Lower points for weekly
                'tests_completed' => fake()->numberBetween(1, 25),
                'last_activity_at' => fake()->dateTimeBetween('-7 days', 'now'),
            ];
        });
    }

    /**
     * Create monthly period leaderboard
     */
    public function monthly(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'period' => Period::MONTHLY,
                'total_points' => fake()->numberBetween(0, 5000), // Moderate points for monthly
                'tests_completed' => fake()->numberBetween(1, 100),
                'last_activity_at' => fake()->dateTimeBetween('-30 days', 'now'),
            ];
        });
    }

    /**
     * Create all-time period leaderboard
     */
    public function allTime(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'period' => Period::ALL_TIME,
                'last_activity_at' => fake()->dateTimeBetween('-6 months', 'now'),
            ];
        });
    }

    /**
     * Create recently active leaderboard entry
     */
    public function recentlyActive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'last_activity_at' => fake()->dateTimeBetween('-7 days', 'now'),
            ];
        });
    }

    /**
     * Create inactive leaderboard entry
     */
    public function inactive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'last_activity_at' => fake()->dateTimeBetween('-6 months', '-1 month'),
                'current_streak' => 0, // No current streak for inactive users
            ];
        });
    }

    /**
     * Create high-achieving leaderboard entry with many achievements
     */
    public function achievementHunter(): Factory
    {
        return $this->state(function (array $attributes) {
            $totalPoints = fake()->numberBetween(5000, 15000);
            $testsCompleted = fake()->numberBetween(100, 250);
            $averageScore = fake()->numberBetween(85, 98);
            $currentStreak = fake()->numberBetween(20, 75);
            
            // Ensure this user gets most achievements
            $achievements = [
                'streak_5' => [
                    'description' => 'Completed 5 tests in a row!',
                     'earned_at' => fake()->dateTimeBetween('-2 months', 'now')->format('c'),
                ],
                'streak_10' => [
                    'description' => 'Completed 10 tests in a row!',
                     'earned_at' => fake()->dateTimeBetween('-2 months', 'now')->format('c'),
                ],
                'streak_25' => [
                    'description' => 'Completed 25 tests in a row!',
                    'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
                ],
                'tests_10' => [
                    'description' => 'Completed 10 tests!',
                     'earned_at' => fake()->dateTimeBetween('-3 months', 'now')->format('c'),
                ],
                'tests_50' => [
                    'description' => 'Completed 50 tests!',
                     'earned_at' => fake()->dateTimeBetween('-2 months', 'now')->format('c'),
                ],
                'tests_100' => [
                    'description' => 'Completed 100 tests!',
                    'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
                ],
                'perfectionist' => [
                    'description' => 'Maintained 90%+ average score!',
                    'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
                ],
                'points_1000' => [
                    'description' => 'Earned 1000 points!',
                     'earned_at' => fake()->dateTimeBetween('-2 months', 'now')->format('c'),
                ],
                'points_5000' => [
                    'description' => 'Earned 5000 points!',
                    'earned_at' => fake()->dateTimeBetween('-1 month', 'now')->format('c'),
                ],
            ];
            
            if ($totalPoints >= 10000) {
                $achievements['points_10000'] = [
                    'description' => 'Earned 10000 points!',
                     'earned_at' => fake()->dateTimeBetween('-2 weeks', 'now')->format('c'),
                ];
            }
            
            if ($averageScore >= 95) {
                $achievements['master_perfectionist'] = [
                    'description' => 'Maintained 95%+ average score!',
                     'earned_at' => fake()->dateTimeBetween('-2 weeks', 'now')->format('c'),
                ];
            }
            
            return [
                'total_points' => $totalPoints,
                'tests_completed' => $testsCompleted,
                'average_score' => $averageScore,
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, 100)),
                'level' => $this->calculateLevel($totalPoints),
                'achievements' => $achievements,
                'rank_position' => fake()->numberBetween(1, 50),
            ];
        });
    }

    /**
     * Create realistic HSC student leaderboard patterns
     */
    public function hscStudentPattern(): Factory
    {
        return $this->state(function (array $attributes) {
            $patterns = [
                // Struggling student
                [
                    'total_points' => fake()->numberBetween(0, 150),
                    'tests_completed' => fake()->numberBetween(1, 10),
                    'average_score' => fake()->numberBetween(25, 50),
                    'current_streak' => fake()->numberBetween(0, 2),
                    'rank_range' => [700, 1000],
                ],
                // Average student
                [
                    'total_points' => fake()->numberBetween(200, 800),
                    'tests_completed' => fake()->numberBetween(10, 35),
                    'average_score' => fake()->numberBetween(55, 75),
                    'current_streak' => fake()->numberBetween(1, 8),
                    'rank_range' => [200, 700],
                ],
                // Above-average student
                [
                    'total_points' => fake()->numberBetween(800, 2000),
                    'tests_completed' => fake()->numberBetween(25, 75),
                    'average_score' => fake()->numberBetween(75, 88),
                    'current_streak' => fake()->numberBetween(5, 20),
                    'rank_range' => [50, 200],
                ],
                // High-achieving student
                [
                    'total_points' => fake()->numberBetween(2000, 8000),
                    'tests_completed' => fake()->numberBetween(50, 150),
                    'average_score' => fake()->numberBetween(85, 96),
                    'current_streak' => fake()->numberBetween(10, 50),
                    'rank_range' => [1, 50],
                ],
            ];
            
            $pattern = fake()->randomElement($patterns);
            $currentStreak = $pattern['current_streak'];
            
            return [
                'total_points' => $pattern['total_points'],
                'tests_completed' => $pattern['tests_completed'],
                'average_score' => $pattern['average_score'],
                'current_streak' => $currentStreak,
                'longest_streak' => fake()->numberBetween($currentStreak, max($currentStreak, $currentStreak + 10)),
                'level' => $this->calculateLevel($pattern['total_points']),
                'achievements' => $this->generateAchievements(
                    $pattern['total_points'],
                    $pattern['tests_completed'],
                    $pattern['average_score'],
                    $currentStreak
                ),
                'rank_position' => fake()->numberBetween($pattern['rank_range'][0], $pattern['rank_range'][1]),
                'last_activity_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
            ];
        });
    }

    /**
     * Create streak specialist (high streak, moderate other stats)
     */
    public function streakSpecialist(): Factory
    {
        return $this->state(function (array $attributes) {
            $currentStreak = fake()->numberBetween(30, 100);
            $longestStreak = fake()->numberBetween($currentStreak, $currentStreak + 50);
            
            return [
                'current_streak' => $currentStreak,
                'longest_streak' => $longestStreak,
                'tests_completed' => fake()->numberBetween($currentStreak, $currentStreak + 20),
                'average_score' => fake()->numberBetween(70, 85), // Good but not perfect
                'last_activity_at' => fake()->dateTimeBetween('-2 days', 'now'), // Very recent
            ];
        });
    }
}