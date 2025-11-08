<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_key',
        'option_text',
        'option_text_en',
        'is_correct',
        'order',
        'image_url',
        'explanation',
        'is_active',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the question that owns this option.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Scope for active options.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for correct options.
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope for incorrect options.
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    /**
     * Scope to order by option order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get display text (prefer English if available, fallback to Bengali)
     */
    public function getDisplayTextAttribute(): string
    {
        return $this->option_text_en ?: $this->option_text;
    }

    /**
     * Check if this option has an image
     */
    public function hasImage(): bool
    {
        return !empty($this->image_url);
    }

    /**
     * Check if this option has explanation
     */
    public function hasExplanation(): bool
    {
        return !empty($this->explanation);
    }
}
