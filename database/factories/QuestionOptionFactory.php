<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionOption>
 */
class QuestionOptionFactory extends Factory
{
    /**
     * HSC ICT Question Options by subject area
     */
    private array $optionTemplates = [
        'theory' => [
            'ict_basics' => [
                'A' => ['ICT এর পূর্ণরূপ Information and Communication Technology', 'Full form of ICT is Information and Communication Technology'],
                'B' => ['ICT এর পূর্ণরূপ Internet and Computer Technology', 'Full form of ICT is Internet and Computer Technology'],
                'C' => ['ICT এর পূর্ণরূপ Information Control Technology', 'Full form of ICT is Information Control Technology'],
                'D' => ['ICT এর পূর্ণরূপ Integrated Computer Technology', 'Full form of ICT is Integrated Computer Technology'],
            ],
            'hardware' => [
                'A' => ['RAM', 'RAM'],
                'B' => ['ROM', 'ROM'],
                'C' => ['Hard Disk', 'Hard Disk'],
                'D' => ['Cache Memory', 'Cache Memory'],
            ],
        ],
        'networking' => [
            'network_types' => [
                'A' => ['LAN (Local Area Network)', 'LAN (Local Area Network)'],
                'B' => ['WAN (Wide Area Network)', 'WAN (Wide Area Network)'],
                'C' => ['MAN (Metropolitan Area Network)', 'MAN (Metropolitan Area Network)'],
                'D' => ['PAN (Personal Area Network)', 'PAN (Personal Area Network)'],
            ],
        ],
        'programming' => [
            'data_types' => [
                'A' => ['int', 'int'],
                'B' => ['float', 'float'],
                'C' => ['char', 'char'],
                'D' => ['string', 'string'],
            ],
        ],
        'database' => [
            'sql_commands' => [
                'A' => ['SELECT', 'SELECT'],
                'B' => ['INSERT', 'INSERT'],
                'C' => ['UPDATE', 'UPDATE'],
                'D' => ['DELETE', 'DELETE'],
            ],
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = Question::inRandomOrder()->first();
        $optionKey = fake()->randomElement(['A', 'B', 'C', 'D']);
        
        // Generate realistic option text
        $optionText = fake()->sentence(3);
        $optionTextEn = fake()->sentence(3);
        
        // Randomly make this option correct (25% chance for 4-option questions)
        $isCorrect = fake()->boolean(25);

        return [
            'question_id' => $question?->id ?? Question::factory(),
            'option_key' => $optionKey,
            'option_text' => $optionText,
            'option_text_en' => $optionTextEn,
            'is_correct' => $isCorrect,
            'order' => ord($optionKey) - ord('A') + 1, // A=1, B=2, C=3, D=4
            'image_url' => fake()->optional(10)->imageUrl(300, 200, 'technology'),
            'explanation' => fake()->optional(30)->paragraph(),
            'is_active' => fake()->boolean(95),
        ];
    }

    /**
     * Create correct option
     */
    public function correct(): static
    {
        return $this->state([
            'is_correct' => true,
        ]);
    }

    /**
     * Create incorrect option
     */
    public function incorrect(): static
    {
        return $this->state([
            'is_correct' => false,
        ]);
    }

    /**
     * Create option with specific key
     */
    public function withKey(string $key): static
    {
        return $this->state([
            'option_key' => strtoupper($key),
            'order' => ord(strtoupper($key)) - ord('A') + 1,
        ]);
    }

    /**
     * Create ordered set of options for a question
     */
    public static function createSetForQuestion(Question $question, array $optionsData): void
    {
        foreach ($optionsData as $key => $data) {
            self::factory()->create([
                'question_id' => $question->id,
                'option_key' => $key,
                'option_text' => $data['text'],
                'option_text_en' => $data['text_en'] ?? $data['text'],
                'is_correct' => $data['correct'] ?? false,
                'order' => ord($key) - ord('A') + 1,
                'explanation' => $data['explanation'] ?? null,
                'image_url' => $data['image_url'] ?? null,
            ]);
        }
    }
}
