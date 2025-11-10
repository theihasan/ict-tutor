<?php

namespace App\Filament\Resources\QuestionOptions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question_id')
                    ->relationship('question', 'id')
                    ->required(),
                TextInput::make('option_key')
                    ->required(),
                Textarea::make('option_text')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('option_text_en')
                    ->columnSpanFull(),
                Toggle::make('is_correct')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image_url')
                    ->image(),
                Textarea::make('explanation')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
