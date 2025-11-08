@extends('layouts.app')

@section('title', 'মডেল টেস্ট - HSC ICT Interactive')
@section('description', 'HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন। বিগত বছরের বোর্ড প্রশ্ন এবং নতুন প্রশ্নের সমন্বয়ে তৈরি আমাদের মডেল টেস্টে অংশগ্রহণ করুন।')
@section('keywords', 'HSC ICT মডেল টেস্ট, পরীক্ষা প্রস্তুতি, বোর্ড প্রশ্ন, MCQ, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="মডেল টেস্ট - HSC ICT Interactive"/>
<meta property="og:description" content="HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন। বিগত বছরের বোর্ড প্রশ্ন এবং নতুন প্রশ্নের সমন্বয়ে তৈরি আমাদের মডেল টেস্টে অংশগ্রহণ করুন।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/exam-paper.html"/>
<meta property="og:image" content="https://hscict.com/images/exam-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - মডেল টেস্ট পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="মডেল টেস্ট - HSC ICT Interactive"/>
<meta name="twitter:description" content="HSC ICT মডেল টেস্ট দিন এবং পরীক্ষার জন্য প্রস্তুতি নিন। বিগত বছরের বোর্ড প্রশ্ন এবং নতুন প্রশ্নের সমন্বয়ে তৈরি আমাদের মডেল টেস্টে অংশগ্রহণ করুন।"/>
<meta name="twitter:image" content="https://hscict.com/images/exam-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - মডেল টেস্ট পেজ"/>

@section('header-extra')
<!-- Custom exam header with exit button -->
<div class="flex items-center gap-2">
    <button onclick="exitExam()" class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 transition-colors gap-2 bengali-text">
        <span class="material-symbols-outlined text-xl">logout</span>
        <span class="hidden md:inline text-sm font-bold">পরীক্ষা ত্যাগ করুন</span>
    </button>
</div>
@endsection

@section('content')

<!-- Exam Info & Timer Bar -->
<div class="sticky top-[61px] z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm border-b border-primary/20">
<div class="max-w-6xl mx-auto px-4 py-3">
<div class="flex flex-col md:flex-row items-center justify-between gap-4">
<div class="flex-1 text-center md:text-left">
<p class="text-sm font-semibold text-[#0d1b18] dark:text-white bengali-text">অধ্যায় ৩: সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">মডেল টেস্ট ১</p>
</div>
<div class="flex items-center gap-3 px-4 py-2 rounded-lg bg-primary/10">
<span class="material-symbols-outlined text-xl text-primary">timer</span>
<div class="text-center">
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">সময় বাকি</p>
<p class="font-bold text-[#0d1b18] dark:text-white text-lg">23:45</p>
</div>
</div>
<div class="flex items-center gap-3">
<div class="text-center px-3">
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">মোট প্রশ্ন</p>
<p class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">২০</p>
</div>
              <button onclick="submitExam()" class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-green-500 px-6 text-sm font-bold text-white shadow-md hover:bg-green-600 transition-colors bengali-text">
                <span>জমা দিন</span>
                <span class="material-symbols-outlined text-lg">check_circle</span>
              </button>
</div>
</div>
</div>
</div>

<!-- MAIN CONTENT -->
<main class="flex-grow">
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="grid grid-cols-12 gap-6">
<!-- Left Sidebar - Question Navigation -->
<aside class="col-span-12 lg:col-span-2">
<div class="sticky top-40">
<div class="mb-4 flex items-center justify-between">
<h3 class="text-sm font-bold uppercase text-slate-500 dark:text-slate-400 bengali-text">প্রশ্নসমূহ</h3>
</div>
<div class="grid grid-cols-5 lg:grid-cols-3 gap-2">
<!-- Active Question -->
<a href="#q1" class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white font-bold shadow-md transition-all hover:scale-105">1</a>
<!-- Answered Question -->
<a href="#q2" class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-500/20 text-green-600 dark:text-green-400 font-bold border border-green-500/30 transition-all hover:scale-105">2</a>
<!-- Unanswered Questions -->
<a href="#q3" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">3</a>
<a href="#q4" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">4</a>
<a href="#q5" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">5</a>
<a href="#q6" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">6</a>
<a href="#q7" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">...</a>
<a href="#q20" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-slate-800 font-medium border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-primary/5 transition-all">20</a>
</div>
<!-- Legend -->
<div class="mt-6 space-y-2 text-xs">
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-primary"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">বর্তমান</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-green-500/20 border border-green-500/30"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">উত্তরিত</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700"></div>
<span class="text-slate-600 dark:text-slate-400 bengali-text">অনুত্তরিত</span>
</div>
</div>
</div>
</aside>

<!-- Right Column - Questions List -->
<div class="col-span-12 lg:col-span-10">
<div class="space-y-6">

<!-- Question Block 1 - Programming with AI Hint -->
<div class="rounded-xl border border-primary/30 bg-white dark:bg-slate-900/50 p-6 shadow-md" id="q1">
<div class="flex items-start justify-between gap-4 mb-4">
<div class="flex-1">
<p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
<strong class="font-bold">প্রশ্ন ১:</strong> (ক) ৪২<sub>(১০)</sub> সংখ্যাটিকে বাইনারি সংখ্যায় রূপান্তর করো।
</p>
<div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-base">grade</span>
<span class="bengali-text">মান: ৫</span>
</div>
</div>
<button class="flex shrink-0 h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 px-4 text-sm font-bold text-white transition-all shadow-md bengali-text">
<span class="material-symbols-outlined text-lg">code</span>
<span>এডিটর খুলুন</span>
</button>
</div>

<!-- AI Hint Toggle -->
<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
<button onclick="toggleHint('hint1')" class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text">
<span class="material-symbols-outlined text-lg">psychology</span>
<span>AI সাহায্য চাই</span>
</button>
<!-- AI Hint Panel -->
<div id="hint1" class="ai-hint-panel mt-3">
<div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
<div class="flex items-start gap-3">
<div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">smart_toy</span>
</div>
<div class="flex-1">
<p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
<div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 bengali-text">
<p><strong>ধাপ ১:</strong> দশমিক সংখ্যাকে ২ দিয়ে ভাগ করতে থাকুন।</p>
<p><strong>ধাপ ২:</strong> প্রতিবার ভাগশেষ (Remainder) লিখুন।</p>
<p><strong>ধাপ ৩:</strong> শেষ থেকে শুরু পর্যন্ত ভাগশেষগুলো উল্টো করে লিখুন।</p>
<p class="pt-2 text-xs text-slate-600 dark:text-slate-400">
<strong>উদাহরণ:</strong> ৪২ ÷ ২ = ২১ (ভাগশেষ ০) → ২১ ÷ ২ = ১০ (ভাগশেষ ১) → ...
</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Question Block 2 - Logic Gate with AI Hint -->
<div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50 p-6" id="q2">
<div class="flex items-start justify-between gap-4 mb-4">
<div class="flex-1">
<p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
<strong class="font-bold">প্রশ্ন ২:</strong> (খ) XOR গেইট ব্যবহার করে একটি সার্কিট ডিজাইন করো।
</p>
<div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-base">grade</span>
<span class="bengali-text">মান: ৫</span>
</div>
</div>
<button class="flex shrink-0 h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 px-4 text-sm font-bold text-white transition-all shadow-md bengali-text">
<span class="material-symbols-outlined text-lg">draw</span>
<span>সার্কিট এডিটর</span>
</button>
</div>

<!-- AI Hint Toggle -->
<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
<button onclick="toggleHint('hint2')" class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text">
<span class="material-symbols-outlined text-lg">psychology</span>
<span>AI সাহায্য চাই</span>
</button>
<!-- AI Hint Panel -->
<div id="hint2" class="ai-hint-panel mt-3">
<div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
<div class="flex items-start gap-3">
<div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">smart_toy</span>
</div>
<div class="flex-1">
<p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
<div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 bengali-text">
<p><strong>মনে রাখুন:</strong> XOR গেইট যখন দুটি ইনপুট ভিন্ন হয় তখন আউটপুট ১ দেয়।</p>
<p><strong>ট্রুথ টেবিল:</strong></p>
<ul class="list-disc list-inside ml-2 space-y-1">
<li>০ XOR ০ = ০</li>
<li>০ XOR ১ = ১</li>
<li>১ XOR ০ = ১</li>
<li>১ XOR ১ = ০</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Question Block 3 - HTML with AI Hint -->
<div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50 p-6" id="q3">
<div class="flex items-start justify-between gap-4 mb-4">
<div class="flex-1">
<p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
<strong class="font-bold">প্রশ্ন ৩:</strong> (গ) HTML ব্যবহার করে একটি ৩×৩ সারণী তৈরি করো।
</p>
<div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-base">grade</span>
<span class="bengali-text">মান: ৫</span>
</div>
</div>
<button class="flex shrink-0 h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 px-4 text-sm font-bold text-white transition-all shadow-md bengali-text">
<span class="material-symbols-outlined text-lg">code_blocks</span>
<span>HTML এডিটর</span>
</button>
</div>

<!-- AI Hint Toggle -->
<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
<button onclick="toggleHint('hint3')" class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text">
<span class="material-symbols-outlined text-lg">psychology</span>
<span>AI সাহায্য চাই</span>
</button>
<!-- AI Hint Panel -->
<div id="hint3" class="ai-hint-panel mt-3">
<div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
<div class="flex items-start gap-3">
<div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">smart_toy</span>
</div>
<div class="flex-1">
<p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
<div class="text-sm text-slate-700 dark:text-slate-300 space-y-2">
<p class="bengali-text"><strong>মৌলিক স্ট্রাকচার:</strong></p>
<pre class="bg-slate-900 text-green-400 p-3 rounded text-xs overflow-x-auto"><code>&lt;table border="1"&gt;
  &lt;tr&gt;
    &lt;td&gt;সেল ১&lt;/td&gt;
    &lt;td&gt;সেল ২&lt;/td&gt;
    &lt;td&gt;সেল ৩&lt;/td&gt;
  &lt;/tr&gt;
  &lt;!-- আরও ২টি সারি যোগ করুন --&gt;
&lt;/table&gt;</code></pre>
<p class="text-xs text-slate-600 dark:text-slate-400 pt-2 bengali-text">
<strong>টিপস:</strong> &lt;tr&gt; = সারি (row), &lt;td&gt; = ডেটা সেল
</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Question Block 4 - MCQ -->
<div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50 p-6" id="q4">
<div class="mb-4">
<p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
<strong class="font-bold">প্রশ্ন ৪:</strong> কোনটি একটি সার্বজনীন গেইট?
</p>
<div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-base">grade</span>
<span class="bengali-text">মান: ১</span>
</div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
<label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
<input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2" name="q4" type="radio"/>
<span class="bengali-text">AND</span>
</label>
<label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
<input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2" name="q4" type="radio"/>
<span class="bengali-text">OR</span>
</label>
<label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
<input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2" name="q4" type="radio"/>
<span class="bengali-text">NAND</span>
</label>
<label class="flex items-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 p-4 has-[:checked]:bg-primary/10 has-[:checked]:border-primary cursor-pointer transition-all hover:border-primary/50">
<input class="h-4 w-4 text-primary focus:ring-primary focus:ring-2" name="q4" type="radio"/>
<span class="bengali-text">XOR</span>
</label>
</div>

<!-- AI Hint Toggle -->
<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
<button onclick="toggleHint('hint4')" class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text">
<span class="material-symbols-outlined text-lg">psychology</span>
<span>AI সাহায্য চাই</span>
</button>
<!-- AI Hint Panel -->
<div id="hint4" class="ai-hint-panel mt-3">
<div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
<div class="flex items-start gap-3">
<div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">smart_toy</span>
</div>
<div class="flex-1">
<p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
<div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 bengali-text">
<p><strong>মনে রাখুন:</strong> সার্বজনীন গেইট দিয়ে সব ধরনের লজিক গেইট তৈরি করা যায়।</p>
<p>NAND এবং NOR গেইট হলো সার্বজনীন গেইট। এদের দিয়ে AND, OR, NOT সব তৈরি করা সম্ভব।</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Question Block 5 - Short Answer -->
<div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50 p-6" id="q5">
<div class="mb-4">
<p class="text-lg text-[#0d1b18] dark:text-white mb-2 bengali-text">
<strong class="font-bold">প্রশ্ন ৫:</strong> একটি ৪-বিট রেজিস্টারে সর্বোচ্চ কতটি ভিন্ন অবস্থা থাকতে পারে?
</p>
<div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-base">grade</span>
<span class="bengali-text">মান: ২</span>
</div>
</div>
<input class="w-full md:w-1/2 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all bengali-text" placeholder="আপনার উত্তর লিখুন..." type="text"/>

<!-- AI Hint Toggle -->
<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
<button onclick="toggleHint('hint5')" class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors bengali-text">
<span class="material-symbols-outlined text-lg">psychology</span>
<span>AI সাহায্য চাই</span>
</button>
<!-- AI Hint Panel -->
<div id="hint5" class="ai-hint-panel mt-3">
<div class="rounded-lg bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-700/30 p-4">
<div class="flex items-start gap-3">
<div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">smart_toy</span>
</div>
<div class="flex-1">
<p class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-2 bengali-text">AI হিন্ট</p>
<div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 bengali-text">
<p><strong>সূত্র:</strong> n-বিট রেজিস্টারের জন্য মোট অবস্থা = 2<sup>n</sup></p>
<p>এখানে n = 4, তাহলে হিসাব করুন: 2<sup>4</sup> = ?</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
<button class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 px-6 text-sm font-bold text-[#0d1b18] dark:text-white transition-all bengali-text" disabled>
<span class="material-symbols-outlined text-lg">arrow_back</span>
<span>পূর্ববর্তী</span>
</button>
<button class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary hover:bg-opacity-90 px-6 text-sm font-bold text-[#0d1b18] transition-all shadow-md bengali-text">
<span>পরবর্তী</span>
<span class="material-symbols-outlined text-lg">arrow_forward</span>
</button>
</div>
</div>
</div>
</div>
</main>

@endsection

@push('scripts')
<script>
// Get URL parameters for test information
function getURLParams() {
  const urlParams = new URLSearchParams(window.location.search);
  return {
    testName: urlParams.get('test') || 'মডেল টেস্ট',
    testId: urlParams.get('id') || '1',
    totalQuestions: urlParams.get('questions') || '20',
    timeMinutes: parseInt(urlParams.get('time')) || 25,
    chapter: urlParams.get('chapter') || 'অধ্যায় ৩'
  };
}

// Initialize page with URL parameters
function initializePage() {
  const params = getURLParams();
  
  // Update chapter name
  const chapterElement = document.querySelector('.text-sm.font-semibold.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (chapterElement) {
    chapterElement.textContent = `${params.chapter}: সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস`;
  }
  
  // Update test name
  const testNameElement = document.querySelector('.text-xs.text-slate-600.dark\\:text-slate-400.bengali-text');
  if (testNameElement) {
    testNameElement.textContent = `মডেল টেস্ট ${params.testId} - ${params.testName}`;
  }
  
  // Update total questions
  const questionsElement = document.querySelector('.text-lg.font-bold.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (questionsElement) {
    questionsElement.textContent = params.totalQuestions;
  }
  
  // Initialize timer with the correct time
  timeLeft = params.timeMinutes * 60; // Convert minutes to seconds
}

// Toggle AI Hint Panel
function toggleHint(hintId) {
  const hintPanel = document.getElementById(hintId);
  hintPanel.classList.toggle('active');
}

// Exit exam and return to model tests
function exitExam() {
  const confirmExit = confirm('আপনি কি সত্যিই পরীক্ষা ত্যাগ করতে চান? আপনার সমস্ত উত্তর হারিয়ে যাবে।');
  if (confirmExit) {
    window.location.href = '{{ route('model-tests') }}';
  }
}

// Submit exam and go to results
function submitExam() {
  const confirmSubmit = confirm('আপনি কি পরীক্ষা জমা দিতে চান? জমা দেওয়ার পর আপনি উত্তর পরিবর্তন করতে পারবেন না।');
  if (confirmSubmit) {
    // Get test parameters for results page
    const params = getURLParams();
    const resultParams = new URLSearchParams({
      'test': params.testName,
      'id': params.testId,
      'score': '18', // This would be calculated based on actual answers
      'total': params.totalQuestions,
      'time_taken': (params.timeMinutes * 60 - timeLeft) // Calculate time taken
    });
    
    window.location.href = `{{ route('model-test-summary') }}?${resultParams.toString()}`;
  }
}

// Timer Countdown
let timeLeft = 25 * 60; // Default 25 minutes in seconds

function updateTimer() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  const timerDisplay = document.querySelector('.font-bold.text-\\[\\#0d1b18\\].dark\\:text-white.text-lg');
  if (timerDisplay) {
    timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
  }
  if (timeLeft > 0) {
    timeLeft--;
  } else {
    // Time's up - auto submit
    alert('সময় শেষ! আপনার উত্তরপত্র স্বয়ংক্রিয়ভাবে জমা দেওয়া হচ্ছে।');
  }
}

// Initialize page when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  initializePage();
  // Update timer every second
  setInterval(updateTimer, 1000);
});
</script>
@endpush