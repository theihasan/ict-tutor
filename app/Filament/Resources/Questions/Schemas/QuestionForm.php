<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question Details')
                    ->columns(2)
                    ->schema([
                        // Basic Info
                        Select::make('type')
                            ->label('Question Type')
                            ->options([
                                QuestionType::MULTIPLE_CHOICE->value => 'Multiple Choice',
                                QuestionType::TRUE_FALSE->value => 'True/False',
                                QuestionType::FILL_IN_BLANK->value => 'Fill in Blank',
                                QuestionType::SHORT_ANSWER->value => 'Short Answer',
                            ])
                            ->default(QuestionType::MULTIPLE_CHOICE)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if ($state) {
                                    $questionType = QuestionType::from($state);
                                    $set('marks', $questionType->defaultPoints());
                                }
                            })
                            ->columnSpan(1),

                        Select::make('difficulty_level')
                            ->label('Difficulty')
                            ->options([
                                Difficulty::VERY_EASY->value => '⭐ Very Easy',
                                Difficulty::EASY->value => '⭐⭐ Easy',
                                Difficulty::MEDIUM->value => '⭐⭐⭐ Medium',
                                Difficulty::HARD->value => '⭐⭐⭐⭐ Hard',
                                Difficulty::VERY_HARD->value => '⭐⭐⭐⭐⭐ Very Hard',
                            ])
                            ->default(Difficulty::EASY)
                            ->required()
                            ->columnSpan(1),

                        Select::make('chapter_id')
                            ->label('Chapter')
                            ->relationship('chapter', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('topic_id', null))
                            ->columnSpan(1),

                        Select::make('topic_id')
                            ->label('Topic')
                            ->relationship(
                                name: 'topic',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query, Get $get) => $get('chapter_id')
                                        ? $query->where('chapter_id', $get('chapter_id'))
                                        : $query
                            )
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        TextInput::make('marks')
                            ->label('Points')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->default(1)
                            ->suffix('pts')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),
                    ]),

                Section::make('Question Text')
                    ->schema([
                        Textarea::make('question')
                            ->label('Question')
                            ->required()
                            ->rows(3)
                            ->placeholder('Write your question here...')
                            ->columnSpanFull(),

                        Textarea::make('explanation')
                            ->label('Explanation (Optional)')
                            ->rows(2)
                            ->placeholder('Explain the correct answer...')
                            ->columnSpanFull(),
                    ]),

                // Answer Options for Multiple Choice
                Section::make('Answer Options')
                    ->visible(fn (Get $get): bool => $get('type') === QuestionType::MULTIPLE_CHOICE->value)
                    ->schema([
                        Repeater::make('options')
                            ->relationship('options')
                            ->simple(
                                TextInput::make('option_text')
                                    ->label('Option')
                                    ->required()
                                    ->placeholder('Enter answer option...')
                            )
                            ->defaultItems(4)
                            ->minItems(2)
                            ->maxItems(6)
                            ->addActionLabel('Add Option')
                            ->reorderableWithButtons()
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $livewire): array {
                                $existingOptions = $livewire->record?->options()->count() ?? 0;
                                $keys = ['A', 'B', 'C', 'D', 'E', 'F'];
                                
                                return array_merge($data, [
                                    'option_key' => $keys[$existingOptions] ?? 'A',
                                    'order' => $existingOptions,
                                    'is_active' => true,
                                    'is_correct' => false,
                                ]);
                            }),

                        Select::make('correct_answer')
                            ->label('Correct Answer')
                            ->options(function (Get $get) {
                                $options = $get('options') ?? [];
                                $result = [];
                                $keys = ['A', 'B', 'C', 'D', 'E', 'F'];
                                
                                $counter = 0;
                                foreach ($options as $option) {
                                    if (isset($option['option_text']) && !empty($option['option_text'])) {
                                        $key = $keys[$counter] ?? $keys[0];
                                        $result[$key] = "{$key}. " . \Str::limit($option['option_text'], 50);
                                        $counter++;
                                    }
                                }
                                
                                return $result;
                            })
                            ->required()
                            ->placeholder('Select the correct answer')
                            ->live(),
                    ]),

                // Answer for True/False
                Section::make('Answer')
                    ->visible(fn (Get $get): bool => $get('type') === QuestionType::TRUE_FALSE->value)
                    ->schema([
                        Select::make('correct_answer')
                            ->label('Correct Answer')
                            ->options([
                                'A' => 'True',
                                'B' => 'False',
                            ])
                            ->default('A')
                            ->required(),
                    ]),

                // Answer for Fill in Blank / Short Answer
                Section::make('Answer')
                    ->visible(fn (Get $get): bool => in_array($get('type'), [
                        QuestionType::FILL_IN_BLANK->value,
                        QuestionType::SHORT_ANSWER->value,
                    ]))
                    ->schema([
                        Textarea::make('correct_answer')
                            ->label('Correct Answer/Keywords')
                            ->required()
                            ->rows(2)
                            ->placeholder('Provide the correct answer or keywords separated by commas...'),
                    ]),
            ]);
    }
}
