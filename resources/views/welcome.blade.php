@extends('layouts.app')

@section('title', 'HSC ICT Interactive Practice Platform')

@section('description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন। মুখস্থ নির্ভর না হয়ে প্র্যাকটিস নির্ভর হয়ে ICT-তে A+ পান।')

@section('keywords', 'HSC ICT, C Programming, HTML, CSS, Number System, Logic Gates, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং, অনলাইন শিক্ষা, ইন্টারঅ্যাক্টিভ লার্নিং')

@section('og:title', 'HSC ICT Interactive Practice Platform - ICT-তে A+ পান, প্র্যাকটিস করে!')

@section('og:description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন। মুখস্থ নির্ভর না হয়ে প্র্যাকটিস নির্ভর হয়ে ICT-তে A+ পান।')

@section('og:url', 'https://hscict.com/')

@section('og:image', 'https://hscict.com/images/home-og-image.jpg')

@section('og:image:alt', 'HSC ICT Interactive Practice Platform - হোমপেজ')

@section('twitter:title', 'HSC ICT Interactive - ICT-তে A+ পান, প্র্যাকটিস করে!')

@section('twitter:description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন।')

@section('twitter:image', 'https://hscict.com/images/home-og-image.jpg')

@section('twitter:image:alt', 'HSC ICT Interactive Practice Platform - হোমপেজ')

