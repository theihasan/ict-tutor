<?php

namespace App\Http\Controllers;

use App\Pipelines\FilterPipeline;
use App\Pipelines\Filters\SearchFilter;
use App\Services\ChapterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            $chapters = collect()
                ->when($this->hasSearchParameters($request), function ($collection) use ($request) {
                    return $this->getFilteredChapters($request);
                }, function ($collection) {
                    return $this->chapterService->getAllChaptersWithProgress();
                });

            $statistics = $this->chapterService->getChapterStatistics();

            return view('chapters', compact('chapters', 'statistics'));

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapters',
                    'error' => config('app.debug') ? $e->getMessage() : null,
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

            return view('chapter-detail', compact('chapter'));

        } catch (\Exception $e) {
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
                'data' => $statistics,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load statistics',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Search chapters API endpoint
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        try {
            $chapters = $this->getFilteredChapters($request);

            return response()->json([
                'success' => true,
                'data' => $chapters,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
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

            // Get the TestService to fetch chapter-specific tests
            $testService = app(\App\Services\TestService::class);
            $tests = $testService->getTestsByChapter($id);
            $statistics = $testService->getTestStatistics();

            return view('model-tests', [
                'chapter' => $chapter,
                'tests' => $tests,
                'statistics' => $statistics,
                'chapterId' => $id,
                'viewType' => 'chapter-specific',
            ]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load chapter model tests',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

            return back()->with('error', 'Failed to load chapter model tests. Please try again.');
        }
    }

    /**
     * Check if the request contains search parameters
     */
    private function hasSearchParameters(Request $request): bool
    {
        $searchParams = ['search', 'q', 'query'];

        return collect($searchParams)->contains(fn ($param) => $request->filled($param));

        return false;
    }

    /**
     * Get filtered chapters using the pipeline
     */
    private function getFilteredChapters(Request $request)
    {
        $pipeline = new FilterPipeline;

        $pipeline->addFilter(new SearchFilter);

        $query = $this->chapterService->getBaseChapterQuery();
        $filteredQuery = $pipeline->apply($query, $request->all());
        if (auth()->check()) {
            return $this->chapterService->attachUserProgressToChapters($filteredQuery->get());
        }

        return $filteredQuery->get();
    }
}
