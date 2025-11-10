<?php

namespace App\Models;

use App\Enums\FaqCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer', 
        'category',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'category' => 'string',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('question', 'like', '%' . $searchTerm . '%')
              ->orWhere('answer', 'like', '%' . $searchTerm . '%');
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get the category as an enum instance
     */
    public function getCategoryEnumAttribute(): ?FaqCategory
    {
        return $this->category ? FaqCategory::from($this->category) : null;
    }

    /**
     * Get the localized category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return $this->category_enum?->label() ?? $this->category;
    }

    /**
     * Set category from enum or string
     */
     public function setCategoryAttribute($value): void
     {
         $this->attributes['category'] = match (true) {
             $value instanceof FaqCategory => $value->value,
             is_string($value) && in_array($value, FaqCategory::values()) => $value,
             is_string($value) => throw new \InvalidArgumentException("Invalid FAQ category: {$value}"),
             default => $value
         };
     }

    /**
     * Get all available categories
     */
    public static function getCategories(): array
    {
        return FaqCategory::options();
    }
}
