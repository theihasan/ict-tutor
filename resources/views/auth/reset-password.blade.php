@extends('layouts.app')

@section('title', 'নতুন পাসওয়ার্ড - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT Interactive অ্যাকাউন্টের জন্য নতুন পাসওয়ার্ড সেট করুন।')

@section('content')
<main class="flex-grow flex items-center justify-center py-12 px-4">
<div class="w-full max-w-md">

<!-- Header -->
<div class="text-center mb-8">
<div class="flex justify-center mb-4">
<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-3xl text-primary">key</span>
</div>
</div>
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">নতুন পাসওয়ার্ড সেট করুন</h1>
<p class="text-slate-600 dark:text-slate-400 mt-2 text-center bengali-text">
আপনার অ্যাকাউন্টের জন্য একটি নতুন পাসওয়ার্ড তৈরি করুন।
</p>
</div>

<!-- Reset Form -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg">

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6" x-data="{ showPassword: false, showPasswordConfirmation: false }">
@csrf

<!-- Password Reset Token -->
<input type="hidden" name="token" value="{{ $request->route('token') }}">

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
value="{{ old('email', $request->email) }}"
required 
autofocus 
autocomplete="username"
class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-red-500 @enderror"
placeholder="আপনার ইমেইল ঠিকানা"
/>
</div>
@error('email')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Password -->
<div>
<label for="password" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
নতুন পাসওয়ার্ড
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input 
                            id="password" 
                            name="password" 
                            :type="showPassword ? 'text' : 'password'" 
                            required 
                            autocomplete="new-password"
                            class="w-full pl-12 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password') border-red-500 @enderror"
                            placeholder="নতুন পাসওয়ার্ড (কমপক্ষে ৮ অক্ষর)"
                        />
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                        >
                            <span class="material-symbols-outlined text-xl" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                        </button>
</div>
@error('password')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Confirm Password -->
<div>
<label for="password_confirmation" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পাসওয়ার্ড নিশ্চিতকরণ
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            :type="showPasswordConfirmation ? 'text' : 'password'" 
                            required 
                            autocomplete="new-password"
                            class="w-full pl-12 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password_confirmation') border-red-500 @enderror"
                            placeholder="পাসওয়ার্ড পুনরায় লিখুন"
                        />
                        <button 
                            type="button" 
                            @click="showPasswordConfirmation = !showPasswordConfirmation" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                        >
                            <span class="material-symbols-outlined text-xl" x-text="showPasswordConfirmation ? 'visibility_off' : 'visibility'"></span>
                        </button>
</div>
@error('password_confirmation')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Password Requirements -->
<div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700/30">
<h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-2 bengali-text">পাসওয়ার্ডের প্রয়োজনীয়তা:</h4>
<ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1 bengali-text">
<li>• কমপক্ষে ৮ অক্ষর দীর্ঘ</li>
<li>• অন্তত একটি বড় হাতের অক্ষর (A-Z)</li>
<li>• অন্তত একটি ছোট হাতের অক্ষর (a-z)</li>
<li>• অন্তত একটি সংখ্যা (0-9)</li>
</ul>
</div>

<!-- Submit Button -->
<button 
type="submit" 
class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-primary hover:bg-primary/90 text-[#0d1b18] font-bold rounded-lg transition-all shadow-md hover:shadow-lg bengali-text"
>
<span class="material-symbols-outlined text-xl">save</span>
<span>পাসওয়ার্ড রিসেট করুন</span>
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

</div>
</main>


@endsection