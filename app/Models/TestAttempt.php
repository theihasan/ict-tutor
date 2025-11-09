<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class TestAttempt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'test_id',
        'started_at',
        'completed_at',
        'time_taken',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'skipped_answers',
        'obtained_marks',
        'total_marks',
        'percentage',
        'is_passed',
        'attempt_number',
        'ip_address',
        'user_agent',
        'answers',
        'time_spent_per_question',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'percentage' => 'decimal:2',
        'is_passed' => 'boolean',
        'answers' => 'array',
        'time_spent_per_question' => 'array',
    ];

    /**
     * Get the user that owns the test attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the test that owns the test attempt.
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Get the user answers for the test attempt.
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Scope to get completed attempts.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get in-progress attempts.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope to get attempts by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get attempts by test.
     */
    public function scopeByTest($query, $testId)
    {
        return $query->where('test_id', $testId);
    }

    /**
     * Get time taken in human readable format.
     */
    public function getTimeTakenFormattedAttribute()
    {
        if (!$this->time_taken_seconds) {
            return 'N/A';
        }

        $hours = intval($this->time_taken_seconds / 3600);
        $minutes = intval(($this->time_taken_seconds % 3600) / 60);
        $seconds = $this->time_taken_seconds % 60;

        if ($hours > 0) {
            return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
        }

        return sprintf("%d:%02d", $minutes, $seconds);
    }

    /**
     * Get grade color for UI.
     */
    public function getGradeColorAttribute()
    {
        $colors = [
            'A+' => 'green',
            'A' => 'green',
            'A-' => 'green',
            'B+' => 'blue',
            'B' => 'blue',
            'B-' => 'blue',
            'C+' => 'yellow',
            'C' => 'yellow',
            'D' => 'orange',
            'F' => 'red'
        ];

        return $colors[$this->grade] ?? 'gray';
    }

    /**
     * Calculate and assign grade based on percentage.
     */
    public function calculateGrade()
    {
        $percentage = $this->percentage;

        if ($percentage >= 95) {
            $this->grade = 'A+';
        } elseif ($percentage >= 90) {
            $this->grade = 'A';
        } elseif ($percentage >= 85) {
            $this->grade = 'A-';
        } elseif ($percentage >= 80) {
            $this->grade = 'B+';
        } elseif ($percentage >= 75) {
            $this->grade = 'B';
        } elseif ($percentage >= 70) {
            $this->grade = 'B-';
        } elseif ($percentage >= 65) {
            $this->grade = 'C+';
        } elseif ($percentage >= 60) {
            $this->grade = 'C';
        } elseif ($percentage >= 55) {
            $this->grade = 'D';
        } else {
            $this->grade = 'F';
        }

        return $this->grade;
    }

    /**
     * Calculate points earned based on performance.
     */
    public function calculatePoints()
    {
        $basePoints = $this->score * 5; // 5 points per correct answer
        $bonusPoints = 0;

        // Bonus for high percentage
        if ($this->percentage >= 95) {
            $bonusPoints += 50;
        } elseif ($this->percentage >= 90) {
            $bonusPoints += 30;
        } elseif ($this->percentage >= 80) {
            $bonusPoints += 20;
        }

        // Bonus for quick completion
        $timeRatio = $this->time_taken_seconds / ($this->test->duration_minutes * 60);
        if ($timeRatio <= 0.75) { // Completed in 75% of allotted time
            $bonusPoints += 25;
        }

        $this->points_earned = $basePoints + $bonusPoints;
        return $this->points_earned;
    }

    /**
     * Mark attempt as completed.
     */
    public function markCompleted()
    {
        $this->completed_at = now();
        $this->status = 'completed';
        $this->time_taken_seconds = $this->completed_at->diffInSeconds($this->started_at);
        
        // Calculate percentage
        if ($this->total_questions > 0) {
            $this->percentage = ($this->correct_answers / $this->total_questions) * 100;
        }

        // Calculate grade and points
        $this->calculateGrade();
        $this->calculatePoints();

        $this->save();

        // Update test statistics
        $this->test->incrementAttempts();
        $this->test->updateAverageScore();

        // Update user statistics
        $this->user->increment('total_points', $this->points_earned);
        $this->user->touch('last_activity_at');
    }

    /**
     * Check if attempt is expired (exceeded time limit).
     */
    public function isExpired()
    {
        if ($this->status !== 'in_progress') {
            return false;
        }

        $timeLimit = $this->test->duration_minutes * 60; // Convert to seconds
        $elapsed = now()->diffInSeconds($this->started_at);

        return $elapsed > $timeLimit;
    }

    /**
     * Get remaining time in seconds.
     */
    public function getRemainingTimeAttribute()
    {
        if ($this->status !== 'in_progress') {
            return 0;
        }

        $timeLimit = $this->test->duration_minutes * 60;
        $elapsed = now()->diffInSeconds($this->started_at);

        return max(0, $timeLimit - $elapsed);
    }
}
