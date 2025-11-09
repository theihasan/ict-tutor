@extends('layouts.app')

@section('title', 'টেস্টের ফলাফল - {{ $results["attempt"]->test->title }} - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT টেস্টের বিস্তারিত ফলাফল দেখুন এবং উন্নতির জায়গা চিহ্নিত করুন।')

@section('content')
<main class="flex-grow">
<div class="max-w-4xl mx-auto px-4 py-6">

<!-- Results Header -->
<div class="text-center mb-8">
<div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4
@if($results['summary']['passed']) bg-green-500/10 text-green-600 @else bg-red-500/10 text-red-600 @endif">
<span class="material-symbols-outlined text-3xl">
@if($results['summary']['passed']) check_circle @else cancel @endif
</span>
</div>
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text mb-2">
@if($results['summary']['passed']) অভিনন্দন! আপনি পাস করেছেন @else দুঃখিত! আপনি পাস করতে পারেননি @endif
</h1>
<p class="text-lg text-slate-600 dark:text-slate-400 bengali-text">{{ $results['attempt']->test->title }}</p>
</div>

<!-- Score Summary -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
<div class="text-2xl font-bold text-[#0d1b18] dark:text-white">{{ $results['summary']['score'] }}</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মোট স্কোর</div>
</div>
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
<div class="text-2xl font-bold 
@if($results['summary']['percentage'] >= 80) text-green-600
@elseif($results['summary']['percentage'] >= 60) text-yellow-600
@else text-red-600 @endif">
{{ number_format($results['summary']['percentage'], 1) }}%
</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">শতকরা নম্বর</div>
</div>
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
<div class="text-2xl font-bold text-green-600">{{ $results['summary']['correct_answers'] }}</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সঠিক উত্তর</div>
</div>
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
<div class="text-2xl font-bold text-slate-600 dark:text-slate-400">
{{ floor($results['summary']['time_taken'] / 60) }}:{{ str_pad($results['summary']['time_taken'] % 60, 2, '0', STR_PAD_LEFT) }}
</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সময় লেগেছে</div>
</div>
</div>

<!-- Performance Breakdown -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 mb-8">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text mb-4">পারফরম্যান্স বিশ্লেষণ</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="text-center">
<div class="text-3xl font-bold text-green-600 mb-2">{{ $results['summary']['correct_answers'] }}</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সঠিক</div>
<div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 mt-2">
<div class="bg-green-500 h-2 rounded-full" style="width: {{ ($results['summary']['correct_answers'] / $results['summary']['total_questions']) * 100 }}%"></div>
</div>
</div>
<div class="text-center">
<div class="text-3xl font-bold text-red-600 mb-2">{{ $results['summary']['wrong_answers'] }}</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">ভুল</div>
<div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 mt-2">
<div class="bg-red-500 h-2 rounded-full" style="width: {{ ($results['summary']['wrong_answers'] / $results['summary']['total_questions']) * 100 }}%"></div>
</div>
</div>
<div class="text-center">
<div class="text-3xl font-bold text-slate-500 mb-2">{{ $results['summary']['unanswered'] }}</div>
<div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">অনুত্তরিত</div>
<div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 mt-2">
<div class="bg-slate-500 h-2 rounded-full" style="width: {{ ($results['summary']['unanswered'] / $results['summary']['total_questions']) * 100 }}%"></div>
</div>
</div>
</div>
</div>

<!-- Question Review -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 mb-8">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text mb-4">প্রশ্ন পর্যালোচনা</h3>
<div class="space-y-4">
@foreach($results['questions'] as $index => $questionResult)
<div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4
@if($questionResult['is_correct']) border-green-200 dark:border-green-700/30 bg-green-50/50 dark:bg-green-900/10
@else border-red-200 dark:border-red-700/30 bg-red-50/50 dark:bg-red-900/10 @endif">
<div class="flex items-start justify-between mb-3">
<h4 class="font-semibold text-[#0d1b18] dark:text-white bengali-text">প্রশ্ন {{ $index + 1 }}</h4>
<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold
@if($questionResult['is_correct']) bg-green-500/10 text-green-600
@else bg-red-500/10 text-red-600 @endif">
<span class="material-symbols-outlined text-sm">
@if($questionResult['is_correct']) check_circle @else cancel @endif
</span>
@if($questionResult['is_correct']) সঠিক @else ভুল @endif
</span>
</div>
<p class="text-sm text-[#0d1b18] dark:text-white mb-3 bengali-text">{{ $questionResult['question']->question }}</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
<div>
<span class="font-medium text-slate-600 dark:text-slate-400 bengali-text">আপনার উত্তর:</span>
<span class="ml-2 
@if($questionResult['is_correct']) text-green-600 @else text-red-600 @endif">
{{ $questionResult['user_answer'] ?: 'অনুত্তরিত' }}
</span>
</div>
<div>
<span class="font-medium text-slate-600 dark:text-slate-400 bengali-text">সঠিক উত্তর:</span>
<span class="ml-2 text-green-600">{{ $questionResult['correct_answer'] }}</span>
</div>
</div>
@if($questionResult['explanation'])
<div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
<span class="font-medium text-slate-600 dark:text-slate-400 bengali-text">ব্যাখ্যা:</span>
<p class="mt-1 text-sm text-slate-700 dark:text-slate-300 bengali-text">{{ $questionResult['explanation'] }}</p>
</div>
@endif
</div>
@endforeach
</div>
</div>

<!-- Action Buttons -->
<div class="text-center">
<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
<a href="{{ route('tests.preview', $results['attempt']->test->id) }}" class="flex h-12 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary hover:bg-primary/90 px-8 text-lg font-bold text-[#0d1b18] transition-all shadow-md bengali-text">
<span class="material-symbols-outlined text-xl">refresh</span>
<span>আবার চেষ্টা করুন</span>
</a>
<a href="{{ route('model-tests') }}" class="flex h-12 cursor-pointer items-center justify-center gap-2 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 px-8 text-lg font-bold text-[#0d1b18] dark:text-white transition-all bengali-text">
<span class="material-symbols-outlined text-xl">home</span>
<span>মূল পাতায় যান</span>
</a>
</div>
</div>

</div>
</main>
@endsection