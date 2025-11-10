<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('username')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('bio')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('profile_image')
                    ->placeholder('-'),
                TextEntry::make('date_of_birth')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->placeholder('-'),
                TextEntry::make('institution')
                    ->placeholder('-'),
                TextEntry::make('class')
                    ->placeholder('-'),
                TextEntry::make('district')
                    ->placeholder('-'),
                TextEntry::make('division')
                    ->placeholder('-'),
                TextEntry::make('hsc_year')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('level')
                    ->numeric(),
                TextEntry::make('total_points')
                    ->numeric(),
                TextEntry::make('current_streak')
                    ->numeric(),
                TextEntry::make('longest_streak')
                    ->numeric(),
                TextEntry::make('last_activity_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('preferences')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('email_notifications')
                    ->boolean(),
                TextEntry::make('timezone'),
                TextEntry::make('language'),
                IconEntry::make('is_verified')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('role'),
            ]);
    }
}
