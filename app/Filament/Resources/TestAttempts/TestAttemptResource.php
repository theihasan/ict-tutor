<?php

namespace App\Filament\Resources\TestAttempts;

use App\Filament\Resources\TestAttempts\Pages\CreateTestAttempt;
use App\Filament\Resources\TestAttempts\Pages\EditTestAttempt;
use App\Filament\Resources\TestAttempts\Pages\ListTestAttempts;
use App\Filament\Resources\TestAttempts\Pages\ViewTestAttempt;
use App\Filament\Resources\TestAttempts\Schemas\TestAttemptForm;
use App\Filament\Resources\TestAttempts\Schemas\TestAttemptInfolist;
use App\Filament\Resources\TestAttempts\Tables\TestAttemptsTable;
use App\Models\TestAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestAttemptResource extends Resource
{
    protected static ?string $model = TestAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return TestAttemptForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TestAttemptInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestAttemptsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestAttempts::route('/'),
            'create' => CreateTestAttempt::route('/create'),
            'view' => ViewTestAttempt::route('/{record}'),
            'edit' => EditTestAttempt::route('/{record}/edit'),
        ];
    }
}
