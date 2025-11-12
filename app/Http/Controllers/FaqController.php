<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Pipelines\FilterPipeline;
use App\Pipelines\Filters\SearchFilter;
use App\Pipelines\Filters\TypeFilter;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display the FAQ page
     */
    public function index(Request $request)
    {
        $faqs = collect()->when(
            $this->hasFilterParameters($request),
            fn () => $this->getFilteredFaqs($request),
            fn () => Faq::active()->ordered()->get()
        );

        $faqsByCategory = $faqs->groupBy('category');

        return view('faq', compact('faqsByCategory'));
    }

    /**
     * Search FAQs via API
     */
    public function search(Request $request)
    {
        $faqs = $this->getFilteredFaqs($request);
        $faqsByCategory = $faqs->groupBy('category');

        return response()->json([
            'faqs' => $faqsByCategory,
            'total' => $faqs->count(),
            'search_term' => $request->get('q', ''),
            'category' => $request->get('category'),
        ]);
    }

    /**
     * Check if the request contains filter parameters
     */
    private function hasFilterParameters(Request $request): bool
    {
        $filterParams = [
            'search', 'q', 'query',           // Search parameters
            'category', 'type',                // Category filtering
        ];

        return collect($filterParams)->some(fn ($param) => $request->filled($param));

        return false;
    }

    /**
     * Get filtered FAQs using the pipeline
     */
    private function getFilteredFaqs(Request $request)
    {
        $pipeline = new FilterPipeline;

        $pipeline->addFilter(new SearchFilter)
            ->addFilter(new TypeFilter);

        // Get base query and apply filters
        $query = Faq::active()->ordered();
        $filteredQuery = $pipeline->apply($query, $request->all());

        return $filteredQuery->get();
    }
}
