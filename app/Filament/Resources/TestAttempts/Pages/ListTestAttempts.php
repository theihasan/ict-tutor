<?php

namespace App\Filament\Resources\TestAttempts\Pages;

use App\Filament\Resources\TestAttempts\TestAttemptResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListTestAttempts extends ListRecords
{
    protected static string $resource = TestAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::Plus),
        ];
    }
}
