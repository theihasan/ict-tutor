<?php

namespace App\Pipelines\Filters;

use Illuminate\Database\Eloquent\Builder;

class ChapterFilter extends BaseFilter
{
    protected string $parameter = 'chapter_id';

    /**
     * Apply chapter-based filtering
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        $chapterId = is_array($value) ? $value : [$value];

        // Filter out invalid IDs
        $validIds = collect($chapterId)
            ->filter(fn ($id) => is_numeric($id) && $id > 0)
            ->values()
            ->all();

        if (empty($validIds)) {
            return $query;
        }

        // Handle single vs multiple chapter IDs
        if (count($validIds) === 1) {
            return $query->where('chapter_id', $validIds[0]);
        }

        return $query->whereIn('chapter_id', $validIds);
    }

    /**
     * Support multiple parameter names
     */
    public function shouldApply(\Illuminate\Http\Request $request): bool
    {
        return $request->filled($this->parameter) ||
               $request->filled('chapter') ||
               $request->filled('chapters');
    }

    /**
     * Get value with fallback to alternative parameter names
     */
    protected function getValue(\Illuminate\Http\Request $request): mixed
    {
        return $request->get($this->parameter) ??
               $request->get('chapter') ??
               $request->get('chapters');
    }
}
