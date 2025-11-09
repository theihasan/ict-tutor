@extends('layouts.app')

@section('title', 'Student Dashboard - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT শিক্ষার অগ্রগতি ট্র্যাক করুন। দুর্বল টপিক চিহ্নিত করুন এবং লক্ষ্য অর্জনের দিকে এগিয়ে যান।')
@section('keywords', 'HSC ICT Dashboard, Student Progress, Study Analytics, ICT Learning')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

<!-- Welcome Section -->
<div class="flex flex-col gap-8">
<div class="flex flex-wrap justify-between gap-4">
<div class="flex flex-col gap-1">
<p class="text-4xl font-black text-[#0d1b18] dark:text-white bengali-text">স্বাগতম, {{ $user->name }}!</p>
<p class="text-base font-normal text-slate-600 dark:text-slate-400 bengali-text">আপনার A+ লক্ষ্যের দিকে এগিয়ে যান!</p>
</div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
<div class="flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6">
<div class="flex items-center justify-between">
<p class="text-base font-medium text-slate-700 dark:text-slate-300 bengali-text">সামগ্রিক অগ্রগতি</p>
<span class="material-symbols-outlined text-slate-500">pie_chart</span>
</div>
<div class="relative flex size-32 items-center justify-center self-center">
<svg class="size-full -rotate-90 transform" viewbox="0 0 100 100">
<circle class="stroke-slate-200 dark:stroke-slate-700" cx="50" cy="50" fill="none" r="45" stroke-width="10"></circle>
@php
$progressPercentage = $userStats['average_score'] ?? 0;
$strokeDashoffset = 282.74 - (282.74 * ($progressPercentage / 100));
@endphp
<circle class="text-primary" cx="50" cy="50" fill="none" r="45" stroke-dasharray="282.74" stroke-dashoffset="{{ $strokeDashoffset }}" stroke-linecap="round" stroke-width="10"></circle>
</svg>
<span class="absolute text-2xl font-bold text-[#0d1b18] dark:text-white">{{ round($progressPercentage) }}%</span>
</div>
<p class="text-center text-sm text-slate-600 dark:text-slate-400 bengali-text">সম্পন্ন</p>
</div>

<div class="flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6">
<div class="flex items-center justify-between">
<p class="text-base font-medium text-slate-700 dark:text-slate-300 bengali-text">বর্তমান স্ট্রিক</p>
<span class="material-symbols-outlined text-orange-500">local_fire_department</span>
</div>
<p class="text-3xl font-bold text-[#0d1b18] dark:text-white bengali-text">{{ $userStats['current_streak'] ?? 0 }} দিনের স্ট্রিক!</p>
</div>

<div class="flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6">
<div class="flex items-center justify-between">
<p class="text-base font-medium text-slate-700 dark:text-slate-300 bengali-text">মোট প্রশ্ন সমাধান</p>
<span class="material-symbols-outlined text-green-500">task_alt</span>
</div>
<p class="text-3xl font-bold text-[#0d1b18] dark:text-white bengali-text">{{ number_format($userStats['total_questions_answered'] ?? 0) }}+ প্রশ্ন</p>
</div>

