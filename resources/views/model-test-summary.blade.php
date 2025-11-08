@extends('layouts.app')

@section('title', 'পরীক্ষার ফলাফল - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT মডেল টেস্টের বিস্তারিত ফলাফল দেখুন। স্কোর, সঠিক উত্তর, ভুল উত্তর এবং উন্নতির জন্য পরামর্শ পান। আরও ভালো করার জন্য আবার চেষ্টা করুন।')
@section('keywords', 'HSC ICT পরীক্ষার ফলাফল, স্কোর, মূল্যায়ন, বিশ্লেষণ, বাংলাদেশ, শিক্ষা')
@section('author', 'HSC ICT Interactive Team')

@section('og:title', 'পরীক্ষার ফলাফল - HSC ICT Interactive')
@section('og:description', 'আপনার HSC ICT মডেল টেস্টের বিস্তারিত ফলাফল দেখুন। স্কোর, সঠিক উত্তর, ভুল উত্তর এবং উন্নতির জন্য পরামর্শ পান।')
@section('og:url', 'https://hscict.com/model-test-summary.html')
@section('og:image', 'https://hscict.com/images/result-og-image.jpg')
@section('og:image:alt', 'HSC ICT Interactive - পরীক্ষার ফলাফল পেজ')

@section('twitter:title', 'পরীক্ষার ফলাফল - HSC ICT Interactive')
@section('twitter:description', 'আপনার HSC ICT মডেল টেস্টের বিস্তারিত ফলাফল দেখুন। স্কোর, সঠিক উত্তর, ভুল উত্তর এবং উন্নতির জন্য পরামর্শ পান।')
@section('twitter:image', 'https://hscict.com/images/result-og-image.jpg')
@section('twitter:image:alt', 'HSC ICT Interactive - পরীক্ষার ফলাফল পেজ')

@section('content')
<main class="flex flex-col items-center flex-1 py-12">
<div class="max-w-4xl w-full px-4">

<!-- Success Header -->
<div class="text-center mb-8">
<div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-green-400 to-green-600 mb-4 shadow-lg shadow-green-500/30">
<span class="material-symbols-outlined text-white text-5xl">celebration</span>
</div>
<h1 class="text-4xl md:text-5xl font-black text-[#0d1b18] dark:text-white mb-3 bengali-text">
অভিনন্দন! আপনার পরীক্ষা সম্পন্ন
</h1>
<h2 class="text-xl md:text-2xl font-bold text-slate-700 dark:text-slate-300 mb-2 bengali-text">
মডেল টেস্ট ১ - সংখ্যা পদ্ধতি
</h2>
<p class="text-base text-slate-600 dark:text-slate-400 bengali-text">অধ্যায় ৩: সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস</p>
</div>

<!-- Performance Summary Card -->
<div class="bg-white dark:bg-slate-900/50 rounded-2xl shadow-2xl p-8 mb-8 border border-primary/20">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
<!-- Score Circle -->
<div class="flex justify-center">
<div class="relative w-56 h-56">
<!-- SVG Circle Progress -->
<svg class="transform -rotate-90 w-56 h-56">
<circle cx="112" cy="112" r="100" stroke="currentColor" stroke-width="12" fill="none" class="text-slate-200 dark:text-slate-800"/>
<circle cx="112" cy="112" r="100" stroke="currentColor" stroke-width="12" fill="none" stroke-dasharray="628" stroke-dashoffset="31.4" stroke-linecap="round" class="text-green-500 transition-all duration-1000"/>
</svg>
<!-- Score Text -->
<div class="absolute inset-0 flex flex-col items-center justify-center">
<p class="text-6xl font-black text-[#0d1b18] dark:text-white bengali-text">১৯<span class="text-3xl">/২০</span></p>
<div class="mt-2 px-4 py-1.5 rounded-full bg-green-500/20">
<p class="text-2xl font-bold text-green-600 dark:text-green-400">A+</p>
</div>
<p class="text-sm text-slate-600 dark:text-slate-400 mt-2 bengali-text">৯৫% স্কোর</p>
</div>
</div>
</div>

<!-- Stats List -->
<div class="space-y-4">
<div class="flex items-center gap-4 p-4 rounded-xl bg-green-500/10 border border-green-500/20">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center">
<span class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">check_circle</span>
</div>
<div class="flex-1">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সঠিক উত্তর</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">১৯টি</p>
</div>
</div>

<div class="flex items-center gap-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-red-500/20 flex items-center justify-center">
<span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">cancel</span>
</div>
<div class="flex-1">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">ভুল উত্তর</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">১টি</p>
</div>
</div>

<div class="flex items-center gap-4 p-4 rounded-xl bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
<span class="material-symbols-outlined text-slate-600 dark:text-slate-400 text-2xl">timer</span>
</div>
<div class="flex-1">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">সময় লেগেছে</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">২০ মিনিট</p>
</div>
</div>

