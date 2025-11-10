@extends('layouts.app')

@section('title', 'টেস্ট রিপোর্ট - ' . ($test->title ?? 'Unknown Test') . ' - HSC ICT Interactive')
@section('description', 'HSC ICT টেস্টের বিস্তারিত পরিসংখ্যান এবং পারফরম্যান্স বিশ্লেষণ দেখুন।')

@section('content')
<main class="flex-grow">
<div class="max-w-6xl mx-auto px-4 py-6">

<!-- Report Header -->
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 bg-blue-500/10 text-blue-600">
        <span class="material-symbols-outlined text-3xl">analytics</span>
    </div>
    <h1 class="text-3xl font-bold text-[#0d1b18] dark:text-white bengali-text mb-2">টেস্ট রিপোর্ট</h1>
    <p class="text-lg text-slate-600 dark:text-slate-400 bengali-text">{{ $test->title ?? 'Unknown Test' }}</p>
    @if($test->chapter)
        <p class="text-sm text-slate-500 dark:text-slate-500 bengali-text">{{ $test->chapter->name ?? 'Unknown Chapter' }}</p>
    @endif
</div>

<!-- Basic Statistics -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-[#0d1b18] dark:text-white">{{ $reportData['basic_stats']['total_attempts'] }}</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">মোট চেষ্টা</div>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-[#0d1b18] dark:text-white">{{ $reportData['basic_stats']['unique_users'] }}</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">অংশগ্রহণকারী</div>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">{{ number_format($reportData['basic_stats']['average_percentage'], 1) }}%</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">গড় স্কোর</div>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ $reportData['basic_stats']['passed_attempts'] }}</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">পাস</div>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ number_format($reportData['basic_stats']['pass_rate'], 1) }}%</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">পাসের হার</div>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">{{ number_format($reportData['time_analysis']['average_time'], 1) }}</div>
        <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text">গড় সময় (মিনিট)</div>
    </div>
</div>

<!-- Performance Distribution -->
<div class="grid md:grid-cols-2 gap-6 mb-8">
    <!-- Score Distribution -->
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text mb-4">স্কোর বিতরণ</h3>
        <div class="space-y-3">
            @foreach($reportData['performance_stats']['score_distribution'] as $range => $count)
            @php
                $percentage = $reportData['basic_stats']['total_attempts'] > 0 ? ($count / $reportData['basic_stats']['total_attempts']) * 100 : 0;
            @endphp
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $range }}</span>
                <div class="flex items-center space-x-2 flex-1 mx-4">
                    <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-[#0d1b18] dark:text-white">{{ $count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Time Distribution -->
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text mb-4">সময় বিতরণ</h3>
        <div class="space-y-3">
            @foreach($reportData['time_analysis']['time_distribution'] as $range => $count)
            @php
                $percentage = $reportData['basic_stats']['total_attempts'] > 0 ? ($count / $reportData['basic_stats']['total_attempts']) * 100 : 0;
            @endphp
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-600 dark:text-slate-400 bengali-text">{{ $range }}</span>
                <div class="flex items-center space-x-2 flex-1 mx-4">
                    <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-[#0d1b18] dark:text-white">{{ $count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Top Performers -->
@if(count($reportData['user_distribution']['top_performers']) > 0)
<div class="mb-8">
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text mb-4">শীর্ষ পারফরমার</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-2 text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">নাম</th>
                        <th class="text-center py-2 text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">সর্বোচ্চ স্কোর</th>
                        <th class="text-center py-2 text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">চেষ্টার সংখ্যা</th>
                        <th class="text-right py-2 text-sm font-medium text-slate-600 dark:text-slate-400 bengali-text">শেষ চেষ্টা</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['user_distribution']['top_performers'] as $performer)
                    <tr class="border-b border-slate-100 dark:border-slate-800 last:border-b-0">
                        <td class="py-3 text-sm text-[#0d1b18] dark:text-white">{{ $performer['user_name'] }}</td>
                        <td class="py-3 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($performer['best_score'] >= 80) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($performer['best_score'] >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                {{ number_format($performer['best_score'], 1) }}%
                            </span>
                        </td>
                        <td class="py-3 text-center text-sm text-slate-600 dark:text-slate-400">{{ $performer['attempts_count'] }}</td>
                        <td class="py-3 text-right text-sm text-slate-600 dark:text-slate-400">
                            {{ \Carbon\Carbon::parse($performer['latest_attempt'])->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Question Analysis -->
@if($reportData['question_analysis']['total_questions'] > 0)
<div class="mb-8">
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text mb-4">প্রশ্ন বিশ্লেষণ</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 bengali-text mb-4">সবচেয়ে কঠিন প্রশ্নগুলো (কম সঠিক হারের ভিত্তিতে)</p>
        <div class="space-y-3">
            @foreach(array_slice($reportData['question_analysis']['question_stats'], 0, 10) as $question)
            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                <div class="flex-1">
                    <p class="text-sm text-[#0d1b18] dark:text-white">{{ Str::limit($question['question_text'], 60) }}</p>
                    <div class="flex items-center space-x-4 mt-1">
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $question['correct_answers'] }}/{{ $question['total_answers'] }} সঠিক
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($question['difficulty_level'] === 'easy') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif($question['difficulty_level'] === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                            {{ is_string($question['difficulty_level']) ? ucfirst($question['difficulty_level']) : $question['difficulty_level']->value ?? 'Medium' }}
                        </span>
                    </div>
                </div>
                <div class="ml-4 text-right">
                    <div class="text-sm font-medium 
                        @if($question['accuracy_rate'] >= 80) text-green-600
                        @elseif($question['accuracy_rate'] >= 60) text-yellow-600
                        @else text-red-600 @endif">
                        {{ number_format($question['accuracy_rate'], 1) }}%
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 bengali-text">সঠিক হার</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Recent Attempts -->
@if(count($reportData['user_distribution']['recent_attempts']) > 0)
<div class="mb-8">
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text mb-4">সাম্প্রতিক চেষ্টা</h3>
        <div class="space-y-3">
            @foreach($reportData['user_distribution']['recent_attempts'] as $attempt)
            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                            {{ substr($attempt['user_name'], 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#0d1b18] dark:text-white">{{ $attempt['user_name'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            {{ \Carbon\Carbon::parse($attempt['completed_at'])->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if($attempt['time_taken'])
                    <div class="text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 bengali-text">সময়</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">{{ $attempt['time_taken'] }} মিনিট</div>
                    </div>
                    @endif
                    <div class="text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 bengali-text">স্কোর</div>
                        <div class="text-sm font-medium 
                            @if($attempt['score'] >= 80) text-green-600
                            @elseif($attempt['score'] >= 60) text-yellow-600
                            @else text-red-600 @endif">
                            {{ number_format($attempt['score'], 1) }}%
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- No Data Message -->
@if($reportData['basic_stats']['total_attempts'] == 0)
<div class="text-center py-12">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 bg-slate-100 dark:bg-slate-800 text-slate-400">
        <span class="material-symbols-outlined text-3xl">analytics</span>
    </div>
    <h3 class="text-lg font-medium text-slate-900 dark:text-white bengali-text mb-2">কোনো ডেটা পাওয়া যায়নি</h3>
    <p class="text-slate-600 dark:text-slate-400 bengali-text">এই টেস্টে এখনো কেউ অংশগ্রহণ করেনি।</p>
</div>
@endif

<!-- Action Buttons -->
<div class="flex justify-center space-x-4 mt-8">
    <a href="{{ route('model-tests.show', $test->id) }}" 
       class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors bengali-text">
        <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
        টেস্টে ফিরে যান
    </a>
    <a href="{{ route('model-tests') }}" 
       class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors bengali-text">
        <span class="material-symbols-outlined text-sm mr-2">home</span>
        সব টেস্ট দেখুন
    </a>
</div>

</div>
</main>
@endsection