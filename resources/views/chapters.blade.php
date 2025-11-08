@extends('layouts.app')

@section('title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন এবং পরীক্ষায় A+ পান।')

@section('keywords', 'HSC ICT অধ্যায়, C Programming, HTML, CSS, Number System, Logic Gates, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং')

@section('og:title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('og:description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন এবং পরীক্ষায় A+ পান।')

@section('og:url', 'https://hscict.com/chapters.html')

@section('og:image', 'https://hscict.com/images/chapters-og-image.jpg')

@section('og:image:alt', 'HSC ICT Interactive - অধ্যায় নির্বাচন পেজ')

@section('twitter:title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('twitter:description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন।')

@section('twitter:image', 'https://hscict.com/images/chapters-og-image.jpg')

@section('twitter:image:alt', 'HSC ICT Interactive - অধ্যায় নির্বাচন পেজ')

@section('content')
<div class="flex flex-col items-center flex-1">
    <!-- Page Header -->
    <section class="w-full py-12 md:py-16 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <h1 class="text-[#0d1b18] dark:text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4 bengali-text">
                    আপনার অধ্যায় বেছে নিন
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg leading-relaxed bengali-text">
                    যে অধ্যায়ে প্র্যাকটিস করতে চান, সেটিতে ক্লিক করুন
                </p>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="w-full py-8 bg-slate-50 dark:bg-slate-900/30">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Bar -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">search</span>
                        <input 
                            type="text" 
                            id="chapter-search"
                            placeholder="অধ্যায় খুঁজুন..." 
                            class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bengali-text"
                        >
                    </div>
                </div>

                <!-- Filter Options -->
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">ফিল্টার:</span>
                    <select id="color-filter" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary bengali-text">
                        <option value="">সব রং</option>
                        <option value="blue">নীল</option>
                        <option value="green">সবুজ</option>
                        <option value="red">লাল</option>
                        <option value="purple">বেগুনি</option>
                    </select>
                    <button id="clear-filters" class="px-4 py-2 text-primary hover:text-primary/80 text-sm font-medium transition-colors bengali-text">
                        পরিষ্কার করুন
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Chapters Grid -->
    <section class="w-full py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4" id="chapters-container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($chapters as $chapter)
                <a href="{{ route('chapter.show', $chapter->id) }}" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় {{ $chapter->order }}</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">{{ $chapter->name }}</h3>
                            @if($chapter->description)
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 bengali-text">{{ Str::limit($chapter->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">{{ $chapter->icon ?? 'menu_book' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        @if(isset($chapter->user_progress) && $chapter->user_progress->completion_percentage > 0)
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $chapter->user_progress->completion_percentage }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ round($chapter->user_progress->completion_percentage) }}%</span>
                        </div>
                        @else
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                        @endif
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">menu_book</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">কোন অধ্যায় পাওয়া যায়নি</h3>
                    <p class="text-slate-600 dark:text-slate-400 bengali-text">শীঘ্রই নতুন অধ্যায় যোগ করা হবে।</p>
                </div>
                @endforelse
            </div>

            <!-- Quick Stats -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">checklist</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">{{ $statistics['total_chapters'] ?? 0 }}</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">অধ্যায়</p>
                </div>
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">code</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">{{ $statistics['total_topics'] ?? 0 }}</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">টপিক</p>
                </div>
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">psychology</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">{{ $chapters->sum('active_questions') ?? 600 }}+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">প্রশ্ন</p>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('chapter-search');
    const colorFilter = document.getElementById('color-filter');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const chaptersContainer = document.getElementById('chapters-container');
    const chaptersGrid = chaptersContainer.querySelector('.grid');
    
    let searchTimeout;
    
    // Store original content
    const originalContent = chaptersContainer.innerHTML;
    
    // Search functionality
    function performSearch() {
        const searchQuery = searchInput.value.trim();
        const colorValue = colorFilter.value;
        
        if (!searchQuery && !colorValue) {
            chaptersContainer.innerHTML = originalContent;
            return;
        }
        
        let url = '/chapters?';
        const params = new URLSearchParams();
        
        if (searchQuery) {
            params.append('search', searchQuery);
        }
        
        if (colorValue) {
            params.append('filter[color]', colorValue);
        }
        
        // Show loading state
        chaptersGrid.innerHTML = `
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-primary text-4xl animate-spin">refresh</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">খুঁজছি...</p>
            </div>
        `;
        
        // Fetch filtered results
        fetch(url + params.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.chapters) {
                updateChaptersGrid(data.data.chapters);
            } else {
                showNoResults();
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            showError();
        });
    }
    
    // Update chapters grid with new data
    function updateChaptersGrid(chapters) {
        if (chapters.length === 0) {
            showNoResults();
            return;
        }
        
        let gridHTML = '';
        chapters.forEach(chapter => {
            const progressBar = chapter.user_progress && chapter.user_progress.completion_percentage > 0 
                ? `<div class="flex items-center gap-2">
                     <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                         <div class="h-full bg-primary rounded-full" style="width: ${chapter.user_progress.completion_percentage}%"></div>
                     </div>
                     <span class="text-xs font-medium text-slate-600 dark:text-slate-400">${Math.round(chapter.user_progress.completion_percentage)}%</span>
                   </div>`
                : `<span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>`;
            
            gridHTML += `
                <a href="/chapters/${chapter.id}" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ${chapter.order}</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">${chapter.name}</h3>
                            ${chapter.description ? `<p class="text-sm text-slate-600 dark:text-slate-400 mt-1 bengali-text">${chapter.description.substring(0, 100)}${chapter.description.length > 100 ? '...' : ''}</p>` : ''}
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">${chapter.icon || 'menu_book'}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        ${progressBar}
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>
            `;
        });
        
        chaptersGrid.innerHTML = gridHTML;
    }
    
    // Show no results message
    function showNoResults() {
        chaptersGrid.innerHTML = `
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-slate-400 text-4xl">search_off</span>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">কোন অধ্যায় পাওয়া যায়নি</h3>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">অন্য কিছু খুঁজে দেখুন।</p>
            </div>
        `;
    }
    
    // Show error message
    function showError() {
        chaptersGrid.innerHTML = `
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-500 text-4xl">error</span>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">ত্রুটি ঘটেছে</h3>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">পুনরায় চেষ্টা করুন।</p>
            </div>
        `;
    }
    
    // Event listeners
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500); // Debounce search
    });
    
    colorFilter.addEventListener('change', performSearch);
    
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        colorFilter.value = '';
        chaptersContainer.innerHTML = originalContent;
    });
});
</script>
@endpush
@endsection