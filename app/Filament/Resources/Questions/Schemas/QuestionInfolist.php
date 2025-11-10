<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class QuestionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('chapter.name')
                    ->label('Chapter'),
                TextEntry::make('topic.name')
                    ->label('Topic')
                    ->placeholder('-'),
                TextEntry::make('question')
                    ->columnSpanFull(),
                TextEntry::make('question_en')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('correct_answer'),
                TextEntry::make('explanation')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('difficulty_level')
                    ->badge(),
                TextEntry::make('marks')
                    ->numeric(),
                TextEntry::make('tags')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('usage_count')
                    ->numeric(),
                TextEntry::make('success_rate')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
