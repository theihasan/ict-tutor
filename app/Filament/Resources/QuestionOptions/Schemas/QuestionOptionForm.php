<?php

namespace App\Filament\Resources\QuestionOptions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuestionOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question Selection')
                    ->description('Select the question this option belongs to')
                    ->icon('heroicon-o-question-mark-circle')
                    ->columns(1)
                    ->schema([
                        Select::make('question_id')
                            ->label('Question')
                            ->relationship('question', 'question')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                // Allow creating questions from here if needed
                            ])
                            ->helperText('Search and select the question this option belongs to'),
                    ]),
                
                Section::make('Option Details')
                    ->description('Define the option content and properties')
                    ->icon('heroicon-o-list-bullet')
                    ->columns(2)
                    ->schema([
                        TextInput::make('option_key')
                            ->label('Option Key')
                            ->placeholder('A, B, C, D, etc.')
                            ->required()
                            ->maxLength(5)
                            ->helperText('Usually A, B, C, D for multiple choice')
                            ->columnSpan(1),
                        
                        TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Order in which options appear (0 = first)')
                            ->columnSpan(1),
                        
                        Textarea::make('option_text')
                            ->label('Option Text (Bengali)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('The option text in Bengali'),
                        
                        Textarea::make('option_text_en')
                            ->label('Option Text (English)')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Optional English translation of the option'),
                    ]),
                
                Section::make('Media & Explanation')
                    ->description('Add visual content and explanations')
                    ->icon('heroicon-o-photo')
                    ->columns(1)
                    ->schema([
                        FileUpload::make('image_url')
                            ->label('Option Image')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Optional image for this option (max 2MB)'),
                        
                        Textarea::make('explanation')
                            ->label('Explanation')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Optional explanation for why this option is correct/incorrect'),
                    ]),
                
                Section::make('Settings')
                    ->description('Configure option behavior')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_correct')
                            ->label('Correct Answer')
                            ->required()
                            ->helperText('Mark this as the correct answer')
                            ->columnSpan(1),
                        
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->required()
                            ->helperText('Whether this option is active and visible')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
