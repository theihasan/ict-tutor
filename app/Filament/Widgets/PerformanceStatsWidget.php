<?php

namespace App\Filament\Widgets;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PerformanceStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Total users
        $totalUsers = User::count();
        $newUsersThisWeek = User::where('created_at', '>=', now()->subWeek())->count();
        $userGrowth = $newUsersThisWeek > 0 ? '+'.$newUsersThisWeek : '0';

        // Total test attempts
        $totalAttempts = TestAttempt::whereNotNull('completed_at')->count();
        $attemptsThisWeek = TestAttempt::whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subWeek())
            ->count();

        // Average success rate
        $successRate = TestAttempt::whereNotNull('completed_at')
            ->avg('percentage');
        $successRateThisWeek = TestAttempt::whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subWeek())
            ->avg('percentage');

        $successRateTrend = $successRateThisWeek > $successRate ? 'up' : 'down';

        // Active users (users who attempted tests in last 7 days)
        $activeUsers = User::whereHas('testAttempts', function ($query) {
            $query->where('completed_at', '>=', now()->subWeek());
        })->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description($userGrowth.' new this week')
                ->descriptionIcon($newUsersThisWeek > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-minus')
                ->color($newUsersThisWeek > 0 ? 'success' : 'gray'),

            Stat::make('Test Attempts', number_format($totalAttempts))
                ->description($attemptsThisWeek.' this week')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),

            Stat::make('Success Rate', round($successRate, 1).'%')
                ->description('Average across all tests')
                ->descriptionIcon($successRateTrend === 'up' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($successRate >= 70 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger')),

            Stat::make('Active Users', number_format($activeUsers))
                ->description('Attempted tests this week')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
