<!-- FOOTER -->
<footer class="bg-slate-900 text-white mt-auto">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="size-8 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold bengali-text">HSC ICT Interactive</h3>
                </div>
                <p class="text-slate-400 leading-relaxed bengali-text">
                    বাংলাদেশের শিক্ষার্থীদের জন্য সর্বোত্তম HSC ICT অনুশীলন প্ল্যাটফর্ম।
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold mb-4 bengali-text">দ্রুত লিঙ্ক</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ route('welcome') }}" class="hover:text-primary transition-colors bengali-text">হোম</a></li>
                    <li><a href="{{ route('chapters') }}" class="hover:text-primary transition-colors bengali-text">অধ্যায়সমূহ</a></li>
                    <li><a href="{{ route('model-tests') }}" class="hover:text-primary transition-colors bengali-text">মডেল টেস্ট</a></li>
                    <li><a href="{{ route('student-dashboard') }}" class="hover:text-primary transition-colors bengali-text">ড্যাশবোর্ড</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="font-semibold mb-4 bengali-text">সহায়তা</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ route('faq') }}" class="hover:text-primary transition-colors bengali-text">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary transition-colors bengali-text">যোগাযোগ</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-primary transition-colors bengali-text">আমাদের সম্পর্কে</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-primary transition-colors bengali-text">গোপনীয়তা নীতি</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-semibold mb-4 bengali-text">যোগাযোগ</h4>
                <div class="space-y-3 text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">email</span>
                        <span class="text-sm">support@hscict.com</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">phone</span>
                        <span class="text-sm">+880 1234-567890</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span class="text-sm bengali-text">ঢাকা, বাংলাদেশ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-slate-800 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-slate-400 text-sm bengali-text">
                © 2024 HSC ICT Interactive. সকল অধিকার সংরক্ষিত।
            </p>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <button id="theme-toggle" class="flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors text-sm">
                    <span class="material-symbols-outlined text-sm">dark_mode</span>
                    <span class="bengali-text">ডার্ক মোড</span>
                </button>
            </div>
        </div>
    </div>
</footer>