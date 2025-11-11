<?php

namespace App\Filament\Widgets;

use App\Models\TestAttempt;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentActivityWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Test Attempts';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TestAttempt::query()
                    ->with(['user', 'test'])
                    ->whereNotNull('completed_at')
                    ->latest('completed_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('test.title_en')
                    ->label('Test')
                    ->limit(30)
                    ->tooltip(function (TestAttempt $record): ?string {
                        return $record->test?->title_en;
                    }),

                TextColumn::make('percentage')
                    ->label('Score')
                    ->formatStateUsing(fn (string $state): string => round($state, 1).'%')
                    ->badge()
                    ->color(function (string $state): string {
                        if ($state >= 80) {
                            return 'success';
                        }
                        if ($state >= 60) {
                            return 'warning';
                        }

                        return 'danger';
                    }),

                TextColumn::make('is_passed')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Passed' : 'Failed')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                TextColumn::make('time_taken')
                    ->label('Duration')
                    ->formatStateUsing(function (?int $state): string {
                        if (! $state) {
                            return 'N/A';
                        }

                        $hours = intval($state / 3600);
                        $minutes = intval(($state % 3600) / 60);
                        $seconds = $state % 60;

                        if ($hours > 0) {
                            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
                        }

                        return sprintf('%d:%02d', $minutes, $seconds);
                    }),

                TextColumn::make('completed_at')
                    ->label('Completed')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->defaultSort('completed_at', 'desc')
            ->striped()
            ->paginated(false);
    }
}
