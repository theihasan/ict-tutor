<?php

namespace App\Filament\Resources\UserAnswers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserAnswerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('test_attempt_id')
                    ->relationship('testAttempt', 'id')
                    ->required(),
                Select::make('question_id')
                    ->relationship('question', 'id')
                    ->required(),
                TextInput::make('user_answer'),
                Toggle::make('is_correct')
                    ->required(),
                TextInput::make('time_spent')
                    ->numeric(),
                TextInput::make('points_earned')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_flagged')
                    ->required(),
                DateTimePicker::make('answered_at'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('confidence_level')
                    ->required()
                    ->numeric()
                    ->default(3),
                TextInput::make('attempt_count')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
