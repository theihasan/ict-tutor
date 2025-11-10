<?php

namespace App\Filament\Resources\Tests\Schemas;

use App\Enums\TestType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('title_en'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(TestType::class)
                    ->default('model_test')
                    ->required(),
                Select::make('chapter_id')
                    ->relationship('chapter', 'name'),
                TextInput::make('duration')
                    ->required()
                    ->numeric(),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric(),
                TextInput::make('total_marks')
                    ->required()
                    ->numeric(),
                TextInput::make('passing_marks')
                    ->required()
                    ->numeric()
                    ->default(40),
                Textarea::make('question_ids')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('settings')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('attempts_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('average_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('topic_id')
                    ->numeric(),
                Toggle::make('is_public')
                    ->required(),
                Toggle::make('allow_retries')
                    ->required(),
                TextInput::make('max_attempts')
                    ->required()
                    ->numeric()
                    ->default(3),
                Textarea::make('instructions')
                    ->columnSpanFull(),
                DateTimePicker::make('scheduled_at'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                Toggle::make('show_results_immediately')
                    ->required(),
                Toggle::make('randomize_questions')
                    ->required(),
                Toggle::make('negative_marking')
                    ->required(),
                TextInput::make('negative_marks_per_question')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->numeric(),
            ]);
    }
}
