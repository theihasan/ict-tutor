<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $districts = [
            'Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 
            'Rangpur', 'Mymensingh', 'Comilla', 'Narayanganj', 'Gazipur'
        ];
        
        $divisions = [
            'Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 
            'Sylhet', 'Rangpur', 'Mymensingh'
        ];

        $schools = [
            'Notre Dame College', 'Dhaka College', 'Rajuk Uttara Model College',
            'Birshreshtha Munshi Abdur Rouf Public College', 'Adamjee Cantonment College',
            'Chittagong College', 'Rajshahi College', 'Khulna College'
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // Using available database fields only
            'username' => fake()->unique()->userName(),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->dateTimeBetween('-20 years', '-16 years'),
            'bio' => fake()->sentence(10),
            'profile_image' => fake()->imageUrl(200, 200, 'people'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'institution' => fake()->randomElement($schools),
            'class' => fake()->randomElement(['HSC 2024', 'HSC 2025', 'HSC 2026']),
            'district' => fake()->randomElement($districts),
            'division' => fake()->randomElement($divisions),
            'hsc_year' => fake()->numberBetween(2024, 2026),
            'level' => fake()->numberBetween(1, 10),
            'total_points' => fake()->numberBetween(0, 5000),
            'current_streak' => fake()->numberBetween(0, 30),
            'longest_streak' => fake()->numberBetween(0, 50),
            'last_activity_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'preferences' => [
                'theme' => fake()->randomElement(['light', 'dark']),
                'language' => fake()->randomElement(['en', 'bn']),
                'notifications' => fake()->boolean(),
            ],
            'email_notifications' => fake()->boolean(70), // 70% enable email notifications
            'timezone' => 'Asia/Dhaka',
            'language' => fake()->randomElement(['en', 'bn']),
            'is_verified' => fake()->boolean(80), // 80% are verified
            'is_active' => fake()->boolean(95), // 95% are active
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 10,
            'total_points' => fake()->numberBetween(5000, 15000),
            'is_verified' => true,
            'is_active' => true,
        ]);
    }

    /**
     * Create a student user.
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => fake()->numberBetween(1, 5),
            'total_points' => fake()->numberBetween(0, 2000),
        ]);
    }

    /**
     * Create a premium user.
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => fake()->numberBetween(5, 10),
            'total_points' => fake()->numberBetween(2000, 10000),
            'is_verified' => true,
        ]);
    }
}
