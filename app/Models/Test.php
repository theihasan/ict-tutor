<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\TestType;

class Test extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'title_en',
        'description',
        'type',
        'chapter_id',
        'topic_id',
        'duration',
        'total_questions',
        'total_marks',
        'passing_marks',
        'question_ids',
        'settings',
        'is_active',
        'is_featured',
        'is_public',
        'allow_retries',
        'max_attempts',
        'instructions',
        'scheduled_at',
        'starts_at',
        'ends_at',
        'show_results_immediately',
        'randomize_questions',
        'negative_marking',
        'negative_marks_per_question',
        'attempts_count',
        'average_score',
        'created_by',
    ];

    protected $casts = [
        'type' => TestType::class,
        'question_ids' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'allow_retries' => 'boolean',
        'show_results_immediately' => 'boolean',
        'randomize_questions' => 'boolean',
        'negative_marking' => 'boolean',
        'scheduled_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'passing_marks' => 'decimal:2',
        'negative_marks_per_question' => 'decimal:2',
        'average_score' => 'decimal:2',
    ];

    /**
     * Get the chapter that owns the test.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the test attempts for the test.
     */
    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Get the questions for the test.
     * Note: This test model uses question_ids array instead of pivot table
     * Use getTestQuestions() method for actual query
     */
    public function questions()
    {
        return $this->getTestQuestions();
    }

    /**
     * Scope to get only active tests.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured tests.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by test type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get tests by chapter.
     */
    public function scopeByChapter($query, $chapterId)
    {
        return $query->where('chapter_id', $chapterId);
    }

    /**
     * Get questions for this test based on question_ids.
     */
    public function getTestQuestions()
    {
        if (empty($this->question_ids)) {
            return collect();
        }

        return Question::query()
                        ->whereIn('id', $this->question_ids)
                        ->where('is_active', true)
                        ->get();
    }

    /**
     * Get test type in Bangla.
     */
    public function getTypeTextAttribute()
    {
        $types = [
            'model_test' => 'মডেল টেস্ট',
            'practice' => 'প্র্যাকটিস',
            'exam' => 'পরীক্ষা',
            'chapter_test' => 'অধ্যায় টেস্ট'
        ];

        return $types[$this->type] ?? 'অজানা';
    }

    /**
     * Get duration in hours and minutes format.
     */
    public function getDurationFormattedAttribute()
    {
        $hours = intval($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return "{$hours} ঘন্টা {$minutes} মিনিট";
        }

        return "{$minutes} মিনিট";
    }

    /**
     * Check if user has attempted this test.
     */
    public function hasUserAttempted($userId)
    {
        return $this->testAttempts()
                   ->where('user_id', $userId)
                   ->where('status', 'completed')
                   ->exists();
    }

    /**
     * Get user's best attempt for this test.
     */
    public function getUserBestAttempt($userId)
    {
        return $this->testAttempts()
                   ->where('user_id', $userId)
                   ->where('status', 'completed')
                   ->orderBy('score', 'desc')
                   ->first();
    }

    /**
     * Increment attempts count.
     */
    public function incrementAttempts()
    {
        $this->increment('attempts_count');
    }

    /**
     * Update average score based on all attempts.
     */
    public function updateAverageScore()
    {
        $averageScore = $this->testAttempts()
                           ->where('status', 'completed')
                           ->avg('percentage');

        if ($averageScore !== null) {
            $this->average_score = round($averageScore, 2);
            $this->save();
        }
    }
}
