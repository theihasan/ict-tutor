<?php

namespace App\Filament\Resources\Chapters\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ChapterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Enter the chapter name, description, and translations')
                    ->icon(Heroicon::OutlinedInformationCircle)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Chapter Name')
                            ->required()
                            ->placeholder('Enter chapter name'),

                        TextInput::make('name_en')
                            ->label('English Name')
                            ->placeholder('Enter English translation'),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Enter chapter description...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Visual & Display')
                    ->description('Configure the chapter appearance and ordering')
                    ->icon(Heroicon::OutlinedPaintBrush)
                    ->columns(3)
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('Enter icon name or class')
                            ->helperText('CSS class or icon identifier'),

                        ColorPicker::make('color')
                            ->label('Theme Color')
                            ->required()
                            ->default('#3B82F6')
                            ->helperText('Color used for chapter branding'),

                        TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ]),

                Section::make('Status & Metadata')
                    ->description('Chapter status and statistical information')
                    ->icon(Heroicon::OutlinedCog6Tooth)
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->required()
                            ->default(true)
                            ->helperText('Whether this chapter is available to students'),

                        Textarea::make('topics_count')
                            ->label('Topics Count Info')
                            ->placeholder('Additional information about topic count...')
                            ->rows(2)
                            ->helperText('Optional metadata about topics in this chapter'),
                    ]),
            ]);
    }
}
