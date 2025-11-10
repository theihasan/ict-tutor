@extends('layouts.app')

@section('title', 'প্রোফাইল সেটিংস - HSC ICT Interactive')
@section('description', 'আপনার HSC ICT Interactive প্রোফাইল সেটিংস এবং অ্যাকাউন্ট তথ্য পরিচালনা করুন।')

@section('content')
<main class="flex-grow py-8 px-4" x-data="profilePage()">
<div class="max-w-4xl mx-auto">

<!-- Header -->
<div class="mb-8">
<h1 class="text-2xl font-bold text-[#0d1b18] dark:text-white bengali-text">প্রোফাইল সেটিংস</h1>
<p class="text-slate-600 dark:text-slate-400 mt-2 bengali-text">আপনার অ্যাকাউন্ট তথ্য এবং সেটিংস পরিচালনা করুন</p>
</div>

<!-- Success Message -->
@if (session('success'))
<div class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 rounded-lg">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
<p class="text-sm text-green-800 dark:text-green-200 bengali-text">{{ session('success') }}</p>
</div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

<!-- Profile Overview -->
<div class="lg:col-span-1">
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
<div class="text-center">
<!-- Profile Image -->
<div class="w-24 h-24 mx-auto mb-4 bg-primary/10 rounded-full flex items-center justify-center">
@if($user->profile_image)
<img src="{{ $user->profile_image }}" alt="Profile" class="w-24 h-24 rounded-full object-cover">
@else
<span class="material-symbols-outlined text-4xl text-primary">account_circle</span>
@endif
</div>
<h3 class="text-lg font-semibold text-[#0d1b18] dark:text-white bengali-text">{{ $user->name }}</h3>
<p class="text-sm text-slate-600 dark:text-slate-400">{{ '@' . $user->username }}</p>
<p class="text-xs text-slate-500 dark:text-slate-500 mt-1">{{ $user->email }}</p>

<!-- Level Badge -->
<div class="mt-4">
<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary">
<span class="material-symbols-outlined text-lg">star</span>
<span class="text-sm font-semibold bengali-text">লেভেল {{ $user->level ?? 1 }} - {{ $user->getLevelName() }}</span>
</div>
</div>

<!-- Stats -->
<div class="mt-4 grid grid-cols-2 gap-4 text-center">
<div>
<div class="text-lg font-bold text-[#0d1b18] dark:text-white">{{ $user->total_points ?? 0 }}</div>
<div class="text-xs text-slate-600 dark:text-slate-400 bengali-text">মোট পয়েন্ট</div>
</div>
<div>
<div class="text-lg font-bold text-[#0d1b18] dark:text-white">{{ $user->current_streak ?? 0 }}</div>
<div class="text-xs text-slate-600 dark:text-slate-400 bengali-text">স্ট্রিক</div>
</div>
</div>
</div>
</div>
</div>

<!-- Profile Forms -->
<div class="lg:col-span-2 space-y-8">

<!-- Profile Information -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
<h2 class="text-lg font-semibold text-[#0d1b18] dark:text-white mb-6 bengali-text">প্রোফাইল তথ্য</h2>

<form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
@csrf
@method('patch')

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- Name -->
<div>
<label for="name" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পূর্ণ নাম
</label>
<input 
id="name" 
name="name" 
type="text" 
value="{{ old('name', $user->name) }}"
required 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-red-500 @enderror"
/>
@error('name')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Username -->
<div>
<label for="username" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ব্যবহারকারীর নাম
</label>
<input 
id="username" 
name="username" 
type="text" 
value="{{ old('username', $user->username) }}"
required 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('username') border-red-500 @enderror"
/>
@error('username')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Email -->
<div>
<label for="email" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ইমেইল ঠিকানা
</label>
<input 
id="email" 
name="email" 
type="email" 
value="{{ old('email', $user->email) }}"
required 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-red-500 @enderror"
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
value="{{ old('phone', $user->phone) }}"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('phone') border-red-500 @enderror"
/>
@error('phone')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Institution -->
<div>
<label for="institution" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
শিক্ষা প্রতিষ্ঠান
</label>
<input 
id="institution" 
name="institution" 
type="text" 
value="{{ old('institution', $user->institution) }}"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('institution') border-red-500 @enderror"
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
<option value="HSC 1st Year" {{ old('class', $user->class) === 'HSC 1st Year' ? 'selected' : '' }}>HSC ১ম বর্ষ</option>
<option value="HSC 2nd Year" {{ old('class', $user->class) === 'HSC 2nd Year' ? 'selected' : '' }}>HSC ২য় বর্ষ</option>
<option value="HSC Graduate" {{ old('class', $user->class) === 'HSC Graduate' ? 'selected' : '' }}>HSC উত্তীর্ণ</option>
<option value="University" {{ old('class', $user->class) === 'University' ? 'selected' : '' }}>বিশ্ববিদ্যালয়</option>
</select>
@error('class')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>

