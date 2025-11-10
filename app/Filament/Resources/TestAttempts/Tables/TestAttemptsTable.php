<?php

namespace App\Filament\Resources\TestAttempts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestAttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('test.title')
                    ->searchable(),
                TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('time_taken')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_questions')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('correct_answers')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('wrong_answers')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('percentage')
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
                TextColumn::make('skipped_answers')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('obtained_marks')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_marks')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_passed')
                    ->boolean(),
                TextColumn::make('attempt_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon(Heroicon::Eye),
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
