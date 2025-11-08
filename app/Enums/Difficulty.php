<?php

namespace App\Enums;

enum Difficulty: string
{
    case VERY_EASY = 'very_easy';
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
    case VERY_HARD = 'very_hard';

    /**
     * Get all difficulty values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get difficulty label for display
     */
    public function label(): string
    {
        return match($this) {
            self::VERY_EASY => 'Very Easy',
            self::EASY => 'Easy',
            self::MEDIUM => 'Medium',
            self::HARD => 'Hard',
            self::VERY_HARD => 'Very Hard',
        };
    }

    /**
     * Get difficulty description
     */
    public function description(): string
    {
        return match($this) {
            self::VERY_EASY => 'Basic recall questions',
            self::EASY => 'Simple understanding questions',
            self::MEDIUM => 'Application and analysis questions',
            self::HARD => 'Complex problem-solving questions',
            self::VERY_HARD => 'Advanced synthesis and evaluation questions',
        };
    }

    /**
     * Get difficulty color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::VERY_EASY => 'green',
            self::EASY => 'blue',
            self::MEDIUM => 'yellow',
            self::HARD => 'orange',
            self::VERY_HARD => 'red',
        };
    }

    /**
     * Get difficulty level as integer
     */
    public function level(): int
    {
        return match($this) {
            self::VERY_EASY => 1,
            self::EASY => 2,
            self::MEDIUM => 3,
            self::HARD => 4,
            self::VERY_HARD => 5,
        };
    }

    /**
     * Get points multiplier for this difficulty
     */
    public function pointsMultiplier(): float
    {
        return match($this) {
            self::VERY_EASY => 1.0,
            self::EASY => 1.2,
            self::MEDIUM => 1.5,
            self::HARD => 2.0,
            self::VERY_HARD => 2.5,
        };
    }

    /**
     * Get time allocation (in seconds) for this difficulty
     */
    public function timeAllocation(): int
    {
        return match($this) {
            self::VERY_EASY => 30,
            self::EASY => 45,
            self::MEDIUM => 60,
            self::HARD => 90,
            self::VERY_HARD => 120,
        };
    }

    /**
     * Get difficulty from level integer
     */
    public static function fromLevel(int $level): self
    {
        return match($level) {
            1 => self::VERY_EASY,
            2 => self::EASY,
            3 => self::MEDIUM,
            4 => self::HARD,
            5 => self::VERY_HARD,
            default => self::MEDIUM,
        };
    }
}