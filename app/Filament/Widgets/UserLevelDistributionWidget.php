<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserLevelDistributionWidget extends ChartWidget
{
    protected ?string $heading = 'User Level Distribution';

    protected function getData(): array
    {
        // Get user level distribution
        $levelData = User::select([
            'level',
            DB::raw('COUNT(*) as count'),
        ])
            ->groupBy('level')
            ->orderBy('level')
            ->get();

        $levelNames = [
            1 => 'Beginner',
            2 => 'Novice',
            3 => 'Intermediate',
            4 => 'Advanced',
            5 => 'Expert',
            6 => 'Master',
            7 => 'Grandmaster',
            8 => 'Legend',
            9 => 'Mythic',
            10 => 'God Tier',
        ];

        $labels = [];
        $data = [];
        $colors = [
            '#ef4444', // red
            '#f97316', // orange
            '#eab308', // yellow
            '#22c55e', // green
            '#06b6d4', // cyan
            '#3b82f6', // blue
            '#8b5cf6', // violet
            '#ec4899', // pink
            '#f59e0b', // amber
            '#10b981', // emerald
        ];

        foreach ($levelData as $level) {
            $levelNumber = $level->level ?? 1;
            $labels[] = $levelNames[$levelNumber] ?? 'Level '.$levelNumber;
            $data[] = $level->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
