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
<div class="flex flex-col items-center flex-1" x-data="chapterSearch()"
     x-init="initializeSearch()">
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
            <div class="flex justify-center">
                <!-- Search Bar -->
                <div class="w-full max-w-lg">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">search</span>
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            @input.debounce.500ms="performSearch()"
                            placeholder="অধ্যায় খুঁজুন..." 
                            class="w-full pl-12 pr-12 py-4 border border-slate-300 dark:border-slate-600 rounded-2xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bengali-text text-base shadow-sm hover:shadow-md transition-shadow"
                        >
                        <!-- Clear button inside search box -->
                        <button 
                            @click="clearSearch()" 
                            x-show="searchQuery.length > 0"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded-full bg-slate-300 dark:bg-slate-600 hover:bg-slate-400 dark:hover:bg-slate-500 flex items-center justify-center transition-colors group"
                            title="পরিষ্কার করুন"
                        >
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300 group-hover:text-slate-700 dark:group-hover:text-slate-200 text-sm">close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chapters Grid -->
    <section class="w-full py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Show search results when searching -->
                <template x-if="isSearching && searchResults.length > 0">
                    <template x-for="chapter in searchResults" :key="chapter.id">
                        <a :href="`/chapters/${chapter.id}`" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                            <div class="flex items-start justify-between">
                                <div class="flex flex-col flex-1">
                                    <p class="text-sm font-semibold text-primary bengali-text" x-text="`অধ্যায় ${chapter.order}`"></p>
                                    <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text" x-text="chapter.name"></h3>
                                    <p x-show="chapter.description" class="text-sm text-slate-600 dark:text-slate-400 mt-1 bengali-text" x-text="chapter.description ? (chapter.description.length > 100 ? chapter.description.substring(0, 100) + '...' : chapter.description) : ''"></p>
                                </div>
                                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                                    <span class="material-symbols-outlined text-primary text-3xl" x-text="chapter.icon || 'menu_book'"></span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                                <!-- Progress section -->
                                <template x-if="chapter.user_progress && chapter.user_progress.completion_percentage > 0">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full" :style="`width: ${chapter.user_progress.completion_percentage}%`"></div>
                                        </div>
                                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400" x-text="`${Math.round(chapter.user_progress.completion_percentage)}%`"></span>
                                    </div>
                                </template>
                                <template x-if="!chapter.user_progress || chapter.user_progress.completion_percentage <= 0">
                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                                </template>
                                <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                            </div>
                        </a>
                    </template>
                </template>

                <!-- Show original chapters when not searching -->
                @forelse($chapters as $chapter)
                <div x-show="!isSearching">
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
                </div>
                @empty
                <div x-show="!isSearching" class="col-span-full text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">menu_book</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">কোন অধ্যায় পাওয়া যায়নি</h3>
                    <p class="text-slate-600 dark:text-slate-400 bengali-text">শীঘ্রই নতুন অধ্যায় যোগ করা হবে।</p>
                </div>
                @endforelse

                <!-- Loading state -->
                <template x-if="isLoading">
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-primary text-4xl animate-spin">refresh</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 bengali-text">খুঁজছি...</p>
                    </div>
                </template>

                <!-- No search results -->
                <template x-if="isSearching && searchResults.length === 0 && !isLoading">
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-slate-400 text-4xl">search_off</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">কোন অধ্যায় পাওয়া যায়নি</h3>
                        <p class="text-slate-600 dark:text-slate-400 bengali-text">অন্য কিছু খুঁজে দেখুন।</p>
                    </div>
                </template>

                <!-- Error state -->
                <template x-if="hasError">
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-red-500 text-4xl">error</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">ত্রুটি ঘটেছে</h3>
                        <p class="text-slate-600 dark:text-slate-400 bengali-text">পুনরায় চেষ্টা করুন।</p>
                    </div>
                </template>
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
function chapterSearch() {
    return {
        searchQuery: '',
        searchResults: [],
        isLoading: false,
        isSearching: false,
        hasError: false,
        
        initializeSearch() {
            // Initialize any needed setup here
        },
        
        async performSearch() {
            const query = this.searchQuery.trim();
            
            if (!query) {
                this.clearSearch();
                return;
            }
            
            this.isLoading = true;
            this.isSearching = true;
            this.hasError = false;
            this.searchResults = [];
            
            try {
                const params = new URLSearchParams({ search: query });
                const response = await fetch(`/chapters?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success && data.data.chapters) {
                    this.searchResults = data.data.chapters;
                } else {
                    this.searchResults = [];
                }
            } catch (error) {
                console.error('Search error:', error);
                this.hasError = true;
                this.searchResults = [];
            } finally {
                this.isLoading = false;
            }
        },
        
        clearSearch() {
            this.searchQuery = '';
            this.searchResults = [];
            this.isSearching = false;
            this.isLoading = false;
            this.hasError = false;
        }
    }
}
</script>
@endpush
@endsection