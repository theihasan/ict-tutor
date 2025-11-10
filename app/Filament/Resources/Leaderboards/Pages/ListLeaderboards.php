<?php

namespace App\Filament\Resources\Leaderboards\Pages;

use App\Filament\Resources\Leaderboards\LeaderboardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListLeaderboards extends ListRecords
{
    protected static string $resource = LeaderboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::Plus),
        ];
    }
}
