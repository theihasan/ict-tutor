@extends('layouts.app')

@section('title', $chapter->name . ' - অধ্যায় বিস্তারিত - HSC ICT Interactive')

@section('description', 'HSC ICT ' . $chapter->name . ' অধ্যায়ের সকল টপিক এবং প্র্যাকটিস উপকরণ। ' . ($chapter->description ?? ''))

@section('keywords', 'HSC ICT ' . $chapter->name . ', ' . ($chapter->name_en ?? '') . ', বাংলাদেশ, শিক্ষা, প্রোগ্রামিং')

@section('og:title', $chapter->name . ' - অধ্যায় বিস্তারিত - HSC ICT Interactive')

@section('og:description', 'HSC ICT ' . $chapter->name . ' অধ্যায়ের সকল টপিক এবং প্র্যাকটিস উপকরণ।')

@section('og:url', route('chapter.show', $chapter->id))

@section('content')
<div class="flex flex-col items-center flex-1">
    <!-- Page Header -->
    <section class="w-full py-12 md:py-16 bg-gradient-to-b from-primary/5 to-background-light dark:from-primary/10 dark:to-background-dark">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <!-- Back Navigation -->
                <div class="mb-6">
                    <a href="{{ route('chapters') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="font-medium bengali-text">সকল অধ্যায়ে ফিরে যান</span>
                    </a>
                </div>

                <!-- Chapter Header -->
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-4xl">{{ $chapter->icon ?? 'menu_book' }}</span>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-semibold text-primary bengali-text">অধ্যায় {{ $chapter->order }}</p>
                        <h1 class="text-[#0d1b18] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-tight bengali-text">
                            {{ $chapter->name }}
                        </h1>
                        @if($chapter->name_en)
                        <p class="text-slate-600 dark:text-slate-400 text-lg mt-1">{{ $chapter->name_en }}</p>
                        @endif
                    </div>
                </div>

                @if($chapter->description)
                <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg leading-relaxed max-w-3xl mx-auto bengali-text">
                    {{ $chapter->description }}
                </p>
                @endif

                <!-- Progress Bar (if user has progress) -->
                @if(isset($chapter->user_progress) && $chapter->user_progress->completion_percentage > 0)
                <div class="mt-8 max-w-md mx-auto">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">সম্পূর্ণতা</span>
                        <span class="text-sm font-bold text-primary">{{ round($chapter->user_progress->completion_percentage) }}%</span>
                    </div>
                    <div class="w-full h-3 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all duration-300" style="width: {{ $chapter->user_progress->completion_percentage }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Topics Section -->
    <section class="w-full py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#0d1b18] dark:text-white mb-4 bengali-text">
                    এই অধ্যায়ের টপিকসমূহ
                </h2>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">
                    যে টপিকে প্র্যাকটিস করতে চান, সেটিতে ক্লিক করুন
                </p>
            </div>

            @if($chapter->topics->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($chapter->topics as $topic)
                <a href="{{ route('model-tests') }}?topic={{ $topic->id }}" class="group flex flex-col gap-4 rounded-xl border border-primary/20 bg-white dark:bg-slate-900/50 p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:border-primary hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($topic->type === 'theory') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                    @elseif($topic->type === 'practical') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                                    @elseif($topic->type === 'programming') bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300
                                    @elseif($topic->type === 'database') bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300
                                    @elseif($topic->type === 'networking') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                                    @elseif($topic->type === 'hardware') bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300
                                    @else bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-300
                                    @endif">
                                    @switch($topic->type)
                                        @case('theory')
                                            তত্ত্ব
                                            @break
                                        @case('practical')
                                            প্রয়োগ
                                            @break
                                        @case('programming')
                                            প্রোগ্রামিং
                                            @break
                                        @case('database')
                                            ডেটাবেস
                                            @break
                                        @case('networking')
                                            নেটওয়ার্কিং
                                            @break
                                        @case('hardware')
                                            হার্ডওয়্যার
                                            @break
                                        @default
                                            সাধারণ
                                    @endswitch
                                </span>
                                
                                <!-- Difficulty Level -->
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-xs {{ $i <= $topic->difficulty_level ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}">star</span>
                                    @endfor
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-[#0d1b18] dark:text-white mb-2 leading-snug bengali-text">{{ $topic->name }}</h3>
                            @if($topic->name_en)
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">{{ $topic->name_en }}</p>
                            @endif
                            @if($topic->description)
                            <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">{{ Str::limit($topic->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-primary text-2xl">
                                @switch($topic->type)
                                    @case('theory')
                                        book
                                        @break
                                    @case('practical')
                                        build
                                        @break
                                    @case('programming')
                                        code
                                        @break
                                    @case('database')
                                        database
                                        @break
                                    @case('networking')
                                        hub
                                        @break
                                    @case('hardware')
                                        memory
                                        @break
                                    @default
                                        topic
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200 dark:border-slate-800">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">প্র্যাকটিস শুরু করুন</span>
                        <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-slate-400 text-4xl">topic</span>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 bengali-text">এই অধ্যায়ে কোন টপিক নেই</h3>
                <p class="text-slate-600 dark:text-slate-400 bengali-text">শীঘ্রই নতুন টপিক যোগ করা হবে।</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('model-tests') }}?chapter={{ $chapter->id }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-semibold rounded-xl transition-all duration-300 hover:bg-primary/90 hover:shadow-lg">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="bengali-text">মডেল টেস্ট শুরু করুন</span>
                </a>
                @if($chapter->topics->count() > 0)
                <a href="{{ route('model-tests') }}?topic={{ $chapter->topics->first()->id }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-primary text-primary font-semibold rounded-xl transition-all duration-300 hover:bg-primary/5">
                    <span class="material-symbols-outlined">play_arrow</span>
                    <span class="bengali-text">প্রথম টপিক শুরু করুন</span>
                </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Chapter Statistics (if available) -->
    @if(isset($chapter->user_progress))
    <section class="w-full py-12 md:py-16 bg-slate-50 dark:bg-slate-900/30">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-[#0d1b18] dark:text-white mb-8 bengali-text">আপনার অগ্রগতি</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-primary">percent</span>
                    </div>
                    <p class="text-2xl font-bold text-primary mb-1">{{ round($chapter->user_progress->completion_percentage) }}%</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সম্পূর্ণ</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-primary">quiz</span>
                    </div>
                    <p class="text-2xl font-bold text-primary mb-1">{{ $chapter->user_progress->total_attempts }}</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">চেষ্টা</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-primary">target</span>
                    </div>
                    <p class="text-2xl font-bold text-primary mb-1">{{ round($chapter->user_progress->accuracy_rate) }}%</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">নির্ভুলতা</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-primary">local_fire_department</span>
                    </div>
                    <p class="text-2xl font-bold text-primary mb-1">{{ $chapter->user_progress->streak_count }}</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">স্ট্রিক</p>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection