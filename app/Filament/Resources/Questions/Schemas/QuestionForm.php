<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\Difficulty;
use App\Enums\QuestionType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('chapter_id')
                    ->relationship('chapter', 'name')
                    ->required(),
                Select::make('topic_id')
                    ->relationship('topic', 'name'),
                Textarea::make('question')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('question_en')
                    ->columnSpanFull(),
                TextInput::make('correct_answer')
                    ->required(),
                Textarea::make('explanation')
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(QuestionType::class)
                    ->default('mcq')
                    ->required(),
                Select::make('difficulty_level')
                    ->options(Difficulty::class)
                    ->default('easy')
                    ->required(),
                TextInput::make('marks')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('tags')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('usage_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('success_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
