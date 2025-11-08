<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Enums\Period;

class Leaderboard extends Model
{
    use HasFactory;

    const LEVEL_THRESHOLDS = [
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

    protected $fillable = [
        'user_id',
        'period',
        'total_points',
        'tests_completed',
        'average_score',
        'current_streak',
        'longest_streak',
        'rank_position',
        'last_activity_at',
        'achievements',
        'level',
    ];

    protected $casts = [
        'period' => Period::class,
        'average_score' => 'decimal:2',
        'last_activity_at' => 'datetime',
        'achievements' => 'array',
    ];

    /**
     * Relationship: Leaderboard belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get level name based on points
     */
    public function getLevelName(): string
    {
        $levelNames = [
            1 => 'Beginner',
            2 => 'Novice',
            3 => 'Intermediate',
            4 => 'Advanced',
            5 => 'Expert',
            6 => 'Master',
            7 => 'Grandmaster',
            8 => 'Legend',
            9 => 'Mythic',
            10 => 'God Tier',
        ];

        return $levelNames[$this->level] ?? 'Unknown';
    }

    /**
     * Get points needed for next level
     */
    public function getPointsToNextLevel(): int
    {
        $nextLevel = $this->level + 1;
        
        if (!isset(self::LEVEL_THRESHOLDS[$nextLevel])) {
            return 0; // Max level reached
        }
        
        return self::LEVEL_THRESHOLDS[$nextLevel] - $this->total_points;
    }

    /**
     * Calculate level based on total points
     */
    public function calculateLevel(): int
    {
        $level = 1;
        
        foreach (self::LEVEL_THRESHOLDS as $requiredLevel => $requiredPoints) {
            if ($this->total_points >= $requiredPoints) {
                $level = $requiredLevel;
            } else {
                break;
            }
        }
        
        return $level;
    }

    /**
     * Update leaderboard stats
     */
    public function updateStats(int $points, float $score, bool $maintainedStreak = true): void
    {
        $this->total_points += $points;
        $this->tests_completed++;
        $this->last_activity_at = now();
        
        // Update average score
        $this->average_score = (($this->average_score * ($this->tests_completed - 1)) + $score) / $this->tests_completed;
        
        // Update streak
        if ($maintainedStreak) {
            $this->current_streak++;
            if ($this->current_streak > $this->longest_streak) {
                $this->longest_streak = $this->current_streak;
            }
        } else {
            $this->current_streak = 0;
        }
        
        // Update level
        $newLevel = $this->calculateLevel();
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
            $this->addAchievement("level_{$newLevel}", "Reached {$this->getLevelName()} Level!");
        }
        
        // Check for other achievements
        $this->checkAndAddAchievements();
        
        $this->save();
    }

    /**
     * Add achievement to user
     */
    public function addAchievement(string $key, string $description): void
    {
        $achievements = $this->achievements ?? [];
        
        if (!isset($achievements[$key])) {
            $achievements[$key] = [
                'description' => $description,
                'earned_at' => now()->toISOString(),
            ];
            
            $this->achievements = $achievements;
        }
    }

    /**
     * Check and add various achievements
     */
    private function checkAndAddAchievements(): void
    {
        // Streak achievements
        if ($this->current_streak == 5) {
            $this->addAchievement('streak_5', 'Completed 5 tests in a row!');
        }
        if ($this->current_streak == 10) {
            $this->addAchievement('streak_10', 'Completed 10 tests in a row!');
        }
        if ($this->current_streak == 25) {
            $this->addAchievement('streak_25', 'Completed 25 tests in a row!');
        }
        
        // Tests completed achievements
        if ($this->tests_completed == 10) {
            $this->addAchievement('tests_10', 'Completed 10 tests!');
        }
        if ($this->tests_completed == 50) {
            $this->addAchievement('tests_50', 'Completed 50 tests!');
        }
        if ($this->tests_completed == 100) {
            $this->addAchievement('tests_100', 'Completed 100 tests!');
        }
        
        // Score achievements
        if ($this->average_score >= 90) {
            $this->addAchievement('perfectionist', 'Maintained 90%+ average score!');
        }
        if ($this->average_score >= 95) {
            $this->addAchievement('master_perfectionist', 'Maintained 95%+ average score!');
        }
        
        // Points achievements
        if ($this->total_points >= 1000) {
            $this->addAchievement('points_1000', 'Earned 1000 points!');
        }
        if ($this->total_points >= 5000) {
            $this->addAchievement('points_5000', 'Earned 5000 points!');
        }
        if ($this->total_points >= 10000) {
            $this->addAchievement('points_10000', 'Earned 10000 points!');
        }
    }

