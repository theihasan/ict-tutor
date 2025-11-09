@extends('layouts.app')

@section('title', $chapter->name . ' - অধ্যায় বিস্তারিত - HSC ICT Interactive')

@section('description', 'HSC ICT ' . $chapter->name . ' অধ্যায়ের সকল টপিক এবং প্র্যাকটিস উপকরণ। ' . ($chapter->description ?? ''))

@section('keywords', 'HSC ICT ' . $chapter->name . ', ' . ($chapter->name_en ?? '') . ', বাংলাদেশ, শিক্ষা, প্রোগ্রামিং')

@section('og:title', $chapter->name . ' - অধ্যায় বিস্তারিত - HSC ICT Interactive')

@section('og:description', 'HSC ICT ' . $chapter->name . ' অধ্যায়ের সকল টপিক এবং প্র্যাকটিস উপকরণ।')

@section('og:url', route('chapter.show', $chapter->id))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Hero Section with Modern Design -->
    <section class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/10 via-emerald-500/5 to-blue-500/10"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3e%3cg fill="none" fill-rule="evenodd"%3e%3cg fill="%23000000" fill-opacity="0.02"%3e%3ccircle cx="30" cy="30" r="2"/%3e%3c/g%3e%3c/g%3e%3c/svg%3e')] dark:bg-[url('data:image/svg+xml,%3csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3e%3cg fill="none" fill-rule="evenodd"%3e%3cg fill="%23ffffff" fill-opacity="0.03"%3e%3ccircle cx="30" cy="30" r="2"/%3e%3c/g%3e%3c/g%3e%3c/svg%3e')]"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <!-- Back Navigation -->
            <div class="mb-8">
                <a href="{{ route('chapters') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:shadow-lg transition-all duration-300">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    <span class="font-medium bengali-text">সকল অধ্যায়ে ফিরে যান</span>
                </a>
            </div>

            <!-- Chapter Hero Content -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <!-- Chapter Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 backdrop-blur-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="text-primary font-semibold bengali-text">অধ্যায় {{ $chapter->order }}</span>
                    </div>

                    <!-- Chapter Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent mb-4 leading-tight bengali-text">
                        {{ $chapter->name }}
                    </h1>
                    
                    @if($chapter->name_en)
                    <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-6 font-medium">{{ $chapter->name_en }}</p>
                    @endif

                    @if($chapter->description)
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-8 bengali-text">
                        {{ $chapter->description }}
                    </p>
                    @endif

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-8">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">topic</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">{{ $chapter->topics->count() }} টি টপিক</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50">
                            <span class="material-symbols-outlined text-blue-600 text-lg">quiz</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">{{ $chapter->topics->sum(function($topic) { return $topic->questions->count(); }) }}+ প্রশ্ন</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50">
                            <span class="material-symbols-outlined text-amber-600 text-lg">schedule</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 bengali-text">৩০-৪৫ মিনিট</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('model-tests') }}?chapter={{ $chapter->id }}" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-emerald-500 text-white font-bold rounded-2xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/40 hover:scale-105 transition-all duration-300">
                            <span class="material-symbols-outlined text-xl">play_circle</span>
                            <span class="bengali-text">মডেল টেস্ট শুরু করুন</span>
                            <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                        @if($chapter->topics->count() > 0)
                        <a href="{{ route('model-tests') }}?topic={{ $chapter->topics->first()->id }}" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-white dark:bg-slate-800 text-slate-800 dark:text-white font-bold rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:scale-105 transition-all duration-300">
                            <span class="material-symbols-outlined text-xl">school</span>
                            <span class="bengali-text">প্রথম টপিক শুরু</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="relative">
                    <!-- Large Icon Background -->
                    <div class="relative mx-auto w-80 h-80 lg:w-96 lg:h-96">
                        <!-- Gradient Orb Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-emerald-500/15 to-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
                        
                        <!-- Main Icon Container -->
                        <div class="relative w-full h-full rounded-3xl bg-gradient-to-br from-white/90 to-white/70 dark:from-slate-800/90 dark:to-slate-800/70 backdrop-blur-xl border border-white/20 dark:border-slate-700/20 shadow-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-9xl lg:text-[10rem] bg-gradient-to-br from-primary via-emerald-500 to-blue-500 bg-clip-text text-transparent">
                                {{ $chapter->icon ?? 'menu_book' }}
                            </span>
                        </div>

                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl shadow-xl flex items-center justify-center animate-bounce" style="animation-delay: 0.5s;">
                            <span class="material-symbols-outlined text-white text-2xl">star</span>
                        </div>
                        <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl shadow-lg flex items-center justify-center animate-bounce" style="animation-delay: 1s;">
                            <span class="material-symbols-outlined text-white text-lg">lightbulb</span>
                        </div>
                        <div class="absolute top-8 -left-8 w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg shadow-md flex items-center justify-center animate-bounce" style="animation-delay: 1.5s;">
                            <span class="material-symbols-outlined text-white text-sm">rocket_launch</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Section (if available) -->
            @if(isset($chapter->user_progress) && $chapter->user_progress->completion_percentage > 0)
            <div class="mt-16 max-w-2xl mx-auto lg:mx-0">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/20 shadow-xl p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white bengali-text">আপনার অগ্রগতি</h3>
                        <span class="text-2xl font-black text-primary">{{ round($chapter->user_progress->completion_percentage) }}%</span>
                    </div>
                    <div class="relative">
                        <div class="w-full h-4 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary to-emerald-500 rounded-full transition-all duration-1000 ease-out" style="width: {{ $chapter->user_progress->completion_percentage }}%"></div>
                        </div>
                        <div class="absolute inset-0 h-4 bg-gradient-to-r from-white/20 to-transparent rounded-full"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Topics Section -->
    <section class="relative py-20">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-50/50 to-transparent dark:via-slate-800/50"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-primary/10 to-emerald-500/10 border border-primary/20 backdrop-blur-sm mb-6">
                    <span class="material-symbols-outlined text-primary text-lg">school</span>
                    <span class="text-primary font-semibold bengali-text">এই অধ্যায়ের টপিকসমূহ</span>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-black bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent mb-4 bengali-text">
                    শিখুন ও অনুশীলন করুন
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto bengali-text">
                    প্রতিটি টপিকে গভীর জ্ঞান অর্জন করুন এবং ব্যবহারিক অভিজ্ঞতা নিন
                </p>
            </div>

            @if($chapter->topics->count() > 0)
            <!-- Topics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($chapter->topics as $index => $topic)
                <div class="group relative">
                    <!-- Animated Border -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary/50 via-emerald-500/50 to-blue-500/50 rounded-3xl blur opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                    
                    <!-- Main Card -->
                    <a href="{{ route('model-tests') }}?topic={{ $topic->id }}" class="relative block bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/20 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden group-hover:scale-[1.02] group-hover:-translate-y-1">
                        <!-- Card Header with Gradient -->
                        <div class="relative p-6 pb-4
                            @if($topic->type === 'theory') bg-gradient-to-br from-blue-500/10 to-blue-600/5
                            @elseif($topic->type === 'practical') bg-gradient-to-br from-green-500/10 to-green-600/5
                            @elseif($topic->type === 'programming') bg-gradient-to-br from-purple-500/10 to-purple-600/5
                            @elseif($topic->type === 'database') bg-gradient-to-br from-orange-500/10 to-orange-600/5
                            @elseif($topic->type === 'networking') bg-gradient-to-br from-red-500/10 to-red-600/5
                            @elseif($topic->type === 'hardware') bg-gradient-to-br from-gray-500/10 to-gray-600/5
                            @else bg-gradient-to-br from-slate-500/10 to-slate-600/5
                            @endif">
                            
                            <!-- Topic Index -->
                            <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 dark:bg-slate-800/20 backdrop-blur-sm flex items-center justify-center">
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ $index + 1 }}</span>
                            </div>

                            <!-- Icon -->
                            <div class="w-14 h-14 rounded-2xl mb-4 flex items-center justify-center
                                @if($topic->type === 'theory') bg-gradient-to-br from-blue-500 to-blue-600
                                @elseif($topic->type === 'practical') bg-gradient-to-br from-green-500 to-green-600
                                @elseif($topic->type === 'programming') bg-gradient-to-br from-purple-500 to-purple-600
                                @elseif($topic->type === 'database') bg-gradient-to-br from-orange-500 to-orange-600
                                @elseif($topic->type === 'networking') bg-gradient-to-br from-red-500 to-red-600
                                @elseif($topic->type === 'hardware') bg-gradient-to-br from-gray-500 to-gray-600
                                @else bg-gradient-to-br from-primary to-emerald-500
                                @endif
                                shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                <span class="material-symbols-outlined text-white text-2xl">
                                    @switch($topic->type)
                                        @case('theory') auto_stories @break
                                        @case('practical') build_circle @break  
                                        @case('programming') code @break
                                        @case('database') database @break
                                        @case('networking') hub @break
                                        @case('hardware') memory @break
                                        @default topic @break
                                    @endswitch
                                </span>
                            </div>

                            <!-- Type Badge -->
                            <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold mb-3
                                @if($topic->type === 'theory') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200
                                @elseif($topic->type === 'practical') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200
                                @elseif($topic->type === 'programming') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200
                                @elseif($topic->type === 'database') bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-200
                                @elseif($topic->type === 'networking') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200
                                @elseif($topic->type === 'hardware') bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-200
                                @else bg-slate-100 text-slate-800 dark:bg-slate-900/50 dark:text-slate-200
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($topic->type === 'theory') bg-blue-500
                                    @elseif($topic->type === 'practical') bg-green-500
                                    @elseif($topic->type === 'programming') bg-purple-500
                                    @elseif($topic->type === 'database') bg-orange-500
                                    @elseif($topic->type === 'networking') bg-red-500
                                    @elseif($topic->type === 'hardware') bg-gray-500
                                    @else bg-primary
                                    @endif"></span>
                                @switch($topic->type)
                                    @case('theory') তত্ত্বীয় বিষয় @break
                                    @case('practical') ব্যবহারিক প্রয়োগ @break
                                    @case('programming') প্রোগ্রামিং @break
                                    @case('database') ডেটাবেস @break
                                    @case('networking') নেটওয়ার্কিং @break
                                    @case('hardware') হার্ডওয়্যার @break
                                    @default সাধারণ বিষয় @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="px-6 pb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight bengali-text group-hover:text-primary transition-colors">
                                {{ $topic->name }}
                            </h3>
                            
                            @if($topic->name_en)
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-3 font-medium">{{ $topic->name_en }}</p>
                            @endif

                            @if($topic->description)
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4 bengali-text">
                                {{ Str::limit($topic->description, 120) }}
                            </p>
                            @endif

                            <!-- Difficulty and Progress -->
                            <div class="flex items-center justify-between">
                                <!-- Difficulty Stars -->
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-sm {{ $i <= $topic->difficulty_level ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600' }}">star</span>
                                    @endfor
                                    <span class="text-xs text-slate-500 dark:text-slate-400 ml-1 bengali-text">
                                        @if($topic->difficulty_level <= 2) সহজ
                                        @elseif($topic->difficulty_level <= 4) মাধ্যম
                                        @else কঠিন
                                        @endif
                                    </span>
                                </div>

                                <!-- Question Count -->
                                <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-sm">quiz</span>
                                    <span class="bengali-text">{{ $topic->questions->count() }} প্রশ্ন</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Effect Arrow -->
                        <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center opacity-0 group-hover:opacity-100 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- CTA Section -->
            <div class="mt-20 text-center">
                <div class="bg-gradient-to-r from-primary/10 via-emerald-500/10 to-blue-500/10 rounded-3xl border border-primary/20 backdrop-blur-sm p-8 md:p-12">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-4 bengali-text">
                        প্রস্তুত হয়ে গেছেন?
                    </h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 bengali-text">
                        এখনই এই অধ্যায়ের পূর্ণাঙ্গ মডেল টেস্টে অংশ নিন
                    </p>
                    <a href="{{ route('model-tests') }}?chapter={{ $chapter->id }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-emerald-500 text-white font-bold rounded-2xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/40 hover:scale-105 transition-all duration-300">
                        <span class="material-symbols-outlined text-xl">rocket_launch</span>
                        <span class="bengali-text">সম্পূর্ণ অধ্যায়ের টেস্ট দিন</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                </div>
            </div>

            @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="relative mx-auto w-32 h-32 mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 rounded-full animate-pulse"></div>
                    <div class="relative w-full h-full rounded-full bg-gradient-to-br from-white to-slate-100 dark:from-slate-800 dark:to-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-400 text-6xl">construction</span>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 bengali-text">এই অধ্যায় এখনো প্রস্তুত হচ্ছে</h3>
                <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 bengali-text">আমরা খুব শীঘ্রই এই অধ্যায়ের সকল টপিক যোগ করব।</p>
                <a href="{{ route('chapters') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span class="bengali-text">অন্য অধ্যায় দেখুন</span>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- User Progress & Statistics -->
    @if(isset($chapter->user_progress))
    <section class="relative py-20 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-emerald-500/5 to-blue-500/5"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3e%3cg fill="none" fill-rule="evenodd"%3e%3cg fill="%2329d486" fill-opacity="0.1"%3e%3ccircle cx="30" cy="30" r="1.5"/%3e%3c/g%3e%3c/g%3e%3c/svg%3e')] dark:bg-[url('data:image/svg+xml,%3csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3e%3cg fill="none" fill-rule="evenodd"%3e%3cg fill="%2329d486" fill-opacity="0.05"%3e%3ccircle cx="30" cy="30" r="1.5"/%3e%3c/g%3e%3c/g%3e%3c/svg%3e')]"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-primary/10 to-emerald-500/10 border border-primary/20 backdrop-blur-sm mb-6">
                    <span class="material-symbols-outlined text-primary text-lg">trending_up</span>
                    <span class="text-primary font-semibold bengali-text">আপনার অগ্রগতি</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-4 bengali-text">
                    দুর্দান্ত! আপনি এগিয়ে চলেছেন
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto bengali-text">
                    আপনার শেখার যাত্রার বিস্তারিত পরিসংখ্যান দেখুন
                </p>
            </div>

            <!-- Main Progress Card -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/20 shadow-2xl p-8 md:p-12 mb-12">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Progress Circle -->
                    <div class="text-center lg:text-left">
                        <div class="relative inline-block">
                            <!-- Large Progress Circle -->
                            <div class="relative w-48 h-48 mx-auto lg:mx-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                    <!-- Background Circle -->
                                    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-slate-200 dark:text-slate-700"/>
                                    <!-- Progress Circle -->
                                    <circle cx="50" cy="50" r="45" fill="none" stroke="url(#progressGradient)" stroke-width="8" stroke-linecap="round" 
                                            stroke-dasharray="282.7" stroke-dashoffset="{{ 282.7 - (282.7 * $chapter->user_progress->completion_percentage / 100) }}"
                                            class="transition-all duration-1000 ease-out"/>
                                    <!-- Gradient Definition -->
                                    <defs>
                                        <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#1dedb9;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#10b981;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <!-- Percentage Text -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="text-4xl font-black text-primary">{{ round($chapter->user_progress->completion_percentage) }}</span>
                                        <span class="text-2xl font-bold text-primary">%</span>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium bengali-text mt-1">সম্পূর্ণ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement Text -->
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-4 bengali-text">
                            @if($chapter->user_progress->completion_percentage >= 80)
                                🎉 অসাধারণ অগ্রগতি!
                            @elseif($chapter->user_progress->completion_percentage >= 50)
                                👏 দুর্দান্ত কাজ চালিয়ে যান!
                            @elseif($chapter->user_progress->completion_percentage >= 25)
                                💪 শুরুটা ভাল হয়েছে!
                            @else
                                🚀 চমৎকার শুরু!
                            @endif
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-6 bengali-text">
                            আপনি এই অধ্যায়ে {{ round($chapter->user_progress->completion_percentage) }}% সম্পূর্ণ করেছেন। 
                            @if($chapter->user_progress->completion_percentage < 100)
                                বাকি অংশ শেষ করতে আরো অনুশীলন করুন।
                            @else
                                অভিনন্দন! আপনি এই অধ্যায় সম্পূর্ণ করেছেন।
                            @endif
                        </p>
                        
                        <!-- Next Action -->
                        @if($chapter->user_progress->completion_percentage < 100)
                        <a href="{{ route('model-tests') }}?chapter={{ $chapter->id }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <span class="material-symbols-outlined">play_arrow</span>
                            <span class="bengali-text">অনুশীলন চালিয়ে যান</span>
                        </a>
                        @else
                        <a href="{{ route('chapters') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <span class="material-symbols-outlined">emoji_events</span>
                            <span class="bengali-text">নতুন অধ্যায় শুরু করুন</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Attempts -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/50 to-blue-600/50 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-xl border border-white/20 dark:border-slate-700/20 shadow-lg p-6 text-center group-hover:scale-105 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">quiz</span>
                        </div>
                        <p class="text-3xl font-black text-blue-600 mb-2">{{ $chapter->user_progress->total_attempts }}</p>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 bengali-text">মোট চেষ্টা</p>
                    </div>
                </div>

                <!-- Accuracy Rate -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500/50 to-emerald-600/50 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-xl border border-white/20 dark:border-slate-700/20 shadow-lg p-6 text-center group-hover:scale-105 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">target</span>
                        </div>
                        <p class="text-3xl font-black text-emerald-600 mb-2">{{ round($chapter->user_progress->accuracy_rate) }}%</p>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 bengali-text">নির্ভুলতার হার</p>
                    </div>
                </div>

                <!-- Current Streak -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-orange-500/50 to-orange-600/50 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-xl border border-white/20 dark:border-slate-700/20 shadow-lg p-6 text-center group-hover:scale-105 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">local_fire_department</span>
                        </div>
                        <p class="text-3xl font-black text-orange-600 mb-2">{{ $chapter->user_progress->streak_count }}</p>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 bengali-text">দিনের স্ট্রিক</p>
                    </div>
                </div>

                <!-- Study Time -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-500/50 to-purple-600/50 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-xl border border-white/20 dark:border-slate-700/20 shadow-lg p-6 text-center group-hover:scale-105 transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">schedule</span>
                        </div>
                        <p class="text-3xl font-black text-purple-600 mb-2">{{ round(($chapter->user_progress->total_attempts * 2.5)) }}</p>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 bengali-text">মিনিট অধ্যয়ন</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection