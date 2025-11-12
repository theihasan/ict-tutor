<?php

namespace App\Http\Controllers;

use App\Services\TestService;
use App\Services\QuestionPaperService;
use App\Enums\TestType;
use App\Pipelines\FilterPipeline;
use App\Pipelines\Filters\SearchFilter;
use App\Pipelines\Filters\TypeFilter;
use App\Pipelines\Filters\ChapterFilter;
use App\Pipelines\Filters\StatusFilter;
use App\Pipelines\Filters\DifficultyFilter;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TestController extends Controller
{
    public function __construct(
        private TestService $testService,
        private QuestionPaperService $questionPaperService
    ) {}

    /**
     * Display all tests with pipeline filtering
     */
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            $viewType = $request->get('view', 'hierarchical');

            match (true) {
                $this->hasFilterParameters($request) => function() use ($request, &$tests, &$viewType) {
                    $tests = $this->getFilteredTests($request);
                    $viewType = 'flat';
                }(),
                $viewType === 'hierarchical' => function() use ($request, &$chaptersWithTests, &$tests) {
                    $chaptersWithTests = $this->getHierarchicalTests($request);
                    $tests = collect();
                }(),
                default => function() use (&$tests) {
                    $tests = $this->testService->getTestsByType(TestType::MODEL_TEST);
                }()
            };
            
            $statistics = $this->testService->getTestStatistics();

            if ($viewType === 'hierarchical') {
                return view('model-tests', compact('chaptersWithTests', 'statistics', 'viewType'));
            } else {
                return view('model-tests', compact('tests', 'statistics', 'viewType'));
            }
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load tests',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->route('model-tests')->with('error', 'Failed to load tests. Please try again.');
        }
    }

    /**
     * Display tests by chapter
     */
    public function byChapter(Request $request, int $chapterId): View|JsonResponse|RedirectResponse
    {
        try {
            $tests = $this->testService->getTestsByChapter($chapterId);
            $statistics = $this->testService->getTestStatistics();

            return view('model-tests', compact('tests', 'statistics', 'chapterId'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapter tests',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->route('model-tests')->with('error', 'Failed to load chapter tests. Please try again.');
        }
    }

    /**
     * Display tests by type
     */
    public function byType(Request $request, string $type): View|JsonResponse|RedirectResponse
    {
        try {
            $testType = TestType::tryFrom($type);

            $tests = $this->testService->getTestsByType($testType);
            $statistics = $this->testService->getTestStatistics();

            return view('model-tests', compact('tests', 'statistics', 'type'));
            
        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load tests by type. Please try again.');
        }
    }

    /**
     * Display specific test details
     */
    public function show(Request $request, int $id): View|JsonResponse|RedirectResponse
    {
        try {
            $test = $this->testService->getTestById($id);

            return view('model-test-summary', compact('test'));

        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load test details. Please try again.');
        }
    }

    /**
     * Display featured tests
     */
    public function featured(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            $tests = $this->testService->getFeaturedTests();
            $statistics = $this->testService->getTestStatistics();

            return view('model-tests', compact('tests', 'statistics'));
            
        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load featured tests. Please try again.');
        }
    }

    /**
     * API endpoint for test statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $statistics = $this->testService->getTestStatistics();
            
            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load statistics',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Search tests API endpoint
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        try {
            $tests = $this->testService->searchTests($request->get('q'));
            
            return response()->json([
                'success' => true,
                'data' => $tests
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }



    /**
     * Display exam paper for a specific test
     */
    public function examPaper(Request $request, int $testId): View|JsonResponse|RedirectResponse
    {
        try {
            $userId = auth()->id();
            $questionPaper = $this->questionPaperService->generateQuestionPaper($testId, $userId);

            return view('exam-paper', compact('questionPaper'));

        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load exam paper. Please try again.');
        }
    }

    /**
     * Get test preview without starting attempt
     */
    public function preview(Request $request, int $testId): View|JsonResponse|RedirectResponse
    {
        try {
            $preview = $this->questionPaperService->getTestPreview($testId);
            return view('test-preview', compact('preview'));

        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load test preview. Please try again.');
        }
    }

    /**
     * Start a test attempt
     */
    public function startAttempt(Request $request, int $testId): JsonResponse|RedirectResponse
    {
        try {
            $userId = auth()->id();
            $attempt = $this->questionPaperService->startTestAttempt($testId, $userId);

            return redirect()->route('tests.exam-paper', $testId);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save answer for a question
     */
    public function saveAnswer(Request $request): JsonResponse
    {
        $request->validate([
            'attempt_id' => 'required|integer|exists:test_attempts,id',
            'question_id' => 'required|integer|exists:questions,id',
            'answer' => 'required|string'
        ]);

        try {
            $userAnswer = $this->questionPaperService->saveAnswer(
                $request->attempt_id,
                $request->question_id,
                $request->answer
            );

            return response()->json([
                'success' => true,
                'data' => $userAnswer,
                'message' => 'Answer saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save answer',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Submit test attempt
     */
    public function submitAttempt(Request $request, int $attemptId): JsonResponse|RedirectResponse
    {
        try {
            $attempt = $this->questionPaperService->submitTest($attemptId);

            return redirect()->route('tests.results', $attemptId);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show test results
     */
    public function results(Request $request, int $attemptId): View|JsonResponse|RedirectResponse
    {
        try {
            $results = $this->questionPaperService->getTestResults($attemptId);

            // Ensure user can only view their own results
            if (auth()->id() !== $results['attempt']->user_id) {
                abort(403, 'Unauthorized');
            }

            return view('test-results', compact('results'));

        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load test results. Please try again.');
        }
    }

    /**
     * Display test report with statistics and analytics
     */
    public function report(Request $request, int $id): View|JsonResponse|RedirectResponse
    {
        try {
            $test = $this->testService->getTestById($id);

            $reportData = $this->testService->getTestReport($id);

            return view('test-report', compact('test', 'reportData'));

        } catch (\Exception $e) {
            return redirect()->route('model-tests')->with('error', 'Failed to load test report. Please try again.');
        }
    }


}