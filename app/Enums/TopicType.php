<?php

namespace App\Enums;

enum TopicType: string
{
    case THEORY = 'theory';
    case PRACTICAL = 'practical';
    case MIXED = 'mixed';
    case PROGRAMMING = 'programming';
    case HARDWARE = 'hardware';
    case SOFTWARE = 'software';
    case NETWORKING = 'networking';
    case DATABASE = 'database';

    /**
     * Get all topic type values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get topic type label for display
     */
    public function label(): string
    {
        return match($this) {
            self::THEORY => 'Theory',
            self::PRACTICAL => 'Practical',
            self::MIXED => 'Theory & Practical',
            self::PROGRAMMING => 'Programming',
            self::HARDWARE => 'Hardware',
            self::SOFTWARE => 'Software',
            self::NETWORKING => 'Networking',
            self::DATABASE => 'Database',
        };
    }

    /**
     * Get topic type description
     */
    public function description(): string
    {
        return match($this) {
            self::THEORY => 'Theoretical concepts and knowledge',
            self::PRACTICAL => 'Hands-on practical work',
            self::MIXED => 'Combination of theory and practical',
            self::PROGRAMMING => 'Programming and coding concepts',
            self::HARDWARE => 'Computer hardware components',
            self::SOFTWARE => 'Software applications and systems',
            self::NETWORKING => 'Network and communication systems',
            self::DATABASE => 'Database design and management',
        };
    }

    /**
     * Get topic type color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::THEORY => 'blue',
            self::PRACTICAL => 'green',
            self::MIXED => 'purple',
            self::PROGRAMMING => 'orange',
            self::HARDWARE => 'red',
            self::SOFTWARE => 'indigo',
            self::NETWORKING => 'teal',
            self::DATABASE => 'yellow',
        };
    }

    /**
     * Get icon for topic type
     */
    public function icon(): string
    {
        return match($this) {
            self::THEORY => 'book-open',
            self::PRACTICAL => 'wrench',
            self::MIXED => 'puzzle-piece',
            self::PROGRAMMING => 'code',
            self::HARDWARE => 'cpu',
            self::SOFTWARE => 'desktop-computer',
            self::NETWORKING => 'globe',
            self::DATABASE => 'database',
        };
    }
}