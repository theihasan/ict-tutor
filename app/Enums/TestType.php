<?php

namespace App\Enums;

enum TestType: string
{
    case MODEL_TEST = 'model_test';
    case PRACTICE_TEST = 'practice_test';
    case CHAPTER_TEST = 'chapter_test';
    case TOPIC_TEST = 'topic_test';
    case FINAL_EXAM = 'final_exam';
    case MOCK_EXAM = 'mock_exam';
    case QUICK_QUIZ = 'quick_quiz';
    case TIMED_CHALLENGE = 'timed_challenge';
    case CUSTOM_TEST = 'custom_test';

    /**
     * Get all test type values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get test type label for display
     */
    public function label(): string
    {
        return match($this) {
            self::MODEL_TEST => 'Model Test',
            self::PRACTICE_TEST => 'Practice Test',
            self::CHAPTER_TEST => 'Chapter Test',
            self::TOPIC_TEST => 'Topic Test',
            self::FINAL_EXAM => 'Final Exam',
            self::MOCK_EXAM => 'Mock Exam',
            self::QUICK_QUIZ => 'Quick Quiz',
            self::TIMED_CHALLENGE => 'Timed Challenge',
            self::CUSTOM_TEST => 'Custom Test',
        };
    }

    /**
     * Get test type description
     */
    public function description(): string
    {
        return match($this) {
            self::MODEL_TEST => 'HSC board exam pattern test',
            self::PRACTICE_TEST => 'General practice questions',
            self::CHAPTER_TEST => 'Test covering entire chapter',
            self::TOPIC_TEST => 'Test focusing on specific topic',
            self::FINAL_EXAM => 'Comprehensive final examination',
            self::MOCK_EXAM => 'Full-length mock examination',
            self::QUICK_QUIZ => 'Short quiz with few questions',
            self::TIMED_CHALLENGE => 'Speed-based challenge test',
            self::CUSTOM_TEST => 'User-created custom test',
        };
    }

    /**
     * Get default duration in minutes
     */
    public function defaultDuration(): int
    {
        return match($this) {
            self::MODEL_TEST => 180,      // 3 hours
            self::PRACTICE_TEST => 60,    // 1 hour
            self::CHAPTER_TEST => 90,     // 1.5 hours
            self::TOPIC_TEST => 30,       // 30 minutes
            self::FINAL_EXAM => 210,      // 3.5 hours
            self::MOCK_EXAM => 180,       // 3 hours
            self::QUICK_QUIZ => 15,       // 15 minutes
            self::TIMED_CHALLENGE => 10,  // 10 minutes
            self::CUSTOM_TEST => 60,      // 1 hour (default)
        };
    }

    /**
     * Get default number of questions
     */
    public function defaultQuestionCount(): int
    {
        return match($this) {
            self::MODEL_TEST => 50,
            self::PRACTICE_TEST => 20,
            self::CHAPTER_TEST => 30,
            self::TOPIC_TEST => 15,
            self::FINAL_EXAM => 70,
            self::MOCK_EXAM => 50,
            self::QUICK_QUIZ => 5,
            self::TIMED_CHALLENGE => 10,
            self::CUSTOM_TEST => 20,
        };
    }

    /**
     * Get points multiplier for this test type
     */
    public function pointsMultiplier(): float
    {
        return match($this) {
            self::MODEL_TEST => 2.0,
            self::PRACTICE_TEST => 1.0,
            self::CHAPTER_TEST => 1.5,
            self::TOPIC_TEST => 1.2,
            self::FINAL_EXAM => 3.0,
            self::MOCK_EXAM => 2.5,
            self::QUICK_QUIZ => 0.8,
            self::TIMED_CHALLENGE => 1.8,
            self::CUSTOM_TEST => 1.0,
        };
    }

    /**
     * Check if test type is exam-level
     */
    public function isExamLevel(): bool
    {
        return match($this) {
            self::MODEL_TEST,
            self::FINAL_EXAM,
            self::MOCK_EXAM => true,
            default => false,
        };
    }

    /**
     * Check if test type allows retries
     */
    public function allowsRetries(): bool
    {
        return match($this) {
            self::PRACTICE_TEST,
            self::CHAPTER_TEST,
            self::TOPIC_TEST,
            self::QUICK_QUIZ,
            self::CUSTOM_TEST => true,
            self::MODEL_TEST,
            self::FINAL_EXAM,
            self::MOCK_EXAM,
            self::TIMED_CHALLENGE => false,
        };
    }

    /**
     * Get test type color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::MODEL_TEST => 'red',
            self::PRACTICE_TEST => 'blue',
            self::CHAPTER_TEST => 'green',
            self::TOPIC_TEST => 'yellow',
            self::FINAL_EXAM => 'purple',
            self::MOCK_EXAM => 'indigo',
            self::QUICK_QUIZ => 'pink',
            self::TIMED_CHALLENGE => 'orange',
            self::CUSTOM_TEST => 'gray',
        };
    }

    /**
     * Get icon for test type
     */
    public function icon(): string
    {
        return match($this) {
            self::MODEL_TEST => 'academic-cap',
            self::PRACTICE_TEST => 'pencil',
            self::CHAPTER_TEST => 'book-open',
            self::TOPIC_TEST => 'document-text',
            self::FINAL_EXAM => 'shield-check',
            self::MOCK_EXAM => 'clipboard-check',
            self::QUICK_QUIZ => 'lightning-bolt',
            self::TIMED_CHALLENGE => 'clock',
            self::CUSTOM_TEST => 'cog',
        };
    }
}