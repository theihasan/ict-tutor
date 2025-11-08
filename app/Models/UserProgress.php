<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'chapter_id',
        'topic_id',
        'type',
        'completion_percentage',
        'total_attempts',
        'correct_answers',
        'wrong_answers',
        'accuracy_rate',
        'time_spent_minutes',
        'last_practiced_at',
        'is_weak_area',
        'streak_count',
        'best_score',
        'performance_trend',
    ];

    protected $casts = [
        'completion_percentage' => 'decimal:2',
        'accuracy_rate' => 'decimal:2',
        'last_practiced_at' => 'datetime',
        'is_weak_area' => 'boolean',
        'performance_trend' => 'array',
    ];

    /**
     * Relationship: UserProgress belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: UserProgress belongs to a Chapter (optional)
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Relationship: UserProgress belongs to a Topic (optional)
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get total questions attempted
     */
    public function getTotalAttemptedAttribute(): int
    {
        return $this->correct_answers + $this->wrong_answers;
    }

    /**
     * Check if this is chapter-level progress
     */
    public function isChapterProgress(): bool
    {
        return $this->type === 'chapter';
    }

    /**
     * Check if this is topic-level progress
     */
    public function isTopicProgress(): bool
    {
        return $this->type === 'topic';
    }

    /**
     * Get progress level based on completion percentage
     */
    public function getProgressLevel(): string
    {
        $percentage = $this->completion_percentage;
        
        if ($percentage >= 90) return 'Mastered';
        if ($percentage >= 75) return 'Advanced';
        if ($percentage >= 50) return 'Intermediate';
        if ($percentage >= 25) return 'Beginner';
        
        return 'Not Started';
    }

    /**
     * Get progress color for UI
     */
    public function getProgressColor(): string
    {
        $percentage = $this->completion_percentage;
        
        if ($percentage >= 90) return 'green';
        if ($percentage >= 75) return 'blue';
        if ($percentage >= 50) return 'yellow';
        if ($percentage >= 25) return 'orange';
        
        return 'gray';
    }

    /**
     * Get formatted time spent
     */
    public function getFormattedTimeSpent(): string
    {
        $minutes = $this->time_spent_minutes;
        
        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            return "{$hours}h {$remainingMinutes}m";
        }
        
        return "{$minutes}m";
    }

    /**
     * Update progress with new attempt data
     */
    public function updateWithAttempt(int $correctAnswers, int $wrongAnswers, int $timeSpentMinutes, int $score): void
    {
        $this->total_attempts++;
        $this->correct_answers += $correctAnswers;
        $this->wrong_answers += $wrongAnswers;
        $this->time_spent_minutes += $timeSpentMinutes;
        $this->last_practiced_at = now();
        
        // Update best score
        if ($score > $this->best_score) {
            $this->best_score = $score;
        }
        
        // Recalculate accuracy rate
        $totalAnswered = $this->correct_answers + $this->wrong_answers;
        if ($totalAnswered > 0) {
            $this->accuracy_rate = ($this->correct_answers / $totalAnswered) * 100;
        }
        
        // Update completion percentage (this would need business logic based on curriculum)
        $this->updateCompletionPercentage();
        
        // Check if this is a weak area
        $this->updateWeakAreaStatus();
        
        // Update performance trend
        $this->updatePerformanceTrend($score);
        
        $this->save();
    }

    /**
     * Update completion percentage based on performance
     */
    private function updateCompletionPercentage(): void
    {
        // Simple logic: base completion on accuracy and attempts
        // This can be customized based on curriculum requirements
        $accuracyFactor = min(100, $this->accuracy_rate);
        $attemptsFactor = min(100, $this->total_attempts * 10); // 10 attempts = full attempt factor
        
        $this->completion_percentage = ($accuracyFactor * 0.7) + ($attemptsFactor * 0.3);
    }

    /**
     * Update weak area status based on performance
     */
    private function updateWeakAreaStatus(): void
    {
        // Mark as weak area if accuracy is below 60% and user has made sufficient attempts
        $this->is_weak_area = ($this->accuracy_rate < 60.0 && $this->total_attempts >= 5);
    }

    /**
     * Update performance trend data
     */
    private function updatePerformanceTrend(int $latestScore): void
    {
        $trend = $this->performance_trend ?? [];
        
        // Keep only last 10 scores for trend analysis
        $trend[] = [
            'score' => $latestScore,
            'accuracy' => $this->accuracy_rate,
            'timestamp' => now()->toISOString(),
        ];
        
        if (count($trend) > 10) {
            $trend = array_slice($trend, -10);
        }
        
        $this->performance_trend = $trend;
    }

    /**
     * Get performance trend direction
     */
    public function getTrendDirection(): string
    {
        $trend = $this->performance_trend ?? [];
        
        if (count($trend) < 3) {
            return 'insufficient_data';
        }
        
        $recent = array_slice($trend, -3);
        $scores = array_column($recent, 'score');
        
        if ($scores[2] > $scores[1] && $scores[1] > $scores[0]) {
            return 'improving';
        } elseif ($scores[2] < $scores[1] && $scores[1] < $scores[0]) {
            return 'declining';
        }
        
        return 'stable';
    }

    /**
     * Calculate improvement suggestions
     */
    public function getSuggestions(): array
    {
        $suggestions = [];
        
        if ($this->is_weak_area) {
            $suggestions[] = "Focus more practice on this area - accuracy is below 60%";
        }
        
        if ($this->accuracy_rate > 0 && $this->accuracy_rate < 70) {
            $suggestions[] = "Review fundamental concepts before attempting more questions";
        }
        
        if ($this->total_attempts < 10) {
            $suggestions[] = "Practice more questions to improve your understanding";
        }
        
        if ($this->getTrendDirection() === 'declining') {
            $suggestions[] = "Your recent performance is declining - consider reviewing basics";
        }
        
        if ($this->streak_count > 5) {
            $suggestions[] = "Great streak! Keep up the consistent practice";
        }
        
        return $suggestions;
    }

    /**
     * Scope: Get weak areas only
     */
    public function scopeWeakAreas($query)
    {
        return $query->where('is_weak_area', true);
    }

    /**
     * Scope: Get chapter progress
     */
    public function scopeChapterProgress($query)
    {
        return $query->where('type', 'chapter');
    }

    /**
     * Scope: Get topic progress
     */
    public function scopeTopicProgress($query)
    {
        return $query->where('type', 'topic');
    }

    /**
     * Scope: Get progress for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get recently practiced areas
     */
    public function scopeRecentlyPracticed($query, $days = 7)
    {
        return $query->where('last_practiced_at', '>=', now()->subDays($days));
    }

    /**
     * Get comprehensive progress report
     */
    public function getProgressReport(): array
    {
        return [
            'level' => $this->getProgressLevel(),
            'completion_percentage' => $this->completion_percentage,
            'accuracy_rate' => $this->accuracy_rate,
            'total_attempts' => $this->total_attempts,
            'time_spent' => $this->getFormattedTimeSpent(),
            'trend_direction' => $this->getTrendDirection(),
            'is_weak_area' => $this->is_weak_area,
            'streak_count' => $this->streak_count,
            'best_score' => $this->best_score,
            'suggestions' => $this->getSuggestions(),
            'last_practiced' => $this->last_practiced_at?->diffForHumans(),
        ];
    }
}
