@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে - HSC ICT Interactive')

@section('description', 'HSC ICT শেখার ভবিষ্যৎ। আমাদের ইন্টের‍্যাক্টিভ প্ল্যাটফর্মে C-Programming, HTML, Number Systems প্র্যাকটিস করুন। মুখস্থ নির্ভর না হয়ে প্র্যাকটিস নির্ভর হয়ে ICT-তে A+ পান।')

@section('keywords', 'HSC ICT, C Programming, HTML, CSS, Number System, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং, অনলাইন শিক্ষা')

@section('og:title', 'আমাদের সম্পর্কে - HSC ICT Interactive')

@section('og:description', 'HSC ICT শেখার ভবিষ্যৎ। আমাদের ইন্টের‍্যাক্টিভ প্ল্যাটফর্মে C-Programming, HTML, Number Systems প্র্যাকটিস করুন। মুখস্থ নির্ভর না হয়ে প্র্যাকটিস নির্ভর হয়ে ICT-তে A+ পান।')

@section('og:url', 'https://hscict.com/about.html')

@section('og:image', 'https://hscict.com/images/about-og-image.jpg')

@section('og:image:alt', 'HSC ICT Interactive - আমাদের সম্পর্কে পেজ')

@section('twitter:title', 'আমাদের সম্পর্কে - HSC ICT Interactive')

@section('twitter:description', 'HSC ICT শেখার ভবিষ্যৎ। আমাদের ইন্টের‍্যাক্টিভ প্ল্যাটফর্মে C-Programming, HTML, Number Systems প্র্যাকটিস করুন।')

@section('twitter:image', 'https://hscict.com/images/about-og-image.jpg')

@section('twitter:image:alt', 'HSC ICT Interactive - আমাদের সম্পর্কে পেজ')

@section('content')
<!-- Content Container -->
<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">

<!-- PageHeading -->
<div class="flex flex-col items-center justify-center gap-3 text-center mb-12">
<h1 class="text-4xl sm:text-5xl font-black leading-tight tracking-tight text-[#0d1b18] dark:text-white bengali-text">আমাদের সম্পর্কে</h1>
<p class="text-base sm:text-lg font-normal leading-normal text-primary bengali-text">HSC ICT শেখার ভবিষ্যৎ</p>
</div>

<!-- Our Story Card -->
<div class="mb-12">
<div class="flex flex-col lg:flex-row items-center justify-start rounded-xl shadow-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden">
<div class="w-full lg:w-2/5 aspect-video lg:aspect-auto lg:h-80 bg-center bg-no-repeat bg-cover" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCl7rzkNlPOs8YXv16VyAHB4JDgnNswnt7xbDP7lKuvip7Wrwy0LSFDJRcllpZr9BQVqfrAUsrz1_MUBUm6Sb4kVitjXJSIeWJm1LDy318t1owoL76kzPbiY3Mvi8qVWmkD3cQeEs92t103Djqma_PtXShQHqKva_WBQrVMoh1Gky4ubOKOkEDIARX5DFmFcMcNzPfeIhX1nh85r_KUmdI_ghDc4VbqqvAD33ZGK0ZzQY2i3NyIwr7qD9oPlgEi9Sp2_UxFuv43FA");'></div>
<div class="flex w-full lg:w-3/5 grow flex-col items-stretch justify-center gap-4 p-6 sm:p-8">
<h2 class="text-2xl font-bold leading-tight tracking-tight text-[#0d1b18] dark:text-white bengali-text">আমাদের গল্প</h2>
<div class="flex flex-col gap-4">
<p class="text-base font-normal leading-relaxed text-slate-600 dark:text-slate-300 bengali-text">
HSC ICT মুখস্থ নির্ভর না হয়ে প্র্যাকটিস নির্ভর হওয়া উচিত। আমাদের লক্ষ্য শিক্ষার্থীদের জন্য একটি ইন্টের‍্যাক্টিভ এবং আনন্দদায়ক প্ল্যাটফর্ম তৈরি করা যেখানে সিমুলেটর, কাস্টমাইজড প্র্যাকটিস এবং স্মার্ট ফিডব্যাক দিয়ে শিক্ষার্থীরা সফল হতে পারে।
</p>
<p class="text-base font-normal leading-relaxed text-slate-600 dark:text-slate-300 bengali-text">
আমরা বিশ্বাস করি যে হাতে-কলমে শেখার মাধ্যমে শিক্ষার্থীরা কেবল পরীক্ষাতেই ভালো করে না, বরং ভবিষ্যতের জন্য প্রয়োজনীয় ডিজিটাল দক্ষতাও অর্জন করে।
</p>
</div>
</div>
</div>
</div>

