<?php

namespace App\Filament\Resources\QuestionOptions\Pages;

use App\Filament\Resources\QuestionOptions\QuestionOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditQuestionOption extends EditRecord
{
    protected static string $resource = QuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->icon(Heroicon::Trash),
        ];
    }
}
