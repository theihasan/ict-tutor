@extends('layouts.app')

@section('title', 'মডেল টেস্ট - HSC ICT Interactive')
@section('description', 'HSC ICT এর জন্য বিস্তৃত মডেল টেস্ট সংগ্রহ। বিগত বছরের বোর্ড প্রশ্ন, চ্যাপ্টার ভিত্তিক টেস্ট এবং নতুন প্রশ্নের সমন্বয়ে তৈরি মডেল টেস্টে অংশগ্রহণ করুন।')
@section('keywords', 'HSC ICT মডেল টেস্ট, বোর্ড প্রশ্ন, পরীক্ষা প্রস্তুতি, MCQ প্র্যাকটিস, বাংলাদেশ, শিক্ষা')
@section('author', 'HSC ICT Interactive Team')

@section('og:title', 'মডেল টেস্ট - HSC ICT Interactive')
@section('og:description', 'HSC ICT এর জন্য বিস্তৃত মডেল টেস্ট সংগ্রহ। বিগত বছরের বোর্ড প্রশ্ন, চ্যাপ্টার ভিত্তিক টেস্ট এবং নতুন প্রশ্নের সমন্বয়ে তৈরি মডেল টেস্টে অংশগ্রহণ করুন।')
@section('og:url', 'https://hscict.com/model-tests.html')
@section('og:image', 'https://hscict.com/images/model-tests-og-image.jpg')
@section('og:image:alt', 'HSC ICT Interactive - মডেল টেস্ট সমূহ')

@section('twitter:title', 'মডেল টেস্ট - HSC ICT Interactive')
@section('twitter:description', 'HSC ICT এর জন্য বিস্তৃত মডেল টেস্ট সংগ্রহ। বিগত বছরের বোর্ড প্রশ্ন, চ্যাপ্টার ভিত্তিক টেস্ট এবং নতুন প্রশ্নের সমন্বয়ে তৈরি মডেল টেস্টে অংশগ্রহণ করুন।')
@section('twitter:image', 'https://hscict.com/images/model-tests-og-image.jpg')
@section('twitter:image:alt', 'HSC ICT Interactive - মডেল টেস্ট সমূহ')

@section('content')
<main class="flex flex-col items-center flex-1" x-data="modelTests()" x-init="initCollapsibleStates()">
<!-- Breadcrumbs & Page Header -->
<section class="w-full py-8 md:py-12 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
<div class="max-w-6xl mx-auto px-4">
<!-- Breadcrumbs -->
<div class="mb-6 flex flex-wrap items-center gap-2">
<a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors bengali-text" href="{{ route('welcome') }}">হোম</a>
<span class="text-sm text-slate-400 dark:text-slate-500">/</span>
@if(isset($chapterId))
<a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors bengali-text" href="{{ route('chapters') }}">অধ্যায়সমূহ</a>
<span class="text-sm text-slate-400 dark:text-slate-500">/</span>
<span class="text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">মডেল টেস্ট</span>
@else
<span class="text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">মডেল টেস্ট</span>
@endif
</div>

<!-- Page Heading -->
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-3xl">quiz</span>
</div>
<div>
                <h1 class="text-3xl md:text-4xl font-black text-[#0d1b18] dark:text-white leading-tight tracking-tight bengali-text">
                @if(isset($chapterId) && isset($tests) && $tests->first() && $tests->first()->chapter)
                {{ $tests->first()->chapter->name ?? 'মডেল টেস্ট' }}
                @elseif(isset($type))
                {{ ucfirst($type) }} টেস্ট
                @elseif(isset($viewType) && $viewType === 'hierarchical')
                অধ্যায় ভিত্তিক মডেল টেস্ট
                @else
                মডেল টেস্ট সমূহ
                @endif
                </h1>
                <p class="text-base text-slate-600 dark:text-slate-400 mt-1 bengali-text">
                @if(isset($chapterId))
                এই অধ্যায়ের জন্য উপলব্ধ মডেল টেস্ট বেছে নিন
                @elseif(isset($viewType) && $viewType === 'hierarchical')
                অধ্যায় এবং টপিক অনুযায়ী সাজানো মডেল টেস্ট সমূহ
                @else
                আপনার পছন্দসই মডেল টেস্ট বেছে নিন
@endif

</div> <!-- End Original Content -->

</div>
</section>

<!-- Search and Filter Section -->
<section class="w-full py-8 bg-slate-50">
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
                        placeholder="মডেল টেস্ট খুঁজুন..." 
                        class="w-full pl-12 pr-12 py-4 border border-slate-300 rounded-2xl bg-white text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bengali-text text-base shadow-sm hover:shadow-md transition-shadow"
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
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded-full bg-slate-300 hover:bg-slate-400 flex items-center justify-center transition-colors group"
                        title="পরিষ্কার করুন"
                    >
                        <span class="material-symbols-outlined text-slate-600 group-hover:text-slate-700 text-sm">close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Model Test List -->
