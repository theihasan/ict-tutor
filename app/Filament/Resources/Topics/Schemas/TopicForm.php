<?php

namespace App\Filament\Resources\Topics\Schemas;

use App\Enums\TopicType;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Topic details and classification')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('chapter_id')
                                    ->label('Chapter')
                                    ->relationship('chapter', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('name')
                                    ->label('Topic Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter topic name...')
                                    ->columnSpan(1),
                            ]),

                        TextInput::make('name_en')
                            ->label('Topic Name (English)')
                            ->maxLength(255)
                            ->placeholder('Enter English topic name (optional)...'),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->placeholder('Brief description of the topic...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Topic Settings')
                    ->description('Configure topic properties and difficulty')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('type')
                                    ->label('Topic Type')
                                    ->options(TopicType::class)
                                    ->default('theory')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('difficulty_level')
                                    ->label('Difficulty Level')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5)
                                    ->default(1)
                                    ->suffix('/5')
                                    ->columnSpan(1),

                                TextInput::make('order')
                                    ->label('Display Order')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->helperText('Order in which this topic appears')
                                    ->columnSpan(1),
                            ]),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Enable this topic for students')
                            ->default(true),
                    ]),

                Section::make('Learning Content')
                    ->description('Define what students will learn from this topic')
                    ->schema([
                        RichEditor::make('learning_objectives')
                            ->label('Learning Objectives')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->placeholder('Define what students will learn from this topic...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
