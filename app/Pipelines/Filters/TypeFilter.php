<?php

namespace App\Pipelines\Filters;

use App\Enums\FaqCategory;
use App\Enums\TestType;
use Illuminate\Database\Eloquent\Builder;

class TypeFilter extends BaseFilter
{
    protected string $parameter = 'type';

    /**
     * Apply type/category filter based on model context
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        $modelClass = $query->getModel();
        $tableName = $modelClass->getTable();

        // Handle different model types
        switch ($tableName) {
            case 'tests':
                return $this->applyTestTypeFilter($query, $value);

            case 'faqs':
                return $this->applyFaqCategoryFilter($query, $value);

            default:
                // For other models, assume a 'type' column exists
                return $query->where('type', $value);
        }
    }

    /**
     * Apply TestType enum filter
     */
    protected function applyTestTypeFilter(Builder $query, mixed $value): Builder
    {
        // Handle both string and enum values
        if (is_string($value)) {
            $testType = TestType::tryFrom($value);
            if (! $testType) {
                return $query; // Invalid type, return unmodified query
            }
            $value = $testType;
        }

        if ($value instanceof TestType) {
            return $query->where('type', $value);
        }

        return $query;
    }

    /**
     * Apply FaqCategory enum filter
     */
    protected function applyFaqCategoryFilter(Builder $query, mixed $value): Builder
    {
        // Validate category value
        if (is_string($value) && in_array($value, FaqCategory::values())) {
            return $query->byCategory($value);
        }

        return $query;
    }

    /**
     * Alternative parameter name support for category filtering
     */
    public function shouldApply(\Illuminate\Http\Request $request): bool
    {
        // Support both 'type' and 'category' parameters
        return $request->filled($this->parameter) || $request->filled('category');
    }

    /**
     * Get value with fallback to category parameter
     */
    protected function getValue(\Illuminate\Http\Request $request): mixed
    {
        return $request->get($this->parameter) ?? $request->get('category');
    }
}
