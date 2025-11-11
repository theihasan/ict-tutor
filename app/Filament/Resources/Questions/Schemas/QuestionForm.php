<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question Details')
                    ->description('Define the question content and metadata')
                    ->icon('heroicon-o-question-mark-circle')
                    ->columns(2)
                    ->schema([
                        Select::make('chapter_id')
                            ->relationship('chapter', 'name')
                            ->required()
                            ->columnSpan(1),
                        Select::make('topic_id')
                            ->relationship('topic', 'name')
                            ->columnSpan(1),
                        Textarea::make('question')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('question_en')
                            ->label('Question (English)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('explanation')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Question Configuration')
                    ->description('Set question type, difficulty, and scoring')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(3)
                    ->schema([
                        Select::make('type')
                            ->options(QuestionType::class)
                            ->default('mcq')
                            ->required()
                            ->columnSpan(1),
                        Select::make('difficulty_level')
                            ->options(Difficulty::class)
                            ->default('easy')
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('marks')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->columnSpan(1),
                        TextInput::make('correct_answer')
                            ->required()
                            ->helperText('Enter the correct answer key (e.g., A, B, C, D)')
                            ->columnSpan(1),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->columnSpan(1),
                        Textarea::make('tags')
                            ->columnSpan(1),
                    ]),

                Section::make('Question Options')
                    ->description('Create multiple choice options for this question')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        Repeater::make('options')
                            ->relationship('options')
                            ->schema([
                                TextInput::make('option_key')
                                    ->label('Option Key')
                                    ->placeholder('A, B, C, D, etc.')
                                    ->required()
                                    ->maxLength(5)
                                    ->columnSpan(1),

                                TextInput::make('order')
                                    ->label('Order')
                                    ->required()
                                    ->numeric()
                                    ->default(fn ($get) => $get('../../options') ? count($get('../../options')) : 0)
                                    ->minValue(0)
                                    ->columnSpan(1),

                                Textarea::make('option_text')
                                    ->label('Option Text (Bengali)')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Textarea::make('option_text_en')
                                    ->label('Option Text (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                FileUpload::make('image_url')
                                    ->label('Option Image')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->columnSpanFull(),

                                Textarea::make('explanation')
                                    ->label('Option Explanation')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Toggle::make('is_correct')
                                    ->label('Correct Answer')
                                    ->columnSpan(1),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->addActionLabel('Add Option')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['option_key'] ?? null),
                    ]),

                Section::make('Statistics')
                    ->description('Usage and performance metrics')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(2)
                    ->schema([
                        TextInput::make('usage_count')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->columnSpan(1),
                        TextInput::make('success_rate')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->suffix('%')
                            ->readOnly()
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
