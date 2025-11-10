<?php

namespace App\Filament\Widgets;

use App\Models\Chapter;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ChapterProgressWidget extends ChartWidget
{
    protected ?string $heading = 'Chapter Completion Rates';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get chapter completion data
        $chapterData = Chapter::select([
            'chapters.id',
            'chapters.name',
            DB::raw('COUNT(DISTINCT user_progress.user_id) as completed_users'),
            DB::raw('(SELECT COUNT(*) FROM users WHERE is_active = 1) as total_users'),
        ])
            ->leftJoin('user_progress', function ($join) {
                $join->on('chapters.id', '=', 'user_progress.chapter_id')
                    ->where('user_progress.completion_percentage', '>=', 100);
            })
            ->groupBy('chapters.id', 'chapters.name')
            ->orderBy('chapters.name')
            ->limit(10) // Limit to first 10 chapters for better readability
            ->get();

        $labels = [];
        $completionRates = [];
        $colors = [];

        foreach ($chapterData as $chapter) {
            // Ensure proper UTF-8 encoding for Bengali text
            $chapterName = mb_convert_encoding($chapter->name, 'UTF-8', 'UTF-8');
            $labels[] = mb_substr($chapterName, 0, 20, 'UTF-8').(mb_strlen($chapterName, 'UTF-8') > 20 ? '...' : '');
            $totalUsers = $chapter->total_users > 0 ? $chapter->total_users : 1;
            $completionRate = ($chapter->completed_users / $totalUsers) * 100;
            $completionRates[] = round($completionRate, 1);

            // Color coding based on completion rate
            if ($completionRate >= 80) {
                $colors[] = 'rgba(16, 185, 129, 0.8)'; // Green
            } elseif ($completionRate >= 50) {
                $colors[] = 'rgba(59, 130, 246, 0.8)'; // Blue
            } elseif ($completionRate >= 30) {
                $colors[] = 'rgba(245, 158, 11, 0.8)'; // Yellow
            } else {
                $colors[] = 'rgba(239, 68, 68, 0.8)'; // Red
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Completion Rate (%)',
                    'data' => $completionRates,
                    'backgroundColor' => $colors,
                    'borderColor' => array_map(function ($color) {
                        return str_replace('0.8', '1', $color);
                    }, $colors),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'callback' => "function(value) { return value + '%'; }",
                    ],
                ],
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 45,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
