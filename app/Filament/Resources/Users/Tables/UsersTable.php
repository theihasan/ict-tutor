<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
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
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                ImageColumn::make('profile_image'),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('institution')
                    ->searchable(),
                TextColumn::make('class')
                    ->searchable(),
                TextColumn::make('district')
                    ->searchable(),
                TextColumn::make('division')
                    ->searchable(),
                TextColumn::make('hsc_year')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('level')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_points')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_streak')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longest_streak')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_activity_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('email_notifications')
                    ->boolean(),
                TextColumn::make('timezone')
                    ->searchable(),
                TextColumn::make('language')
                    ->searchable(),
                IconColumn::make('is_verified')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('role')
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
