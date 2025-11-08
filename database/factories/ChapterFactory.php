<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // HSC ICT Chapter names in Bengali and English
        $chapters = [
            [
                'name' => 'তথ্য ও যোগাযোগ প্রযুক্তি',
                'name_en' => 'Information and Communication Technology',
                'description' => 'তথ্য ও যোগাযোগ প্রযুক্তির মূলভিত্তি এবং এর প্রয়োগ সম্পর্কে জানুন।',
            ],
            [
                'name' => 'কমিউনিকেশন সিস্টেমস ও নেটওয়ার্কিং',
                'name_en' => 'Communication Systems and Networking',
                'description' => 'যোগাযোগ ব্যবস্থা এবং নেটওয়ার্ক প্রযুক্তি সম্পর্কে বিস্তারিত আলোচনা।',
            ],
            [
                'name' => 'সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস',
                'name_en' => 'Number Systems and Digital Devices',
                'description' => 'বিভিন্ন সংখ্যা পদ্ধতি এবং ডিজিটাল যন্ত্রাংশের কার্যপ্রণালী।',
            ],
            [
                'name' => 'ওয়েব ডিজাইন পরিচিতি ও HTML',
                'name_en' => 'Web Design Introduction and HTML',
                'description' => 'ওয়েব ডিজাইনের মূলভিত্তি এবং HTML প্রোগ্রামিং।',
            ],
            [
                'name' => 'প্রোগ্রামিং ভাষা',
                'name_en' => 'Programming Language',
                'description' => 'প্রোগ্রামিং ভাষার ধারণা এবং বিভিন্ন প্রোগ্রামিং ভাষার পরিচয়।',
            ],
            [
                'name' => 'ডেটাবেস ম্যানেজমেন্ট সিস্টেম',
                'name_en' => 'Database Management System',
                'description' => 'ডেটাবেস তৈরি, পরিচালনা এবং SQL প্রোগ্রামিং।',
            ],
        ];

        $selectedChapter = fake()->randomElement($chapters);

        return [
            'name' => $selectedChapter['name'],
            'name_en' => $selectedChapter['name_en'],
            'description' => $selectedChapter['description'],
            'order' => fake()->numberBetween(1, 6),
            'is_active' => fake()->boolean(90), // 90% chapters are active
            'icon' => fake()->randomElement([
                'computer', 'network', 'calculator', 'code', 'database', 'globe'
            ]),
            'color' => fake()->randomElement([
                'blue', 'green', 'purple', 'orange', 'red', 'indigo'
            ]),
        ];
    }

    /**
     * Create a specific HSC ICT chapter.
     */
    public function chapter1(): static
    {
        return $this->state([
            'name' => 'তথ্য ও যোগাযোগ প্রযুক্তি',
            'name_en' => 'Information and Communication Technology',
            'description' => 'তথ্য ও যোগাযোগ প্রযুক্তির মূলভিত্তি এবং এর প্রয়োগ সম্পর্কে জানুন।',
            'order' => 1,
            'is_active' => true,
            'icon' => 'computer',
            'color' => 'blue',
        ]);
    }

    /**
     * Create chapter 2.
     */
    public function chapter2(): static
    {
        return $this->state([
            'name' => 'কমিউনিকেশন সিস্টেমস ও নেটওয়ার্কিং',
            'name_en' => 'Communication Systems and Networking',
            'description' => 'যোগাযোগ ব্যবস্থা এবং নেটওয়ার্ক প্রযুক্তি সম্পর্কে বিস্তারিত আলোচনা।',
            'order' => 2,
            'is_active' => true,
            'icon' => 'network',
            'color' => 'green',
        ]);
    }

    /**
     * Create chapter 3.
     */
    public function chapter3(): static
    {
        return $this->state([
            'name' => 'সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস',
            'name_en' => 'Number Systems and Digital Devices',
            'description' => 'বিভিন্ন সংখ্যা পদ্ধতি এবং ডিজিটাল যন্ত্রাংশের কার্যপ্রণালী।',
            'order' => 3,
            'is_active' => true,
            'icon' => 'calculator',
            'color' => 'purple',
        ]);
    }

    /**
     * Create chapter 4.
     */
    public function chapter4(): static
    {
        return $this->state([
            'name' => 'ওয়েব ডিজাইন পরিচিতি ও HTML',
            'name_en' => 'Web Design Introduction and HTML',
            'description' => 'ওয়েব ডিজাইনের মূলভিত্তি এবং HTML প্রোগ্রামিং।',
            'order' => 4,
            'is_active' => true,
            'icon' => 'globe',
            'color' => 'orange',
        ]);
    }

    /**
     * Create chapter 5.
     */
    public function chapter5(): static
    {
        return $this->state([
            'name' => 'প্রোগ্রামিং ভাষা',
            'name_en' => 'Programming Language',
            'description' => 'প্রোগ্রামিং ভাষার ধারণা এবং বিভিন্ন প্রোগ্রামিং ভাষার পরিচয়।',
            'order' => 5,
            'is_active' => true,
            'icon' => 'code',
            'color' => 'red',
        ]);
    }

    /**
     * Create chapter 6.
     */
    public function chapter6(): static
    {
        return $this->state([
            'name' => 'ডেটাবেস ম্যানেজমেন্ট সিস্টেম',
            'name_en' => 'Database Management System',
            'description' => 'ডেটাবেস তৈরি, পরিচালনা এবং SQL প্রোগ্রামিং।',
            'order' => 6,
            'is_active' => true,
            'icon' => 'database',
            'color' => 'indigo',
        ]);
    }
}