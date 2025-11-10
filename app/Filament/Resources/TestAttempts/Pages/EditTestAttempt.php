<?php

namespace App\Filament\Resources\TestAttempts\Pages;

use App\Filament\Resources\TestAttempts\TestAttemptResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditTestAttempt extends EditRecord
{
    protected static string $resource = TestAttemptResource::class;

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