<!-- Our Values Section -->
<div class="mb-12">
<div class="flex flex-col rounded-xl shadow-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden p-6 sm:p-8">
<h2 class="text-2xl font-bold leading-tight tracking-tight mb-6 text-[#0d1b18] dark:text-white bengali-text">আমাদের মূল্যবোধ</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
<div class="flex flex-col gap-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 p-4">
<div class="text-primary"><span class="material-symbols-outlined text-3xl">emoji_objects</span></div>
<div class="flex flex-col gap-1">
<h3 class="text-base font-bold leading-tight text-[#0d1b18] dark:text-white bengali-text">উদ্ভাবন</h3>
<p class="text-sm font-normal leading-normal text-slate-600 dark:text-slate-300 bengali-text">আমরা সবসময় নতুন শেখার পদ্ধতি খুঁজে বের করি।</p>
</div>
</div>
<div class="flex flex-col gap-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 p-4">
<div class="text-primary"><span class="material-symbols-outlined text-3xl">handshake</span></div>
<div class="flex flex-col gap-1">
<h3 class="text-base font-bold leading-tight text-[#0d1b18] dark:text-white bengali-text">সহযোগিতা</h3>
<p class="text-sm font-normal leading-normal text-slate-600 dark:text-slate-300 bengali-text">শিক্ষার্থী এবং শিক্ষকদের সাথে একসাথে কাজ করি।</p>
</div>
</div>
<div class="flex flex-col gap-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 p-4">
<div class="text-primary"><span class="material-symbols-outlined text-3xl">checklist</span></div>
<div class="flex flex-col gap-1">
<h3 class="text-base font-bold leading-tight text-[#0d1b18] dark:text-white bengali-text">স্পষ্টতা</h3>
<p class="text-sm font-normal leading-normal text-slate-600 dark:text-slate-300 bengali-text">ICT-এর কঠিন বিষয় সহজভাবে উপস্থাপন করি।</p>
</div>
</div>
<div class="flex flex-col gap-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-background-light dark:bg-slate-700 p-4">
<div class="text-primary"><span class="material-symbols-outlined text-3xl">verified</span></div>
<div class="flex flex-col gap-1">
<h3 class="text-base font-bold leading-tight text-[#0d1b18] dark:text-white bengali-text">গুণমান</h3>
<p class="text-sm font-normal leading-normal text-slate-600 dark:text-slate-300 bengali-text">সেরা প্র্যাকটিস ম্যাটেরিয়াল সরবরাহ করি।</p>
</div>
</div>
</div>
</div>
</div>

<!-- Team Section -->
<div class="mb-12">
<h2 class="text-2xl text-center font-bold leading-tight tracking-tight mb-8 text-[#0d1b18] dark:text-white bengali-text">আমাদের দল</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
<!-- Team Member 1 -->
<div class="flex flex-col items-center text-center">
<img class="size-24 rounded-full mb-4 object-cover border-2 border-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNlXxhmjEjGdEw5fbA8t7FFhWlMzaxoMDeHjH7xTitqYoKF-1ncOFBUROtOzNr5CtKfNtZG6aUjRTll-vdI8pt3tEMDk_W8V8MOLmYOvrr2Rpu_nPd3oUPBzlJ-k4lK0mdGcMR0OqWxdD35nez8Ng2PJqF5WeecG71aJqXx0rKyEn2jckyRUk_CqyBHc3da1y3tYbkiRbLbJDQUKfaSE4ni_4_zEZmASBlr8FrJP1o7RYF_Si3E3wTcoIrJfrG-mjpZaXmGvnHfg" alt="Professional avatar for a team member"/>
<h3 class="font-bold text-lg text-[#0d1b18] dark:text-white bengali-text">কামরুল হাসান</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">প্রতিষ্ঠাতা ও প্রধান নির্বাহী</p>
</div>
<!-- Team Member 2 -->
<div class="flex flex-col items-center text-center">
<img class="size-24 rounded-full mb-4 object-cover border-2 border-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAd66o_y5tmIb94AJRpJp50KWUfTGry1dBHpMtM0r-Z1p30Qc-oK-eqTRAJ-gjl1g3Oh6XgGNSDMaAsIWggIB5Yp7DCswBakOY0jGx7hDHJtVQkG16g3pbY5v8yh5owJJiyEa1cROpFvO5be1xAhdvServfb-IJYczeb_d5tO1Me1Dfjr4g6tTYRKK2fGsCS2re8EitHXx7TwsOxovPNjuZHPlkm3LPW7k5EoXnr8Ru-dhE90U597F7u5iGKnENJjlDy1Jcq4WPYA" alt="Professional avatar for a female team member"/>
<h3 class="font-bold text-lg text-[#0d1b18] dark:text-white bengali-text">ফারিয়া আহমেদ</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">লিড ডেভেলপার</p>
</div>
<!-- Team Member 3 -->
<div class="flex flex-col items-center text-center">
<img class="size-24 rounded-full mb-4 object-cover border-2 border-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB0prnrxcb8iNlFUlN10J_OVmNvWGWoF6DoFZr96TCj1_WDFUtyd9lbMQQY4HTjbNo2ZbmE8h0tnu60wNs6BeeuFB-OCYhcuBWNlnG6ev24h5ElyoARzXL58ljK0mSrLrgN1yIhRFeHD8pLa_Rek9453ZVCk8RFTBP46c9-hzQDyKGn1oCnbB2cjPArhjsOzQ2xmZWPh0ytf6fuQfBQbeaA6wDeqzFw-M_CFw4uQW5BcSbBukA6vGy99d6NQg_VWlvSya3ByEhBRQ" alt="Professional avatar for another female team member"/>
<h3 class="font-bold text-lg text-[#0d1b18] dark:text-white bengali-text">সাদিয়া রহমান</h3>
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">কন্টেন্ট স্ট্র্যাটেজিস্ট</p>
</div>
</div>
</div>

<!-- Call to Action -->
<div class="text-center pt-8">
<button onclick="location.href='{{ route('chapters') }}'" class="cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-primary text-[#0d1b18] gap-2 text-base font-bold leading-normal tracking-wide min-w-48 px-6 hover:opacity-90 transition-opacity bengali-text">
এখনই প্র্যাকটিস শুরু করুন
</button>
</div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>
@endpush