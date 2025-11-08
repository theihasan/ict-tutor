@extends('layouts.app')

@section('title', 'প্রোফাইল সম্পাদনা - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT প্রোফাইল সম্পাদনা করুন। আপনার অগ্রগতি ট্র্যাক করুন এবং ব্যক্তিগত তথ্য আপডেট করুন। HSC ICT-তে সফল হওয়ার জন্য আপনার প্রোফাইল সম্পূর্ণ করুন।')
@section('keywords', 'HSC ICT প্রোফাইল, শিক্ষার্থী প্রোফাইল, অগ্রগতি ট্র্যাকিং, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="প্রোফাইল সম্পাদনা - HSC ICT Interactive"/>
<meta property="og:description" content="আপনার HSC ICT প্রোফাইল সম্পাদনা করুন। আপনার অগ্রগতি ট্র্যাক করুন এবং ব্যক্তিগত তথ্য আপডেট করুন। HSC ICT-তে সফল হওয়ার জন্য আপনার প্রোফাইল সম্পূর্ণ করুন।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/edit-profile.html"/>
<meta property="og:image" content="https://hscict.com/images/profile-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - প্রোফাইল সম্পাদনা পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="প্রোফাইল সম্পাদনা - HSC ICT Interactive"/>
<meta name="twitter:description" content="আপনার HSC ICT প্রোফাইল সম্পাদনা করুন। আপনার অগ্রগতি ট্র্যাক করুন এবং ব্যক্তিগত তথ্য আপডেট করুন।"/>
<meta name="twitter:image" content="https://hscict.com/images/profile-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - প্রোফাইল সম্পাদনা পেজ"/>

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

<!-- Page Header -->
<div class="flex flex-col items-center gap-2 text-center mb-8">
<h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#0d1b18] dark:text-white bengali-text">আমার প্রোফাইল</h1>
<p class="text-lg text-slate-600 dark:text-slate-400 bengali-text">আপনার তথ্য দেখুন এবং আপডেট করুন</p>
</div>

<!-- Profile Information Card -->
<div class="w-full rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 md:p-8 mb-8">
<div class="flex w-full flex-col items-center gap-6">
<div class="flex flex-col items-center gap-4">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-32" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDByzuGm_IalSambS_ZpZZ5g8xhQR5RDoCxGe7_CR3stfZ0LNYWvWJW5qdljoKsqHTdb0CL3rAjwY-y3LQz_DD8yzAfHRUwtNHLXPBoEdpAg3J2pX4pYuCBN249jazCB2FCkiWh8Xq4mAKz7ev-L8xLtJUvXNTUElpiso4v86DYbY5YfvoQJ4E0mh1NZhS686d-v1CiUJwhmQAom4Mrx80YXW9Q4oJbdsZtoJBh-8z62PQy88gIeFJnAnP3d6rGN8kHEyFuyf2a6g");'></div>
<div class="flex flex-col items-center">
<p class="text-2xl font-bold tracking-tight text-[#0d1b18] dark:text-white bengali-text">ছাত্রের পুরো নাম</p>
<p class="text-base font-normal text-slate-500 dark:text-slate-400">student.email@example.com</p>
</div>
<button class="flex h-9 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary/20 px-4 text-sm font-bold text-[#0d1b18] hover:bg-primary/30 dark:text-white dark:hover:bg-primary/40 bengali-text">
<span>ছবি পরিবর্তন করুন</span>
</button>
</div>
<hr class="my-6 w-full border-t border-slate-200 dark:border-slate-700"/>
<div class="grid w-full grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">নাম:</p>
<input class="form-input h-12 w-full rounded-lg border border-slate-300 bg-white dark:bg-slate-800 px-3.5 text-base placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/50 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-500 bengali-text" value="ছাত্রের পুরো নাম"/>
</label>
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">ইমেইল:</p>
<input class="form-input h-12 w-full cursor-not-allowed rounded-lg border border-slate-300 bg-slate-100 dark:bg-slate-800 px-3.5 text-base text-slate-500 dark:border-slate-600 dark:text-slate-400" disabled="" value="student.email@example.com"/>
</label>
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">ফোন নম্বর:</p>
<input class="form-input h-12 w-full rounded-lg border border-slate-300 bg-white dark:bg-slate-800 px-3.5 text-base placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/50 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-500" value="01XXXXXXXXX"/>
</label>
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">স্কুল/কলেজের নাম:</p>
<input class="form-input h-12 w-full rounded-lg border border-slate-300 bg-white dark:bg-slate-800 px-3.5 text-base placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/50 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-500 bengali-text" value="শিক্ষাপ্রতিষ্ঠানের নাম"/>
</label>
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">শ্রেণি:</p>
<select class="form-select h-12 w-full rounded-lg border border-slate-300 bg-white dark:bg-slate-800 px-3.5 text-base focus:border-primary focus:ring-2 focus:ring-primary/50 dark:border-slate-600 dark:text-white bengali-text">
<option>HSC 1st Year</option>
<option selected="">HSC 2nd Year</option>
<option>HSC Candidate</option>
</select>
</label>
<label class="flex flex-col">
<p class="pb-2 text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">জেলা:</p>
<select class="form-select h-12 w-full rounded-lg border border-slate-300 bg-white dark:bg-slate-800 px-3.5 text-base focus:border-primary focus:ring-2 focus:ring-primary/50 dark:border-slate-600 dark:text-white bengali-text">
<option selected="">ঢাকা</option>
<option>চট্টগ্রাম</option>
<option>খুলনা</option>
<option>রাজশাহী</option>
<option>সিলেট</option>
<option>রংপুর</option>
<option>বরিশাল</option>
<option>ময়মনসিংহ</option>
</select>
</label>
</div>
<div class="flex w-full justify-end pt-6">
<button class="flex h-12 min-w-40 cursor-pointer items-center justify-center rounded-lg bg-primary px-6 text-base font-bold text-[#0d1b18] hover:opacity-90 transition-opacity bengali-text">
<span>তথ্য আপডেট করুন</span>
</button>
</div>
</div>
</div>

