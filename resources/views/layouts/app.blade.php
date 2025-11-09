<!DOCTYPE html>
<html class="light" lang="bn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'HSC ICT Interactive')</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="@yield('description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন।')"/>
    <meta name="keywords" content="@yield('keywords', 'HSC ICT, C Programming, HTML, CSS, Number System, Logic Gates, বাংলাদেশ, শিক্ষা, প্রোগ্রামিং, অনলাইন শিক্ষা, ইন্টারঅ্যাক্টিভ লার্নিং')"/>
    <meta name="author" content="HSC ICT Interactive Team"/>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og:title', 'HSC ICT Interactive Practice Platform')"/>
    <meta property="og:description" content="@yield('og:description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন।')"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="@yield('og:url', config('app.url'))"/>
    <meta property="og:image" content="@yield('og:image', asset('images/home-og-image.jpg'))"/>
    <meta property="og:image:alt" content="@yield('og:image:alt', 'HSC ICT Interactive Platform')"/>
    <meta property="og:site_name" content="HSC ICT Interactive"/>
    <meta property="og:locale" content="bn_BD"/>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('twitter:title', 'HSC ICT Interactive - ICT-তে A+ পান, প্র্যাকটিস করে!')"/>
    <meta name="twitter:description" content="@yield('twitter:description', 'বাংলাদেশের সেরা HSC ICT প্র্যাকটিস প্ল্যাটফর্ম। C-Programming, HTML, Number Systems, Logic Gates - সব ইন্টারঅ্যাক্টিভ সিমুলেটরে প্র্যাকটিস করুন।')"/>
    <meta name="twitter:image" content="@yield('twitter:image', asset('images/home-og-image.jpg'))"/>
    <meta name="twitter:image:alt" content="@yield('twitter:image:alt', 'HSC ICT Interactive Platform')"/>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <!-- Tailwind CDN (to be replaced with Vite build) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1dedb9",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221d",
                    },
                    fontFamily: {
                        "display": ["Inter", "Hind Siliguri", "sans-serif"],
                        "bengali": ["Hind Siliguri", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">

            <!-- Header -->
            @unless(isset($hideHeader) && $hideHeader)
                @include('partials.header')
            @endunless

            <!-- Mobile Menu -->
            @unless(isset($hideHeader) && $hideHeader)
                @include('partials.mobile-menu')
            @endunless

            <!-- Main Content -->
            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            @unless(isset($hideFooter) && $hideFooter)
                @include('partials.footer')
            @endunless

        </div>
    </div>

    <!-- Global JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Theme toggle functionality
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const isDark = document.documentElement.classList.contains('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    
                    // Update button text
                    const span = themeToggle.querySelector('span:last-child');
                    if (span) {
                        span.textContent = isDark ? 'লাইট মোড' : 'ডার্ক মোড';
                    }
                    const icon = themeToggle.querySelector('.material-symbols-outlined');
                    if (icon) {
                        icon.textContent = isDark ? 'light_mode' : 'dark_mode';
                    }
                });
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        });
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>