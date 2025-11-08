@extends('layouts.app')

@section('title', 'FAQ - HSC ICT Interactive Practice Platform')
@section('description', 'HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।')
@section('keywords', 'HSC ICT FAQ, সচরাচর জিজ্ঞাসা, সাহায্য, প্রশ্ন উত্তর, বাংলাদেশ, শিক্ষা')

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="FAQ - HSC ICT Interactive"/>
<meta property="og:description" content="HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://hscict.com/faq.html"/>
<meta property="og:image" content="https://hscict.com/images/faq-og-image.jpg"/>
<meta property="og:image:alt" content="HSC ICT Interactive - FAQ পেজ"/>
<meta property="og:site_name" content="HSC ICT Interactive"/>
<meta property="og:locale" content="bn_BD"/>

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="FAQ - HSC ICT Interactive"/>
<meta name="twitter:description" content="HSC ICT Interactive সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্ন ও উত্তর। প্ল্যাটফর্ম ব্যবহার, প্র্যাকটিস সম্পর্কে এবং অন্যান্য সহায়ক তথ্য জানুন।"/>
<meta name="twitter:image" content="https://hscict.com/images/faq-og-image.jpg"/>
<meta name="twitter:image:alt" content="HSC ICT Interactive - FAQ পেজ"/>

@section('content')
<!-- Hero Section -->
<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">
<div class="text-center mb-12">
<h1 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-200 mb-4 bengali-text">
প্রায়শই জিজ্ঞাসিত প্রশ্ন (FAQ)
</h1>
<p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto bengali-text">
HSC ICT Interactive প্ল্যাটফর্ম সম্পর্কে আপনার যে কোনো প্রশ্নের উত্তর এখানে খুঁজে পান
</p>
</div>

<!-- Search Box -->
<div class="max-w-2xl mx-auto mb-12">
<div class="relative">
<input 
  type="text" 
  placeholder="প্রশ্ন খুঁজুন..." 
  class="w-full px-4 py-3 pl-12 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bengali-text"
  id="faq-search"
/>
<span class="material-symbols-outlined absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
search
</span>
</div>
</div>

<!-- FAQ Categories -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<button class="category-btn active p-4 rounded-lg border-2 border-primary bg-primary/10 text-primary font-medium transition-all hover:bg-primary/20 bengali-text" data-category="general">
সাধারণ
</button>
<button class="category-btn p-4 rounded-lg border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium transition-all hover:border-primary hover:text-primary bengali-text" data-category="technical">
প্রযুক্তিগত
</button>
<button class="category-btn p-4 rounded-lg border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium transition-all hover:border-primary hover:text-primary bengali-text" data-category="account">
অ্যাকাউন্ট
</button>
</div>

<!-- FAQ Sections -->
<div class="max-w-4xl mx-auto">