    /**
     * Get all available achievements with status
     */
    public function getAllAchievements(): array
    {
        $allAchievements = [
            'streak_5' => 'Complete 5 tests in a row',
            'streak_10' => 'Complete 10 tests in a row', 
            'streak_25' => 'Complete 25 tests in a row',
            'tests_10' => 'Complete 10 tests',
            'tests_50' => 'Complete 50 tests',
            'tests_100' => 'Complete 100 tests',
            'perfectionist' => 'Maintain 90%+ average score',
            'master_perfectionist' => 'Maintain 95%+ average score',
            'points_1000' => 'Earn 1000 points',
            'points_5000' => 'Earn 5000 points',
            'points_10000' => 'Earn 10000 points',
        ];
        
        $userAchievements = $this->achievements ?? [];
        $result = [];
        
        foreach ($allAchievements as $key => $description) {
            $result[] = [
                'key' => $key,
                'description' => $description,
                'earned' => isset($userAchievements[$key]),
                'earned_at' => $userAchievements[$key]['earned_at'] ?? null,
            ];
        }
        
        return $result;
    }

    /**
     * Get user's rank among all users for this period
     */
    public function getCurrentRank(): int
    {
        if ($this->rank_position) {
            return $this->rank_position;
        }
        
        return self::where('period', $this->period)
            ->where('total_points', '>', $this->total_points)
            ->count() + 1;
    }

    /**
     * Update rank positions for all users in a period
     */
    public static function updateRankings(Period $period = Period::ALL_TIME): void
    {
        $leaderboards = self::where('period', $period->value)
            ->orderBy('total_points', 'desc')
            ->orderBy('average_score', 'desc')
            ->orderBy('current_streak', 'desc')
            ->get();
            
        foreach ($leaderboards as $index => $leaderboard) {
            $leaderboard->update(['rank_position' => $index + 1]);
        }
    }

    /**
     * Get top users for a period
     */
    public static function getTopUsers(Period $period = Period::ALL_TIME, int $limit = 10)
    {
        return self::with('user')
            ->where('period', $period->value)
            ->orderBy('total_points', 'desc')
            ->orderBy('average_score', 'desc')
            ->orderBy('current_streak', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Scope: Filter by period
     */
    public function scopePeriod($query, Period $period)
    {
        return $query->where('period', $period->value);
    }

    /**
     * Scope: Order by rank
     */
    public function scopeOrderByRank($query)
    {
        return $query->orderBy('total_points', 'desc')
            ->orderBy('average_score', 'desc')
            ->orderBy('current_streak', 'desc');
    }

    /**
     * Scope: Active users (activity in last 30 days)
     */
    public function scopeActiveUsers($query)
    {
        return $query->where('last_activity_at', '>=', now()->subDays(30));
    }

    /**
     * Get leaderboard stats summary
     */
    public function getStatsSummary(): array
    {
        return [
            'rank' => $this->getCurrentRank(),
            'level' => $this->level,
            'level_name' => $this->getLevelName(),
            'total_points' => $this->total_points,
            'points_to_next_level' => $this->getPointsToNextLevel(),
            'tests_completed' => $this->tests_completed,
            'average_score' => $this->average_score,
            'current_streak' => $this->current_streak,
            'longest_streak' => $this->longest_streak,
            'achievements_count' => count($this->achievements ?? []),
            'last_activity' => $this->last_activity_at?->diffForHumans(),
        ];
    }

    /**
     * Create or update leaderboard entry for user
     */
    public static function updateUserStats(int $userId, int $points, float $score, bool $maintainedStreak = true, Period $period = Period::ALL_TIME): void
    {
        $leaderboard = self::firstOrCreate([
            'user_id' => $userId,
            'period' => $period->value,
        ]);
        
        $leaderboard->updateStats($points, $score, $maintainedStreak);
    }

    /**
     * Reset weekly/monthly leaderboards
     */
    public static function resetPeriodic(): void
    {
        // Reset weekly leaderboards every Monday
        if (now()->dayOfWeek === Carbon::MONDAY) {
            self::where('period', Period::WEEKLY->value)->delete();
        }
        
        // Reset monthly leaderboards on first day of month
        if (now()->day === 1) {
            self::where('period', Period::MONTHLY->value)->delete();
        }
    }
}
