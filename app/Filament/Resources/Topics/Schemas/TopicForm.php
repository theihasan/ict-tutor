<?php

namespace App\Filament\Resources\Topics\Schemas;

use App\Enums\TopicType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('chapter_id')
                    ->relationship('chapter', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('name_en'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(TopicType::class)
                    ->default('theory')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('difficulty_level')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('learning_objectives')
                    ->columnSpanFull(),
            ]);
    }
}
