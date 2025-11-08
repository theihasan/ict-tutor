<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChapterService
{
    /**
     * Get all active chapters with progress data
     */
    public function getAllChaptersWithProgress(): Collection
    {
        $userId = Auth::id();
        
        return Cache::remember("chapters_with_progress_{$userId}", 300, function () use ($userId) {
            $chapters = Chapter::where('is_active', true)
                ->with(['topics' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }])
                ->orderBy('order')
                ->get();

            if ($userId) {
                // Attach user progress for each chapter
                $chapters = $chapters->map(function ($chapter) use ($userId) {
                    $chapter->user_progress = $this->getChapterProgress($chapter->id, $userId);
                    $chapter->topics_progress = $this->getTopicsProgress($chapter->id, $userId);
                    return $chapter;
                });
            }

            return $chapters;
        });
    }

    /**
     * Get chapter by ID with detailed information
     */
    public function getChapterById(int $chapterId): ?Chapter
    {
        $userId = Auth::id();
        
        $chapter = Chapter::where('id', $chapterId)
            ->where('is_active', true)
            ->with(['topics' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->first();

        if ($chapter && $userId) {
            $chapter->user_progress = $this->getChapterProgress($chapterId, $userId);
            $chapter->topics_progress = $this->getTopicsProgress($chapterId, $userId);
        }

        return $chapter;
    }

    /**
     * Get chapter progress for a user
     */
    private function getChapterProgress(int $chapterId, int $userId): ?object
    {
        $progress = UserProgress::where('chapter_id', $chapterId)
            ->where('user_id', $userId)
            ->where('type', 'chapter')
            ->first();

        if ($progress) {
            return (object) [
                'completion_percentage' => $progress->completion_percentage,
                'total_attempts' => $progress->total_attempts,
                'accuracy_rate' => $progress->accuracy_rate,
                'is_weak_area' => $progress->is_weak_area,
                'last_practiced_at' => $progress->last_practiced_at,
                'streak_count' => $progress->streak_count,
                'best_score' => $progress->best_score,
            ];
        }

        return (object) [
            'completion_percentage' => 0,
            'total_attempts' => 0,
            'accuracy_rate' => 0,
            'is_weak_area' => false,
            'last_practiced_at' => null,
            'streak_count' => 0,
            'best_score' => 0,
        ];
    }

    /**
     * Get topics progress for a chapter
     */
    private function getTopicsProgress(int $chapterId, int $userId): Collection
    {
        return UserProgress::where('user_id', $userId)
            ->where('type', 'topic')
            ->whereHas('topic', function ($query) use ($chapterId) {
                $query->where('chapter_id', $chapterId);
            })
            ->with('topic')
            ->get();
    }

    /**
     * Get chapter statistics
     */
    public function getChapterStatistics(): array
    {
        return Cache::remember('chapter_statistics', 600, function () {
            $totalChapters = Chapter::where('is_active', true)->count();
            $totalTopics = Chapter::where('is_active', true)
                ->withCount(['topics' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get()
                ->sum('topics_count');

            $avgProgressByChapter = [];
            $userId = Auth::id();
            
            if ($userId) {
                $chapters = Chapter::where('is_active', true)->get();
                
                foreach ($chapters as $chapter) {
                    $avgProgress = UserProgress::where('chapter_id', $chapter->id)
                        ->where('type', 'chapter')
                        ->avg('completion_percentage') ?? 0;
                    
                    $avgProgressByChapter[$chapter->id] = round($avgProgress, 2);
                }
            }

            return [
                'total_chapters' => $totalChapters,
                'total_topics' => $totalTopics,
                'avg_progress_by_chapter' => $avgProgressByChapter,
            ];
        });
    }

    /**
     * Search chapters by name
     */
    public function searchChapters(string $query): Collection
    {
        return Chapter::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('name_en', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with(['topics' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

    /**
     * Get chapters by difficulty or category
     */
    public function getChaptersByFilter(array $filters = []): Collection
    {
        $query = Chapter::where('is_active', true);
        
        if (isset($filters['color'])) {
            $query->where('color', $filters['color']);
        }
        
        if (isset($filters['has_topics']) && $filters['has_topics']) {
            $query->has('topics');
        }

        return $query->with(['topics' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

    /**
     * Clear chapter cache
     */
    public function clearCache(): void
    {
        Cache::forget('chapter_statistics');
        
        // Clear user-specific caches if user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();
            Cache::forget("chapters_with_progress_{$userId}");
        }
    }
}