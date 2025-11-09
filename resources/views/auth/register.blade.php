@extends('layouts.app')

@section('title', 'নিবন্ধন - HSC ICT Interactive')
@section('description', 'HSC ICT Interactive প্ল্যাটফর্মে নিবন্ধন করুন এবং বিনামূল্যে পড়াশোনা শুরু করুন।')

@section('content')
<main class="flex-grow py-12 px-4">
<div class="max-w-2xl mx-auto">

<!-- Header -->
<div class="text-center mb-8">
<div class="flex justify-center mb-4">
<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-3xl text-primary">person_add</span>
</div>
</div>
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">নিবন্ধন করুন</h1>
<p class="text-slate-600 dark:text-slate-400 mt-2 bengali-text">একটি নতুন অ্যাকাউন্ট তৈরি করুন</p>
</div>

<!-- Registration Form -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg">

<form method="POST" action="{{ route('register') }}" class="space-y-6">
@csrf

<!-- Personal Information Section -->
<div class="border-b border-slate-200 dark:border-slate-700 pb-6">
<h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white mb-4 bengali-text">ব্যক্তিগত তথ্য</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- Name -->
<div class="md:col-span-2">
<label for="name" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পূর্ণ নাম *
</label>
<input 
id="name" 
name="name" 
type="text" 
value="{{ old('name') }}"
required 
autofocus 
autocomplete="name"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-red-500 @enderror"
placeholder="আপনার পূর্ণ নাম"
/>
@error('name')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Username -->
<div>
<label for="username" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ব্যবহারকারীর নাম *
</label>
<input 
id="username" 
name="username" 
type="text" 
value="{{ old('username') }}"
required 
autocomplete="username"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('username') border-red-500 @enderror"
placeholder="ব্যবহারকারীর নাম (ইংরেজিতে)"
/>
@error('username')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Email -->
<div>
<label for="email" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ইমেইল ঠিকানা *
</label>
<input 
id="email" 
name="email" 
type="email" 
value="{{ old('email') }}"
required 
autocomplete="email"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-red-500 @enderror"
placeholder="আপনার ইমেইল ঠিকানা"
/>
@error('email')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Phone -->
<div>
<label for="phone" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ফোন নম্বর
</label>
<input 
id="phone" 
name="phone" 
type="tel" 
value="{{ old('phone') }}"
autocomplete="tel"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('phone') border-red-500 @enderror"
placeholder="০১৭xxxxxxxx"
/>
@error('phone')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Gender -->
<div>
<label for="gender" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
লিঙ্গ
</label>
<select 
id="gender" 
name="gender"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('gender') border-red-500 @enderror"
>
<option value="">নির্বাচন করুন</option>
<option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>পুরুষ</option>
<option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>মহিলা</option>
<option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>অন্যান্য</option>
</select>
@error('gender')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Date of Birth -->
<div>
<label for="date_of_birth" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
জন্ম তারিখ
</label>
<input 
id="date_of_birth" 
name="date_of_birth" 
type="date" 
value="{{ old('date_of_birth') }}"
autocomplete="bday"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('date_of_birth') border-red-500 @enderror"
/>
@error('date_of_birth')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>
</div>

