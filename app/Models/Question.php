<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\QuestionType;
use App\Enums\Difficulty;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapter_id',
        'topic_id',
        'question',
        'question_en',
        'correct_answer',
        'explanation',
        'type',
        'difficulty_level',
        'marks',
        'tags',
        'is_active',
        'usage_count',
        'success_rate',
    ];

    protected $casts = [
        'tags' => 'array',
        'type' => QuestionType::class,
        'difficulty_level' => Difficulty::class,
        'is_active' => 'boolean',
        'success_rate' => 'decimal:2',
    ];

    /**
     * Get the chapter that owns the question.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the topic that owns the question.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the options for the question.
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->ordered();
    }

    /**
     * Get the correct option for the question.
     */
    public function correctOption(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->where('is_correct', true);
    }

    /**
     * Get the user answers for the question.
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Scope to get only active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by difficulty level.
     */
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope to filter by question type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get questions by chapter.
     */
    public function scopeByChapter($query, $chapterId)
    {
        return $query->where('chapter_id', $chapterId);
    }

    /**
     * Scope to get questions by topic.
     */
    public function scopeByTopic($query, $topicId)
    {
        return $query->where('topic_id', $topicId);
    }

    /**
     * Get formatted options as associative array.
     */
    public function getFormattedOptionsAttribute()
    {
        return $this->options->pluck('option_text', 'option_key')->toArray();
    }

    /**
     * Get options as array for API response.
     */
    public function getOptionsArrayAttribute()
    {
        return $this->options->map(function ($option) {
            return [
                'key' => $option->option_key,
                'text' => $option->option_text,
                'text_en' => $option->option_text_en,
                'image_url' => $option->image_url,
                'is_correct' => $option->is_correct,
            ];
        })->toArray();
    }

    /**
     * Get difficulty level as text.
     */
    public function getDifficultyTextAttribute()
    {
        $levels = [
            1 => 'খুব সহজ',
            2 => 'সহজ',
            3 => 'মাঝারি',
            4 => 'কঠিন',
            5 => 'খুব কঠিন'
        ];

        return $levels[$this->difficulty_level] ?? 'অজানা';
    }

    /**
     * Check if answer is correct.
     */
    public function isCorrectAnswer($answer)
    {
        return strtoupper($answer) === strtoupper($this->correct_answer);
    }

    /**
     * Increment usage count.
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Update success rate based on user answers.
     */
    public function updateSuccessRate()
    {
        $totalAnswers = $this->userAnswers()->count();
        $correctAnswers = $this->userAnswers()->where('is_correct', true)->count();
        
        if ($totalAnswers > 0) {
            $this->success_rate = ($correctAnswers / $totalAnswers) * 100;
            $this->save();
        }
    }
}
