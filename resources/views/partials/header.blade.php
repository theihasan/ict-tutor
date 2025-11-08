<!-- HEADER -->
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/20 py-3">
            <div class="flex items-center gap-3 text-[#0d1b18] dark:text-white">
                <div class="size-6 text-primary">
                    <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-bold leading-tight tracking-tight text-slate-800 dark:text-slate-200 bengali-text">HSC ICT Interactive</h2>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex flex-1 justify-end gap-8">
                <div class="flex items-center gap-9 text-slate-700 dark:text-slate-300">
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('welcome') }}">হোম</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('chapters') }}">অধ্যায়সমূহ</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('student-dashboard') }}">ড্যাশবোর্ড</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('model-tests') }}">মডেল টেস্ট</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('edit-profile') }}">প্রোফাইল</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary transition-colors bengali-text" href="{{ route('faq') }}">FAQ</a>
                </div>
                <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-[#0d1b18] text-sm font-bold leading-normal tracking-wide hover:bg-opacity-90 transition-all bengali-text" onclick="location.href='{{ route('chapters') }}'">
                    <span class="truncate">প্র্যাকটিস শুরু করুন</span>
                </button>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="flex items-center justify-center w-10 h-10 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </div>
</header>