<!-- Educational Information Section -->
<div class="border-b border-slate-200 dark:border-slate-700 pb-6">
<h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white mb-4 bengali-text">শিক্ষা সংক্রান্ত তথ্য</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- Institution -->
<div>
<label for="institution" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
শিক্ষা প্রতিষ্ঠান
</label>
<input 
id="institution" 
name="institution" 
type="text" 
value="{{ old('institution') }}"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('institution') border-red-500 @enderror"
placeholder="আপনার স্কুল/কলেজের নাম"
/>
@error('institution')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Class -->
<div>
<label for="class" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
শ্রেণি
</label>
<select 
id="class" 
name="class"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('class') border-red-500 @enderror"
>
<option value="">নির্বাচন করুন</option>
<option value="HSC 1st Year" {{ old('class') === 'HSC 1st Year' ? 'selected' : '' }}>HSC ১ম বর্ষ</option>
<option value="HSC 2nd Year" {{ old('class') === 'HSC 2nd Year' ? 'selected' : '' }}>HSC ২য় বর্ষ</option>
<option value="HSC Graduate" {{ old('class') === 'HSC Graduate' ? 'selected' : '' }}>HSC উত্তীর্ণ</option>
<option value="University" {{ old('class') === 'University' ? 'selected' : '' }}>বিশ্ববিদ্যালয়</option>
</select>
@error('class')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- HSC Year -->
<div>
<label for="hsc_year" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
HSC পরীক্ষার বছর
</label>
<select 
id="hsc_year" 
name="hsc_year"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('hsc_year') border-red-500 @enderror"
>
<option value="">নির্বাচন করুন</option>
@for($year = 2030; $year >= 2020; $year--)
<option value="{{ $year }}" {{ old('hsc_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
@endfor
</select>
@error('hsc_year')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- District -->
<div>
<label for="district" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
জেলা
</label>
<input 
id="district" 
name="district" 
type="text" 
value="{{ old('district') }}"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('district') border-red-500 @enderror"
placeholder="আপনার জেলার নাম"
/>
@error('district')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Division -->
<div>
<label for="division" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
বিভাগ
</label>
<select 
id="division" 
name="division"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('division') border-red-500 @enderror"
>
<option value="">নির্বাচন করুন</option>
<option value="Dhaka" {{ old('division') === 'Dhaka' ? 'selected' : '' }}>ঢাকা</option>
<option value="Chittagong" {{ old('division') === 'Chittagong' ? 'selected' : '' }}>চট্টগ্রাম</option>
<option value="Rajshahi" {{ old('division') === 'Rajshahi' ? 'selected' : '' }}>রাজশাহী</option>
<option value="Khulna" {{ old('division') === 'Khulna' ? 'selected' : '' }}>খুলনা</option>
<option value="Sylhet" {{ old('division') === 'Sylhet' ? 'selected' : '' }}>সিলেট</option>
<option value="Barisal" {{ old('division') === 'Barisal' ? 'selected' : '' }}>বরিশাল</option>
<option value="Rangpur" {{ old('division') === 'Rangpur' ? 'selected' : '' }}>রংপুর</option>
<option value="Mymensingh" {{ old('division') === 'Mymensingh' ? 'selected' : '' }}>ময়মনসিংহ</option>
</select>
@error('division')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>
</div>

<!-- Password Section -->
<div class="space-y-4">
<h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text">পাসওয়ার্ড</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- Password -->
<div>
<label for="password" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পাসওয়ার্ড *
</label>
<div class="relative">
<input 
id="password" 
name="password" 
type="password" 
required 
autocomplete="new-password"
class="w-full px-4 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password') border-red-500 @enderror"
placeholder="পাসওয়ার্ড (কমপক্ষে ৮ অক্ষর)"
/>
<button 
type="button" 
onclick="togglePassword('password')" 
class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
>
<span class="material-symbols-outlined text-xl" id="password-toggle-icon">visibility</span>
</button>
</div>
@error('password')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Confirm Password -->
<div>
<label for="password_confirmation" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পাসওয়ার্ড নিশ্চিতকরণ *
</label>
<div class="relative">
<input 
id="password_confirmation" 
name="password_confirmation" 
type="password" 
required 
autocomplete="new-password"
class="w-full px-4 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password_confirmation') border-red-500 @enderror"
placeholder="পাসওয়ার্ড পুনরায় লিখুন"
/>
<button 
type="button" 
onclick="togglePassword('password_confirmation')" 
class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
>
<span class="material-symbols-outlined text-xl" id="password_confirmation-toggle-icon">visibility</span>
</button>
</div>
@error('password_confirmation')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>
</div>

<!-- Terms and Conditions -->
<div>
<label for="terms" class="flex items-start space-x-3">
<input 
id="terms" 
name="terms" 
type="checkbox"
required
class="h-4 w-4 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded mt-1 @error('terms') border-red-500 @enderror"
>
<span class="text-sm text-slate-700 dark:text-slate-300 bengali-text">
আমি <a href="{{ route('privacy') }}" class="text-primary hover:text-primary/80" target="_blank">গোপনীয়তা নীতি</a> এবং 
<a href="#" class="text-primary hover:text-primary/80" target="_blank">ব্যবহারের শর্তাবলী</a> পড়েছি এবং সম্মত।
</span>
</label>
@error('terms')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Submit Button -->
<button 
type="submit" 
class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-primary hover:bg-primary/90 text-[#0d1b18] font-bold rounded-lg transition-all shadow-md hover:shadow-lg bengali-text"
>
<span class="material-symbols-outlined text-xl">person_add</span>
<span>নিবন্ধন করুন</span>
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

<!-- Login Link -->
<div class="text-center">
<p class="text-sm text-slate-600 dark:text-slate-400 bengali-text">
ইতিমধ্যে অ্যাকাউন্ট আছে?
<a 
href="{{ route('login') }}" 
class="font-medium text-primary hover:text-primary/80 transition-colors bengali-text"
>
লগইন করুন
</a>
</p>
</div>

</div>

</div>
</main>

<script>
function togglePassword(fieldId) {
const field = document.getElementById(fieldId);
const icon = document.getElementById(fieldId + '-toggle-icon');

if (field.type === 'password') {
field.type = 'text';
icon.textContent = 'visibility_off';
} else {
field.type = 'password';
icon.textContent = 'visibility';
}
}
</script>
@endsection