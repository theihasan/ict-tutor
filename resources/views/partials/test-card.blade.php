<!-- Test Card Component -->
<div class="group flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl border 
    @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
        border-green-500/20 hover:border-green-500 hover:shadow-green-500/10
    @elseif(!$test->is_public)
        border-amber-500/20 hover:border-amber-500 hover:shadow-amber-500/10
    @else
        border-primary/20 hover:border-primary hover:shadow-primary/10
    @endif
    bg-white dark:bg-slate-900/50 p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
    
    <div class="flex items-center gap-4 flex-1 w-full">
        <!-- Test Icon -->
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl 
            @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
                bg-green-500/10 text-green-500 group-hover:bg-green-500/20
            @elseif(!$test->is_public)
                bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400
            @else
                bg-primary/10 text-primary group-hover:bg-primary/20
            @endif
            transition-colors">
            @if($test->user_progress && $test->user_progress->is_attempted && $test->user_progress->completion_status === 'passed')
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            @elseif(!$test->is_public)
                <span class="material-symbols-outlined text-2xl">lock</span>
            @else
                <span class="material-symbols-outlined text-2xl">description</span>
            @endif
        </div>
        
        <!-- Test Details -->
        <div class="flex flex-col flex-1">
            <h4 class="text-base font-bold text-[#0d1b18] dark:text-white mb-1 bengali-text">{{ $test->title }}</h4>
            
            <!-- Status Badge -->
            @if($test->user_progress && $test->user_progress->is_attempted)
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full 
                        @if($test->user_progress->completion_status === 'passed')
                            bg-green-500/10 text-green-600 dark:text-green-400
                        @else
                            bg-red-500/10 text-red-600 dark:text-red-400
                        @endif
                        text-xs font-bold">
                        <span class="material-symbols-outlined text-sm">
                            @if($test->user_progress->completion_status === 'passed')
                                check_circle
                            @else
                                cancel
                            @endif
                        </span>
                        {{ $test->user_progress->best_score }}/{{ $test->total_marks }} ({{ number_format($test->user_progress->best_percentage, 0) }}%)
                    </span>
                </div>
            @elseif(!$test->is_public)
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-bold bengali-text">
                        <span class="material-symbols-outlined text-sm">workspace_premium</span>
                        প্রিমিয়াম
                    </span>
                </div>
            @endif
            
            <!-- Test Meta Info -->
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-600 dark:text-slate-400 bengali-text">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">quiz</span>
                    {{ $test->total_questions }}টি প্রশ্ন
                </span>
                @if($test->duration)
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $test->duration }} মিনিট
                </span>
                @endif
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">grade</span>
                    পূর্ণমান: {{ $test->total_marks }}
                </span>
                @if($showChapter && $test->chapter)
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">book</span>
                    {{ $test->chapter->name }}
                </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="w-full md:w-auto">
        @if(!$test->is_public)
            <!-- Premium Test -->
            <button class="flex h-10 w-full md:min-w-[120px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-4 text-sm font-bold text-white hover:from-amber-600 hover:to-amber-700 transition-all shadow-md shadow-amber-500/30 bengali-text">
                <span class="material-symbols-outlined text-base">workspace_premium</span>
                <span>আনলক</span>
            </button>
        @elseif($test->user_progress && $test->user_progress->is_attempted)
            <!-- Completed Test -->
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <button onclick="startTest('{{ $test->title }}', {{ $test->id }}, {{ $test->total_questions }}, {{ $test->duration ?? 25 }})" class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary/10 hover:bg-primary/20 px-4 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[100px] bengali-text">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    <span>পুনরায়</span>
                </button>
                <button onclick="viewReport({{ $test->id }})" class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg border border-primary/30 hover:bg-primary/5 px-4 text-sm font-bold text-[#0d1b18] dark:text-white transition-all min-w-[100px] bengali-text">
                    <span class="material-symbols-outlined text-base">bar_chart</span>
                    <span>রিপোর্ট</span>
                </button>
            </div>
        @else
            <!-- New Test -->
            <button onclick="startTest('{{ $test->title }}', {{ $test->id }}, {{ $test->total_questions }}, {{ $test->duration ?? 25 }})" class="flex h-10 w-full md:min-w-[120px] cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-[#0d1b18] hover:bg-opacity-90 transition-all shadow-md shadow-primary/20 bengali-text">
                <span>শুরু করুন</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
        @endif
    </div>
</div>