<?php

namespace App\Filament\Resources\UserAnswers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserAnswersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('testAttempt.id')
                    ->searchable(),
                TextColumn::make('question.id')
                    ->searchable(),
                TextColumn::make('user_answer')
                    ->searchable(),
                IconColumn::make('is_correct')
                    ->boolean(),
                TextColumn::make('time_spent')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points_earned')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_flagged')
                    ->boolean(),
                TextColumn::make('answered_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('confidence_level')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('attempt_count')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->icon(Heroicon::PencilSquare),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon(Heroicon::Trash),
                ]),
            ]);
    }
}