<div class="flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6">
<div class="flex items-center justify-between">
<p class="text-base font-medium text-slate-700 dark:text-slate-300 bengali-text">লিডারবোর্ড র‍্যাঙ্ক</p>
<span class="material-symbols-outlined text-yellow-500">military_tech</span>
</div>
<p class="text-3xl font-bold text-[#0d1b18] dark:text-white bengali-text">#{{ $leaderboardPosition->position ?? 'N/A' }}</p>
</div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
<!-- Weak Topics -->
<div class="flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 lg:col-span-2">
<h2 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">আপনার দুর্বল টপিক</h2>
<div class="flex flex-col divide-y divide-slate-200 dark:divide-slate-800">
@forelse($progressData->where('is_weak_area', true)->take(3) as $progress)
<div class="grid grid-cols-1 gap-2 py-4 md:grid-cols-[1fr_2fr]">
<p class="font-medium text-primary/80 dark:text-primary/90 bengali-text">{{ $progress->topic->name ?? 'Unknown Topic' }}</p>
<p class="text-sm text-slate-600 dark:text-slate-400">
@if($progress->accuracy_rate < 50)
Your average accuracy in this topic is {{ round($progress->accuracy_rate) }}% - needs improvement.
@elseif($progress->total_attempts < 5)
You have attempted only {{ $progress->total_attempts }} questions in this topic.
@else
You haven't practiced this topic recently.
@endif
</p>
</div>
@empty
<div class="py-4">
<p class="text-sm text-slate-600 dark:text-slate-400">Great job! No weak topics identified yet. Keep practicing to maintain your performance.</p>
</div>
@endforelse
</div>
<div class="pt-2">
<button class="h-11 w-full items-center justify-center rounded-lg bg-primary px-6 text-sm font-bold text-[#0d1b18] hover:bg-primary/90 sm:w-auto bengali-text">প্র্যাকটিস শুরু করুন</button>
</div>
</div>

<!-- Continue Where You Left Off -->
<div class="flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6">
<h2 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">যেখান থেকে শেষ করেছিলেন</h2>
<div class="flex flex-col gap-4">
@forelse($recentAttempts->take(2) as $attempt)
<div class="rounded-lg bg-slate-100/60 dark:bg-slate-800/50 p-4">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">{{ $attempt->test->title ?? 'Test' }}</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">
@if($attempt->completed_at)
স্কোর: {{ $attempt->score ?? 0 }}/{{ $attempt->total_questions ?? 0 }}
@else
চলমান - {{ $attempt->created_at->diffForHumans() }} শুরু
@endif
</p>
@if($attempt->completed_at)
<a href="{{ route('tests.results', $attempt->id) }}" class="mt-3 inline-flex h-9 items-center justify-center rounded-md bg-blue-500/20 px-4 text-sm font-medium text-blue-700 hover:bg-blue-500/30 dark:bg-blue-300/20 dark:text-blue-300 dark:hover:bg-blue-300/30 bengali-text">রিপোর্ট দেখুন</a>
@else
<a href="{{ route('tests.exam-paper', $attempt->test_id) }}" class="mt-3 inline-flex h-9 items-center justify-center rounded-md bg-blue-500 px-4 text-sm font-medium text-white hover:bg-blue-600 bengali-text">চালিয়ে যান</a>
@endif
</div>
@empty
<div class="rounded-lg bg-slate-100/60 dark:bg-slate-800/50 p-4">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">কোনো সাম্প্রতিক কার্যক্রম নেই</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">একটি নতুন টেস্ট শুরু করুন</p>
<a href="{{ route('model-tests') }}" class="mt-3 inline-flex h-9 items-center justify-center rounded-md bg-blue-500 px-4 text-sm font-medium text-white hover:bg-blue-600 bengali-text">টেস্ট শুরু করুন</a>
</div>
@endforelse
</div>
</div>
</div>

<!-- All Chapters -->
<div class="flex flex-col gap-4">
<h2 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">সকল অধ্যায়</h2>
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ১: তথ্য ও যোগাযোগ প্রযুক্তি</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 100%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ২: কমিউনিকেশন সিস্টেম</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 90%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ৩: সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 60%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ৪: ওয়েব ডিজাইন পরিচিতি</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 75%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ৫: প্রোগ্রামিং ভাষা</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 50%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
<a class="group flex flex-col gap-2 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1" href="#">
<p class="font-semibold text-slate-800 dark:text-slate-200 bengali-text">অধ্যায় ৬: ডেটাবেজ ম্যানেজমেন্ট সিস্টেম</p>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700">
<div class="h-2 rounded-full bg-primary" style="width: 80%"></div>
</div>
<span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity self-end">arrow_forward</span>
</a>
</div>
</div>
</div>
</div>
@endsection