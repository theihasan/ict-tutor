<?php

namespace App\Enums;

enum Period: string
{
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case YEARLY = 'yearly';
    case ALL_TIME = 'all_time';

    /**
     * Get all period values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get period label for display
     */
    public function label(): string
    {
        return match($this) {
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::QUARTERLY => 'Quarterly',
            self::YEARLY => 'Yearly',
            self::ALL_TIME => 'All Time',
        };
    }

    /**
     * Get period description
     */
    public function description(): string
    {
        return match($this) {
            self::WEEKLY => 'Current week performance',
            self::MONTHLY => 'Current month performance',
            self::QUARTERLY => 'Current quarter performance',
            self::YEARLY => 'Current year performance',
            self::ALL_TIME => 'Overall lifetime performance',
        };
    }

    /**
     * Get period duration in days
     */
    public function durationInDays(): int
    {
        return match($this) {
            self::WEEKLY => 7,
            self::MONTHLY => 30,
            self::QUARTERLY => 90,
            self::YEARLY => 365,
            self::ALL_TIME => 0, // No limit
        };
    }

    /**
     * Get reset frequency description
     */
    public function resetFrequency(): string
    {
        return match($this) {
            self::WEEKLY => 'Resets every Monday',
            self::MONTHLY => 'Resets on 1st of each month',
            self::QUARTERLY => 'Resets every 3 months',
            self::YEARLY => 'Resets on January 1st',
            self::ALL_TIME => 'Never resets',
        };
    }

    /**
     * Get next reset date
     */
    public function getNextResetDate(): ?\Carbon\Carbon
    {
        $now = \Carbon\Carbon::now();
        
        return match($this) {
            self::WEEKLY => $now->copy()->startOfWeek()->addWeek(),
            self::MONTHLY => $now->copy()->startOfMonth()->addMonth(),
            self::QUARTERLY => $now->copy()->startOfQuarter()->addQuarter(),
            self::YEARLY => $now->copy()->startOfYear()->addYear(),
            self::ALL_TIME => null,
        };
    }

    /**
     * Get period start date
     */
    public function getPeriodStartDate(): ?\Carbon\Carbon
    {
        $now = \Carbon\Carbon::now();
        
        return match($this) {
            self::WEEKLY => $now->copy()->startOfWeek(),
            self::MONTHLY => $now->copy()->startOfMonth(),
            self::QUARTERLY => $now->copy()->startOfQuarter(),
            self::YEARLY => $now->copy()->startOfYear(),
            self::ALL_TIME => null,
        };
    }

    /**
     * Check if period should be reset
     */
    public function shouldReset(\Carbon\Carbon $lastUpdate): bool
    {
        $now = \Carbon\Carbon::now();
        
        return match($this) {
            self::WEEKLY => $lastUpdate->weekOfYear !== $now->weekOfYear || $lastUpdate->year !== $now->year,
            self::MONTHLY => $lastUpdate->month !== $now->month || $lastUpdate->year !== $now->year,
            self::QUARTERLY => $lastUpdate->quarter !== $now->quarter || $lastUpdate->year !== $now->year,
            self::YEARLY => $lastUpdate->year !== $now->year,
            self::ALL_TIME => false,
        };
    }

    /**
     * Get period icon
     */
    public function icon(): string
    {
        return match($this) {
            self::WEEKLY => 'calendar-week',
            self::MONTHLY => 'calendar',
            self::QUARTERLY => 'calendar-alt',
            self::YEARLY => 'calendar-year',
            self::ALL_TIME => 'infinity',
        };
    }

    /**
     * Get period color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::WEEKLY => 'green',
            self::MONTHLY => 'blue',
            self::QUARTERLY => 'yellow',
            self::YEARLY => 'purple',
            self::ALL_TIME => 'gray',
        };
    }
}