<!-- Bio -->
<div>
<label for="bio" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
বায়ো
</label>
<textarea 
id="bio" 
name="bio" 
rows="3"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('bio') border-red-500 @enderror"
placeholder="নিজের সম্পর্কে সংক্ষেপে লিখুন..."
>{{ old('bio', $user->bio) }}</textarea>
@error('bio')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Settings -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- Email Notifications -->
<div class="flex items-center justify-between p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
<div>
<label for="email_notifications" class="text-sm font-medium text-[#0d1b18] dark:text-white bengali-text">
ইমেইল নোটিফিকেশন
</label>
<p class="text-xs text-slate-600 dark:text-slate-400 bengali-text">গুরুত্বপূর্ণ আপডেট পান</p>
</div>
<input 
id="email_notifications" 
name="email_notifications" 
type="checkbox"
value="1"
{{ old('email_notifications', $user->email_notifications) ? 'checked' : '' }}
class="h-4 w-4 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded"
>
</div>

<!-- Language -->
<div>
<label for="language" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
ভাষা
</label>
<select 
id="language" 
name="language"
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('language') border-red-500 @enderror"
>
<option value="bn" {{ old('language', $user->language) === 'bn' ? 'selected' : '' }}>বাংলা</option>
<option value="en" {{ old('language', $user->language) === 'en' ? 'selected' : '' }}>English</option>
</select>
@error('language')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>

<div class="flex justify-end">
<button 
type="submit" 
class="flex items-center gap-2 px-6 py-2 bg-primary hover:bg-primary/90 text-[#0d1b18] font-semibold rounded-lg transition-all shadow-md bengali-text"
>
<span class="material-symbols-outlined text-lg">save</span>
<span>সংরক্ষণ করুন</span>
</button>
</div>

</form>
</div>

<!-- Change Password -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
<h2 class="text-lg font-semibold text-[#0d1b18] dark:text-white mb-6 bengali-text">পাসওয়ার্ড পরিবর্তন</h2>

<form method="POST" action="{{ route('password.update') }}" class="space-y-6">
@csrf
@method('put')

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<!-- Current Password -->
<div>
<label for="current_password" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
বর্তমান পাসওয়ার্ড
</label>
<input 
id="current_password" 
name="current_password" 
type="password" 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('current_password') border-red-500 @enderror"
/>
@error('current_password')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- New Password -->
<div>
<label for="password" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
নতুন পাসওয়ার্ড
</label>
<input 
id="password" 
name="password" 
type="password" 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password') border-red-500 @enderror"
/>
@error('password')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>

<!-- Confirm Password -->
<div>
<label for="password_confirmation" class="block text-sm font-medium text-[#0d1b18] dark:text-white mb-2 bengali-text">
পাসওয়ার্ড নিশ্চিতকরণ
</label>
<input 
id="password_confirmation" 
name="password_confirmation" 
type="password" 
class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-[#0d1b18] dark:text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password_confirmation') border-red-500 @enderror"
/>
@error('password_confirmation')
<p class="mt-1 text-sm text-red-600 dark:text-red-400 bengali-text">{{ $message }}</p>
@enderror
</div>
</div>

<div class="flex justify-end">
<button 
type="submit" 
class="flex items-center gap-2 px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all shadow-md bengali-text"
>
<span class="material-symbols-outlined text-lg">key</span>
<span>পাসওয়ার্ড পরিবর্তন করুন</span>
</button>
</div>

</form>
</div>

<!-- Delete Account -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-red-200 dark:border-red-700/30 p-6">
<h2 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-4 bengali-text">অ্যাকাউন্ট ডিলিট করুন</h2>
<p class="text-sm text-red-700 dark:text-red-300 mb-4 bengali-text">
একবার আপনার অ্যাকাউন্ট ডিলিট করা হলে, এর সমস্ত তথ্য এবং ডেটা স্থায়ীভাবে মুছে যাবে।
</p>

                        <button 
                            @click="confirmDelete()" 
                            class="flex items-center gap-2 px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all shadow-md bengali-text"
                        >
<span class="material-symbols-outlined text-lg">delete_forever</span>
<span>অ্যাকাউন্ট ডিলিট করুন</span>
</button>

<!-- Hidden delete form -->
                    <form x-ref="deleteForm" method="POST" action="{{ route('profile.destroy') }}" class="hidden">
@csrf
@method('delete')
                        <input type="password" name="password" x-ref="deletePassword" required>
</form>

</div>

</div>

</div>

</div>
</main>

<script>
function profilePage() {
    return {
        confirmDelete() {
            const password = prompt('নিশ্চিতকরণের জন্য আপনার পাসওয়ার্ড দিন:');
            if (password) {
                if (confirm('আপনি কি নিশ্চিত যে আপনি আপনার অ্যাকাউন্ট ডিলিট করতে চান? এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।')) {
                    this.$refs.deletePassword.value = password;
                    this.$refs.deleteForm.submit();
                }
            }
        }
    }
}
</script>
@endsection