<?php

namespace App\Pipelines\Filters;

use App\Enums\Difficulty;
use Illuminate\Database\Eloquent\Builder;

class DifficultyFilter extends BaseFilter
{
    protected string $parameter = 'difficulty';

    /**
     * Support multiple parameter names and formats
     */
    public function shouldApply(\Illuminate\Http\Request $request): bool
    {
        return $request->filled($this->parameter) ||
               $request->filled('difficulty_level') ||
               $request->filled('min_difficulty') ||
               $request->filled('max_difficulty');
    }

    /**
     * Apply difficulty-based filtering
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        // This method won't be called directly, we override handle() instead
        return $query;
    }

    /**
     * Handle difficulty filtering with support for ranges and multiple formats
     */
    public function handle(Builder $query, \Closure $next, \Illuminate\Http\Request $request): Builder
    {
        if ($this->shouldApply($request)) {
            $query = $this->applyDifficultyFilters($query, $request);
        }

        return $next($query);
    }

    /**
     * Apply all relevant difficulty filters
     */
    protected function applyDifficultyFilters(Builder $query, \Illuminate\Http\Request $request): Builder
    {
        // Handle single difficulty filter
        if ($request->filled('difficulty')) {
            $query = $this->applySingleDifficultyFilter($query, $request->get('difficulty'));
        }

        // Handle difficulty level filter (integer-based)
        if ($request->filled('difficulty_level')) {
            $query = $this->applyDifficultyLevelFilter($query, $request->get('difficulty_level'));
        }

        // Handle difficulty range filters
        if ($request->filled('min_difficulty') || $request->filled('max_difficulty')) {
            $query = $this->applyDifficultyRangeFilter(
                $query,
                $request->get('min_difficulty'),
                $request->get('max_difficulty')
            );
        }

        return $query;
    }

    /**
     * Apply single difficulty filter (supports both enum value and level)
     */
    protected function applySingleDifficultyFilter(Builder $query, mixed $difficulty): Builder
    {
        // Handle array of difficulties
        if (is_array($difficulty)) {
            $validDifficulties = collect($difficulty)
                ->map(fn ($d) => $this->normalizeDifficulty($d))
                ->filter()
                ->unique()
                ->values()
                ->all();

            if (! empty($validDifficulties)) {
                return $query->whereIn('difficulty', $validDifficulties);
            }

            return $query;
        }

        // Handle single difficulty
        $normalizedDifficulty = $this->normalizeDifficulty($difficulty);

        if ($normalizedDifficulty) {
            return $query->where('difficulty', $normalizedDifficulty);
        }

        return $query;
    }

    /**
     * Apply difficulty level filter (integer-based)
     */
    protected function applyDifficultyLevelFilter(Builder $query, mixed $level): Builder
    {
        if (is_numeric($level)) {
            $intLevel = (int) $level;
            $difficulty = Difficulty::fromLevel($intLevel);

            return $query->where('difficulty', $difficulty);
        }

        return $query;
    }

    /**
     * Apply difficulty range filter
     */
    protected function applyDifficultyRangeFilter(Builder $query, mixed $minDifficulty = null, mixed $maxDifficulty = null): Builder
    {
        if ($minDifficulty !== null) {
            $minDiff = $this->normalizeDifficulty($minDifficulty);
            if ($minDiff) {
                // Use level comparison for range filtering
                $minLevel = $minDiff->level();
                $query = $query->whereRaw('difficulty >= ?', [$minLevel]);
            }
        }

        if ($maxDifficulty !== null) {
            $maxDiff = $this->normalizeDifficulty($maxDifficulty);
            if ($maxDiff) {
                // Use level comparison for range filtering
                $maxLevel = $maxDiff->level();
                $query = $query->whereRaw('difficulty <= ?', [$maxLevel]);
            }
        }

        return $query;
    }

    /**
     * Normalize difficulty input to Difficulty enum
     */
    protected function normalizeDifficulty(mixed $difficulty): ?Difficulty
    {
        if ($difficulty instanceof Difficulty) {
            return $difficulty;
        }

        if (is_string($difficulty)) {
            // Try to match enum value directly
            $enumDifficulty = Difficulty::tryFrom(strtolower($difficulty));
            if ($enumDifficulty) {
                return $enumDifficulty;
            }

            // Try to match by label (case-insensitive)
            $normalizedInput = strtolower(str_replace([' ', '_', '-'], '', $difficulty));

            foreach (Difficulty::cases() as $case) {
                $normalizedLabel = strtolower(str_replace([' ', '_', '-'], '', $case->label()));
                if ($normalizedInput === $normalizedLabel) {
                    return $case;
                }
            }
        }

        if (is_numeric($difficulty)) {
            return Difficulty::fromLevel((int) $difficulty);
        }

        return null;
    }
}
