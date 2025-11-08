@extends('layouts.app')

@section('title', 'লিডারবোর্ড - HSC ICT Interactive')
@section('description', 'HSC ICT Interactive এর শীর্ষ পারফর্মারদের দেখুন। লিডারবোর্ডে আপনার অবস্থান দেখুন এবং অন্যদের সাথে প্রতিযোগিতা করুন। সেরা হওয়ার জন্য আরও প্র্যাকটিস করুন।')
@section('keywords', 'HSC ICT লিডারবোর্ড, র‍্যাংকিং, প্রতিযোগিতা, শীর্ষ স্কোরার, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="লিডারবোর্ড - HSC ICT Interactive"/>
<meta property="og:description" content="HSC ICT Interactive এর শীর্ষ পারফর্মারদের দেখুন। লিডারবোর্ডে আপনার অবস্থান দেখুন এবং অন্যদের সাথে প্রতিযোগিতা করুন। সেরা হওয়ার জন্য আরও প্র্যাকটিস করুন।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/leaderboard.html"/>
<meta property="og:image" content="https://hscict.com/images/leaderboard-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - লিডারবোর্ড পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="লিডারবোর্ড - HSC ICT Interactive"/>
<meta name="twitter:description" content="HSC ICT Interactive এর শীর্ষ পারফর্মারদের দেখুন। লিডারবোর্ডে আপনার অবস্থান দেখুন এবং অন্যদের সাথে প্রতিযোগিতা করুন।"/>
<meta name="twitter:image" content="https://hscict.com/images/leaderboard-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - লিডারবোর্ড পেজ"/>

@section('content')
<!-- Page Header -->
<section class="w-full py-12 md:py-16 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
<div class="max-w-6xl mx-auto px-4">
<div class="text-center">
<h1 class="text-[#0d1b18] dark:text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4 bengali-text">
লিডারবোর্ড
</h1>
<p class="text-slate-600 dark:text-slate-400 text-base md:text-lg leading-relaxed bengali-text">
দেখুন আপনি কেমন করছেন অন্যদের তুলনায়
</p>
</div>
</div>
</section>

<!-- Leaderboard Content -->
<section class="w-full py-12 md:py-16">
<div class="max-w-4xl mx-auto px-4">

<!-- Time Period Filter -->
<div class="flex justify-center mb-8">
<div class="flex w-full max-w-md h-12 items-center justify-center rounded-lg bg-slate-200 dark:bg-slate-800 p-1.5">
<label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-primary has-[:checked]:shadow-md has-[:checked]:text-[#0d1b18] text-slate-600 dark:text-slate-400 dark:has-[:checked]:text-[#0d1b18] text-sm font-medium leading-normal transition-all bengali-text">
<span class="truncate">সাপ্তাহিক</span>
<input checked="" class="invisible w-0" name="leaderboard-filter" type="radio" value="সাপ্তাহিক"/>
</label>
<label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-primary has-[:checked]:shadow-md has-[:checked]:text-[#0d1b18] text-slate-600 dark:text-slate-400 dark:has-[:checked]:text-[#0d1b18] text-sm font-medium leading-normal transition-all bengali-text">
<span class="truncate">মাসিক</span>
<input class="invisible w-0" name="leaderboard-filter" type="radio" value="মাসিক"/>
</label>
<label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-primary has-[:checked]:shadow-md has-[:checked]:text-[#0d1b18] text-slate-600 dark:text-slate-400 dark:has-[:checked]:text-[#0d1b18] text-sm font-medium leading-normal transition-all bengali-text">
<span class="truncate">সর্বমোট</span>
<input class="invisible w-0" name="leaderboard-filter" type="radio" value="সর্বমোট"/>
</label>
</div>
</div>

<!-- Current User Rank Card -->
<div class="mb-8">
<div class="flex flex-col items-center justify-center rounded-xl bg-primary/10 dark:bg-primary/20 p-6 text-center border border-primary/20">
<p class="text-[#0d1b18] dark:text-white text-lg font-bold leading-tight mb-2 bengali-text">আপনার বর্তমান র‍্যাঙ্ক</p>
<div class="flex flex-col sm:flex-row items-center sm:items-end gap-2 sm:gap-4">
<p class="text-[#0d1b18] dark:text-white text-5xl font-black bengali-text">#৮৭</p>
<p class="text-slate-700 dark:text-slate-300 text-lg font-medium bengali-text">১,২০০ পয়েন্ট</p>
</div>
</div>
</div>

<!-- Top 3 Podium -->
<div class="mb-8">
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
<!-- 2nd Place -->
<div class="md:order-1 flex flex-col items-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 shadow-sm">
<div class="w-16 h-16 rounded-full bg-slate-300 dark:bg-slate-600 flex items-center justify-center mb-3">
<span class="text-3xl">🥈</span>
</div>
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">রায়হান আহমেদ</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 bengali-text">রাজউক উত্তরা কলেজ</p>
<p class="text-2xl font-black text-primary bengali-text">৫,১০০</p>
<p class="text-xs text-slate-500 bengali-text">পয়েন্ট</p>
</div>
<!-- 1st Place -->
<div class="md:order-2 flex flex-col items-center p-6 rounded-xl bg-gradient-to-b from-primary/10 to-primary/5 border-2 border-primary shadow-lg">
<div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center mb-3">
<span class="text-4xl">🏆</span>
</div>
<h3 class="text-xl font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">আফসানা মিম</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 bengali-text">নটর ডেম কলেজ, ঢাকা</p>
<p class="text-3xl font-black text-primary bengali-text">৫,২০০</p>
<p class="text-xs text-slate-500 bengali-text">পয়েন্ট</p>
</div>
<!-- 3rd Place -->
<div class="md:order-3 flex flex-col items-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 shadow-sm">
<div class="w-16 h-16 rounded-full bg-amber-200 dark:bg-amber-800/50 flex items-center justify-center mb-3">
<span class="text-3xl">🥉</span>
</div>
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">সাদিয়া ইসলাম</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 bengali-text">ভিকারুননিসা কলেজ</p>
<p class="text-2xl font-black text-primary bengali-text">৫,০০০</p>
<p class="text-xs text-slate-500 bengali-text">পয়েন্ট</p>
</div>
</div>
</div>

<!-- Leaderboard Table -->
<div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50 shadow-sm">
<div class="bg-slate-100 dark:bg-slate-800/50 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">সম্পূর্ণ লিডারবোর্ড</h3>
</div>
<table class="w-full text-left">
<thead>
<tr class="bg-slate-50 dark:bg-slate-800/30">
<th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 w-1/4 bengali-text">র‍্যাঙ্ক</th>
<th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 w-1/2 bengali-text">ছাত্রের নাম</th>
<th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 w-1/4 text-right bengali-text">পয়েন্ট</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-200 dark:divide-slate-700">
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">৪.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">তানভীর হাসান</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৯৫০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">৫.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">নাফিসা খান</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৯০০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">৬.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">আরিফ রহমান</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৮৫০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">৭.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">মারিয়া সুলতানা</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৮০০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">৮.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">শাকিব আল হাসান</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৭৫০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">৯.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">রুমানা আক্তার</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৭০০</td>
</tr>
<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
<td class="h-16 px-6 py-2 text-base font-medium text-slate-600 dark:text-slate-400 bengali-text">১০.</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">ইমরান হোসেন</td>
<td class="h-16 px-6 py-2 text-sm font-medium text-[#0d1b18] dark:text-white text-right bengali-text">৪,৬৫০</td>
</tr>
</tbody>
</table>
</div>

<!-- Motivation Section -->
<div class="mt-8 text-center p-6 rounded-xl bg-gradient-to-r from-primary/5 to-primary/10 border border-primary/20">
<h3 class="text-xl font-bold text-[#0d1b18] dark:text-white mb-2 bengali-text">আরও প্র্যাকটিস করুন!</h3>
<p class="text-slate-600 dark:text-slate-400 mb-4 bengali-text">প্রতিদিন প্র্যাকটিস করে আপনার র‍্যাঙ্ক উন্নতি করুন</p>
<a href="{{ route('chapters') }}" class="inline-flex items-center justify-center rounded-lg h-12 px-6 bg-primary text-[#0d1b18] text-base font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all shadow-lg shadow-primary/20 bengali-text">
<span class="truncate">প্র্যাকটিস শুরু করুন</span>
</a>
</div>

</div>
</section>
</main>

@endsection