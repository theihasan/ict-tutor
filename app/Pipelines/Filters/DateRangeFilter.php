<?php

namespace App\Pipelines\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DateRangeFilter extends BaseFilter
{
    protected string $parameter = 'date_range';
    protected bool $requiresValue = false;

    /**
     * Support multiple date parameter formats
     */
    public function shouldApply(\Illuminate\Http\Request $request): bool
    {
        return $request->filled('start_date') ||
               $request->filled('end_date') ||
               $request->filled('from_date') ||
               $request->filled('to_date') ||
               $request->filled('created_after') ||
               $request->filled('created_before') ||
               $request->filled('updated_after') ||
               $request->filled('updated_before') ||
               $request->filled($this->parameter);
    }

    /**
     * Apply date range filtering
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        return $query;
    }

    /**
     * Handle date range filtering with multiple parameter formats
     */
    public function handle(Builder $query, \Closure $next, \Illuminate\Http\Request $request): Builder
    {
        if ($this->shouldApply($request)) {
            $query = $this->applyDateRangeFilters($query, $request);
        }

        return $next($query);
    }

    /**
     * Apply all relevant date range filters
     */
    protected function applyDateRangeFilters(Builder $query, \Illuminate\Http\Request $request): Builder
    {
        // Handle general date range
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query = $this->applyDateRange($query, 'created_at', 
                $request->get('start_date'), 
                $request->get('end_date')
            );
        }

        // Handle from/to date format
        if ($request->filled('from_date') || $request->filled('to_date')) {
            $query = $this->applyDateRange($query, 'created_at', 
                $request->get('from_date'), 
                $request->get('to_date')
            );
        }

        // Handle created_at specific filters
        if ($request->filled('created_after')) {
            $query = $this->applyDateFilter($query, 'created_at', '>=', $request->get('created_after'));
        }

        if ($request->filled('created_before')) {
            $query = $this->applyDateFilter($query, 'created_at', '<=', $request->get('created_before'));
        }

        // Handle updated_at specific filters
        if ($request->filled('updated_after')) {
            $query = $this->applyDateFilter($query, 'updated_at', '>=', $request->get('updated_after'));
        }

        if ($request->filled('updated_before')) {
            $query = $this->applyDateFilter($query, 'updated_at', '<=', $request->get('updated_before'));
        }

        // Handle combined date_range parameter (JSON or comma-separated)
        if ($request->filled('date_range')) {
            $query = $this->applyParsedDateRange($query, $request->get('date_range'));
        }

        return $query;
    }

    /**
     * Apply date range filter to a specific column
     */
    protected function applyDateRange(Builder $query, string $column, mixed $startDate = null, mixed $endDate = null): Builder
    {
        if ($startDate !== null) {
            $query = $this->applyDateFilter($query, $column, '>=', $startDate);
        }

        if ($endDate !== null) {
            $query = $this->applyDateFilter($query, $column, '<=', $endDate);
        }

        return $query;
    }

    /**
     * Apply a single date filter
     */
    protected function applyDateFilter(Builder $query, string $column, string $operator, mixed $date): Builder
    {
        $parsedDate = $this->parseDate($date);
        
        if ($parsedDate) {
            // For end dates, include the entire day
            if (in_array($operator, ['<=', '<']) && $parsedDate->format('H:i:s') === '00:00:00') {
                $parsedDate = $parsedDate->endOfDay();
            }

            return $query->where($column, $operator, $parsedDate);
        }

        return $query;
    }

    /**
     * Apply parsed date range from JSON or comma-separated format
     */
    protected function applyParsedDateRange(Builder $query, mixed $dateRange): Builder
    {
        $parsed = $this->parseDateRangeValue($dateRange);
        
        if ($parsed && (isset($parsed['start']) || isset($parsed['end']))) {
            return $this->applyDateRange($query, 'created_at', 
                $parsed['start'] ?? null, 
                $parsed['end'] ?? null
            );
        }

        return $query;
    }

    /**
     * Parse date range value from various formats
     */
    protected function parseDateRangeValue(mixed $dateRange): ?array
    {
        if (is_string($dateRange)) {
            // Try to decode as JSON first
            $decoded = json_decode($dateRange, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return [
                    'start' => $decoded['start'] ?? $decoded['from'] ?? null,
                    'end' => $decoded['end'] ?? $decoded['to'] ?? null,
                ];
            }

            // Try comma-separated format
            $parts = explode(',', $dateRange);
            if (count($parts) === 2) {
                return [
                    'start' => trim($parts[0]),
                    'end' => trim($parts[1]),
                ];
            }
        }

        if (is_array($dateRange)) {
            return [
                'start' => $dateRange['start'] ?? $dateRange['from'] ?? $dateRange[0] ?? null,
                'end' => $dateRange['end'] ?? $dateRange['to'] ?? $dateRange[1] ?? null,
            ];
        }

        return null;
    }

    /**
     * Parse date string to Carbon instance
     */
    protected function parseDate(mixed $date): ?Carbon
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        if ($date instanceof \DateTime) {
            return Carbon::instance($date);
        }

        if (is_string($date)) {
            try {
                // Handle common date formats
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    return Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
                }

                if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date)) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $date);
                }

                // Try to parse with Carbon's flexible parsing
                return Carbon::parse($date);
                
            } catch (\Exception $e) {
                // Invalid date format, return null
                return null;
            }
        }

        if (is_numeric($date)) {
            try {
                return Carbon::createFromTimestamp($date);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}