<!-- Progress & Achievements Summary Card -->
<div class="w-full rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 md:p-8 mb-8">
<h3 class="mb-6 text-2xl font-bold tracking-tight text-[#0d1b18] dark:text-white bengali-text">আমার অর্জন</h3>
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
<div class="flex flex-col gap-2 rounded-lg border border-primary/20 bg-slate-50 dark:bg-slate-800/50 p-4">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400 bengali-text">সেরা স্কোর</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">১৯/২০</p>
<p class="text-xs text-slate-400 dark:text-slate-500 bengali-text">মডেল টেস্ট ১</p>
</div>
<div class="flex flex-col gap-2 rounded-lg border border-primary/20 bg-slate-50 dark:bg-slate-800/50 p-4">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400 bengali-text">মোট প্র্যাকটিস সময়</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">৩০০ মিনিট</p>
<p class="text-xs text-slate-400 dark:text-slate-500 bengali-text">গত ৩০ দিনে</p>
</div>
<div class="flex flex-col gap-2 rounded-lg border border-primary/20 bg-slate-50 dark:bg-slate-800/50 p-4">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400 bengali-text">বর্তমান স্ট্রিক</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">৫ দিন</p>
<p class="text-xs text-slate-400 dark:text-slate-500 bengali-text">চালিয়ে যান!</p>
</div>
<div class="flex flex-col gap-3 rounded-lg border border-primary/20 bg-slate-50 dark:bg-slate-800/50 p-4">
<div class="flex items-center justify-between">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400 bengali-text">ICT সম্পূর্ণ</p>
<p class="text-sm font-bold text-[#0d1b18] dark:text-white">75%</p>
</div>
<div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-600">
<div class="h-2 rounded-full bg-primary transition-all duration-500" style="width: 75%;"></div>
</div>
</div>
</div>
<div class="mt-8 flex justify-start">
<button class="flex h-11 cursor-pointer items-center justify-center rounded-lg border border-primary/20 bg-white dark:bg-slate-800 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors bengali-text">
<span>পূর্ণাঙ্গ রিপোর্ট দেখুন</span>
</button>
</div>
</div>

<!-- Account Settings Card -->
<div class="w-full rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 md:p-8">
<h3 class="mb-6 text-2xl font-bold tracking-tight text-[#0d1b18] dark:text-white bengali-text">একাউন্ট সেটিংস</h3>
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
<div class="flex flex-col gap-4 sm:flex-row sm:gap-4">
<button class="flex h-11 w-full cursor-pointer items-center justify-center rounded-lg border border-primary/20 bg-white dark:bg-slate-800 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors sm:w-auto bengali-text">পাসওয়ার্ড পরিবর্তন করুন</button>
<button class="flex h-11 w-full cursor-pointer items-center justify-center rounded-lg border border-primary/20 bg-white dark:bg-slate-800 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors sm:w-auto bengali-text">নোটিফিকেশন সেটিংস</button>
</div>
<button class="flex h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-red-500/10 px-5 text-sm font-bold text-red-600 hover:bg-red-500/20 dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500/30 transition-colors sm:w-auto bengali-text">
<span class="material-symbols-outlined text-lg">logout</span>
<span>লগ আউট</span>
</button>
</div>
</div>

</div>
@endsection