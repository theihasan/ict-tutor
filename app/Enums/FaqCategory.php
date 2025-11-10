<?php

namespace App\Enums;

enum FaqCategory: string
{
    case GENERAL = 'general';
    case TECHNICAL = 'technical';
    case ACCOUNT = 'account';

    public function label(): string
    {
        return match($this) {
            self::GENERAL => 'সাধারণ',
            self::TECHNICAL => 'কারিগরি',
            self::ACCOUNT => 'অ্যাকাউন্ট',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}