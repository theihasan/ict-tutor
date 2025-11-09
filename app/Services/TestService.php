<?php

namespace App\Services;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Chapter;
use App\Enums\TestType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TestService
{
    /**
     * Get all active tests with user progress data
     */
    public function getAllTestsWithProgress(): Collection
    {
        $userId = Auth::id();
        
        return Cache::remember("tests_with_progress_{$userId}", 300, function () use ($userId) {
            $tests = Test::where('is_active', true)
                ->with(['chapter'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($userId) {
                // Attach user progress for each test
                $tests = $tests->map(function ($test) use ($userId) {
                    $test->user_progress = $this->getTestProgress($test->id, $userId);
                    $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                    return $test;
                });
            }
            
            return $tests;
        });
    }

    /**
     * Get tests by chapter with user progress
     */
    public function getTestsByChapter(int $chapterId): Collection
    {
        $userId = Auth::id();
        
        return Cache::remember("tests_chapter_{$chapterId}_user_{$userId}", 300, function () use ($chapterId, $userId) {
            $tests = Test::where('is_active', true)
                ->where('chapter_id', $chapterId)
                ->with(['chapter'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($userId) {
                $tests = $tests->map(function ($test) use ($userId) {
                    $test->user_progress = $this->getTestProgress($test->id, $userId);
                    $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                    return $test;
                });
            }

            return $tests;
        });
    }

    /**
     * Get tests by type with user progress
     */
    public function getTestsByType(TestType $type): Collection
    {
        $userId = Auth::id();
        
        return Cache::remember("tests_type_{$type->value}_user_{$userId}", 300, function () use ($type, $userId) {
            $tests = Test::where('is_active', true)
                ->where('type', $type)
                ->with(['chapter'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($userId) {
                $tests = $tests->map(function ($test) use ($userId) {
                    $test->user_progress = $this->getTestProgress($test->id, $userId);
                    $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                    return $test;
                });
            }

            return $tests;
        });
    }

    /**
     * Get test by ID with detailed information
     */
    public function getTestById(int $testId): ?Test
    {
        $userId = Auth::id();
        
        $test = Test::where('id', $testId)
            ->where('is_active', true)
            ->with(['chapter'])
            ->first();

        if ($test && $userId) {
            $test->user_progress = $this->getTestProgress($testId, $userId);
            $test->user_attempts = $this->getUserAttempts($testId, $userId);
        }

        return $test;
    }

    /**
     * Get test progress for a user
     */
    private function getTestProgress(int $testId, int $userId): ?object
    {
        $attempts = TestAttempt::where('test_id', $testId)
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        if ($attempts->isEmpty()) {
            return (object) [
                'is_attempted' => false,
                'total_attempts' => 0,
                'best_score' => 0,
                'best_percentage' => 0,
                'average_score' => 0,
                'last_attempt_at' => null,
                'completion_status' => 'not_started',
            ];
        }

        $bestAttempt = $attempts->sortByDesc('score')->first();
        $averageScore = $attempts->avg('score');

        return (object) [
            'is_attempted' => true,
            'total_attempts' => $attempts->count(),
            'best_score' => $bestAttempt->score,
            'best_percentage' => $bestAttempt->percentage,
            'average_score' => round($averageScore, 2),
            'last_attempt_at' => $attempts->sortByDesc('completed_at')->first()->completed_at,
            'completion_status' => $bestAttempt->percentage >= 60 ? 'passed' : 'failed',
        ];
    }

    /**
     * Get user attempts for a test
     */
    private function getUserAttempts(int $testId, int $userId): Collection
    {
        return TestAttempt::where('test_id', $testId)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get test statistics
     */
    public function getTestStatistics(): array
    {
        return Cache::remember('test_statistics', 600, function () {
            $totalTests = Test::where('is_active', true)->count();
            $testsByType = Test::where('is_active', true)
                ->selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->type->value => $item->count];
                });

            $userId = Auth::id();
            $userStats = [];
            
            if ($userId) {
                $completedTests = TestAttempt::where('user_id', $userId)
                    ->where('status', 'completed')
                    ->distinct('test_id')
                    ->count();

                $totalAttempts = TestAttempt::where('user_id', $userId)
                    ->where('status', 'completed')
                    ->count();

                $averageScore = TestAttempt::where('user_id', $userId)
                    ->where('status', 'completed')
                    ->avg('percentage') ?? 0;

                $userStats = [
                    'completed_tests' => $completedTests,
                    'total_attempts' => $totalAttempts,
                    'average_score' => round($averageScore, 2),
                ];
            }

            return [
                'total_tests' => $totalTests,
                'tests_by_type' => $testsByType,
                'user_stats' => $userStats,
            ];
        });
    }

    /**
     * Search tests by title
     */
    public function searchTests(string $query): Collection
    {
        $userId = Auth::id();
        
        $tests = Test::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('title_en', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with(['chapter'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($userId) {
            $tests = $tests->map(function ($test) use ($userId) {
                $test->user_progress = $this->getTestProgress($test->id, $userId);
                $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                return $test;
            });
        }

        return $tests;
    }

    /**
     * Get tests by filters
     */
    public function getTestsByFilter(array $filters = []): Collection
    {
        $userId = Auth::id();
        $query = Test::where('is_active', true);
        
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        
        if (isset($filters['chapter_id'])) {
            $query->where('chapter_id', $filters['chapter_id']);
        }

        if (isset($filters['difficulty'])) {
            // Assuming difficulty is stored in settings or as a separate field
            $query->whereJsonContains('settings->difficulty', $filters['difficulty']);
        }

        if (isset($filters['is_featured']) && $filters['is_featured']) {
            $query->where('is_featured', true);
        }

        $tests = $query->with(['chapter'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($userId) {
            $tests = $tests->map(function ($test) use ($userId) {
                $test->user_progress = $this->getTestProgress($test->id, $userId);
                $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                return $test;
            });
        }

        return $tests;
    }

    /**
     * Get featured tests
     */
    public function getFeaturedTests(): Collection
    {
        return $this->getTestsByFilter(['is_featured' => true]);
    }

    /**
     * Get tests organized hierarchically by chapter/topic structure
     */
    public function getTestsHierarchically(): Collection
    {
        $userId = Auth::id();
        
        return Cache::remember("tests_hierarchical_{$userId}", 300, function () use ($userId) {
            // Get all chapters with their topics and tests
            $chapters = Chapter::where('is_active', true)
                ->with([
                    'topics' => function ($query) {
                        $query->where('is_active', true)->orderBy('order');
                    },
                    'topics.questions' => function ($query) {
                        $query->where('is_active', true);
                    }
                ])
                ->orderBy('order')
                ->get();

            // Also get tests that might not be topic-specific but chapter-specific
            $allTests = Test::where('is_active', true)
                ->with(['chapter'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Attach user progress if authenticated
            if ($userId) {
                $allTests = $allTests->map(function ($test) use ($userId) {
                    $test->user_progress = $this->getTestProgress($test->id, $userId);
                    $test->user_attempts = $this->getUserAttempts($test->id, $userId);
                    return $test;
                });
            }

            // Organize tests by chapter and topic
            $hierarchicalData = $chapters->map(function ($chapter) use ($allTests) {
                // Get tests for this chapter
                $chapterTests = $allTests->where('chapter_id', $chapter->id);
                
                // Organize topics with their actual tests
                $topicsWithTests = $chapter->topics->map(function ($topic) use ($chapterTests) {
                    // Get tests that are specifically assigned to this topic
                    $topicTests = $chapterTests->where('topic_id', $topic->id);
                    $topic->tests = $topicTests;
                    $topic->total_questions = $topic->questions->count();
                    return $topic;
                });

                $chapter->topics = $topicsWithTests;
                $chapter->tests = $chapterTests;
                
                return $chapter;
            });

            return $hierarchicalData;
        });
    }

    /**
     * Clear test cache
     */
    public function clearCache(): void
    {
        Cache::forget('test_statistics');
        
        // Clear user-specific caches if user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();
            Cache::forget("tests_with_progress_{$userId}");
            Cache::forget("tests_hierarchical_{$userId}");
            
            // Clear chapter-specific caches
            $chapters = Chapter::pluck('id');
            foreach ($chapters as $chapterId) {
                Cache::forget("tests_chapter_{$chapterId}_user_{$userId}");
            }

            // Clear type-specific caches
            foreach (TestType::cases() as $type) {
                Cache::forget("tests_type_{$type->value}_user_{$userId}");
            }
        }
    }
}