<?php

namespace App\Enums;

enum QuestionType: string
{
    case MULTIPLE_CHOICE = 'multiple_choice';
    case TRUE_FALSE = 'true_false';
    case FILL_IN_BLANK = 'fill_in_blank';
    case SHORT_ANSWER = 'short_answer';
    case CODE_SNIPPET = 'code_snippet';
    case IMAGE_BASED = 'image_based';
    case DRAG_DROP = 'drag_drop';
    case MATCHING = 'matching';

    /**
     * Get all question type values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get question type label for display
     */
    public function label(): string
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::TRUE_FALSE => 'True/False',
            self::FILL_IN_BLANK => 'Fill in the Blank',
            self::SHORT_ANSWER => 'Short Answer',
            self::CODE_SNIPPET => 'Code Snippet',
            self::IMAGE_BASED => 'Image Based',
            self::DRAG_DROP => 'Drag & Drop',
            self::MATCHING => 'Matching',
        };
    }

    /**
     * Get question type description
     */
    public function description(): string
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 'Select one correct answer from multiple options',
            self::TRUE_FALSE => 'Choose between True or False',
            self::FILL_IN_BLANK => 'Fill in the missing word or phrase',
            self::SHORT_ANSWER => 'Provide a brief written answer',
            self::CODE_SNIPPET => 'Code-related question with syntax highlighting',
            self::IMAGE_BASED => 'Question based on an image or diagram',
            self::DRAG_DROP => 'Drag items to correct positions',
            self::MATCHING => 'Match items from two columns',
        };
    }

    /**
     * Get question type icon
     */
    public function icon(): string
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 'check-circle',
            self::TRUE_FALSE => 'toggle-left',
            self::FILL_IN_BLANK => 'edit',
            self::SHORT_ANSWER => 'file-text',
            self::CODE_SNIPPET => 'code',
            self::IMAGE_BASED => 'image',
            self::DRAG_DROP => 'move',
            self::MATCHING => 'link',
        };
    }

    /**
     * Check if question type supports auto-grading
     */
    public function isAutoGradable(): bool
    {
        return match($this) {
            self::MULTIPLE_CHOICE,
            self::TRUE_FALSE,
            self::DRAG_DROP,
            self::MATCHING => true,
            self::FILL_IN_BLANK,
            self::SHORT_ANSWER,
            self::CODE_SNIPPET,
            self::IMAGE_BASED => false,
        };
    }

    /**
     * Get default points for this question type
     */
    public function defaultPoints(): int
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 1,
            self::TRUE_FALSE => 1,
            self::FILL_IN_BLANK => 2,
            self::SHORT_ANSWER => 3,
            self::CODE_SNIPPET => 5,
            self::IMAGE_BASED => 2,
            self::DRAG_DROP => 3,
            self::MATCHING => 4,
        };
    }

    /**
     * Get expected answer format
     */
    public function answerFormat(): string
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 'Single letter (A, B, C, D)',
            self::TRUE_FALSE => 'Boolean (True/False)',
            self::FILL_IN_BLANK => 'Text string',
            self::SHORT_ANSWER => 'Text paragraph',
            self::CODE_SNIPPET => 'Code block',
            self::IMAGE_BASED => 'Letter or text based on image',
            self::DRAG_DROP => 'Position coordinates',
            self::MATCHING => 'Paired associations',
        };
    }
}