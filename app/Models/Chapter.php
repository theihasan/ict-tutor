<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_en',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
        'topics_count',
    ];

    protected $casts = [
        'topics_count' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the topics for the chapter.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    /**
     * Get the questions for the chapter.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the tests for the chapter.
     */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    /**
     * Get the user progress for the chapter.
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Scope to get only active chapters.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order chapters by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get total questions count for this chapter.
     */
    public function getTotalQuestionsAttribute()
    {
        return $this->questions()->count();
    }

    /**
     * Get active questions count for this chapter.
     */
    public function getActiveQuestionsAttribute()
    {
        return $this->questions()->where('is_active', true)->count();
    }
}
