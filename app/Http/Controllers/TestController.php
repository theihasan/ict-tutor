<?php

namespace App\Http\Controllers;

use App\Services\TestService;
use App\Enums\TestType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TestController extends Controller
{
    public function __construct(
        private TestService $testService
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
     * Clear test cache (for admin use)
     */
    public function clearCache(): JsonResponse
    {
        try {
            $this->testService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}