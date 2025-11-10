<?php

namespace App\Filament\Resources\TestAttempts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestAttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('test_id')
                    ->relationship('test', 'title')
                    ->required(),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('completed_at'),
                TextInput::make('time_taken')
                    ->numeric(),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric(),
                TextInput::make('correct_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('wrong_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('skipped_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('obtained_marks')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_marks')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_passed')
                    ->required(),
                TextInput::make('attempt_number')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                Textarea::make('answers')
                    ->columnSpanFull(),
                Textarea::make('time_spent_per_question')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
