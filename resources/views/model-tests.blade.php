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
<a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors bengali-text" href="#">হোম</a>
<span class="text-sm text-slate-400 dark:text-slate-500">/</span>
<a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors bengali-text" href="#">অধ্যায়সমূহ</a>
<span class="text-sm text-slate-400 dark:text-slate-500">/</span>
<span class="text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">অধ্যায় ৩</span>
</div>

<!-- Page Heading -->
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-3xl">memory</span>
</div>
<div>
<h1 class="text-3xl md:text-4xl font-black text-[#0d1b18] dark:text-white leading-tight tracking-tight bengali-text">
অধ্যায় ৩: সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস
</h1>
<p class="text-base text-slate-600 dark:text-slate-400 mt-1 bengali-text">আপনার পছন্দসই মডেল টেস্ট বেছে নিন</p>
</div>
</div>
</div>
</div>
</section>

<!-- Model Test List -->
<section class="w-full py-12 md:py-16">
<div class="max-w-6xl mx-auto px-4">
<div class="flex flex-col gap-4">

<!-- Test Item 1: New Test -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-0.5">
<div class="flex items-center gap-4 flex-1 w-full">
<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary/20 transition-colors">
<span class="material-symbols-outlined text-3xl">description</span>
</div>
              <div class="flex flex-col flex-1">
                <h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">মডেল টেস্ট ১ - সংখ্যা পদ্ধতি</h3>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">quiz</span>
                    মোট প্রশ্ন: ২০টি
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">schedule</span>
                    সময়: ২৫ মিনিট
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">grade</span>
                    পূর্ণমান: ২০
                  </span>
                </div>
              </div>
            </div>
            <div class="w-full md:w-auto">
              <button onclick="startTest('সংখ্যা পদ্ধতি', 1, 20, 25)" class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-6 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                <span>শুরু করুন</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
              </button>
</div>
</div>

<!-- Test Item 2: Completed Test -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-green-500/20 bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:shadow-green-500/10 hover:border-green-500 hover:-translate-y-0.5">
<div class="flex items-center gap-4 flex-1 w-full">
<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-green-500/10 text-green-500 group-hover:bg-green-500/20 transition-colors">
<span class="material-symbols-outlined text-3xl">task_alt</span>
</div>
<div class="flex flex-col flex-1">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">মডেল টেস্ট ২ - লজিক গেট</h3>
<div class="flex items-center gap-2 mb-2">
<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500/10 text-green-600 dark:text-green-400 text-sm font-bold">
<span class="material-symbols-outlined text-base">check_circle</span>
Score: 18/20 (90%)
</span>
</div>
<div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">quiz</span>
মোট প্রশ্ন: ২০টি
</span>
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">schedule</span>
সময়: ২৫ মিনিট
</span>
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">grade</span>
পূর্ণমান: ২০
</span>
</div>
</div>
</div>
<div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <button onclick="startTest('লজিক গেট', 2, 20, 25)" class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary/10 hover:bg-primary/20 px-5 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[120px] bengali-text">
                  <span class="material-symbols-outlined text-lg">refresh</span>
                  <span>পুনরায় দিন</span>
                </button>
<button class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg border border-primary/30 hover:bg-primary/5 px-5 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[120px] bengali-text">
<span class="material-symbols-outlined text-lg">bar_chart</span>
<span>রিপোর্ট দেখুন</span>
</button>
</div>
</div>

<!-- Test Item 3: Locked Test -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-amber-500/20 bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-500 hover:-translate-y-0.5">
<div class="flex items-center gap-4 flex-1 w-full">
<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
<span class="material-symbols-outlined text-3xl">lock</span>
</div>
<div class="flex flex-col flex-1">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">মডেল টেস্ট ৩ - এনকোডার ও ডিকোডার</h3>
<div class="flex items-center gap-2 mb-2">
<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold bengali-text">
<span class="material-symbols-outlined text-base">workspace_premium</span>
প্রিমিয়াম
</span>
</div>
<div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">quiz</span>
মোট প্রশ্ন: ২০টি
</span>
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">schedule</span>
সময়: ২৫ মিনিট
</span>
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-base">grade</span>
পূর্ণমান: ২০
</span>
</div>
</div>
</div>
<div class="w-full md:w-auto">
<button class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-6 text-sm font-bold text-white hover:from-amber-600 hover:to-amber-700 transition-all shadow-md shadow-amber-500/30 bengali-text">
<span class="material-symbols-outlined text-lg">workspace_premium</span>
<span>আনলক করুন</span>
</button>
</div>
</div>

<!-- Test Item 4: New Test -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-0.5">
<div class="flex items-center gap-4 flex-1 w-full">
<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary/20 transition-colors">
<span class="material-symbols-outlined text-3xl">description</span>
</div>
              <div class="flex flex-col flex-1">
                <h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">মডেল টেস্ট ৪ - অ্যাডার</h3>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">quiz</span>
                    মোট প্রশ্ন: ২০টি
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">schedule</span>
                    সময়: ২৫ মিনিট
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">grade</span>
                    পূর্ণমান: ২০
                  </span>
                </div>
              </div>
            </div>
            <div class="w-full md:w-auto">
              <button onclick="startTest('অ্যাডার', 4, 20, 25)" class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-6 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                <span>শুরু করুন</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
              </button>
</div>
</div>

<!-- Test Item 5: New Test -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-5 transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-0.5">
<div class="flex items-center gap-4 flex-1 w-full">
<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary/20 transition-colors">
<span class="material-symbols-outlined text-3xl">description</span>
</div>
              <div class="flex flex-col flex-1">
                <h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">মডেল টেস্ট ৫ - বাইনারি অ্যারিথমেটিক</h3>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600 dark:text-slate-400 bengali-text">
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">quiz</span>
                    মোট প্রশ্ন: ২০টি
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">schedule</span>
                    সময়: ২৫ মিনিট
                  </span>
                  <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">grade</span>
                    পূর্ণমান: ২০
                  </span>
                </div>
              </div>
            </div>
            <div class="w-full md:w-auto">
              <button onclick="startTest('বাইনারি অ্যারিথমেটিক', 5, 20, 25)" class="flex h-11 w-full md:min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-6 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                <span>শুরু করুন</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
              </button>
</div>
</div>

</div>

<!-- Stats Summary -->
<div class="mt-12 p-6 rounded-xl bg-gradient-to-r from-primary/5 to-blue-500/5 dark:from-primary/10 dark:to-blue-500/10 border border-primary/20">
<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
<div class="text-center">
<p class="text-3xl font-black text-primary mb-1 bengali-text">৫</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মোট টেস্ট</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-green-500 mb-1 bengali-text">১</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সম্পন্ন</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-amber-500 mb-1">90%</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">গড় স্কোর</p>
</div>
<div class="text-center">
<p class="text-3xl font-black text-blue-500 mb-1 bengali-text">২০</p>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মিনিট গড় সময়</p>
</div>
</div>
</div>
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
        'time': timeMinutes,
        'chapter': 'অধ্যায় ৩'
      });
      
      // Navigate to exam-paper with parameters
      window.location.href = `{{ route('exam-paper') }}?${params.toString()}`;
    }
</script>
@endpush