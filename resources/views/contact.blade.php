@extends('layouts.app')

@section('title', 'যোগাযোগ - HSC ICT Interactive')
@section('description', 'HSC ICT Interactive টিমের সাথে যোগাযোগ করুন। আমাদের সাহায্য এবং সাপোর্ট সেবার মাধ্যমে আপনার ICT শেখার যাত্রায় আমরা সাহায্য করতে প্রস্তুত।')
@section('keywords', 'HSC ICT যোগাযোগ, সাপোর্ট, সাহায্য, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং সাহায্য')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="যোগাযোগ - HSC ICT Interactive"/>
<meta property="og:description" content="HSC ICT Interactive টিমের সাথে যোগাযোগ করুন। আমাদের সাহায্য এবং সাপোর্ট সেবার মাধ্যমে আপনার ICT শেখার যাত্রায় আমরা সাহায্য করতে প্রস্তুত।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/contact.html"/>
<meta property="og:image" content="https://hscict.com/images/contact-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - যোগাযোগ পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="যোগাযোগ - HSC ICT Interactive"/>
<meta name="twitter:description" content="HSC ICT Interactive টিমের সাথে যোগাযোগ করুন। আমাদের সাহায্য এবং সাপোর্ট সেবার মাধ্যমে আপনার ICT শেখার যাত্রায় আমরা সাহায্য করতে প্রস্তুত।"/>
<meta name="twitter:image" content="https://hscict.com/images/contact-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - যোগাযোগ পেজ"/>

@section('content')
<!-- Content Container -->
<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">

<!-- PageHeading -->
<div class="flex flex-col items-center justify-center gap-3 text-center mb-12">
<h1 class="text-4xl sm:text-5xl font-black leading-tight tracking-tight text-[#0d1b18] dark:text-white bengali-text">যোগাযোগ করুন</h1>
<p class="text-base sm:text-lg font-normal leading-normal text-primary bengali-text">আমাদের সাথে যুক্ত থাকুন</p>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

