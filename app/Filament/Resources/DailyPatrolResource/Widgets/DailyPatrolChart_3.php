<?php

namespace App\Filament\Resources\DailyPatrolResource\Widgets;

use Flowframe\Trend\Trend;
use App\Models\DailyPatrol;
use Filament\Widgets\ChartWidget;

class DailyPatrolChart_3 extends ChartWidget
{
    protected static ?string $heading = 'Patrol Status Distribution';

    protected function getData(): array
    {
        $statuses = ['OPEN', 'WAITING MATERIAL', 'CLOSED'];

        // Get count of each status
        $data = DailyPatrol::query()
            ->selectRaw('status, COUNT(*) as count')
            ->whereIn('status', $statuses)
            ->groupBy('status')
            ->pluck('count', 'status');

        // Ensure all statuses are included, even if the count is 0
        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[$status] = $data->get($status, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Status',
                    'data' => array_values($statusCounts),
                    'backgroundColor' => [
                        'red',    // OPEN
                        'yellow', // WAITING MATERIAL
                        'green',  // CLOSED
                    ],
                ],
            ],
            'labels' => array_keys($statusCounts),
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
