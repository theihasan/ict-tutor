<?php

namespace App\Filament\Resources\QuestionOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class QuestionOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->striped()
            ->columns([
                TextColumn::make('question.question')
                    ->label('Question')
                    ->searchable()
                    ->limit(80)
                    ->tooltip(fn ($record) => $record->question?->question)
                    ->wrap()
                    ->weight('medium'),
                TextColumn::make('option_key')
                    ->label('Key')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('option_text')
                    ->label('Option Text')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->option_text)
                    ->wrap(),
                IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
                TextColumn::make('order')
                    ->label('Order')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(fn () => null)
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('question.chapter.title')
                    ->label('Chapter')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('question.topic.title')
                    ->label('Topic')
                    ->badge()
                    ->color('warning')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('question')
                    ->relationship('question', 'question')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('question.chapter')
                    ->relationship('question.chapter', 'title')
                    ->label('Chapter')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('question.topic')
                    ->relationship('question.topic', 'title')
                    ->label('Topic')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_correct')
                    ->label('Correct Answer')
                    ->placeholder('All options')
                    ->trueLabel('Correct answers only')
                    ->falseLabel('Incorrect answers only'),
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All options')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
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
