<?php

namespace App\Filament\Resources\UserProgress\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserProgressTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('chapter.name')
                    ->searchable(),
                TextColumn::make('topic.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('completion_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_attempts')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('correct_answers')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('wrong_answers')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('accuracy_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('time_spent_minutes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_practiced_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_weak_area')
                    ->boolean(),
                TextColumn::make('streak_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('best_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