<!-- General FAQ -->
<div id="general-faq" class="faq-section">
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 bengali-text">সাধারণ প্রশ্ন</h2>
<div class="space-y-4">

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">HSC ICT Interactive প্ল্যাটফর্মটি কী?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
HSC ICT Interactive হল একটি অনলাইন শিক্ষা প্ল্যাটফর্ম যা বাংলাদেশের HSC পর্যায়ের শিক্ষার্থীদের জন্য ICT বিষয়ে ইন্টারঅ্যাক্টিভ অনুশীলনের সুবিধা প্রদান করে। এখানে C প্রোগ্রামিং সিমুলেটর, মডেল টেস্ট, অগ্রগতি ট্র্যাকিং এবং বিস্তৃত শিক্ষা উপকরণ রয়েছে।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">এই প্ল্যাটফর্মটি কীভাবে ব্যবহার করব?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
প্রথমে একটি অ্যাকাউন্ট তৈরি করুন, তারপর 'অধ্যায়সমূহ' সেকশন থেকে আপনার পছন্দের অধ্যায় নির্বাচন করুন। প্রতিটি অধ্যায়ে ইন্টারঅ্যাক্টিভ লেসন, অনুশীলনী এবং কুইজ রয়েছে। আপনার অগ্রগতি ড্যাশবোর্ডে দেখতে পারবেন।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">প্ল্যাটফর্মটি কি বিনামূল্যে ব্যবহার করা যায়?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
হ্যাঁ, HSC ICT Interactive প্ল্যাটফর্মের মূল বৈশিষ্ট্যগুলি সম্পূর্ণ বিনামূল্যে ব্যবহার করা যায়। তবে কিছু প্রিমিয়াম বৈশিষ্ট্য যেমন উন্নত বিশ্লেষণ এবং ব্যক্তিগত টিউটরিং এর জন্য সাবস্ক্রিপশন প্রয়োজন হতে পারে।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">কোন কোন অধ্যায় এবং বিষয় কভার করা হয়?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
HSC ICT সিলেবাসের সব অধ্যায় কভার করা হয়েছে যার মধ্যে রয়েছে: তথ্য ও যোগাযোগ প্রযুক্তি, কমিউনিকেশন সিস্টেম ও নেটওয়ার্কিং, সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস, HTML প্রোগ্রামিং, C প্রোগ্রামিং, ডেটাবেস ম্যানেজমেন্ট সিস্টেম।
</p>
</div>
</div>

</div>
</div>

<!-- Technical FAQ -->
<div id="technical-faq" class="faq-section hidden">
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 bengali-text">প্রযুক্তিগত প্রশ্ন</h2>
<div class="space-y-4">

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">C প্রোগ্রামিং সিমুলেটর কীভাবে কাজ করে?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
আমাদের C প্রোগ্রামিং সিমুলেটর একটি ব্রাউজার-ভিত্তিক কোড এডিটর যা রিয়েল-টাইমে C কোড লিখা, কম্পাইল এবং রান করার সুবিধা দেয়। এটি ইনপুট/আউটপুট হ্যান্ডলিং, ডিবাগিং এবং কোড হাইলাইটিং বৈশিষ্ট্য সহ আসে।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">প্ল্যাটফর্মটি কোন ডিভাইসে কাজ করে?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
HSC ICT Interactive সব ধরনের ডিভাইসে কাজ করে - ডেস্কটপ, ল্যাপটপ, ট্যাবলেট এবং স্মার্টফোনে। প্ল্যাটফর্মটি রেসপন্সিভ ডিজাইনের সাথে তৈরি যা সব স্ক্রিন সাইজে সঠিকভাবে কাজ করে।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">ইন্টারনেট সংযোগ ছাড়া কি ব্যবহার করা যাবে?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
বর্তমানে প্ল্যাটফর্মটি ইন্টারনেট সংযোগের প্রয়োজন। তবে আমরা ভবিষ্যতে অফলাইন মোড চালু করার পরিকল্পনা করছি যেখানে কিছু কন্টেন্ট ডাউনলোড করে অফলাইনে ব্যবহার করা যাবে।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">কোন ব্রাউজার সাপোর্ট করে?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
প্ল্যাটফর্মটি সব আধুনিক ব্রাউজারে কাজ করে যেমন Google Chrome, Mozilla Firefox, Safari, Microsoft Edge। সর্বোত্তম অভিজ্ঞতার জন্য আপডেটেড ব্রাউজার ব্যবহার করুন।
</p>
</div>
</div>

</div>
</div>

