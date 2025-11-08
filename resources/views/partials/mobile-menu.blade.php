<!-- Mobile Menu Dropdown -->
<div id="mobile-menu" class="hidden md:hidden bg-background-light dark:bg-background-dark border-b border-primary/20 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <nav class="flex flex-col gap-1">
            <a href="{{ route('welcome') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">হোম</a>
            <a href="{{ route('chapters') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">অধ্যায়সমূহ</a>
            <a href="{{ route('student-dashboard') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">ড্যাশবোর্ড</a>
            <a href="{{ route('model-tests') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">মডেল টেস্ট</a>
            <a href="{{ route('edit-profile') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">প্রোফাইল</a>
            <a href="{{ route('faq') }}" class="px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors bengali-text">FAQ</a>
            <button onclick="location.href='{{ route('chapters') }}'" class="mt-2 w-full flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-[#0d1b18] text-sm font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all bengali-text">
                <span class="truncate">প্র্যাকটিস শুরু করুন</span>
            </button>
        </nav>
    </div>
</div>