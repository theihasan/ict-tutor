<?php

namespace App\Services;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Chapter;
use App\Models\UserAnswer;
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
    }

    /**
     * Get tests by chapter with user progress
     */
    public function getTestsByChapter(int $chapterId): Collection
    {
        $userId = Auth::id();
        
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
    }

    /**
     * Get tests by type with user progress
     */
    public function getTestsByType(TestType $type): Collection
    {
        $userId = Auth::id();
        
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
            ->whereNotNull('completed_at')
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

        $bestAttempt = $attempts->sortByDesc('obtained_marks')->first();
        $averageScore = $attempts->avg('obtained_marks');

        return (object) [
            'is_attempted' => true,
            'total_attempts' => $attempts->count(),
            'best_score' => $bestAttempt->obtained_marks,
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
                ->whereNotNull('completed_at')
                ->distinct('test_id')
                ->count();

            $totalAttempts = TestAttempt::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->count();

            $averageScore = TestAttempt::where('user_id', $userId)
                ->whereNotNull('completed_at')
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
    }

    /**
     * Get comprehensive test report data
     */
    public function getTestReport(int $testId): array
    {
        $test = Test::with(['chapter'])->find($testId);
        
        if (!$test) {
            throw new \Exception('Test not found');
        }

        // Basic test information
        $reportData = [
            'test' => $test,
            'basic_stats' => $this->getBasicTestStats($testId),
            'performance_stats' => $this->getPerformanceStats($testId),
            'question_analysis' => $this->getQuestionAnalysis($testId),
            'time_analysis' => $this->getTimeAnalysis($testId),
            'user_distribution' => $this->getUserDistribution($testId),
        ];

        return $reportData;
    }

    /**
     * Get basic test statistics
     */
    private function getBasicTestStats(int $testId): array
    {
        $totalAttempts = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->count();

        $uniqueUsers = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->distinct('user_id')
            ->count();

        $averageScore = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->avg('obtained_marks') ?? 0;

        $averagePercentage = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->avg('percentage') ?? 0;

        $passedAttempts = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->where('percentage', '>=', 60)
            ->count();

        return [
            'total_attempts' => $totalAttempts,
            'unique_users' => $uniqueUsers,
            'average_score' => round($averageScore, 2),
            'average_percentage' => round($averagePercentage, 2),
            'passed_attempts' => $passedAttempts,
            'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
        ];
    }

    /**
     * Get performance statistics breakdown
     */
    private function getPerformanceStats(int $testId): array
    {
        $attempts = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->get();

        if ($attempts->isEmpty()) {
            return [
                'score_distribution' => [],
                'highest_score' => 0,
                'lowest_score' => 0,
                'median_score' => 0,
            ];
        }

        $scores = $attempts->pluck('percentage')->sort()->values();
        
        $scoreRanges = [
            '0-20%' => 0,
            '21-40%' => 0,
            '41-60%' => 0,
            '61-80%' => 0,
            '81-100%' => 0,
        ];

        foreach ($scores as $score) {
            if ($score <= 20) $scoreRanges['0-20%']++;
            elseif ($score <= 40) $scoreRanges['21-40%']++;
            elseif ($score <= 60) $scoreRanges['41-60%']++;
            elseif ($score <= 80) $scoreRanges['61-80%']++;
            else $scoreRanges['81-100%']++;
        }

        return [
            'score_distribution' => $scoreRanges,
            'highest_score' => $scores->max(),
            'lowest_score' => $scores->min(),
            'median_score' => $scores->median(),
        ];
    }

    /**
     * Get question-wise analysis
     */
    private function getQuestionAnalysis(int $testId): array
    {
        // Get all answers for this test
        $answers = UserAnswer::whereHas('testAttempt', function ($query) use ($testId) {
            $query->where('test_id', $testId)->whereNotNull('completed_at');
        })
        ->with(['question'])
        ->get();

        if ($answers->isEmpty()) {
            return [
                'total_questions' => 0,
                'question_stats' => [],
            ];
        }

        $questionStats = [];
        $questionGroups = $answers->groupBy('question_id');

        foreach ($questionGroups as $questionId => $questionAnswers) {
            $question = $questionAnswers->first()->question;
            $totalAnswers = $questionAnswers->count();
            $correctAnswers = $questionAnswers->where('is_correct', true)->count();
            
            $questionStats[] = [
                'question_id' => $questionId,
                'question_text' => $question->text ?? 'Question ' . $questionId,
                'total_answers' => $totalAnswers,
                'correct_answers' => $correctAnswers,
                'accuracy_rate' => $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 2) : 0,
                'difficulty_level' => $question->difficulty_level ? $question->difficulty_level->value : 'medium',
            ];
        }

        // Sort by accuracy rate (ascending) to show difficult questions first
        usort($questionStats, function($a, $b) {
            return $a['accuracy_rate'] <=> $b['accuracy_rate'];
        });

        return [
            'total_questions' => count($questionStats),
            'question_stats' => $questionStats,
        ];
    }

    /**
     * Get time analysis for test attempts
     */
    private function getTimeAnalysis(int $testId): array
    {
        $attempts = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->whereNotNull('started_at')
            ->get();

        if ($attempts->isEmpty()) {
            return [
                'average_time' => 0,
                'fastest_time' => 0,
                'slowest_time' => 0,
                'time_distribution' => [],
            ];
        }

        $durations = $attempts->map(function ($attempt) {
            $start = \Carbon\Carbon::parse($attempt->started_at);
            $end = \Carbon\Carbon::parse($attempt->completed_at);
            return $end->diffInMinutes($start);
        })->filter()->values();

        if ($durations->isEmpty()) {
            return [
                'average_time' => 0,
                'fastest_time' => 0,
                'slowest_time' => 0,
                'time_distribution' => [],
            ];
        }

        $timeRanges = [
            '0-10 min' => 0,
            '11-20 min' => 0,
            '21-30 min' => 0,
            '31-45 min' => 0,
            '45+ min' => 0,
        ];

        foreach ($durations as $duration) {
            if ($duration <= 10) $timeRanges['0-10 min']++;
            elseif ($duration <= 20) $timeRanges['11-20 min']++;
            elseif ($duration <= 30) $timeRanges['21-30 min']++;
            elseif ($duration <= 45) $timeRanges['31-45 min']++;
            else $timeRanges['45+ min']++;
        }

        return [
            'average_time' => round($durations->avg(), 2),
            'fastest_time' => $durations->min(),
            'slowest_time' => $durations->max(),
            'time_distribution' => $timeRanges,
        ];
    }

    /**
     * Get user distribution data
     */
    private function getUserDistribution(int $testId): array
    {
        $attempts = TestAttempt::where('test_id', $testId)
            ->whereNotNull('completed_at')
            ->with(['user'])
            ->get();

        if ($attempts->isEmpty()) {
            return [
                'attempts_per_user' => [],
                'top_performers' => [],
                'recent_attempts' => [],
            ];
        }

        // Attempts per user
        $attemptsPerUser = $attempts->groupBy('user_id')->map(function ($userAttempts) {
            return $userAttempts->count();
        });

        // Top performers (best score per user)
        $topPerformers = $attempts->groupBy('user_id')
            ->map(function ($userAttempts) {
                $bestAttempt = $userAttempts->sortByDesc('percentage')->first();
                return [
                    'user_name' => $bestAttempt->user->name ?? 'Anonymous',
                    'best_score' => $bestAttempt->percentage,
                    'attempts_count' => $userAttempts->count(),
                    'latest_attempt' => $bestAttempt->completed_at,
                ];
            })
            ->sortByDesc('best_score')
            ->take(10)
            ->values();

        // Recent attempts
        $recentAttempts = $attempts->sortByDesc('completed_at')
            ->take(10)
            ->map(function ($attempt) {
                return [
                    'user_name' => $attempt->user->name ?? 'Anonymous',
                    'score' => $attempt->percentage,
                    'completed_at' => $attempt->completed_at,
                    'time_taken' => $attempt->started_at && $attempt->completed_at 
                        ? \Carbon\Carbon::parse($attempt->started_at)->diffInMinutes($attempt->completed_at)
                        : null,
                ];
            })
            ->values();

        return [
            'attempts_per_user' => $attemptsPerUser->toArray(),
            'top_performers' => $topPerformers->toArray(),
            'recent_attempts' => $recentAttempts->toArray(),
        ];
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