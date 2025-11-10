<?php

namespace App\Filament\Resources\Leaderboards\Pages;

use App\Filament\Resources\Leaderboards\LeaderboardResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditLeaderboard extends EditRecord
{
    protected static string $resource = LeaderboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye),
            DeleteAction::make()
                ->icon(Heroicon::Trash),
        ];
    }
}