<!-- Account FAQ -->
<div id="account-faq" class="faq-section hidden">
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 bengali-text">অ্যাকাউন্ট সংক্রান্ত</h2>
<div class="space-y-4">

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">কীভাবে নতুন অ্যাকাউন্ট তৈরি করব?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
হোম পেজে 'সাইন আপ' বাটনে ক্লিক করুন এবং আপনার নাম, ইমেইল ঠিকানা, পাসওয়ার্ড দিয়ে রেজিস্ট্রেশন সম্পন্ন করুন। রেজিস্ট্রেশনের পর আপনার ইমেইলে একটি যাচাইকরণ লিঙ্ক পাবেন।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">পাসওয়ার্ড ভুলে গেলে কী করব?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
লগইন পেজে 'পাসওয়ার্ড ভুলে গেছেন?' লিঙ্কে ক্লিক করুন এবং আপনার ইমেইল ঠিকানা দিন। আপনার ইমেইলে পাসওয়ার্ড রিসেট করার জন্য একটি লিঙ্ক পাবেন।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">প্রোফাইল তথ্য কীভাবে আপডেট করব?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
ড্যাশবোর্ডে লগইন করার পর 'প্রোফাইল' সেকশনে গিয়ে আপনার ব্যক্তিগত তথ্য, পছন্দ এবং সেটিংস আপডেট করতে পারবেন। পরিবর্তনগুলি সংরক্ষণ করতে ভুলবেন না।
</p>
</div>
</div>

<div class="faq-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
<button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
<span class="font-medium text-slate-800 dark:text-slate-200 bengali-text">অ্যাকাউন্ট ডিলিট করতে চাইলে কী করব?</span>
<span class="material-symbols-outlined text-slate-400 transform transition-transform">expand_more</span>
</button>
<div class="faq-answer hidden px-6 pb-4">
<p class="text-slate-600 dark:text-slate-400 leading-relaxed bengali-text">
অ্যাকাউন্ট ডিলিট করতে চাইলে প্রোফাইল সেটিংসে 'অ্যাকাউন্ট ডিলিট' অপশনে ক্লিক করুন অথবা আমাদের সাপোর্ট টিমের সাথে যোগাযোগ করুন। মনে রাখবেন, ডিলিট করার পর আপনার সব ডেটা এবং অগ্রগতি চিরতরে মুছে যাবে।
</p>
</div>
</div>

</div>
</div>

</div>

<!-- Contact Section -->
<div class="bg-slate-50 dark:bg-slate-900 mt-16 py-12">
<div class="max-w-4xl mx-auto px-4 text-center">
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4 bengali-text">
আপনার প্রশ্নের উত্তর পাননি?
</h2>
<p class="text-slate-600 dark:text-slate-400 mb-6 bengali-text">
আমাদের সাপোর্ট টিম আপনাকে সাহায্য করতে প্রস্তুত। যে কোনো সময় যোগাযোগ করুন।
</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-[#0d1b18] font-medium rounded-lg hover:bg-opacity-90 transition-all bengali-text">
<span class="material-symbols-outlined mr-2">email</span>
যোগাযোগ করুন
</a>
<a href="mailto:support@hscict.com" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-all bengali-text">
<span class="material-symbols-outlined mr-2">support</span>
support@hscict.com
</a>
</div>
</div>
</div>

@endsection

@push('scripts')
<script>
// FAQ functionality
const faqQuestions = document.querySelectorAll('.faq-question');
const faqSearch = document.getElementById('faq-search');
const categoryButtons = document.querySelectorAll('.category-btn');
const faqSections = document.querySelectorAll('.faq-section');

// FAQ accordion
faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        const icon = question.querySelector('.material-symbols-outlined');
        
        answer.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
});

// Category switching
categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        const category = button.dataset.category;
        
        // Update active button
        categoryButtons.forEach(btn => {
            btn.classList.remove('active', 'border-primary', 'bg-primary/10', 'text-primary');
            btn.classList.add('border-slate-300', 'dark:border-slate-600', 'text-slate-700', 'dark:text-slate-300');
        });
        
        button.classList.add('active', 'border-primary', 'bg-primary/10', 'text-primary');
        button.classList.remove('border-slate-300', 'dark:border-slate-600', 'text-slate-700', 'dark:text-slate-300');
        
        // Show relevant FAQ section
        faqSections.forEach(section => {
            if (section.id === category + '-faq') {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        });
    });
});

// FAQ search functionality
faqSearch.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question span').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
        
        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endpush