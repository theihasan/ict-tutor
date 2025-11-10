<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('username'),
                TextInput::make('phone')
                    ->tel(),
                Textarea::make('bio')
                    ->columnSpanFull(),
                FileUpload::make('profile_image')
                    ->image(),
                DatePicker::make('date_of_birth'),
                TextInput::make('gender'),
                TextInput::make('institution'),
                TextInput::make('class'),
                TextInput::make('district'),
                TextInput::make('division'),
                TextInput::make('hsc_year')
                    ->numeric(),
                TextInput::make('level')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('total_points')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('current_streak')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('longest_streak')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_activity_at'),
                Textarea::make('preferences')
                    ->columnSpanFull(),
                Toggle::make('email_notifications')
                    ->required(),
                TextInput::make('timezone')
                    ->required()
                    ->default('Asia/Dhaka'),
                TextInput::make('language')
                    ->required()
                    ->default('bn'),
                Toggle::make('is_verified')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('role')
                    ->required()
                    ->default('student'),
            ]);
    }
}
