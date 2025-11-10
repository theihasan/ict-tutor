<?php

namespace App\Filament\Resources\UserAnswers\Pages;

use App\Filament\Resources\UserAnswers\UserAnswerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListUserAnswers extends ListRecords
{
    protected static string $resource = UserAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::Plus),
        ];
    }
}
