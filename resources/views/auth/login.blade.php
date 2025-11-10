@extends('layouts.app')

@section('title', 'লগইন - HSC ICT Interactive')
@section('description', 'HSC ICT Interactive প্ল্যাটফর্মে লগইন করুন এবং আপনার পড়াশোনা চালিয়ে যান।')

@section('content')
<main class="flex-grow flex items-center justify-center py-12 px-4">
<div class="w-full max-w-md">

<!-- Header -->
<div class="text-center mb-8">
<div class="flex justify-center mb-4">
<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-3xl text-primary">login</span>
</div>
</div>
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">লগইন করুন</h1>
<p class="text-slate-600 dark:text-slate-400 mt-2 bengali-text">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
</div>

<!-- Login Form -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg">

<!-- Session Status -->
@if (session('status'))
<div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 rounded-lg">
<p class="text-sm text-green-800 dark:text-green-200 bengali-text">{{ session('status') }}</p>
</div>
@endif

<!-- Success Message -->
@if (session('success'))
<div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 rounded-lg">
<p class="text-sm text-green-800 dark:text-green-200 bengali-text">{{ session('success') }}</p>
</div>
@endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ showPassword: false }">
@csrf

<!-- Email/Username -->
<div>
<label for="login" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ইমেইল বা ব্যবহারকারীর নাম
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">person</span>
<input 
id="login" 
name="login" 
type="text" 
value="{{ old('login') }}"
required 
autofocus 
autocomplete="username"
class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('login') border-red-500 @enderror"
placeholder="আপনার ইমেইল বা ব্যবহারকারীর নাম"
/>
</div>
@error('login')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Password -->
<div>
<label for="password" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পাসওয়ার্ড
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input 
                            id="password" 
                            name="password" 
                            :type="showPassword ? 'text' : 'password'" 
                            required 
                            autocomplete="current-password"
                            class="w-full pl-12 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password') border-red-500 @enderror"
                            placeholder="আপনার পাসওয়ার্ড"
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

<!-- Remember Me & Forgot Password -->
<div class="flex items-center justify-between">
<label for="remember" class="flex items-center space-x-2">
<input 
id="remember" 
name="remember" 
type="checkbox"
class="h-4 w-4 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded"
>
<span class="text-sm text-slate-700 dark:text-slate-300 bengali-text">আমাকে মনে রাখুন</span>
</label>

<a 
href="{{ route('password.request') }}" 
class="text-sm text-primary hover:text-primary/80 transition-colors bengali-text"
>
পাসওয়ার্ড ভুলে গেছেন?
</a>
</div>

<!-- Submit Button -->
<button 
type="submit" 
class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-primary hover:bg-primary/90 text-[#0d1b18] font-bold rounded-lg transition-all shadow-md hover:shadow-lg bengali-text"
>
<span class="material-symbols-outlined text-xl">login</span>
<span>লগইন করুন</span>
</button>

</form>

<!-- Divider -->
<div class="relative my-6">
<div class="absolute inset-0 flex items-center">
<div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
</div>
<div class="relative flex justify-center text-sm">
<span class="px-3 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 bengali-text">অথবা</span>
</div>
</div>

<!-- Register Link -->
<div class="text-center">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">
অ্যাকাউন্ট নেই?
<a 
href="{{ route('register') }}" 
class="font-medium text-primary hover:text-primary/80 transition-colors bengali-text"
>
নতুন অ্যাকাউন্ট তৈরি করুন
</a>
</p>
</div>

</div>

</div>
</main>


@endsection