<div class="flex items-center gap-4 p-4 rounded-xl bg-primary/10 border border-primary/20">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/20 flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-2xl">leaderboard</span>
</div>
<div class="flex-1">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">লিডারবোর্ডে স্থান</p>
<p class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">২৫<span class="text-lg">/৫০০</span></p>
</div>
</div>
</div>
</div>
</div>

<!-- Weak Areas Section -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl shadow-xl p-6 mb-8 border border-amber-500/20">
<div class="flex items-center gap-3 mb-4">
<div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center">
<span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-2xl">lightbulb</span>
</div>
<h3 class="text-xl font-bold text-[#0d1b18] dark:text-white bengali-text">উন্নতির সুযোগ</h3>
</div>
<div class="space-y-3">
<div class="flex items-center justify-between p-4 rounded-lg bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-amber-600 dark:text-amber-400">error</span>
<p class="text-[#0d1b18] dark:text-white font-medium bengali-text">২-এর পরিপূরক (2's Complement)</p>
</div>
<button class="px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold transition-colors bengali-text">
পুনরায় প্র্যাকটিস
</button>
</div>
</div>
<button class="mt-4 w-full flex items-center justify-center gap-2 h-12 px-6 text-base font-bold rounded-lg bg-primary/20 hover:bg-primary/30 text-[#0d1b18] dark:text-white transition-colors bengali-text">
<span class="material-symbols-outlined">bar_chart</span>
<span>বিস্তারিত রিপোর্ট দেখুন</span>
</button>
</div>

<!-- Social Share Section -->
<div class="bg-gradient-to-br from-primary/5 to-blue-500/5 dark:from-primary/10 dark:to-blue-500/10 rounded-xl shadow-lg p-6 mb-8 border border-primary/20">
<h3 class="text-xl font-bold text-[#0d1b18] dark:text-white text-center mb-5 bengali-text">আপনার সাফল্য শেয়ার করুন!</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
<button class="flex items-center justify-center gap-2 h-11 px-4 text-sm font-bold rounded-lg bg-[#1877F2] hover:bg-[#1565C0] text-white transition-colors shadow-md bengali-text">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v7.031C18.343 21.128 22 16.991 22 12z"/>
</svg>
<span>Facebook</span>
</button>
<button class="flex items-center justify-center gap-2 h-11 px-4 text-sm font-bold rounded-lg bg-[#25D366] hover:bg-[#1DA851] text-white transition-colors shadow-md bengali-text">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.38 1.25 4.82l-1.33 4.86 5-1.3c1.38.74 2.92 1.18 4.54 1.18h.01c5.46 0 9.91-4.45 9.91-9.91s-4.45-9.91-9.91-9.91z"/>
</svg>
<span>WhatsApp</span>
</button>
<button class="flex items-center justify-center gap-2 h-11 px-4 text-sm font-bold rounded-lg bg-[#1DA1F2] hover:bg-[#1A8CD8] text-white transition-colors shadow-md bengali-text">
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
<path d="M22.46 6c-.77.35-1.6.58-2.46.67.88-.53 1.56-1.37 1.88-2.38-.83.49-1.74.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.22-1.95-.55v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.21 0-.42-.01-.63.84-.6 1.56-1.36 2.14-2.23z"/>
</svg>
<span>Twitter</span>
</button>
<button class="flex items-center justify-center gap-2 h-11 px-4 text-sm font-bold rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-[#0d1b18] dark:text-white border border-slate-200 dark:border-slate-700 transition-colors shadow-md bengali-text">
<span class="material-symbols-outlined">link</span>
<span>লিঙ্ক কপি</span>
</button>
</div>
</div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
          <button onclick="window.location.href='{{ route('model-tests') }}'" class="flex items-center justify-center gap-2 h-12 px-6 text-base font-bold rounded-lg bg-green-500 hover:bg-green-600 text-white transition-all shadow-lg shadow-green-500/30 bengali-text">
            <span class="material-symbols-outlined">arrow_forward</span>
            <span>পরবর্তী মডেল টেস্ট</span>
          </button>
          <button onclick="window.location.href='{{ route('chapters') }}'" class="flex items-center justify-center gap-2 h-12 px-6 text-base font-bold rounded-lg bg-primary/20 hover:bg-primary/30 text-[#0d1b18] dark:text-white transition-colors bengali-text">
            <span class="material-symbols-outlined">home</span>
            <span>অধ্যায়ে ফিরে যান</span>
          </button>
        </div>

<!-- Additional Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<div class="text-center p-4 rounded-lg bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
<p class="text-3xl font-black text-primary mb-1 bengali-text">৯৫%</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">নির্ভুলতা</p>
</div>
<div class="text-center p-4 rounded-lg bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
<p class="text-3xl font-black text-blue-500 mb-1 bengali-text">৫</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">সম্পন্ন টেস্ট</p>
</div>
<div class="text-center p-4 rounded-lg bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
<p class="text-3xl font-black text-purple-500 mb-1">+50</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">পয়েন্ট অর্জিত</p>
</div>
<div class="text-center p-4 rounded-lg bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
<p class="text-3xl font-black text-orange-500 mb-1 bengali-text">৩</p>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">স্তর বৃদ্ধি</p>
</div>
</div>

</div>
</main>

@endsection

@push('scripts')
<script>
// Get URL parameters for test results
function getURLParams() {
  const urlParams = new URLSearchParams(window.location.search);
  return {
    testName: urlParams.get('test') || 'মডেল টেস্ট',
    testId: urlParams.get('id') || '1',
    score: parseInt(urlParams.get('score')) || 18,
    total: parseInt(urlParams.get('total')) || 20,
    timeTaken: parseInt(urlParams.get('time_taken')) || 1200 // seconds
  };
}

// Calculate percentage and grade
function calculateGrade(score, total) {
  const percentage = Math.round((score / total) * 100);
  let grade = 'F';
  if (percentage >= 95) grade = 'A+';
  else if (percentage >= 90) grade = 'A';
  else if (percentage >= 85) grade = 'A-';
  else if (percentage >= 80) grade = 'B+';
  else if (percentage >= 75) grade = 'B';
  else if (percentage >= 70) grade = 'B-';
  else if (percentage >= 65) grade = 'C+';
  else if (percentage >= 60) grade = 'C';
  else if (percentage >= 55) grade = 'D';
  
  return { percentage, grade };
}

// Initialize results page with URL parameters
function initializeResults() {
  const params = getURLParams();
  const { percentage, grade } = calculateGrade(params.score, params.total);
  const wrongAnswers = params.total - params.score;
  const timeInMinutes = Math.round(params.timeTaken / 60);

  // Update test name
  const testNameElement = document.querySelector('h2.text-xl.md\\:text-2xl.font-bold.text-slate-700.dark\\:text-slate-300.mb-2.bengali-text');
  if (testNameElement) {
    testNameElement.textContent = `মডেল টেস্ট ${params.testId} - ${params.testName}`;
  }

  // Update score display
  const scoreElement = document.querySelector('.text-6xl.font-black.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (scoreElement) {
    scoreElement.innerHTML = `${params.score}<span class="text-3xl">/${params.total}</span>`;
  }

  // Update grade
  const gradeElement = document.querySelector('.text-2xl.font-bold.text-green-600.dark\\:text-green-400');
  if (gradeElement) {
    gradeElement.textContent = grade;
  }

  // Update percentage
  const percentageElement = document.querySelector('.text-sm.text-slate-600.dark\\:text-slate-400.mt-2.bengali-text');
  if (percentageElement) {
    percentageElement.textContent = `${percentage}% স্কোর`;
  }

  // Update correct answers
  const correctElement = document.querySelector('.bg-green-500\\/10 .text-2xl.font-bold.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (correctElement) {
    correctElement.textContent = `${params.score}টি`;
  }

  // Update wrong answers
  const wrongElement = document.querySelector('.bg-red-500\\/10 .text-2xl.font-bold.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (wrongElement) {
    wrongElement.textContent = `${wrongAnswers}টি`;
  }

  // Update time taken
  const timeElement = document.querySelector('.bg-slate-100.dark\\:bg-slate-800\\/50 .text-2xl.font-bold.text-\\[\\#0d1b18\\].dark\\:text-white.bengali-text');
  if (timeElement) {
    timeElement.textContent = `${timeInMinutes} মিনিট`;
  }

  // Update progress circle (rough calculation)
  const progressCircle = document.querySelector('circle[stroke-dashoffset]');
  if (progressCircle) {
    const circumference = 628; // 2 * π * 100
    const offset = circumference - (circumference * percentage / 100);
    progressCircle.setAttribute('stroke-dashoffset', offset);
  }
}

// Add navigation functionality to buttons
function addNavigationHandlers() {
  // "পরবর্তী মডেল টেস্ট" button
  const nextTestBtn = document.querySelector('button:has(.material-symbols-outlined:contains("arrow_forward"))');
  if (nextTestBtn) {
    nextTestBtn.addEventListener('click', () => {
      window.location.href = '{{ route('model-tests') }}';
    });
  }

  // "অধ্যায়ে ফিরে যান" button  
  const backToChapterBtn = document.querySelector('button:has(.material-symbols-outlined:contains("home"))');
  if (backToChapterBtn) {
    backToChapterBtn.addEventListener('click', () => {
      window.location.href = '{{ route('chapters') }}';
    });
  }
}

// Celebration animation on load
window.addEventListener('load', function() {
  console.log('Result page loaded successfully!');
  
  // Initialize results with URL parameters
  initializeResults();
  
  // Add navigation handlers
  addNavigationHandlers();
  
  // Optional: Add confetti or celebration animation for high scores
  const params = getURLParams();
  const { percentage } = calculateGrade(params.score, params.total);
  if (percentage >= 90) {
    console.log('Excellent score! 🎉');
  }
});
</script>
@endpush