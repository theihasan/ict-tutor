<?php

namespace App\Filament\Resources\Tests\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('title_en')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('chapter.name')
                    ->label('Chapter')
                    ->placeholder('-'),
                TextEntry::make('duration')
                    ->numeric(),
                TextEntry::make('total_questions')
                    ->numeric(),
                TextEntry::make('total_marks')
                    ->numeric(),
                TextEntry::make('passing_marks')
                    ->numeric(),
                TextEntry::make('question_ids')
                    ->columnSpanFull(),
                TextEntry::make('settings')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('attempts_count')
                    ->numeric(),
                TextEntry::make('average_score')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('topic_id')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_public')
                    ->boolean(),
                IconEntry::make('allow_retries')
                    ->boolean(),
                TextEntry::make('max_attempts')
                    ->numeric(),
                TextEntry::make('instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('scheduled_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('starts_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ends_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('show_results_immediately')
                    ->boolean(),
                IconEntry::make('randomize_questions')
                    ->boolean(),
                IconEntry::make('negative_marking')
                    ->boolean(),
                TextEntry::make('negative_marks_per_question')
                    ->numeric(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
