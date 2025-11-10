<?php

namespace App\Filament\Resources\UserProgress\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserProgressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('chapter_id')
                    ->relationship('chapter', 'name'),
                Select::make('topic_id')
                    ->relationship('topic', 'name'),
                TextInput::make('type')
                    ->required()
                    ->default('chapter'),
                TextInput::make('completion_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_attempts')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('correct_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('wrong_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('accuracy_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('time_spent_minutes')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_practiced_at'),
                Toggle::make('is_weak_area')
                    ->required(),
                TextInput::make('streak_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('best_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('performance_trend')
                    ->columnSpanFull(),
            ]);
    }
}
