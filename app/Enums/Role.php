<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';

    /**
     * Get all role values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get role label for display
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::STUDENT => 'Student',
        };
    }

    /**
     * Get role description
     */
    public function description(): string
    {
        return match($this) {
            self::ADMIN => 'System administrator with full access',
            self::STUDENT => 'Student user with learning access',
        };
    }

    /**
     * Check if role has admin privileges
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Check if role is student
     */
    public function isStudent(): bool
    {
        return $this === self::STUDENT;
    }

    /**
     * Get role permissions
     */
    public function permissions(): array
    {
        return match($this) {
            self::ADMIN => [
                'manage_users',
                'manage_content',
                'view_analytics',
                'manage_tests',
                'manage_chapters',
                'manage_questions',
                'view_all_progress',
                'manage_leaderboards',
            ],
            self::STUDENT => [
                'take_tests',
                'view_progress',
                'view_leaderboard',
                'update_profile',
                'view_results',
            ],
        };
    }

    /**
     * Check if role has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }
}