@extends('layouts.app')

@section('title', 'পাসওয়ার্ড ভুলে গেছেন - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT Interactive অ্যাকাউন্টের পাসওয়ার্ড রিসেট করুন।')

@section('content')
<main class="flex-grow flex items-center justify-center py-12 px-4">
<div class="w-full max-w-md">

<!-- Header -->
<div class="text-center mb-8">
<div class="flex justify-center mb-4">
<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-3xl text-primary">lock_reset</span>
</div>
</div>
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">পাসওয়ার্ড ভুলে গেছেন?</h1>
<p class="text-slate-600 dark:text-slate-400 mt-2 text-center bengali-text">
চিন্তা করবেন না! আপনার ইমেইল ঠিকানা দিন, আমরা পাসওয়ার্ড রিসেট লিংক পাঠিয়ে দেব।
</p>
</div>

<!-- Reset Form -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg">

<!-- Session Status -->
@if (session('status'))
<div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 rounded-lg">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
<p class="text-sm text-green-800 dark:text-green-200 bengali-text">{{ session('status') }}</p>
</div>
</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
@csrf

<!-- Email -->
<div>
<label for="email" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ইমেইল ঠিকানা
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">email</span>
<input 
id="email" 
name="email" 
type="email" 
value="{{ old('email') }}"
required 
autofocus 
autocomplete="email"
class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-red-500 @enderror"
placeholder="আপনার ইমেইল ঠিকানা"
/>
</div>
@error('email')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Submit Button -->
<button 
type="submit" 
class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-primary hover:bg-primary/90 text-[#0d1b18] font-bold rounded-lg transition-all shadow-md hover:shadow-lg bengali-text"
>
<span class="material-symbols-outlined text-xl">send</span>
<span>পাসওয়ার্ড রিসেট লিংক পাঠান</span>
</button>

</form>

<!-- Back to Login -->
<div class="mt-6 text-center">
<a 
href="{{ route('login') }}" 
class="inline-flex items-center gap-2 text-sm text-primary hover:text-primary/80 transition-colors bengali-text"
>
<span class="material-symbols-outlined text-lg">arrow_back</span>
<span>লগইন পাতায় ফিরে যান</span>
</a>
</div>

</div>

<!-- Help Section -->
<div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700/30">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl mt-0.5">info</span>
<div>
<h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200 bengali-text">সাহায্য প্রয়োজন?</h3>
<p class="text-xs text-blue-700 dark:text-blue-300 mt-1 bengali-text">
যদি আপনি ইমেইল না পান, তাহলে স্প্যাম ফোল্ডার চেক করুন অথবা আমাদের সাথে যোগাযোগ করুন।
</p>
<a href="{{ route('contact') }}" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium bengali-text">
যোগাযোগ করুন →
</a>
</div>
</div>
</div>

</div>
</main>
@endsection