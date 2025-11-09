<?php

namespace App\Http\Controllers;

use App\Services\ChapterService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
    public function __construct(
        private ChapterService $chapterService
    ) {}

    /**
     * Display all chapters
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            // Handle search query
            if ($request->has('search')) {
                $chapters = $this->chapterService->searchChapters($request->get('search'));
            } 
            // Handle filters
            elseif ($request->has('filter')) {
                $filters = $request->only(['color', 'has_topics']);
                $chapters = $this->chapterService->getChaptersByFilter($filters);
            } 
            // Get all chapters with progress
            else {
                $chapters = $this->chapterService->getAllChaptersWithProgress();
            }

            // Get statistics for the view
            $statistics = $this->chapterService->getChapterStatistics();

            // Return JSON for API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'chapters' => $chapters,
                        'statistics' => $statistics
                    ]
                ]);
            }

            // Return view for web requests
            return view('chapters', compact('chapters', 'statistics'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapters',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Failed to load chapters. Please try again.');
        }
    }

    /**
     * Display specific chapter details
     */
    public function show(Request $request, int $id): View|JsonResponse
    {
        try {
            $chapter = $this->chapterService->getChapterById($id);

            if (!$chapter) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Chapter not found'
                    ], 404);
                }

                return abort(404, 'Chapter not found');
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $chapter
                ]);
            }

            return view('chapter-detail', compact('chapter'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapter details',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Failed to load chapter details. Please try again.');
        }
    }

    /**
     * API endpoint for chapter statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $statistics = $this->chapterService->getChapterStatistics();
            
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
     * Search chapters API endpoint
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        try {
            $chapters = $this->chapterService->searchChapters($request->get('q'));
            
            return response()->json([
                'success' => true,
                'data' => $chapters
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
     * Display model tests for a specific chapter
     */
    public function modelTests(Request $request, int $id): View|JsonResponse
    {
        try {
            $chapter = $this->chapterService->getChapterById($id);

            if (!$chapter) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Chapter not found'
                    ], 404);
                }

                return abort(404, 'Chapter not found');
            }

            // Get the TestService to fetch chapter-specific tests
            $testService = app(\App\Services\TestService::class);
            $tests = $testService->getTestsByChapter($id);
            $statistics = $testService->getTestStatistics();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'chapter' => $chapter,
                        'tests' => $tests,
                        'statistics' => $statistics
                    ]
                ]);
            }

            return view('model-tests', [
                'chapter' => $chapter,
                'tests' => $tests,
                'statistics' => $statistics,
                'chapterId' => $id,
                'viewType' => 'chapter-specific'
            ]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapter model tests',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Failed to load chapter model tests. Please try again.');
        }
    }

    /**
     * Clear chapter cache (for admin use)
     */
    public function clearCache(): JsonResponse
    {
        try {
            $this->chapterService->clearCache();
            
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