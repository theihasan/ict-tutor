<?php

namespace App\Filament\Resources\Questions\Pages;

use App\Enums\QuestionType;
use App\Filament\Resources\Questions\QuestionResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Question created successfully!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Convert tags string to array
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        // Initialize statistics for new questions
        $data['usage_count'] = 0;
        $data['success_rate'] = 0;

        return $data;
    }

    protected function afterCreate(): void
    {
        $questionType = $this->record->type;
        $optionsCount = $this->record->options()->count();

        // Show helpful tips based on question type
        if ($questionType === QuestionType::MULTIPLE_CHOICE && $optionsCount < 3) {
            Notification::make()
                ->title('Tip: Add more options')
                ->body('Multiple choice questions work best with 3-5 options for better assessment.')
                ->warning()
                ->send();
        }

        if ($questionType === QuestionType::MULTIPLE_CHOICE) {
            $correctOptions = $this->record->options()->where('is_correct', true)->count();
            if ($correctOptions === 0) {
                Notification::make()
                    ->title('No correct answer marked')
                    ->body('Don\'t forget to mark one option as correct in the options section.')
                    ->warning()
                    ->send();
            } elseif ($correctOptions > 1) {
                Notification::make()
                    ->title('Multiple correct answers')
                    ->body('Multiple choice questions should have exactly one correct answer.')
                    ->warning()
                    ->send();
            }
        }
    }
}