<!-- Contact Form Card -->
<div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 sm:p-8">
<div class="flex flex-col gap-6">
<h2 class="text-2xl font-bold leading-tight tracking-tight text-[#0d1b18] dark:text-white bengali-text">আমাদের একটি বার্তা পাঠান</h2>
<form class="flex flex-col gap-5">
<div class="flex flex-col sm:flex-row gap-5">
<label class="flex flex-col min-w-40 flex-1">
<p class="text-[#0d1b18] dark:text-slate-300 text-base font-medium leading-normal pb-2 bengali-text">আপনার নাম</p>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0d1b18] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 text-base font-normal leading-normal bengali-text" placeholder="আপনার নাম লিখুন" value=""/>
</label>
<label class="flex flex-col min-w-40 flex-1">
<p class="text-[#0d1b18] dark:text-slate-300 text-base font-medium leading-normal pb-2 bengali-text">আপনার ইমেইল</p>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0d1b18] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 text-base font-normal leading-normal" placeholder="আপনার ইমেইল লিখুন" type="email" value=""/>
</label>
</div>
<label class="flex flex-col w-full">
<p class="text-[#0d1b18] dark:text-slate-300 text-base font-medium leading-normal pb-2 bengali-text">বিষয়</p>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0d1b18] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 text-base font-normal leading-normal bengali-text" placeholder="আপনার বার্তাটির বিষয়" value=""/>
</label>
<label class="flex flex-col w-full">
<p class="text-[#0d1b18] dark:text-slate-300 text-base font-medium leading-normal pb-2 bengali-text">আপনার বার্তা</p>
<textarea class="form-textarea flex w-full min-w-0 flex-1 resize-y overflow-hidden rounded-lg text-[#0d1b18] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 min-h-32 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 text-base font-normal leading-normal bengali-text" placeholder="আপনার বার্তাটি এখানে লিখুন..."></textarea>
</label>
<button type="submit" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-primary text-[#0d1b18] gap-2 text-base font-bold leading-normal tracking-wide transition-all hover:bg-opacity-90 bengali-text">
<span class="material-symbols-outlined">send</span>
বার্তা পাঠান
</button>
</form>
</div>
</div>

<!-- Contact Information Card -->
<div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 sm:p-8">
<div class="flex flex-col gap-6 h-full">
<h2 class="text-2xl font-bold leading-tight tracking-tight text-[#0d1b18] dark:text-white bengali-text">অন্যান্য যোগাযোগের উপায়</h2>
<div class="flex flex-col gap-6 justify-around grow">
<div class="flex items-start gap-4">
<div class="flex items-center justify-center size-12 rounded-full bg-primary/10 text-primary">
<span class="material-symbols-outlined">call</span>
</div>
<div class="flex flex-col">
<p class="text-sm text-slate-500 dark:text-slate-400 bengali-text">সাপোর্ট হটলাইন:</p>
<a class="text-lg font-bold text-[#0d1b18] dark:text-white hover:text-primary transition-colors" href="tel:+8801234567890">+৮৮০ ১২৩৪ ৫৬৭ ৮৯০</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="flex items-center justify-center size-12 rounded-full bg-primary/10 text-primary">
<span class="material-symbols-outlined">mail</span>
</div>
<div class="flex flex-col">
<p class="text-sm text-slate-500 dark:text-slate-400 bengali-text">ইমেইল:</p>
<a class="text-lg font-bold text-[#0d1b18] dark:text-white hover:text-primary transition-colors" href="mailto:support@hscict.com">support@hscict.com</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="flex items-center justify-center size-12 rounded-full bg-primary/10 text-primary">
<span class="material-symbols-outlined">location_on</span>
</div>
<div class="flex flex-col">
<p class="text-sm text-slate-500 dark:text-slate-400 bengali-text">ঠিকানা:</p>
<p class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">ঢাকা, বাংলাদেশ</p>
</div>
</div>
<div class="flex items-start gap-4">
<div class="flex items-center justify-center size-12 rounded-full bg-primary/10 text-primary">
<span class="material-symbols-outlined">schedule</span>
</div>
<div class="flex flex-col">
<p class="text-sm text-slate-500 dark:text-slate-400 bengali-text">সাপোর্ট সময়:</p>
<p class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">২৪/৭ অনলাইন সাপোর্ট</p>
</div>
</div>
</div>

<!-- Social Links Section -->
<div class="border-t border-slate-200 dark:border-slate-600 pt-6 mt-4">
<p class="text-center text-sm font-medium text-slate-600 dark:text-slate-300 pb-4 bengali-text">আমাদের ফলো করুন</p>
<div class="flex justify-center items-center gap-4">
<a class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-primary/20 text-slate-700 dark:text-slate-300 hover:text-primary transition-colors" href="#" aria-label="Facebook">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
</svg>
</a>
<a class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-primary/20 text-slate-700 dark:text-slate-300 hover:text-primary transition-colors" href="#" aria-label="YouTube">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
</svg>
</a>
<a class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-primary/20 text-slate-700 dark:text-slate-300 hover:text-primary transition-colors" href="#" aria-label="Telegram">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
</svg>
</a>
<a class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-primary/20 text-slate-700 dark:text-slate-300 hover:text-primary transition-colors" href="#" aria-label="Discord">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
</svg>
</a>
</div>
</div>
</div>
</div>

</div>

<!-- FAQ Section -->
<div class="mt-16">
<h2 class="text-2xl font-bold leading-tight tracking-tight text-center mb-8 text-[#0d1b18] dark:text-white bengali-text">সচরাচর জিজ্ঞাসিত প্রশ্নসমূহ</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">প্ল্যাটফর্মটি কি সম্পূর্ণ ফ্রি?</h3>
<p class="text-slate-600 dark:text-slate-300 bengali-text">হ্যাঁ, আমাদের প্ল্যাটফর্মের সকল ফিচার সম্পূর্ণ বিনামূল্যে ব্যবহার করতে পারবেন।</p>
</div>
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">কিভাবে অ্যাকাউন্ট তৈরি করবো?</h3>
<p class="text-slate-600 dark:text-slate-300 bengali-text">হোম পেজে গিয়ে 'প্র্যাকটিস শুরু করুন' বাটনে ক্লিক করুন এবং নির্দেশনা অনুসরণ করুন।</p>
</div>
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">কতক্ষণের মধ্যে উত্তর পাবো?</h3>
<p class="text-slate-600 dark:text-slate-300 bengali-text">আমরা সাধারণত ২৪ ঘন্টার মধ্যে সকল প্রশ্নের উত্তর দেওয়ার চেষ্টা করি।</p>
</div>
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">মোবাইলে ব্যবহার করা যাবে?</h3>
<p class="text-slate-600 dark:text-slate-300 bengali-text">অবশ্যই! আমাদের প্ল্যাটফর্ম সকল ডিভাইসে সুন্দরভাবে কাজ করে।</p>
</div>
</div>
</div>

</div>
@endsection