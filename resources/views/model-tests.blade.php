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
<main class="flex flex-col items-center flex-1">
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
@if(isset($chapterId) && $tests->first() && $tests->first()->chapter)
{{ $tests->first()->chapter->name ?? 'মডেল টেস্ট' }}
@elseif(isset($type))
{{ ucfirst($type) }} টেস্ট
@else
মডেল টেস্ট সমূহ
@endif
</h1>
<p class="text-base text-slate-600 dark:text-slate-400 mt-1 bengali-text">
@if(isset($chapterId))
এই অধ্যায়ের জন্য উপলব্ধ মডেল টেস্ট বেছে নিন
@else
আপনার পছন্দসই মডেল টেস্ট বেছে নিন
@endif
</p>
</div>
</div>
</div>
</div>
</section>

<!-- Model Test List -->
<section class="w-full py-12 md:py-16">
<div class="max-w-6xl mx-auto px-4">
<div class="flex flex-col gap-4">

@forelse($tests as $test)
<!-- Test Item: {{ $test->title }} -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border 
    @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
        border-green-500/20 hover:border-green-500 hover:shadow-green-500/10
    @elseif(!$test->is_public)
        border-amber-500/20 hover:border-amber-500 hover:shadow-amber-500/10
    @else
        border-primary/20 hover:border-primary hover:shadow-primary/10
    @endif
    bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
    
    <div class="flex items-center gap-4 flex-1 w-full">
        <!-- Test Icon -->
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl 
            @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
                bg-green-500/10 text-green-500 group-hover:bg-green-500/20
            @elseif(!$test->is_public)
                bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400
            @else
                bg-primary/10 text-primary group-hover:bg-primary/20
            @endif
            transition-colors">
            @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
                <span class="material-symbols-outlined text-3xl">task_alt</span>
            @elseif(!$test->is_public)
                <span class="material-symbols-outlined text-3xl">lock</span>
            @else
                <span class="material-symbols-outlined text-3xl">description</span>
            @endif
        </div>
        
        <!-- Test Details -->
        <div class="flex flex-col flex-1">
            <h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">{{ $test->title }}</h3>
            
            <!-- Status Badge -->
            @if($test->user_progress && $test->user_progress->is_attempted)
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full 
                        @if($test->user_progress->completion_status === 'passed')
                            bg-green-500/10 text-green-600 dark:text-green-400
                        @else
                            bg-red-500/10 text-red-600 dark:text-red-400
                        @endif
                        text-sm font-bold">
                        <span class="material-symbols-outlined text-base">
                            @if($test->user_progress->completion_status === 'passed')
                                check_circle
                            @else
                                cancel
                            @endif
                        </span>
                        Score: {{ $test->user_progress->best_score }}/{{ $test->total_marks }} ({{ number_format($test->user_progress->best_percentage, 0) }}%)
                    </span>
                </div>
            @elseif(!$test->is_public)
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold bengali-text">
                        <span class="material-symbols-outlined text-base">workspace_premium</span>
                        প্রিমিয়াম
                    </span>
                </div>
            @endif
            
            <!-- Test Meta Info -->
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">quiz</span>
                    মোট প্রশ্ন: {{ $test->total_questions }}টি
                </span>
                @if($test->duration)
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">schedule</span>
                    সময়: {{ $test->duration }} মিনিট
                </span>
                @endif
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">grade</span>
                    পূর্ণমান: {{ $test->total_marks }}
                </span>
                @if($test->chapter)
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">book</span>
                    {{ $test->chapter->name }}
                </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="w-full md:w-auto">
        @if(!$test->is_public)
            <!-- Premium Test -->
            <button class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-6 text-sm font-bold text-white hover:from-amber-600 hover:to-amber-700 transition-all shadow-md shadow-amber-500/30 bengali-text">
                <span class="material-symbols-outlined text-lg">workspace_premium</span>
                <span>আনলক করুন</span>
            </button>
        @elseif($test->user_progress && $test->user_progress->is_attempted)
            <!-- Completed Test -->
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <button onclick="startTest('{{ $test->title }}', {{ $test->id }}, {{ $test->total_questions }}, {{ $test->duration ?? 25 }})" class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary/10 hover:bg-primary/20 px-5 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[120px] bengali-text">
                    <span class="material-symbols-outlined text-lg">refresh</span>
                    <span>পুনরায় দিন</span>
                </button>
                <button onclick="viewReport({{ $test->id }})" class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg border border-primary/30 hover:bg-primary/5 px-5 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[120px] bengali-text">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    <span>রিপোর্ট দেখুন</span>
                </button>
            </div>
        @else
            <!-- New Test -->
            <button onclick="startTest('{{ $test->title }}', {{ $test->id }}, {{ $test->total_questions }}, {{ $test->duration ?? 25 }})" class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-6 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                <span>শুরু করুন</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </button>
        @endif
    </div>
</div>
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

<!-- Stats Summary -->
@if($statistics && count($tests) > 0)
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
    // Start Test Navigation Function
    function startTest(testName, testId, totalQuestions, timeMinutes) {
      // Create URL parameters to pass test data to exam-paper
      const params = new URLSearchParams({
        'test': testName,
        'id': testId,
        'questions': totalQuestions,
        'time': timeMinutes
      });
      
      // Navigate to exam-paper with parameters
      window.location.href = `{{ route('exam-paper') }}?${params.toString()}`;
    }

    // View Test Report Function
    function viewReport(testId) {
      // Navigate to test report page
      window.location.href = `{{ url('/model-tests') }}/${testId}/report`;
    }
</script>
@endpush