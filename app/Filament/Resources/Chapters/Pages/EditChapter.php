<?php

namespace App\Filament\Resources\Chapters\Pages;

use App\Filament\Resources\Chapters\ChapterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditChapter extends EditRecord
{
    protected static string $resource = ChapterResource::class;

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
