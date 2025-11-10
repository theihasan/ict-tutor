<?php

namespace App\Filament\Resources\Chapters\Pages;

use App\Filament\Resources\Chapters\ChapterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListChapters extends ListRecords
{
    protected static string $resource = ChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::Plus),
        ];
    }
}
