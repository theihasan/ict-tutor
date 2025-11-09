<?php

namespace App\Http\Controllers;

use App\Services\TestService;
use App\Services\QuestionPaperService;
use App\Enums\TestType;
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
     * Display all tests
     */
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        try {
            // Check if we want hierarchical view (default behavior)
            $viewType = $request->get('view', 'hierarchical');
            
            if ($request->has('search')) {
                $tests = $this->testService->searchTests($request->get('search'));
                $viewType = 'flat'; // Use flat view for search results
            } 
            elseif ($request->has('filter')) {
                $filters = $request->only(['type', 'chapter_id', 'difficulty', 'is_featured']);
                $tests = $this->testService->getTestsByFilter($filters);
                $viewType = 'flat'; // Use flat view for filtered results
            } 
            elseif ($viewType === 'hierarchical') {
                // Use hierarchical structure by default
                $chaptersWithTests = $this->testService->getTestsHierarchically();
                $tests = collect(); // Empty for hierarchical view
            }
            else {
                $tests = $this->testService->getAllTestsWithProgress();
            }
            
            // Get statistics for the view
            $statistics = $this->testService->getTestStatistics();

            // Return JSON for API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'tests' => $tests ?? collect(),
                        'chapters' => $chaptersWithTests ?? collect(),
                        'statistics' => $statistics,
                        'view_type' => $viewType
                    ]
                ]);
            }

            // Return view for web requests
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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'tests' => $tests,
                        'statistics' => $statistics
                    ]
                ]);
            }

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
            // Validate test type
            $testType = TestType::tryFrom($type);
            if (!$testType) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid test type'
                    ], 400);
                }
                return abort(404, 'Invalid test type');
            }

            $tests = $this->testService->getTestsByType($testType);
            $statistics = $this->testService->getTestStatistics();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'tests' => $tests,
                        'statistics' => $statistics
                    ]
                ]);
            }

            return view('model-tests', compact('tests', 'statistics', 'type'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load tests by type',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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

            if (!$test) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Test not found'
                    ], 404);
                }

                return abort(404, 'Test not found');
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $test
                ]);
            }

            return view('model-test-summary', compact('test'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load test details',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'tests' => $tests,
                        'statistics' => $statistics
                    ]
                ]);
            }

            return view('model-tests', compact('tests', 'statistics'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load featured tests',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $questionPaper
                ]);
            }

            return view('exam-paper', compact('questionPaper'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate question paper',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $preview
                ]);
            }

            return view('test-preview', compact('preview'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load test preview',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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
            
            if (!$userId) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Authentication required'
                    ], 401);
                }
                return redirect()->route('login');
            }

            $attempt = $this->questionPaperService->startTestAttempt($testId, $userId);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $attempt,
                    'redirect_url' => route('tests.exam-paper', $testId)
                ]);
            }

            return redirect()->route('tests.exam-paper', $testId);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 400);
            }

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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $attempt,
                    'redirect_url' => route('tests.results', $attemptId)
                ]);
            }

            return redirect()->route('tests.results', $attemptId);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 400);
            }

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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $results
                ]);
            }

            return view('test-results', compact('results'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load test results',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

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

            if (!$test) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Test not found'
                    ], 404);
                }

                return abort(404, 'Test not found');
            }

            // Get comprehensive test statistics
            $reportData = $this->testService->getTestReport($id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $reportData
                ]);
            }

            return view('test-report', compact('test', 'reportData'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load test report',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->route('model-tests')->with('error', 'Failed to load test report. Please try again.');
        }
    }


}