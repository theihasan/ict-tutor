<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
                // Basic Question Setup - Most Important First
                Section::make('Question Setup')
                    ->description('Start by defining the basic question information')
                    ->icon('heroicon-o-academic-cap')
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->label('Question Type')
                            ->options([
                                QuestionType::MULTIPLE_CHOICE->value => QuestionType::MULTIPLE_CHOICE->label(),
                                QuestionType::TRUE_FALSE->value => QuestionType::TRUE_FALSE->label(),
                                QuestionType::FILL_IN_BLANK->value => QuestionType::FILL_IN_BLANK->label(),
                                QuestionType::SHORT_ANSWER->value => QuestionType::SHORT_ANSWER->label(),
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
                            ->helperText(fn (Get $get): string => $get('type')
                                    ? QuestionType::from($get('type'))->description()
                                    : 'Select a question type to see its description'
                            ),

                        Grid::make(2)
                            ->schema([
                                Select::make('difficulty_level')
                                    ->label('Difficulty')
                                    ->options([
                                        Difficulty::VERY_EASY->value => '⭐ '.Difficulty::VERY_EASY->label(),
                                        Difficulty::EASY->value => '⭐⭐ '.Difficulty::EASY->label(),
                                        Difficulty::MEDIUM->value => '⭐⭐⭐ '.Difficulty::MEDIUM->label(),
                                        Difficulty::HARD->value => '⭐⭐⭐⭐ '.Difficulty::HARD->label(),
                                        Difficulty::VERY_HARD->value => '⭐⭐⭐⭐⭐ '.Difficulty::VERY_HARD->label(),
                                    ])
                                    ->default(Difficulty::EASY)
                                    ->required()
                                    ->helperText(fn (Get $get): string => $get('difficulty_level')
                                            ? Difficulty::from($get('difficulty_level'))->description()
                                            : ''
                                    ),

                                TextInput::make('marks')
                                    ->label('Points')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(10)
                                    ->default(1)
                                    ->suffix('pts')
                                    ->helperText('How many points this question is worth'),
                            ]),

                        Select::make('chapter_id')
                            ->label('Chapter')
                            ->relationship('chapter', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('topic_id', null)),

                        Select::make('topic_id')
                            ->label('Topic (Optional)')
                            ->relationship(
                                name: 'topic',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query, Get $get) => $get('chapter_id')
                                        ? $query->where('chapter_id', $get('chapter_id'))
                                        : $query
                            )
                            ->searchable()
                            ->preload()
                            ->helperText('Select a chapter first to see available topics'),
                    ]),

                // Question Content
                Section::make('Question Content')
                    ->description('Write your question text and explanation')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Textarea::make('question')
                            ->label('Question Text (Bengali)')
                            ->required()
                            ->rows(4)
                            ->placeholder('আপনার প্রশ্নটি এখানে লিখুন...')
                            ->helperText('Clear, concise question text in Bengali')
                            ->columnSpanFull(),

                        Textarea::make('question_en')
                            ->label('Question Text (English - Optional)')
                            ->rows(4)
                            ->placeholder('Write your question here...')
                            ->helperText('Optional English translation')
                            ->columnSpanFull(),

                        Textarea::make('explanation')
                            ->label('Answer Explanation (Optional)')
                            ->rows(3)
                            ->placeholder('Explain why this is the correct answer...')
                            ->helperText('Help students understand the reasoning behind the answer')
                            ->columnSpanFull(),
                    ]),

                // Answer Options - Only show for relevant question types
                Section::make('Answer Options')
                    ->description('Set up the possible answers for your question')
                    ->icon('heroicon-o-list-bullet')
                    ->visible(fn (Get $get): bool => in_array($get('type'), [
                        QuestionType::MULTIPLE_CHOICE->value,
                        QuestionType::TRUE_FALSE->value,
                    ]))
                    ->schema([
                        // True/False Simple Toggle
                        Select::make('correct_answer')
                            ->label('Correct Answer')
                            ->options([
                                'A' => 'True',
                                'B' => 'False',
                            ])
                            ->default('A')
                            ->required()
                            ->visible(fn (Get $get): bool => $get('type') === QuestionType::TRUE_FALSE->value)
                            ->helperText('Select the correct answer for this True/False question'),

                        // Multiple Choice Options
                        Repeater::make('options')
                            ->relationship('options')
                            ->visible(fn (Get $get): bool => $get('type') === QuestionType::MULTIPLE_CHOICE->value)
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('option_key')
                                            ->label('Key')
                                            ->placeholder('A')
                                            ->required()
                                            ->maxLength(1)
                                            ->default(function ($get) {
                                                $options = $get('../../options') ?? [];
                                                $keys = ['A', 'B', 'C', 'D', 'E', 'F'];

                                                return $keys[count($options)] ?? 'A';
                                            })
                                            ->rules([
                                                'required',
                                                'max:1',
                                                'regex:/^[A-Za-z]$/',
                                            ])
                                            ->columnSpan(1),

                                        Textarea::make('option_text')
                                            ->label('Option Text')
                                            ->required()
                                            ->rows(2)
                                            ->placeholder('Enter the option text...')
                                            ->columnSpan(2),

                                        Toggle::make('is_correct')
                                            ->label('Correct?')
                                            ->columnSpan(1),
                                    ]),

                                Textarea::make('option_text_en')
                                    ->label('English Translation (Optional)')
                                    ->rows(2)
                                    ->placeholder('English version of this option...')
                                    ->columnSpanFull(),

                                FileUpload::make('image_url')
                                    ->label('Option Image (Optional)')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('Add an image if this option includes visual content')
                                    ->columnSpanFull(),

                                // Auto-calculate order
                                TextInput::make('order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(function ($get) {
                                        $options = $get('../../options') ?? [];

                                        return count($options);
                                    })
                                    ->hidden(),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->hidden(),
                            ])
                            ->defaultItems(4)
                            ->minItems(2)
                            ->maxItems(6)
                            ->addActionLabel('+ Add Another Option')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => isset($state['option_key'], $state['option_text'])
                                    ? "{$state['option_key']}. ".\Str::limit($state['option_text'], 30)
                                    : 'New Option'
                            )
                            ->helperText('Create at least 2 options. Mark exactly one as correct.'),

                        // Auto-set correct answer for MCQ
                        TextInput::make('correct_answer')
                            ->label('Correct Answer Key')
                            ->required()
                            ->visible(fn (Get $get): bool => $get('type') === QuestionType::MULTIPLE_CHOICE->value)
                            ->placeholder('A')
                            ->maxLength(1)
                            ->rules([
                                'required',
                                'max:1',
                                'regex:/^[A-Za-z]$/',
                            ])
                            ->helperText('Enter the letter of the correct option (A, B, C, D, etc.)')
                            ->live(),
                    ]),

                // Non-MCQ Answer Section
                Section::make('Answer Configuration')
                    ->description('Set up the answer for this question')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Get $get): bool => ! in_array($get('type'), [
                        QuestionType::MULTIPLE_CHOICE->value,
                        QuestionType::TRUE_FALSE->value,
                    ]))
                    ->schema([
                        Textarea::make('correct_answer')
                            ->label('Sample Answer/Keywords')
                            ->required()
                            ->rows(3)
                            ->placeholder('Provide the correct answer or key terms...')
                            ->helperText('For auto-grading, provide exact keywords or phrases separated by commas'),
                    ]),

                // Optional Settings - Collapsed by default
                Section::make('Additional Settings')
                    ->description('Optional settings and metadata')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('tags')
                                    ->label('Tags')
                                    ->placeholder('programming, loops, fundamentals')
                                    ->helperText('Comma-separated tags for categorizing this question')
                                    ->columnSpan(1),

                                Toggle::make('is_active')
                                    ->label('Publish Immediately')
                                    ->default(true)
                                    ->helperText('Make this question available for use right away')
                                    ->columnSpan(1),
                            ]),

                        Placeholder::make('tips')
                            ->label('💡 Pro Tips')
                            ->content(new \Illuminate\Support\HtmlString('
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Keep questions clear and concise</li>
                                    <li>• Avoid negative statements when possible</li>
                                    <li>• Make sure there\'s only one clearly correct answer</li>
                                    <li>• Use explanations to help students learn from mistakes</li>
                                </ul>
                            ')),
                    ]),

                // Statistics - Only show when editing
                Section::make('Performance Statistics')
                    ->description('Question usage and success metrics')
                    ->icon('heroicon-o-chart-bar')
                    ->visible(fn ($operation) => $operation === 'edit')
                    ->columns(2)
                    ->schema([
                        TextInput::make('usage_count')
                            ->label('Times Used')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->suffix('times')
                            ->columnSpan(1),
                        TextInput::make('success_rate')
                            ->label('Success Rate')
                            ->numeric()
                            ->default(0)
                            ->suffix('%')
                            ->readOnly()
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
