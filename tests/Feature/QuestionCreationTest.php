<?php

namespace Tests\Feature;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use App\Filament\Resources\Questions\Pages\CreateQuestion;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuestionCreationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
    }

    public function test_can_create_question_with_options(): void
    {
        $chapter = Chapter::factory()->create();

        $questionData = [
            'chapter_id' => $chapter->id,
            'question' => 'What is the capital of Bangladesh?',
            'correct_answer' => 'A',
            'explanation' => 'Dhaka is the capital and largest city of Bangladesh.',
            'type' => QuestionType::MULTIPLE_CHOICE->value,
            'difficulty_level' => Difficulty::EASY->value,
            'marks' => 1,
            'is_active' => true,
            'options' => [
                [
                    'option_key' => 'A',
                    'option_text' => 'ঢাকা',
                    'is_correct' => true,
                    'is_active' => true,
                    'order' => 0,
                ],
                [
                    'option_key' => 'B',
                    'option_text' => 'চট্টগ্রাম',
                    'is_correct' => false,
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'option_key' => 'C',
                    'option_text' => 'সিলেট',
                    'is_correct' => false,
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'option_key' => 'D',
                    'option_text' => 'রাজশাহী',
                    'is_correct' => false,
                    'is_active' => true,
                    'order' => 3,
                ],
            ],
        ];

        Livewire::test(CreateQuestion::class)
            ->fillForm($questionData)
            ->call('create')
            ->assertHasNoFormErrors();

        // Assert question was created
        $this->assertDatabaseHas('questions', [
            'question' => 'What is the capital of Bangladesh?',
            'correct_answer' => 'A',
            'chapter_id' => $chapter->id,
        ]);

        // Assert options were created
        $question = Question::where('question', 'What is the capital of Bangladesh?')->first();
        $this->assertDatabaseHas('question_options', [
            'question_id' => $question->id,
            'option_key' => 'A',
            'option_text' => 'ঢাকা',
            'is_correct' => true,
        ]);

        $this->assertDatabaseHas('question_options', [
            'question_id' => $question->id,
            'option_key' => 'B',
            'option_text' => 'চট্টগ্রাম',
            'is_correct' => false,
        ]);

        // Assert all 4 options were created
        $this->assertEquals(4, $question->options()->count());
    }

    public function test_question_creation_form_has_repeater_for_options(): void
    {
        Livewire::test(CreateQuestion::class)
            ->assertFormExists()
            ->assertFormFieldExists('options');
    }
}
