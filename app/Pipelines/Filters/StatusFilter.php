<?php

namespace App\Pipelines\Filters;

use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends BaseFilter
{
    protected string $parameter = 'status';

    protected bool $requiresValue = false;

    /**
     * Status filter supports multiple parameters
     */
    public function shouldApply(\Illuminate\Http\Request $request): bool
    {
        return $request->has('is_active') ||
               $request->has('is_featured') ||
               $request->has('is_public') ||
               $request->has('active') ||
               $request->has('featured') ||
               $request->has('public') ||
               $request->filled($this->parameter);
    }

    /**
     * Apply status-based filtering
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        // This method won't be called directly, we override handle() instead
        return $query;
    }

    /**
     * Handle multiple status filters
     */
    public function handle(Builder $query, \Closure $next, \Illuminate\Http\Request $request): Builder
    {
        if ($this->shouldApply($request)) {
            $query = $this->applyStatusFilters($query, $request);
        }

        return $next($query);
    }

    /**
     * Apply all relevant status filters
     */
    protected function applyStatusFilters(Builder $query, \Illuminate\Http\Request $request): Builder
    {
        // Handle is_active filter
        if ($request->has('is_active')) {
            $query = $this->applyBooleanFilter($query, 'is_active', $request->get('is_active'));
        }

        // Handle active filter (alternative name)
        if ($request->has('active')) {
            $query = $this->applyBooleanFilter($query, 'is_active', $request->get('active'));
        }

        // Handle is_featured filter
        if ($request->has('is_featured')) {
            $query = $this->applyBooleanFilter($query, 'is_featured', $request->get('is_featured'));
        }

        // Handle featured filter (alternative name)
        if ($request->has('featured')) {
            $query = $this->applyBooleanFilter($query, 'is_featured', $request->get('featured'));
        }

        // Handle is_public filter
        if ($request->has('is_public')) {
            $query = $this->applyBooleanFilter($query, 'is_public', $request->get('is_public'));
        }

        // Handle public filter (alternative name)
        if ($request->has('public')) {
            $query = $this->applyBooleanFilter($query, 'is_public', $request->get('public'));
        }

        // Handle general status filter
        if ($request->filled('status')) {
            $query = $this->applyGeneralStatusFilter($query, $request->get('status'));
        }

        return $query;
    }

    /**
     * Apply boolean filter with proper type conversion
     */
    protected function applyBooleanFilter(Builder $query, string $column, mixed $value): Builder
    {
        // Convert various truthy/falsy values to boolean
        $boolValue = $this->convertToBoolean($value);

        if ($boolValue !== null) {
            return $query->where($column, $boolValue);
        }

        return $query;
    }

    /**
     * Apply general status filter (e.g., status=active)
     */
    protected function applyGeneralStatusFilter(Builder $query, string $status): Builder
    {
        switch (strtolower($status)) {
            case 'active':
                return $query->where('is_active', true);

            case 'inactive':
                return $query->where('is_active', false);

            case 'featured':
                return $query->where('is_featured', true);

            case 'public':
                return $query->where('is_public', true);

            case 'private':
                return $query->where('is_public', false);

            default:
                // Try to match the status directly if it's a valid column value
                return $query->where('status', $status);
        }
    }

    /**
     * Convert various input types to boolean
     */
    protected function convertToBoolean(mixed $value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $normalized = strtolower(trim($value));

            if (in_array($normalized, ['true', '1', 'yes', 'on'])) {
                return true;
            }

            if (in_array($normalized, ['false', '0', 'no', 'off'])) {
                return false;
            }
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        return null; // Invalid value, don't apply filter
    }
}
