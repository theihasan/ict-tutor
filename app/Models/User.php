<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Auth\Passwords\CanResetPassword;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'bio',
        'profile_image',
        'date_of_birth',
        'gender',
        'institution',
        'class',
        'district',
        'division',
        'hsc_year',
        'level',
        'total_points',
        'current_streak',
        'longest_streak',
        'last_activity_at',
        'preferences',
        'email_notifications',
        'timezone',
        'language',
        'is_verified',
        'is_active',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_activity_at' => 'datetime',
            'preferences' => 'array',
            'email_notifications' => 'boolean',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'total_points' => 'integer',
            'level' => 'integer',
            'current_streak' => 'integer',
            'longest_streak' => 'integer',
            'hsc_year' => 'integer',
        ];
    }

    /**
     * Get the test attempts for the user.
     */
    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Get the user progress records for the user.
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Get the leaderboard entries for the user.
     */
    public function leaderboards(): HasMany
    {
        return $this->hasMany(Leaderboard::class);
    }

    /**
     * Get the user answers through test attempts.
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class, 'test_attempt_id', 'id')
            ->join('test_attempts', 'user_answers.test_attempt_id', '=', 'test_attempts.id')
            ->where('test_attempts.user_id', $this->id);
    }

    /**
     * Get user's weak areas based on progress.
     */
    public function getWeakAreas()
    {
        return $this->userProgress()->where('is_weak_area', true)->get();
    }

    /**
     * Get user's current level name.
     */
    public function getLevelName(): string
    {
        $levelNames = [
            1 => 'Beginner',
            2 => 'Novice', 
            3 => 'Intermediate',
            4 => 'Advanced',
            5 => 'Expert',
            6 => 'Master',
            7 => 'Grandmaster',
            8 => 'Legend',
            9 => 'Mythic',
            10 => 'God Tier',
        ];

        return $levelNames[$this->level ?? 1] ?? 'Beginner';
    }

    /**
     * Check if user is premium based on level.
     */
    public function isPremium(): bool
    {
        return $this->level >= 5; // Level 5+ considered premium
    }

    /**
     * Check if user is high-level (admin-like).
     */
    public function isHighLevel(): bool
    {
        return $this->level >= 8; // Level 8+ considered high-level
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get user's achievement level.
     */
    public function getAchievementLevel(): string
    {
        if ($this->level >= 8) return 'Expert';
        if ($this->level >= 5) return 'Advanced';
        if ($this->level >= 3) return 'Intermediate';
        return 'Beginner';
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'is_verified' => true,
        ])->save();
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        // Email verification disabled for now
        // $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    /**
     * Update user's last activity timestamp.
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Add points to user's total.
     */
    public function addPoints(int $points): void
    {
        $this->increment('total_points', $points);
        $this->checkLevelUp();
    }

    /**
     * Check if user should level up based on points.
     */
    private function checkLevelUp(): void
    {
        $pointsForNextLevel = $this->getPointsRequiredForLevel($this->level + 1);
        
        if ($this->total_points >= $pointsForNextLevel) {
            $this->increment('level');
        }
    }

    /**
     * Get points required for a specific level.
     */
    private function getPointsRequiredForLevel(int $level): int
    {
        // Level progression: Level 1 = 0, Level 2 = 100, Level 3 = 250, etc.
        return match($level) {
            1 => 0,
            2 => 100,
            3 => 250,
            4 => 500,
            5 => 1000,
            6 => 2000,
            7 => 4000,
            8 => 8000,
            9 => 15000,
            10 => 30000,
            default => 30000 + (($level - 10) * 10000),
        };
    }

    /**
     * Update user's streak.
     */
    public function updateStreak(): void
    {
        $lastActivity = $this->last_activity_at;
        $now = now();
        
        if (!$lastActivity) {
            // First activity
            $this->update([
                'current_streak' => 1,
                'longest_streak' => max($this->longest_streak, 1),
                'last_activity_at' => $now,
            ]);
        } elseif ($lastActivity->isToday()) {
            // Same day, don't update streak
            $this->update(['last_activity_at' => $now]);
        } elseif ($lastActivity->isYesterday()) {
            // Consecutive day
            $newStreak = $this->current_streak + 1;
            $this->update([
                'current_streak' => $newStreak,
                'longest_streak' => max($this->longest_streak, $newStreak),
                'last_activity_at' => $now,
            ]);
        } else {
            // Streak broken
            $this->update([
                'current_streak' => 1,
                'last_activity_at' => $now,
            ]);
        }
    }
}
