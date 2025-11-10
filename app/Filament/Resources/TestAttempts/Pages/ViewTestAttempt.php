<?php

namespace App\Filament\Resources\TestAttempts\Pages;

use App\Filament\Resources\TestAttempts\TestAttemptResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewTestAttempt extends ViewRecord
{
    protected static string $resource = TestAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare),
        ];
    }
}
