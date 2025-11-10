<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Enums\FaqCategory;

class FaqController extends Controller
{
    /**
     * Display the FAQ page
     */
    public function index(Request $request)
    {
        $query = Faq::active()->ordered();

        // Apply category filter if provided
        if ($request->filled('category') && in_array($request->category, FaqCategory::values())) {
            $query->byCategory($request->category);
        }

        // Apply search filter if provided
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $faqs = $query->get();

        // Group FAQs by category for display
        $faqsByCategory = $faqs->groupBy('category');

        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'faqs' => $faqsByCategory,
                'total' => $faqs->count()
            ]);
        }

        return view('faq', compact('faqsByCategory'));
    }

    /**
     * Search FAQs via API
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('q', '');
        $category = $request->get('category');

        $query = Faq::active()->ordered();

        if (!empty($searchTerm)) {
            $query->search($searchTerm);
        }

        if (!empty($category) && in_array($category, FaqCategory::values())) {
            $query->byCategory($category);
        }

        $faqs = $query->get();
        $faqsByCategory = $faqs->groupBy('category');

        return response()->json([
            'faqs' => $faqsByCategory,
            'total' => $faqs->count(),
            'search_term' => $searchTerm,
            'category' => $category
        ]);
    }
}
