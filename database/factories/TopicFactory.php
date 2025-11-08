<?php

namespace Database\Factories;

use App\Enums\TopicType;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * HSC ICT Topics organized by chapter
     */
    private array $hscTopics = [
        1 => [ // Information and Communication Technology
            [
                'name' => 'তথ্য ও যোগাযোগ প্রযুক্তির ধারণা',
                'name_en' => 'Concept of ICT',
                'description' => 'তথ্য ও যোগাযোগ প্রযুক্তির মূল ধারণা এবং গুরুত্ব।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'তথ্য প্রযুক্তির ইতিহাস',
                'name_en' => 'History of Information Technology',
                'description' => 'তথ্য প্রযুক্তির বিকাশের ইতিহাস এবং মাইলফলক।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'হার্ডওয়্যার ও সফটওয়্যার',
                'name_en' => 'Hardware and Software',
                'description' => 'কম্পিউটার হার্ডওয়্যার ও সফটওয়্যারের পরিচয়।',
                'type' => TopicType::MIXED,
            ],
            [
                'name' => 'ইনপুট ও আউটপুট ডিভাইস',
                'name_en' => 'Input and Output Devices',
                'description' => 'কম্পিউটারের ইনপুট ও আউটপুট যন্ত্রাংশ।',
                'type' => TopicType::HARDWARE,
            ],
            [
                'name' => 'মেমোরি ও স্টোরেজ',
                'name_en' => 'Memory and Storage',
                'description' => 'কম্পিউটার মেমোরি এবং ডেটা স্টোরেজের ধারণা।',
                'type' => TopicType::HARDWARE,
            ],
        ],
        2 => [ // Communication Systems and Networking
            [
                'name' => 'যোগাযোগ ব্যবস্থার পরিচয়',
                'name_en' => 'Introduction to Communication Systems',
                'description' => 'বিভিন্ন যোগাযোগ ব্যবস্থার পরিচয় এবং বিকাশ।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'নেটওয়ার্কের ধারণা',
                'name_en' => 'Network Concepts',
                'description' => 'কম্পিউটার নেটওয়ার্কের মূল ধারণা এবং প্রকারভেদ।',
                'type' => TopicType::NETWORKING,
            ],
            [
                'name' => 'ইন্টারনেট ও ওয়ার্ল্ড ওয়াইড ওয়েব',
                'name_en' => 'Internet and World Wide Web',
                'description' => 'ইন্টারনেট এবং ওয়েব প্রযুক্তির পরিচয়।',
                'type' => TopicType::NETWORKING,
            ],
            [
                'name' => 'ই-মেইল ও সোশ্যাল নেটওয়ার্কিং',
                'name_en' => 'Email and Social Networking',
                'description' => 'ইলেকট্রনিক মেইল এবং সামাজিক নেটওয়ার্কিং সেবা।',
                'type' => TopicType::PRACTICAL,
            ],
            [
                'name' => 'মোবাইল যোগাযোগ',
                'name_en' => 'Mobile Communication',
                'description' => 'মোবাইল ফোন এবং বেতার যোগাযোগ প্রযুক্তি।',
                'type' => TopicType::THEORY,
            ],
        ],
        3 => [ // Number Systems and Digital Devices
            [
                'name' => 'সংখ্যা পদ্ধতির পরিচয়',
                'name_en' => 'Introduction to Number Systems',
                'description' => 'বিভিন্ন সংখ্যা পদ্ধতির পরিচয় এবং ব্যবহার।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'বাইনারি সংখ্যা পদ্ধতি',
                'name_en' => 'Binary Number System',
                'description' => 'বাইনারি সংখ্যা পদ্ধতি এবং রূপান্তর প্রক্রিয়া।',
                'type' => TopicType::PRACTICAL,
            ],
            [
                'name' => 'অক্টাল ও হেক্সাডেসিমেল',
                'name_en' => 'Octal and Hexadecimal',
                'description' => 'অক্টাল এবং হেক্সাডেসিমেল সংখ্যা পদ্ধতি।',
                'type' => TopicType::PRACTICAL,
            ],
            [
                'name' => 'লজিক গেট',
                'name_en' => 'Logic Gates',
                'description' => 'বিভিন্ন ধরনের লজিক গেট এবং তাদের কার্যপ্রণালী।',
                'type' => TopicType::HARDWARE,
            ],
            [
                'name' => 'বুলিয়ান অ্যালজেব্রা',
                'name_en' => 'Boolean Algebra',
                'description' => 'বুলিয়ান অ্যালজেব্রার নিয়ম এবং প্রয়োগ।',
                'type' => TopicType::THEORY,
            ],
        ],
        4 => [ // Web Design Introduction and HTML
            [
                'name' => 'ওয়েব ডিজাইনের পরিচয়',
                'name_en' => 'Introduction to Web Design',
                'description' => 'ওয়েব ডিজাইনের মূলনীতি এবং পরিকল্পনা।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'HTML এর মূলভিত্তি',
                'name_en' => 'HTML Fundamentals',
                'description' => 'HTML ট্যাগ এবং কাঠামোর পরিচয়।',
                'type' => TopicType::PROGRAMMING,
            ],
            [
                'name' => 'HTML ট্যাগ ও অ্যাট্রিবিউট',
                'name_en' => 'HTML Tags and Attributes',
                'description' => 'বিভিন্ন HTML ট্যাগ এবং তাদের অ্যাট্রিবিউট।',
                'type' => TopicType::PROGRAMMING,
            ],
            [
                'name' => 'টেবিল ও ফর্ম তৈরি',
                'name_en' => 'Creating Tables and Forms',
                'description' => 'HTML দিয়ে টেবিল এবং ফর্ম তৈরি করার পদ্ধতি।',
                'type' => TopicType::PRACTICAL,
            ],
            [
                'name' => 'CSS এর পরিচয়',
                'name_en' => 'Introduction to CSS',
                'description' => 'ক্যাসকেডিং স্টাইল শিটের মূল ধারণা।',
                'type' => TopicType::PROGRAMMING,
            ],
        ],
        5 => [ // Programming Language
            [
                'name' => 'প্রোগ্রামিং ভাষার পরিচয়',
                'name_en' => 'Introduction to Programming Languages',
                'description' => 'প্রোগ্রামিং ভাষার ধারণা এবং শ্রেণীবিভাগ।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'অ্যালগরিদম ও ফ্লোচার্ট',
                'name_en' => 'Algorithm and Flowchart',
                'description' => 'সমস্যা সমাধানের অ্যালগরিদম এবং ফ্লোচার্ট।',
                'type' => TopicType::PROGRAMMING,
            ],
            [
                'name' => 'C প্রোগ্রামিং এর মূলভিত্তি',
                'name_en' => 'C Programming Fundamentals',
                'description' => 'C প্রোগ্রামিং ভাষার পরিচয় এবং গঠন।',
                'type' => TopicType::PROGRAMMING,
            ],
            [
                'name' => 'ভেরিয়েবল ও ডেটা টাইপ',
                'name_en' => 'Variables and Data Types',
                'description' => 'প্রোগ্রামিংয়ে ভেরিয়েবল এবং ডেটা টাইপের ব্যবহার।',
                'type' => TopicType::PROGRAMMING,
            ],
            [
                'name' => 'কন্ট্রোল স্ট্রাকচার',
                'name_en' => 'Control Structures',
                'description' => 'শর্তাধীন বিবৃতি এবং লুপের ব্যবহার।',
                'type' => TopicType::PROGRAMMING,
            ],
        ],
        6 => [ // Database Management System
            [
                'name' => 'ডেটাবেসের ধারণা',
                'name_en' => 'Database Concepts',
                'description' => 'ডেটাবেস এবং ডেটাবেস ম্যানেজমেন্ট সিস্টেমের পরিচয়।',
                'type' => TopicType::THEORY,
            ],
            [
                'name' => 'রিলেশনাল ডেটাবেস',
                'name_en' => 'Relational Database',
                'description' => 'রিলেশনাল ডেটাবেস মডেল এবং তার বৈশিষ্ট্য।',
                'type' => TopicType::DATABASE,
            ],
            [
                'name' => 'SQL এর পরিচয়',
                'name_en' => 'Introduction to SQL',
                'description' => 'স্ট্রাকচার্ড কুয়েরি ল্যাঙ্গুয়েজের মূল ধারণা।',
                'type' => TopicType::DATABASE,
            ],
            [
                'name' => 'টেবিল তৈরি ও ডেটা ইনসার্ট',
                'name_en' => 'Creating Tables and Inserting Data',
                'description' => 'SQL দিয়ে টেবিল তৈরি এবং ডেটা যোগ করার পদ্ধতি।',
                'type' => TopicType::PRACTICAL,
            ],
            [
                'name' => 'ডেটা কুয়েরি ও রিপোর্ট',
                'name_en' => 'Data Query and Reports',
                'description' => 'ডেটাবেস থেকে তথ্য খোঁজা এবং রিপোর্ট তৈরি।',
                'type' => TopicType::DATABASE,
            ],
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chapter = Chapter::inRandomOrder()->first();
        $chapterOrder = $chapter ? $chapter->order : 1;
        
        // Get topics for this chapter, or fallback to chapter 1
        $topics = $this->hscTopics[$chapterOrder] ?? $this->hscTopics[1];
        $selectedTopic = fake()->randomElement($topics);

        return [
            'chapter_id' => $chapter?->id ?? Chapter::factory(),
            'name' => $selectedTopic['name'],
            'name_en' => $selectedTopic['name_en'],
            'description' => $selectedTopic['description'],
            'type' => $selectedTopic['type']->value,
            'order' => fake()->numberBetween(1, count($topics)),
            'difficulty_level' => fake()->numberBetween(1, 5),
            'is_active' => fake()->boolean(95), // 95% topics are active
            'learning_objectives' => fake()->optional()->words(10, true), // Store as JSON-compatible string
        ];
    }

    /**
     * Create topic for specific chapter
     */
    public function forChapter(int $chapterOrder): static
    {
        return $this->state(function () use ($chapterOrder) {
            $topics = $this->hscTopics[$chapterOrder] ?? $this->hscTopics[1];
            $selectedTopic = fake()->randomElement($topics);
            
            return [
                'chapter_id' => Chapter::where('order', $chapterOrder)->first()?->id,
                'name' => $selectedTopic['name'],
                'name_en' => $selectedTopic['name_en'],
                'description' => $selectedTopic['description'],
                'type' => $selectedTopic['type']->value,
            ];
        });
    }

    /**
     * Create topic with specific type
     */
    public function ofType(TopicType $type): static
    {
        return $this->state([
            'type' => $type->value,
        ]);
    }

    /**
     * Create theory topic
     */
    public function theory(): static
    {
        return $this->ofType(TopicType::THEORY);
    }

    /**
     * Create practical topic
     */
    public function practical(): static
    {
        return $this->ofType(TopicType::PRACTICAL);
    }

    /**
     * Create programming topic
     */
    public function programming(): static
    {
        return $this->ofType(TopicType::PROGRAMMING);
    }

    /**
     * Create database topic
     */
    public function database(): static
    {
        return $this->ofType(TopicType::DATABASE);
    }

    /**
     * Create networking topic
     */
    public function networking(): static
    {
        return $this->ofType(TopicType::NETWORKING);
    }

    /**
     * Create hardware topic
     */
    public function hardware(): static
    {
        return $this->ofType(TopicType::HARDWARE);
    }

    /**
     * Create active topic
     */
    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    /**
     * Create inactive topic
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create topic with high difficulty
     */
    public function difficult(): static
    {
        return $this->state([
            'difficulty_level' => fake()->numberBetween(4, 5),
        ]);
    }

    /**
     * Create topic with easy difficulty
     */
    public function easy(): static
    {
        return $this->state([
            'difficulty_level' => fake()->numberBetween(1, 2),
        ]);
    }
}