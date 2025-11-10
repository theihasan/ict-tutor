@extends('layouts.app')

@section('title', 'টেস্ট প্রিভিউ - ' . $preview['test']->title . ' - HSC ICT Interactive')
@section('description', $preview['test']->description ?? 'HSC ICT টেস্ট প্রিভিউ এবং প্রস্তুতি নিন।')

@section('content')
<main class="flex-grow" x-data="testPreview()">
<div class="max-w-4xl mx-auto px-4 py-6">

<!-- Test Info Header -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 mb-6">
<div class="text-center">
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text mb-2">{{ $preview['test']->title }}</h1>
@if($preview['test']->chapter)
<p class="text-lg text-slate-600 dark:text-slate-400 bengali-text mb-4">{{ $preview['test']->chapter->name }}</p>
@endif
<div class="flex items-center justify-center gap-6 text-sm text-slate-600 dark:text-slate-400">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-lg">quiz</span>
<span class="bengali-text">{{ $preview['metadata']['total_questions'] }} টি প্রশ্ন</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-lg">timer</span>
<span class="bengali-text">{{ $preview['metadata']['duration'] }} মিনিট</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-lg">grade</span>
<span class="bengali-text">{{ $preview['metadata']['total_marks'] }} মার্ক</span>
</div>
</div>
</div>
</div>

<!-- Test Details -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

<!-- Test Information -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text mb-4">টেস্টের তথ্য</h3>
<div class="space-y-3">
<div class="flex justify-between items-center">
<span class="text-slate-600 dark:text-slate-400 bengali-text">টাইপ:</span>
<span class="font-medium text-[#0d1b18] dark:text-white bengali-text">{{ $preview['test']->type_text }}</span>
</div>
<div class="flex justify-between items-center">
<span class="text-slate-600 dark:text-slate-400 bengali-text">সময়সীমা:</span>
<span class="font-medium text-[#0d1b18] dark:text-white bengali-text">{{ $preview['metadata']['duration'] }} মিনিট</span>
</div>
<div class="flex justify-between items-center">
<span class="text-slate-600 dark:text-slate-400 bengali-text">পাসিং মার্ক:</span>
<span class="font-medium text-[#0d1b18] dark:text-white bengali-text">{{ $preview['test']->passing_marks ?? 40 }}%</span>
</div>
@if(isset($preview['metadata']['difficulty_info']['average_difficulty']))
<div class="flex justify-between items-center">
<span class="text-slate-600 dark:text-slate-400 bengali-text">গড় কঠিনতা:</span>
<span class="font-medium text-[#0d1b18] dark:text-white bengali-text">{{ $preview['metadata']['difficulty_info']['average_difficulty'] }}</span>
</div>
@endif
</div>
</div>

<!-- Test Settings -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text mb-4">টেস্টের নিয়মাবলী</h3>
<div class="space-y-3 text-sm">
<div class="flex items-center gap-3">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
<span class="text-slate-700 dark:text-slate-300 bengali-text">
@if($preview['settings']['allow_navigation']) প্রশ্নের মধ্যে আগে-পিছে যাওয়া যাবে @else প্রশ্নের মধ্যে আগে-পিছে যাওয়া যাবে না @endif
</span>
</div>
<div class="flex items-center gap-3">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
<span class="text-slate-700 dark:text-slate-300 bengali-text">
@if($preview['settings']['auto_save_answers']) উত্তর স্বয়ংক্রিয়ভাবে সংরক্ষিত হবে @else উত্তর ম্যানুয়াল সংরক্ষণ করতে হবে @endif
</span>
</div>
@if($preview['settings']['negative_marking'])
<div class="flex items-center gap-3">
<span class="w-2 h-2 rounded-full bg-red-500"></span>
<span class="text-slate-700 dark:text-slate-300 bengali-text">নেগেটিভ মার্কিং রয়েছে ({{ $preview['settings']['negative_marks_per_question'] }} মার্ক কাটা হবে)</span>
</div>
@endif
@if($preview['settings']['enable_ai_hints'])
<div class="flex items-center gap-3">
<span class="w-2 h-2 rounded-full bg-blue-500"></span>
<span class="text-slate-700 dark:text-slate-300 bengali-text">AI সাহায্য উপলব্ধ</span>
</div>
@endif
</div>
</div>

</div>

@if($preview['instructions'])
<!-- Instructions -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 mb-6">
<h3 class="text-lg font-bold text-[#0d1b18] dark:text-white bengali-text mb-4">নির্দেশনাবলী</h3>
<div class="prose prose-slate dark:prose-invert max-w-none bengali-text">
{!! nl2br(e($preview['instructions'])) !!}
</div>
</div>
@endif

<!-- Action Buttons -->
<div class="text-center">
<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <button @click="startTest()" class="flex h-12 cursor-pointer items-center justify-center gap-2 rounded-lg bg-green-500 hover:bg-green-600 px-8 text-lg font-bold text-white transition-all shadow-md bengali-text">
<span class="material-symbols-outlined text-xl">play_arrow</span>
<span>পরীক্ষা শুরু করুন</span>
</button>
<a href="{{ route('model-tests') }}" class="flex h-12 cursor-pointer items-center justify-center gap-2 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 px-8 text-lg font-bold text-[#0d1b18] dark:text-white transition-all bengali-text">
<span class="material-symbols-outlined text-xl">arrow_back</span>
<span>ফিরে যান</span>
</a>
</div>
<p class="text-sm text-slate-500 dark:text-slate-400 mt-4 bengali-text">
পরীক্ষা শুরুর পর সময় গণনা শুরু হয়ে যাবে। নিশ্চিত হয়ে শুরু করুন।
</p>
</div>

</div>
</main>

<script>
function testPreview() {
    return {
        async startTest() {
            const confirmStart = confirm('আপনি কি পরীক্ষা শুরু করতে চান? শুরুর পর সময় গণনা শুরু হয়ে যাবে।');
            if (!confirmStart) {
                return;
            }
            
            try {
                const response = await fetch(`/tests/{{ $preview['test']->id }}/start`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.href = result.redirect_url;
                } else {
                    alert('পরীক্ষা শুরু করতে সমস্যা হয়েছে: ' + result.message);
                }
            } catch (error) {
                console.error('Error starting test:', error);
                alert('পরীক্ষা শুরু করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
            }
        }
    }
}
</script>
@endsection