<section class="w-full py-12 md:py-16">
<div class="max-w-6xl mx-auto px-4">

<!-- Search Results Section -->
<div x-show="isSearching">
    <!-- Loading State -->
    <div x-show="isLoading" class="text-center py-16">
        <div class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-primary/5 text-primary">
            <div class="w-5 h-5 border-2 border-current border-t-transparent rounded-full animate-spin"></div>
            <span class="text-base font-medium bengali-text">খোঁজা হচ্ছে...</span>
        </div>
    </div>
    
    <!-- Error State -->
    <div x-show="hasError && !isLoading" class="text-center py-16">
        <div class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-red-50 text-red-600">
            <span class="material-symbols-outlined">error</span>
            <span class="text-base font-medium bengali-text">অনুসন্ধানে ত্রুটি ঘটেছে</span>
        </div>
    </div>
    
    <!-- Search Results -->
    <div x-show="!isLoading && !hasError">
        <div x-show="searchResults.length > 0">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-[#0d1b18] bengali-text flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">search</span>
                    অনুসন্ধানের ফলাফল
                    <span class="text-base font-medium text-slate-600 ml-2" x-text="`(${searchResults.length}টি টেস্ট পাওয়া গেছে)`"></span>
                </h2>
            </div>
            
            <div class="space-y-4">
                <template x-for="test in searchResults" :key="test.id">
                    <div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-primary/20 hover:border-primary hover:shadow-primary/10 bg-white p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                        
                        <div class="flex items-center gap-4 flex-1 w-full">
                            <!-- Test Icon -->
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-2xl">description</span>
                            </div>
                            
                            <!-- Test Details -->
                            <div class="flex flex-col flex-1">
                                <h4 class="text-base font-bold text-[#0d1b18] mb-1 bengali-text" x-text="test.title"></h4>
                                
                                <!-- Test Meta Info -->
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-600 bengali-text">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">quiz</span>
                                        <span x-text="test.total_questions + 'টি প্রশ্ন'"></span>
                                    </span>
                                    <span x-show="test.duration" class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        <span x-text="test.duration + ' মিনিট'"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">grade</span>
                                        <span x-text="'পূর্ণমান: ' + test.total_marks"></span>
                                    </span>
                                    <span x-show="test.chapter" class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">book</span>
                                        <span x-text="test.chapter ? test.chapter.name : ''"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="w-full md:w-auto">
                            <a :href="`/tests/${test.id}/preview`" class="flex h-10 w-full md:min-w-[120px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                                <span>শুরু করুন</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- No Results -->
        <div x-show="searchResults.length === 0" class="text-center py-16">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400 text-2xl">search_off</span>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-slate-900 mb-1 bengali-text">কোনো টেস্ট পাওয়া যায়নি</h3>
                    <p class="text-slate-600 bengali-text">অন্য কীওয়ার্ড দিয়ে অনুসন্ধান করুন</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Original Content (hidden when searching) -->
<div x-show="!isSearching">

@if(isset($viewType) && $viewType === 'chapter-specific' && isset($chapter) && isset($tests))
    <!-- Chapter-Specific View: Tests for a specific chapter -->
    <div class="flex flex-col gap-4">
        
        <!-- Chapter Info Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-2xl">menu_book</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">{{ $chapter->name }}</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">
                        {{ $tests->count() }} টি মডেল টেস্ট উপলব্ধ
                    </p>
                </div>
            </div>
            <a href="{{ route('model-tests') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary hover:bg-primary/10 rounded-lg transition-colors bengali-text">
                <span class="material-symbols-outlined text-base">apps</span>
                সব টেস্ট দেখুন
            </a>
        </div>

        @forelse($tests as $test)
            @include('partials.test-card', ['test' => $test, 'showChapter' => false])
        @empty
            <!-- No Tests Found -->
            <div class="text-center py-12">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">quiz</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-2 bengali-text">এই অধ্যায়ে কোন টেস্ট নেই</h3>
                <p class="text-slate-500 dark:text-slate-500 bengali-text">এই অধ্যায়ের জন্য এখনো কোন মডেল টেস্ট যোগ করা হয়নি।</p>
                <a href="{{ route('model-tests') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary text-[#0d1b18] rounded-lg font-bold hover:bg-opacity-90 transition-all bengali-text">
                    <span class="material-symbols-outlined">apps</span>
                    সব টেস্ট দেখুন
                </a>
            </div>
        @endforelse
    </div>

@elseif(isset($viewType) && $viewType === 'hierarchical' && isset($chaptersWithTests) && $chaptersWithTests->count() > 0)
    <!-- Hierarchical View: Chapter -> Topic -> Tests -->
    <div class="flex flex-col gap-8">
        
        <!-- View Toggle -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">view_list</span>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">অধ্যায় অনুযায়ী সাজানো</span>
            </div>
            <a href="{{ route('model-tests', ['view' => 'flat']) }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-primary hover:bg-primary/10 rounded-lg transition-colors bengali-text">
                <span class="material-symbols-outlined text-base">swap_vert</span>
                তালিকা ভিউ
            </a>
        </div>

        @forelse($chaptersWithTests as $chapter)
            <!-- Chapter Card -->
            <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                
                <!-- Chapter Header -->
                <div class="bg-gradient-to-r from-primary/5 to-blue-500/5 dark:from-primary/10 dark:to-blue-500/10 p-6 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-2xl">menu_book</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-[#0d1b18] dark:text-white bengali-text">{{ $chapter->name }}</h2>
                                <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">
                                    {{ $chapter->topics->count() }} টি টপিক • {{ $chapter->tests->count() }} টি টেস্ট
                                </p>
                            </div>
                        </div>
                        <button 
                            @click="toggleChapter('chapter-{{ $chapter->id }}')" 
                            class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            aria-label="Toggle chapter"
                        >
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-400 chapter-toggle-icon"
                                  x-text="chapterStates['chapter-{{ $chapter->id }}'] ? 'expand_less' : 'expand_more'">expand_more</span>
                        </button>
                    </div>
                </div>

                <!-- Chapter Content (Collapsible) -->
                <div x-show="chapterStates['chapter-{{ $chapter->id }}']" class="chapter-content"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2">
                    
                    @if($chapter->topics->count() > 0)
                        <!-- Topics with Tests -->
                        <div class="p-6 space-y-6">
                            @foreach($chapter->topics as $topic)
                                @php
                                    $topicTests = $chapter->tests->where('topic_id', $topic->id);
                                @endphp
                                
                                @if($topicTests->count() > 0)
                                    <!-- Topic Section -->
                                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                                        
                                        <!-- Topic Header -->
                                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 border-b border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-blue-500 text-lg">topic</span>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-[#0d1b18] dark:text-white bengali-text">{{ $topic->name }}</h3>
                                                        <p class="text-xs text-slate-500 dark:text-slate-400 bengali-text">{{ $topicTests->count() }} টি টেস্ট</p>
                                                    </div>
                                                </div>
                                                <button 
                                                    @click="toggleTopic('topic-{{ $chapter->id }}-{{ $topic->id }}')" 
                                                    class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                                                    aria-label="Toggle topic"
                                                >
                                                    <span class="material-symbols-outlined text-slate-500 topic-toggle-icon text-sm"
                                                          x-text="topicStates['topic-{{ $chapter->id }}-{{ $topic->id }}'] ? 'expand_less' : 'expand_more'">expand_more</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Topic Tests (Collapsible) -->
                                        <div x-show="topicStates['topic-{{ $chapter->id }}-{{ $topic->id }}']" class="topic-content bg-white dark:bg-slate-900/50"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                                             x-transition:enter-end="opacity-100 transform translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 transform translate-y-0"
                                             x-transition:leave-end="opacity-0 transform -translate-y-2">
                                            <div class="p-4 space-y-3">
                                                @foreach($topicTests as $test)
                                                    @include('partials.test-card', ['test' => $test, 'showChapter' => false])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if($chapter->tests->where('topic_id', null)->count() > 0)
                        <!-- Chapter-level Tests (no specific topic) -->
                        <div class="p-6 border-t border-slate-200 dark:border-slate-700">
                            <h3 class="font-semibold text-[#0d1b18] dark:text-white mb-4 bengali-text flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-600 dark:text-slate-400">quiz</span>
                                চ্যাপ্টার টেস্ট
                            </h3>
                            <div class="space-y-3">
                                @foreach($chapter->tests->where('topic_id', null) as $test)
                                    @include('partials.test-card', ['test' => $test, 'showChapter' => false])
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <!-- No Chapters Found -->
            <div class="text-center py-16">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">menu_book</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-2 bengali-text">কোন অধ্যায় পাওয়া যায়নি</h3>
                <p class="text-slate-500 dark:text-slate-500 bengali-text">এখনও কোন অধ্যায়ে টেস্ট যোগ করা হয়নি।</p>
            </div>
        @endforelse
    </div>

@else
    <!-- Flat View: All Tests -->
    <div class="flex flex-col gap-4">
        
        <!-- View Toggle -->
        @if(!isset($chapterId) && !isset($type))
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">list</span>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">তালিকা ভিউ</span>
            </div>
            <a href="{{ route('model-tests', ['view' => 'hierarchical']) }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-primary hover:bg-primary/10 rounded-lg transition-colors bengali-text">
                <span class="material-symbols-outlined text-base">account_tree</span>
                অধ্যায় ভিউ
            </a>
        </div>
        @endif

        @forelse($tests ?? [] as $test)
            @include('partials.test-card', ['test' => $test, 'showChapter' => true])
        @empty
            <!-- No Tests Found -->
            <div class="text-center py-12">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">quiz</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-2 bengali-text">কোন টেস্ট পাওয়া যায়নি</h3>
                <p class="text-slate-500 dark:text-slate-500 bengali-text">এই বিভাগে এখনো কোন টেস্ট যোগ করা হয়নি।</p>
                <a href="{{ route('model-tests') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary text-[#0d1b18] rounded-lg font-bold hover:bg-opacity-90 transition-all bengali-text">
                    <span class="material-symbols-outlined">arrow_back</span>
                    সব টেস্ট দেখুন
                </a>
            </div>
        @endforelse
    </div>
@endif

</div>

<!-- Stats Summary -->
@if($statistics && ((isset($tests) && count($tests) > 0) || (isset($chaptersWithTests) && $chaptersWithTests->count() > 0)))
<div class="mt-12 p-6 rounded-xl bg-gradient-to-r from-primary/5 to-blue-500/5 dark:from-primary/10 dark:to-blue-500/10 border border-primary/20">
<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
<div class="text-center">
<p class="text-3xl font-black text-primary mb-1 bengali-text">{{ $statistics['total_tests'] }}</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মোট টেস্ট</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-green-500 mb-1 bengali-text">{{ $statistics['user_stats']['completed_tests'] ?? 0 }}</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সম্পন্ন</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-amber-500 mb-1">{{ number_format($statistics['user_stats']['average_score'] ?? 0, 0) }}%</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">গড় স্কোর</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-blue-500 mb-1 bengali-text">{{ $statistics['user_stats']['total_attempts'] ?? 0 }}</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মোট প্রচেষ্টা</p>
</div>
</div>
</div>
@endif
</div>
</section>
</main>
@endsection

@push('scripts')
<script>
function modelTests() {
    return {
        chapterStates: {},
        topicStates: {},
        searchQuery: '',
        searchResults: [],
        isLoading: false,
        isSearching: false,
        hasError: false,
        
        initCollapsibleStates() {
            // Initialize all chapter states from localStorage or default to open
            @if(isset($chaptersWithTests) && $chaptersWithTests->count() > 0)
                @foreach($chaptersWithTests as $chapter)
                    const chapterKey{{ $chapter->id }} = 'chapter-{{ $chapter->id }}';
                    const chapterState{{ $chapter->id }} = localStorage.getItem(`chapter-${chapterKey{{ $chapter->id }}}`);
                    this.chapterStates[chapterKey{{ $chapter->id }}] = chapterState{{ $chapter->id }} !== 'closed';
                    
                    @if($chapter->topics->count() > 0)
                        @foreach($chapter->topics as $topic)
                            @php
                                $topicTests = $chapter->tests->where('topic_id', $topic->id);
                            @endphp
                            @if($topicTests->count() > 0)
                                let topicKey{{ $chapter->id }}_{{ $topic->id }} = 'topic-{{ $chapter->id }}-{{ $topic->id }}';
                                let topicState{{ $chapter->id }}_{{ $topic->id }} = localStorage.getItem(`topic-${topicKey{{ $chapter->id }}_{{ $topic->id }}}`);
                                this.topicStates[topicKey{{ $chapter->id }}_{{ $topic->id }}] = topicState{{ $chapter->id }}_{{ $topic->id }} !== 'closed';
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        },
        
        toggleChapter(chapterId) {
            this.chapterStates[chapterId] = !this.chapterStates[chapterId];
            
            // Store state in localStorage
            localStorage.setItem(`chapter-${chapterId}`, this.chapterStates[chapterId] ? 'open' : 'closed');
        },
        
        toggleTopic(topicId) {
            this.topicStates[topicId] = !this.topicStates[topicId];
            
            // Store state in localStorage
            localStorage.setItem(`topic-${topicId}`, this.topicStates[topicId] ? 'open' : 'closed');
        },
        
        startTest(testName, testId, totalQuestions, timeMinutes) {
            // Create URL parameters for the test
            const params = new URLSearchParams({
                'test': testName,
                'id': testId,
                'questions': totalQuestions,
                'time': timeMinutes
            });
            
            // Navigate to exam-paper with parameters
            window.location.href = `{{ route('exam-paper') }}?${params.toString()}`;
        },
        
        viewReport(testId) {
            // Navigate to test report page
            window.location.href = `{{ url('/model-tests') }}/${testId}/report`;
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
                const response = await fetch(`/model-tests?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success && data.data.tests) {
                    this.searchResults = data.data.tests;
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