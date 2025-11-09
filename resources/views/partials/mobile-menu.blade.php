<!-- Mobile Menu Dropdown -->
<div id="mobile-menu" class="hidden md:hidden bg-background-light dark:bg-background-dark border-b border-primary/20 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <nav class="flex flex-col gap-1">
            <a href="{{ route('welcome') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">হোম</a>
            <a href="{{ route('chapters') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">অধ্যায়সমূহ</a>
            @auth
                <a href="{{ route('student-dashboard') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">ড্যাশবোর্ড</a>
            @endauth
            <a href="{{ route('model-tests') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">মডেল টেস্ট</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">প্রোফাইল</a>
            @endauth
            <a href="{{ route('faq') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">FAQ</a>
            
            @auth
                <!-- User Info -->
                <div class="px-3 py-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                    <div class="text-sm text-slate-600 dark:text-slate-400 bengali-text mb-2">
                        স্বাগতম, {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center rounded-lg h-10 px-4 bg-red-500 hover:bg-red-600 text-white text-sm font-bold leading-normal tracking-wide transition-all bengali-text">
                            <span class="truncate">লগআউট</span>
                        </button>
                    </form>
                </div>
            @else
                <!-- Guest Actions -->
                <div class="mt-2 space-y-2">
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center rounded-lg h-10 px-4 border border-primary text-primary hover:bg-primary/10 text-sm font-bold leading-normal tracking-wide transition-all bengali-text">
                        <span class="truncate">লগইন</span>
                    </a>
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-[#0d1b18] text-sm font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all bengali-text">
                        <span class="truncate">সাইন আপ</span>
                    </a>
                </div>
            @endauth
        </nav>
    </div>
</div>