@section('content')
<div class="flex flex-col items-center">
    <!-- HeroSection -->
    <section class="w-full py-20 md:py-32 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
        <div class="max-w-6xl mx-auto px-4">
            <div class="@container">
                <div class="flex flex-col-reverse gap-10 @[864px]:flex-row @[864px]:gap-12 items-center">
                    <div class="flex flex-col gap-6 @[864px]:w-1/2 @[864px]:justify-center items-center @[864px]:items-start">
                        <div class="flex flex-col gap-4 text-center @[864px]:text-left">
                            <h1 class="text-[#0d1b18] dark:text-white text-4xl font-black leading-tight tracking-tight md:text-6xl bengali-text">
                                ICT-তে A+ পান, প্র্যাকটিস করে!
                            </h1>
                            <h2 class="text-slate-600 dark:text-slate-400 text-base font-normal leading-relaxed md:text-lg bengali-text">
                                C-Programming, HTML, Number Systems - সব প্র্যাকটিস করুন এক জায়গায়।
                            </h2>
                        </div>
                        <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-[#0d1b18] text-base font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all shadow-lg shadow-primary/20 bengali-text">
                            <span class="truncate">এখনই প্র্যাকটিস শুরু করুন</span>
                        </button>
                    </div>
                    <div class="w-full @[864px]:w-1/2 aspect-video bg-slate-200 dark:bg-slate-800 rounded-xl flex items-center justify-center relative shadow-2xl shadow-primary/10 overflow-hidden">
                        <img class="w-full h-full object-cover" data-alt="A snippet of C code for Hello World on a dark editor screen." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxgBZM8It-FEx4rp1gxwNpuF9q0ZQlKMK3UYetExAlTE7bSsAB1p6h7_vyTJ_ihDkLUuCUdU3rco5xNv3nURtpuLVhtX-k0ROartoqKXROfElcpQurkN3YNPR9bC59Vryj4fDQQlnjvDo9PWzqWu29THYbufyMh_8Uexn48TCSX_c4qD80HTRwNx2MDA7bhC4gIRlXGTSggsM0gXhCG9aymuIaLewqjBb1G9p_UUlRkmQ90UNorZIFjpYyTBMhTiTrqIwmIP3jVg"/>
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center cursor-pointer hover:bg-white/40 transition-colors">
                                <span class="material-symbols-outlined text-white text-4xl">play_arrow</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem/Solution Section -->
    <section class="w-full py-20 md:py-24">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-red-500/5 dark:bg-red-500/10 border border-red-500/10">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">cancel</span>
                        <p class="text-[#0d1b18] dark:text-white text-xl font-bold bengali-text">পুরনো পদ্ধতি ❌</p>
                    </div>
                    <ul class="space-y-2 text-slate-600 dark:text-slate-400 list-inside bengali-text">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-red-400">remove</span><span>বই/গাইড পড়ে মুখস্থ করা</span></li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-red-400">remove</span><span>ভিডিও লেকচার দেখে ভুলে যাওয়া</span></li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-red-400">remove</span><span>Error দেখে ভয় পাওয়া</span></li>
                    </ul>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-green-500/5 dark:bg-green-500/10 border border-green-500/10">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-500">check_circle</span>
                        <p class="text-[#0d1b18] dark:text-white text-xl font-bold bengali-text">আমাদের পদ্ধতি ✅</p>
                    </div>
                    <ul class="space-y-2 text-slate-600 dark:text-slate-400 list-inside bengali-text">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-green-400">add</span><span>ইন্টের‍্যাক্টিভ সিমুলেটরে প্র্যাকটিস</span></li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-green-400">add</span><span>তাৎক্ষণিক আউটপুট দেখে শেখা</span></li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-sm mt-1 text-green-400">add</span><span>Error সহজে বুঝতে পারা এবং সমাধান করা</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Simulator Tabs Section -->
    <section class="w-full py-20 md:py-24 bg-white dark:bg-background-dark">
        <div class="max-w-6xl mx-auto px-4 flex flex-col gap-10">
            <div class="flex flex-col gap-2 text-center">
                <h3 class="text-3xl md:text-4xl font-bold text-[#0d1b18] dark:text-white bengali-text">আমাদের ইন্টের‍্যাক্টিভ টুলস</h3>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">কোন সফটওয়্যার ইন্সটল করা লাগবে না। ব্রাউজারেই সব।</p>
            </div>
            <div x-data="welcomeTabs()">
                <div class="@container">
                    <div class="flex overflow-x-auto overflow-y-hidden gap-3 border-b border-primary/20 pb-0">
                        <button @click="activeTab = 'c-compiler'" 
                                :class="activeTab === 'c-compiler' ? 'border-b-primary text-[#0d1b18] dark:text-white' : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:border-b-primary/50 hover:text-[#0d1b18] dark:hover:text-white'" 
                                class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4 flex-1 cursor-pointer min-w-[120px] transition-all">
                            <p class="text-sm font-bold tracking-wide bengali-text">C-কম্পাইলার</p>
                        </button>
                        <button @click="activeTab = 'logic-gate'" 
                                :class="activeTab === 'logic-gate' ? 'border-b-primary text-[#0d1b18] dark:text-white' : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:border-b-primary/50 hover:text-[#0d1b18] dark:hover:text-white'" 
                                class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4 flex-1 cursor-pointer min-w-[120px] transition-all">
                            <p class="text-sm font-bold tracking-wide bengali-text">লজিক গেট বিল্ডার</p>
                        </button>
                        <button @click="activeTab = 'html-css'" 
                                :class="activeTab === 'html-css' ? 'border-b-primary text-[#0d1b18] dark:text-white' : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:border-b-primary/50 hover:text-[#0d1b18] dark:hover:text-white'" 
                                class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4 flex-1 cursor-pointer min-w-[120px] transition-all">
                            <p class="text-sm font-bold tracking-wide">HTML/CSS প্লেগ্রাউন্ড</p>
                        </button>
                        <button @click="activeTab = 'number-system'" 
                                :class="activeTab === 'number-system' ? 'border-b-primary text-[#0d1b18] dark:text-white' : 'border-b-transparent text-slate-500 dark:text-slate-400 hover:border-b-primary/50 hover:text-[#0d1b18] dark:hover:text-white'" 
                                class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4 flex-1 cursor-pointer min-w-[120px] transition-all">
                            <p class="text-sm font-bold tracking-wide bengali-text">নাম্বার সিস্টেম কনভার্টার</p>
                        </button>
                    </div>
                </div>
                <div class="w-full aspect-video bg-white dark:bg-background-dark rounded-xl shadow-2xl shadow-primary/10 overflow-hidden border border-primary/20">
                <!-- C-Compiler Tab -->
                <div x-show="activeTab === 'c-compiler'" class="w-full h-full">
                    <img class="w-full h-full object-cover object-center" data-alt="A realistic screenshot of a C-Programming code editor with a console output window." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC6pn8aI1kLnbSDO_ebzGR5WhJm6lXOtCT2qXYmhz1GLAqVfeWZKMUtKbeBboxNqZHjf0-G_oQh7Ui49-s57nc5PHeY7Mm2ahurZs6Mqe5xIgP1kuPNZvW0KU9WOW3uTzgwX6o7kHaSKIfRopVZnplms1u81cCgBQsGLKdjebehWyEvgVYyUqlu0VP6ixgNpyZ1VtyPnBi2M2V2L5iKRoMjGb5mXIlqrxM7Avoh3hkmo3wpGd4qtswDV-4qHzZEQhCyLGLaob0V0w"/>
                </div>
                <!-- Logic Gate Tab -->
                <div x-show="activeTab === 'logic-gate'" class="w-full h-full">
                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-purple-50 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-5xl">electrical_services</span>
                            </div>
                            <h4 class="text-2xl font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">লজিক গেট বিল্ডার</h4>
                            <p class="text-slate-600 dark:text-slate-400 mb-6 bengali-text">AND, OR, NOT, NAND, NOR গেট দিয়ে সার্কিট ডিজাইন করুন</p>
                            <button class="px-6 py-3 bg-primary text-[#0d1b18] rounded-lg font-bold hover:bg-opacity-90 transition-all bengali-text">শীঘ্রই আসছে</button>
                        </div>
                    </div>
                </div>
                <!-- HTML/CSS Tab -->
                <div x-show="activeTab === 'html-css'" class="w-full h-full">
                    <div class="w-full h-full bg-gradient-to-br from-orange-50 to-pink-50 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-5xl">code</span>
                            </div>
                            <h4 class="text-2xl font-bold text-[#0d1b18] dark:text-white mb-3">HTML/CSS প্লেগ্রাউন্ড</h4>
                            <p class="text-slate-600 dark:text-slate-400 mb-6 bengali-text">লাইভ এডিটর দিয়ে HTML এবং CSS প্র্যাকটিস করুন</p>
                            <button class="px-6 py-3 bg-primary text-[#0d1b18] rounded-lg font-bold hover:bg-opacity-90 transition-all bengali-text">শীঘ্রই আসছে</button>
                        </div>
                    </div>
                </div>
                <!-- Number System Tab -->
                <div x-show="activeTab === 'number-system'" class="w-full h-full">
                    <div class="w-full h-full bg-gradient-to-br from-green-50 to-teal-50 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-5xl">calculate</span>
                            </div>
                            <h4 class="text-2xl font-bold text-[#0d1b18] dark:text-white mb-3 bengali-text">নাম্বার সিস্টেম কনভার্টার</h4>
                            <p class="text-slate-600 dark:text-slate-400 mb-6 bengali-text">Binary, Octal, Decimal, Hexadecimal - সব কনভার্সন এক জায়গায়</p>
                            <button class="px-6 py-3 bg-primary text-[#0d1b18] rounded-lg font-bold hover:bg-opacity-90 transition-all bengali-text">শীঘ্রই আসছে</button>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-slate-600 dark:text-slate-400 bengali-text">ব্রাউজারেই কোড রান করুন, ভুল থেকে শিখুন এবং কনফিডেন্স বাড়ান।</p>
        </div>
    </section>

    <!-- Key Benefits Section -->
    <section class="w-full py-20 md:py-24">
        <div class="max-w-6xl mx-auto px-4 flex flex-col gap-12">
            <div class="flex flex-col gap-2 text-center">
                <h4 class="text-primary text-sm font-bold uppercase tracking-widest">Key Benefits</h4>
                <h3 class="text-3xl md:text-4xl font-bold text-[#0d1b18] dark:text-white bengali-text">শুধু প্র্যাকটিস নয়, আছে আরও অনেক কিছু</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flex flex-col items-center text-center gap-4 p-8 rounded-xl bg-background-light dark:bg-slate-800/50 border border-primary/10 hover:shadow-xl hover:shadow-primary/10 transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl">checklist</span>
                    </div>
                    <h4 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">স্মার্ট MCQ প্র্যাকটিস</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">অধ্যায়ভিত্তিক MCQ প্র্যাকটিস করে আপনার দুর্বল টপিকগুলো সহজেই চিহ্নিত করুন।</p>
                </div>
                <div class="flex flex-col items-center text-center gap-4 p-8 rounded-xl bg-background-light dark:bg-slate-800/50 border border-primary/10 hover:shadow-xl hover:shadow-primary/10 transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl">emoji_events</span>
                    </div>
                    <h4 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">গেইমিফাইড প্রোগ্রেস</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">প্রতিটি সঠিক সমাধানের জন্য পয়েন্ট অর্জন করুন এবং লিডারবোর্ডে বন্ধুদের সাথে প্রতিযোগিতা করুন।</p>
                </div>
                <div class="flex flex-col items-center text-center gap-4 p-8 rounded-xl bg-background-light dark:bg-slate-800/50 border border-primary/10 hover:shadow-xl hover:shadow-primary/10 transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl">history_edu</span>
                    </div>
                    <h4 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text">বোর্ড প্রশ্ন ব্যাংক</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">বিগত বছরের সকল বোর্ড পরীক্ষার প্রশ্ন ও তার সমাধান এখন আপনার হাতের মুঠোয়।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof/Testimonials Section -->
    <section class="w-full py-20 md:py-24 bg-primary/5 dark:bg-primary/10">
        <div class="max-w-6xl mx-auto px-4 flex flex-col gap-12">
            <div class="flex flex-col gap-2 text-center">
                <h3 class="text-3xl md:text-4xl font-bold text-[#0d1b18] dark:text-white bengali-text">আমাদের শিক্ষার্থীরা যা বলছে</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white dark:bg-background-dark shadow-lg shadow-primary/5">
                    <div class="flex items-center gap-4">
                        <img class="w-12 h-12 rounded-full object-cover" data-alt="A smiling female student from Bangladesh." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjzDuMn-BVqjq3NecbdFWH-Iznrp9QeB6PnoFiKzrHkz6J3__SyrlmLTlX_kQ45ba7VShNnhVNbG3ladheMaMu_s6QlLHr2DsR2kvbl8DunR59wyOH_QUyCdpzYp1kjyOFmfB7fhzAY5bdUo7ZV_34HpqZAWxzOvSYSIjqV-UmNPZ_KSh-uPzYmJB4GXgbEC6nXuNuNgihI4yBuxsQ8yNoTMCT2F_txiMTktIxdwGZwNLTsVq3TmBZ3J8_CAugQNESnjySfsKDuQ"/>
                        <div>
                            <p class="font-bold text-[#0d1b18] dark:text-white bengali-text">আফসানা মিম</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 bengali-text">নটর ডেম কলেজ, ঢাকা</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed bengali-text">"এই প্ল্যাটফর্মে প্র্যাকটিস করার পর আমার C-প্রোগ্রামিং এর ভয় পুরোপুরি কেটে গেছে। এখানকার সিমুলেটরগুলো অসাধারণ! আলহামদুলিল্লাহ, ICT তে A+ পেয়েছি!"</p>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white dark:bg-background-dark shadow-lg shadow-primary/5">
                    <div class="flex items-center gap-4">
                        <img class="w-12 h-12 rounded-full object-cover" data-alt="A smiling male student from Bangladesh." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBu4zJXxnzPJtfQDqg1mcNKxz3ofd2r8DNao8F4dQj1ACnt0eX6tWrqSFWYLIQhIrdvMgI__rPVihpLxaqYf8O6bZ1arl0aWAKMoOOR3DJpWKfvTNtCQtZ2Qy5MkxEps1ec1uq1d5jDyNT5HaaGAVla-KTG4W44ulW1BYtlNQIpgZmpei1DQQMSEJ20oZTOJh7SWhMGTkqCBr3upTKmq_pKDqTrAPj6TpZ1UE7aWGaRkgtZ2THWy6K8sh8ujAqqgHgu85eM9t9dwQ"/>
                        <div>
                            <p class="font-bold text-[#0d1b18] dark:text-white bengali-text">রায়হান আহমেদ</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 bengali-text">রাজউক উত্তরা মডেল কলেজ</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed bengali-text">"লজিক গেট আর নাম্বার সিস্টেমের কনভার্সনগুলো অনেক কঠিন লাগতো। এখানকার ইন্টার‍্যাক্টিভ টুলস দিয়ে প্র্যাকটিস করে সব কনসেপ্ট একদম পরিষ্কার হয়ে গেছে।"</p>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white dark:bg-background-dark shadow-lg shadow-primary/5">
                    <div class="flex items-center gap-4">
                        <img class="w-12 h-12 rounded-full object-cover" data-alt="A confident female student from Bangladesh." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBrfhyFL3kx5Z2yNreVXZEJpY4vY1X3o54f1nOrVyq0TF2-_0VAhypWGMOD05kUwJgZVLEU4UUm9E3sZLmWWDcLp-ZdToP3BZju047PJmDVCuTJF79x-wYFFCdvlMTRXvFj_pOOBudMpR3CIGwFPXAp9JNZoi0zK_ja8PJ7Rt2W6EUgH_YF3-j99WGuK7rBJ9V6CNS6DAFXjPappn5QrHcq0ewrOauVQA0B7zIEOAAuuy6fLujcuyPEKq3hWa097Np_ilQQMWWSSg"/>
                        <div>
                            <p class="font-bold text-[#0d1b18] dark:text-white bengali-text">সাদিয়া ইসলাম</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 bengali-text">ভিকারুননিসা নূন স্কুল এন্ড কলেজ</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed bengali-text">"বোর্ড পরীক্ষার আগে এখানকার প্রশ্ন ব্যাংক থেকে প্র্যাকটিস করে অনেক সাহায্য পেয়েছি। ওয়েবসাইটটা ব্যবহার করাও খুব সহজ।"</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16 pt-8">
                <div class="text-center">
                    <p class="text-3xl font-black text-primary">50,000+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400">C-Programs Compiled</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-primary bengali-text">১০,০০০+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সন্তুষ্ট শিক্ষার্থী</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-primary">1,200+</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400">MCQs Solved</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="w-full py-20 md:py-32">
        <div class="max-w-4xl mx-auto px-4 text-center flex flex-col items-center gap-6">
            <h2 class="text-4xl md:text-5xl font-black text-[#0d1b18] dark:text-white bengali-text">ICT-তে ভয় আর নয়।</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-md leading-relaxed bengali-text">আপনার প্রথম প্রোগ্রাম রান করতে ২ মিনিটেরও কম সময় লাগবে। আজই শুরু করুন আপনার সফলতার যাত্রা।</p>
            <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-[#0d1b18] text-base font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all shadow-lg shadow-primary/20 bengali-text">
                <span class="truncate">ফ্রি প্র্যাকটিস শুরু করুন</span>
            </button>
            <p class="text-xs text-slate-500">No credit card required.</p>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
function welcomeTabs() {
    return {
        activeTab: 'c-compiler'
    }
}
</script>
@endpush