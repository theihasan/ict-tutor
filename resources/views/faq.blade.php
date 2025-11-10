@extends('layouts.app')

@section('title', 'FAQ - HSC ICT Interactive Practice Platform')
@section('description', 'HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।')
@section('keywords', 'HSC ICT FAQ, সচরাচর জিজ্ঞাসা, সাহায্য, প্রশ্ন উত্তর, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="FAQ - HSC ICT Interactive"/>
<meta property="og:description" content="HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/faq.html"/>
<meta property="og:image" content="https://hscict.com/images/faq-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - FAQ পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="FAQ - HSC ICT Interactive"/>
<meta name="twitter:description" content="HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।"/>
<meta name="twitter:image" content="https://hscict.com/images/faq-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - FAQ পেজ"/>

@push('styles')
<style>
/* Smooth FAQ accordion animations */
.faq-item {
    transition: all 0.2s ease-in-out;
}

.faq-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.faq-answer {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: top;
}

/* Smooth icon rotation */
.material-symbols-outlined {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom transition for max-height */
[x-transition] {
    transition-property: opacity, max-height, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Smooth search results appearance */
.faq-section {
    transition: all 0.3s ease-in-out;
}

/* Category button smooth transitions */
.grid button {
    transition: all 0.2s ease-in-out;
}

.grid button:hover {
    transform: translateY(-1px);
}
</style>
@endpush

@section('content')
<div x-data="faqApp()" x-init="initializeFaq()">
<!-- Hero Section -->
<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">
<div class="text-center mb-12">
<h1 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-200 mb-4 bengali-text">
প্রায়শই জিজ্ঞাসিত প্রশ্ন (FAQ)
</h1>
<p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto bengali-text">
HSC ICT Interactive প্ল্যাটফর্ম সম্পর্কে আপনার যে কোনো প্রশ্নের উত্তর এখানে খুঁজে পান
</p>
</div>

<!-- Search Box -->
<div class="max-w-2xl mx-auto mb-12">
<div class="relative">
<input 
  type="text" 
  placeholder="প্রশ্ন খুঁজুন..." 
  class="w-full px-4 py-3 pl-12 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:shadow-md focus:shadow-lg bengali-text"
  x-model="searchTerm"
  @input="searchFAQs()"
  value="{{ request('search') }}"
/>
<span class="material-symbols-outlined absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
search
</span>
</div>
</div>

<!-- FAQ Categories -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
@foreach(\App\Enums\FaqCategory::cases() as $categoryEnum)
<button @click="setActiveCategory('{{ $categoryEnum->value }}')" 
        class="p-4 rounded-lg border-2 font-medium transition-all duration-300 hover:bg-primary/20 hover:shadow-md hover:-translate-y-0.5 bengali-text"
        :class="activeCategory === '{{ $categoryEnum->value }}' ? 'border-primary bg-primary/10 text-primary shadow-lg' : 'border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:border-primary hover:text-primary'">
{{ $categoryEnum->label() }}
</button>
@endforeach
</div>

<!-- FAQ Sections -->
<div class="max-w-4xl mx-auto">

@if(isset($faqsByCategory) && $faqsByCategory->count() > 0)
    @foreach(\App\Enums\FaqCategory::cases() as $categoryEnum)
        @php 
            $category = $categoryEnum->value;
            $title = $categoryEnum->label() . ' প্রশ্ন';
        @endphp
        @if($faqsByCategory->has($category))
        <div x-show="activeCategory === '{{ $category }}' || searchTerm !== ''" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             class="faq-section mb-8">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 bengali-text" x-show="activeCategory === '{{ $category }}' && searchTerm === ''">{{ $title }}</h2>
            <div class="space-y-4">
                @foreach($faqsByCategory[$category] as $faq)
                <div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200" 
                     x-show="activeCategory === '{{ $category }}' || isVisible('{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <button @click="toggleFAQ('faq{{ $faq->id }}')" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200">
                        <span class="font-medium text-slate-800 dark:text-slate-200 bengali-text pr-4">{{ $faq->question }}</span>
                        <span class="material-symbols-outlined text-slate-400 flex-shrink-0 transition-all duration-300" 
                              :class="{ 'rotate-180 text-primary': openFAQs.faq{{ $faq->id }} }">expand_more</span>
                    </button>
                    <div x-show="openFAQs.faq{{ $faq->id }}" 
                         x-collapse
                         class="border-t border-slate-100 dark:border-slate-700">
                        <div class="px-6 py-4">
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
@else
    <div class="text-center py-12">
        <div class="text-slate-500 dark:text-slate-400 text-lg bengali-text">
            <span x-show="searchTerm !== ''">আপনার অনুসন্ধানের জন্য কোনো ফলাফল পাওয়া যায়নি।</span>
            <span x-show="searchTerm === ''">কোনো FAQ পাওয়া যায়নি।</span>
        </div>
    </div>
@endif

</div>

<!-- Contact Section -->
<div class="bg-slate-50 dark:bg-slate-900 mt-16 py-12">
<div class="max-w-4xl mx-auto px-4 text-center">
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4 bengali-text">
আপনার প্রশ্নের উত্তর পাননি?
</h2>
<p class="text-slate-600 dark:text-slate-400 mb-6 bengali-text">
আমাদের সাপোর্ট টিম আপনাকে সাহায্য করতে প্রস্তুত। যে কোনো সময় যোগাযোগ করুন।
</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-[#0d1b18] font-medium rounded-lg hover:bg-opacity-90 transition-all bengali-text">
<span class="material-symbols-outlined mr-2">email</span>
যোগাযোগ করুন
</a>
<a href="mailto:support@hscict.com" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-all bengali-text">
<span class="material-symbols-outlined mr-2">support</span>
support@hscict.com
</a>
</div>
</div>
</div>

</div> <!-- End Alpine.js component -->
@endsection

@push('scripts')
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script>
function faqApp() {
    return {
        activeCategory: '{{ request("category", "general") }}',
        searchTerm: '{{ request("search") }}',
        openFAQs: {},
        searchTimeout: null,
        
        initializeFaq() {
            // Initialize with URL parameters
            if (this.searchTerm) {
                this.searchFAQs();
            }
        },
        
        setActiveCategory(category) {
            this.activeCategory = category;
            this.searchTerm = '';
            
            // Update URL without reloading
            const url = new URL(window.location);
            url.searchParams.set('category', category);
            url.searchParams.delete('search');
            window.history.pushState({}, '', url);
        },
        
        toggleFAQ(faqId) {
            this.openFAQs[faqId] = !this.openFAQs[faqId];
        },
        
        isVisible(question, answer) {
            if (!this.searchTerm) return this.activeCategory === 'all';
            
            const searchLower = this.searchTerm.toLowerCase();
            return question.toLowerCase().includes(searchLower) || 
                   answer.toLowerCase().includes(searchLower);
        },
        
        searchFAQs() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            
            // Set new timeout for debounced search
            this.searchTimeout = setTimeout(() => {
                if (this.searchTerm.trim()) {
                    this.performSearch();
                } else {
                    // If search is empty, show current category
                    const url = new URL(window.location);
                    url.searchParams.delete('search');
                    url.searchParams.set('category', this.activeCategory);
                    window.history.pushState({}, '', url);
                }
            }, 300);
        },
        
        performSearch() {
            const url = new URL(window.location);
            url.searchParams.set('search', this.searchTerm);
            url.searchParams.delete('category');
            window.history.pushState({}, '', url);
            
            // Make AJAX request for search results
            fetch(`/api/faqs/search?q=${encodeURIComponent(this.searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    // Handle search results if needed
                    console.log('Search results:', data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }
    }
}
</script>
@endpush