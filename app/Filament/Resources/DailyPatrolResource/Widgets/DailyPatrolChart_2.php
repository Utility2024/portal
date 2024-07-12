<?php

namespace App\Filament\Resources\DailyPatrolResource\Widgets;

use Carbon\Carbon;
use Flowframe\Trend\Trend;
use App\Models\DailyPatrol;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class DailyPatrolChart_2 extends ChartWidget
{
    protected static ?string $heading = 'Patrol ( Monthly Count )';

    protected function getData(): array
    {
        $data = Trend::model(DailyPatrol::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(function (TrendValue $value) {
                $date = Carbon::parse($value->date);
                $formattedDate = $date->format('M');

                return $formattedDate;
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
