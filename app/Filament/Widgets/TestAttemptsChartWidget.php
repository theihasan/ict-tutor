<?php

namespace App\Filament\Widgets;

use App\Models\TestAttempt;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TestAttemptsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Test Performance Analytics';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get test attempt data for the last 7 days with pass/fail breakdown
        $data = TestAttempt::select([
            DB::raw('DATE(completed_at) as date'),
            DB::raw('COUNT(*) as total_attempts'),
            DB::raw('SUM(CASE WHEN is_passed = 1 THEN 1 ELSE 0 END) as passed'),
            DB::raw('SUM(CASE WHEN is_passed = 0 THEN 1 ELSE 0 END) as failed'),
        ])
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $totalAttempts = [];
        $passed = [];
        $failed = [];

        // Fill in missing dates with 0 values
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M j');

            $dayData = $data->firstWhere('date', $date);
            $totalAttempts[] = $dayData ? $dayData->total_attempts : 0;
            $passed[] = $dayData ? $dayData->passed : 0;
            $failed[] = $dayData ? $dayData->failed : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Passed Tests',
                    'data' => $passed,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill' => false,
                ],
                [
                    'label' => 'Failed Tests',
                    'data' => $failed,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'fill' => false,
                ],
                [
                    'label' => 'Total Attempts',
                    'data' => $totalAttempts,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
        ];
    }
}
