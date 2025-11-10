<?php

namespace App\Filament\Resources\TestAttempts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestAttemptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('test.title')
                    ->label('Test'),
                TextEntry::make('started_at')
                    ->dateTime(),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('time_taken')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total_questions')
                    ->numeric(),
                TextEntry::make('correct_answers')
                    ->numeric(),
                TextEntry::make('wrong_answers')
                    ->numeric(),
                TextEntry::make('percentage')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('skipped_answers')
                    ->numeric(),
                TextEntry::make('obtained_marks')
                    ->numeric(),
                TextEntry::make('total_marks')
                    ->numeric(),
                IconEntry::make('is_passed')
                    ->boolean(),
                TextEntry::make('attempt_number')
                    ->numeric(),
                TextEntry::make('ip_address')
                    ->placeholder('-'),
                TextEntry::make('user_agent')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('answers')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('time_spent_per_question')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
