@extends('layouts.app')

@section('title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন এবং পরীক্ষায় A+ পান।')

@section('keywords', 'HSC ICT অধ্যায়, C Programming, HTML, CSS, Number System, Logic Gates, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং')

@section('og:title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('og:description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন এবং পরীক্ষায় A+ পান।')

@section('og:url', 'https://hscict.com/chapters.html')

@section('og:image', 'https://hscict.com/images/chapters-og-image.jpg')

@section('og:image:alt', 'HSC ICT Interactive - অধ্যায় নির্বাচন পেজ')

@section('twitter:title', 'অধ্যায় নির্বাচন - HSC ICT Interactive')

@section('twitter:description', 'HSC ICT-এর সকল অধ্যায়ের ইন্টারঅ্যাক্টিভ প্র্যাকটিস। C-Programming, HTML, Number Systems, Logic Gates - সব একসাথে প্র্যাকটিস করুন।')

@section('twitter:image', 'https://hscict.com/images/chapters-og-image.jpg')

@section('twitter:image:alt', 'HSC ICT Interactive - অধ্যায় নির্বাচন পেজ')

@section('content')
<div class="flex flex-col items-center flex-1">
    <!-- Page Header -->
    <section class="w-full py-12 md:py-16 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <h1 class="text-[#0d1b18] dark:text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4 bengali-text">
                    আপনার অধ্যায় বেছে নিন
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg leading-relaxed bengali-text">
                    যে অধ্যায়ে প্র্যাকটিস করতে চান, সেটিতে ক্লিক করুন
                </p>
            </div>
        </div>
    </section>

    <!-- Chapters Grid -->
    <section class="w-full py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chapter 1 -->
                <a href="{{ route('model-tests') }}?chapter=1" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ১</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">তথ্য ও যোগাযোগ প্রযুক্তি: বিশ্ব ও বাংলাদেশ প্রেক্ষিত</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">public</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 30%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">30%</span>
                        </div>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>

                <!-- Chapter 2 -->
                <a href="{{ route('model-tests') }}?chapter=2" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ২</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">কমিউনিকেশন সিস্টেম ও নেটওয়ার্কিং</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">hub</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>

                <!-- Chapter 3 -->
                <a href="{{ route('model-tests') }}?chapter=3" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ৩</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">memory</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>

                <!-- Chapter 4 -->
                <a href="{{ route('model-tests') }}?chapter=4" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ৪</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">ওয়েব ডিজাইন পরিচিতি এবং HTML</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">code</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 30%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">30%</span>
                        </div>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>

                <!-- Chapter 5 -->
                <a href="{{ route('model-tests') }}?chapter=5" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ৫</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">প্রোগ্রামিং ভাষা</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">data_object</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>

                <!-- Chapter 6 -->
                <a href="{{ route('model-tests') }}?chapter=6" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় ৬</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#0d1b18] dark:text-white mt-2 leading-snug bengali-text">ডেটাবেজ ম্যানেজমেন্ট সিস্টেম</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl">database</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 30%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">30%</span>
                        </div>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">checklist</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">১২০০+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">MCQ প্রশ্ন</p>
                </div>
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">code</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">৫০০+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">প্রোগ্রামিং সমস্যা</p>
                </div>
                <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white dark:bg-slate-900/50 border border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-4xl">psychology</span>
                    </div>
                    <p class="text-3xl font-black text-primary mb-1 bengali-text">১০০+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">ইন্টার‍্যাক্টিভ টিউটোরিয়াল</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection