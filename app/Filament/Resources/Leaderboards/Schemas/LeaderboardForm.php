<?php

namespace App\Filament\Resources\Leaderboards\Schemas;

use App\Enums\Period;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LeaderboardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('period')
                    ->options(Period::class)
                    ->default('all_time')
                    ->required(),
                TextInput::make('total_points')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('tests_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('average_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('current_streak')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('longest_streak')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('rank_position')
                    ->numeric(),
                DateTimePicker::make('last_activity_at'),
                Textarea::make('achievements')
                    ->columnSpanFull(),
                TextInput::make('level')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
