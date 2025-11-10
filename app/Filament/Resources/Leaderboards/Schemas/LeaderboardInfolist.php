<?php

namespace App\Filament\Resources\Leaderboards\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LeaderboardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('period')
                    ->badge(),
                TextEntry::make('total_points')
                    ->numeric(),
                TextEntry::make('tests_completed')
                    ->numeric(),
                TextEntry::make('average_score')
                    ->numeric(),
                TextEntry::make('current_streak')
                    ->numeric(),
                TextEntry::make('longest_streak')
                    ->numeric(),
                TextEntry::make('rank_position')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('last_activity_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('achievements')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('level')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
