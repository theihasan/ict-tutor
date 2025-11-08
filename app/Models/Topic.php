<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TopicType;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapter_id',
        'name',
        'name_en',
        'description',
        'type',
        'order',
        'difficulty_level',
        'is_active',
        'learning_objectives',
    ];

    protected $casts = [
        'type' => TopicType::class,
        'learning_objectives' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the chapter that owns the topic.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the questions for the topic.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the user progress for the topic.
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Scope to get only active topics.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order topics by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope to filter by difficulty level.
     */
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
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
}
