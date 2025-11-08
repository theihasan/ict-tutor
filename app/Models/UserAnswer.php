<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'selected_answer',
        'correct_answer',
        'is_correct',
        'time_taken_seconds',
        'marks_earned',
        'is_flagged',
        'answered_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_flagged' => 'boolean',
        'answered_at' => 'datetime',
    ];

    /**
     * Relationship: UserAnswer belongs to a TestAttempt
     */
    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

    /**
     * Relationship: UserAnswer belongs to a Question
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relationship: Get the user through the test attempt
     */
    public function user(): BelongsTo
    {
        return $this->testAttempt->user();
    }

    /**
     * Check if the answer was skipped (no answer selected)
     */
    public function isSkipped(): bool
    {
        return is_null($this->selected_answer);
    }

    /**
     * Check if the answer was attempted (has a selected answer)
     */
    public function isAttempted(): bool
    {
        return !is_null($this->selected_answer);
    }

    /**
     * Get the time taken in a human-readable format
     */
    public function getFormattedTimeTaken(): string
    {
        if (!$this->time_taken_seconds) {
            return 'Not recorded';
        }

        $minutes = floor($this->time_taken_seconds / 60);
        $seconds = $this->time_taken_seconds % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }

    /**
     * Get answer status as text
     */
    public function getStatusText(): string
    {
        if ($this->isSkipped()) {
            return 'Skipped';
        }

        return $this->is_correct ? 'Correct' : 'Incorrect';
    }

    /**
     * Get answer status color for UI
     */
    public function getStatusColor(): string
    {
        if ($this->isSkipped()) {
            return 'gray';
        }

        return $this->is_correct ? 'green' : 'red';
    }

    /**
     * Scope: Get correct answers only
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope: Get incorrect answers only
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false)->whereNotNull('selected_answer');
    }

    /**
     * Scope: Get skipped answers only
     */
    public function scopeSkipped($query)
    {
        return $query->whereNull('selected_answer');
    }

    /**
     * Scope: Get flagged answers
     */
    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    /**
     * Scope: Get answers for a specific test attempt
     */
    public function scopeForAttempt($query, $attemptId)
    {
        return $query->where('test_attempt_id', $attemptId);
    }

    /**
     * Scope: Get answers for a specific question
     */
    public function scopeForQuestion($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Get performance metrics for this answer
     */
    public function getPerformanceMetrics(): array
    {
        return [
            'is_correct' => $this->is_correct,
            'is_skipped' => $this->isSkipped(),
            'time_taken' => $this->time_taken_seconds,
            'marks_earned' => $this->marks_earned,
            'is_flagged' => $this->is_flagged,
            'efficiency_score' => $this->calculateEfficiencyScore(),
        ];
    }

    /**
     * Calculate efficiency score based on correctness and time taken
     */
    public function calculateEfficiencyScore(): float
    {
        if (!$this->is_correct || !$this->time_taken_seconds) {
            return 0.0;
        }

        // Assume 60 seconds is the baseline for a question
        $baselineTime = 60;
        $efficiency = min(1.0, $baselineTime / $this->time_taken_seconds);
        
        return round($efficiency * 100, 2); // Return as percentage
    }

    /**
     * Mark answer as flagged for review
     */
    public function flag(): bool
    {
        return $this->update(['is_flagged' => true]);
    }

    /**
     * Remove flag from answer
     */
    public function unflag(): bool
    {
        return $this->update(['is_flagged' => false]);
    }

    /**
     * Toggle flag status
     */
    public function toggleFlag(): bool
    {
        return $this->update(['is_flagged' => !$this->is_flagged]);
    }
}
