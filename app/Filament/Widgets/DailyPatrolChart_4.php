<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Carbon;
use App\Models\DailyPatrol;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DailyPatrolChart_4 extends ChartWidget
{
    protected static ?string $heading = 'Patrol ( Yearly Count )';
    
    protected function getData(): array
    {
        $year = now()->year;
        
        $data = Trend::model(DailyPatrol::class)
            ->between(
                start: Carbon::createFromDate($year)->startOfYear(),
                end: Carbon::createFromDate($year)->endOfYear(),
            )
            ->perYear()
            ->count();
        
        return [
            'datasets' => [
                [
                    'type' => 'doughnut',
                    'label' => 'Jumlah',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getChartOptions(): array
    {
        return [
            'height' => 250, // Sesuaikan dengan tinggi yang diinginkan
            'maintainAspectRatio' => false,
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'layout' => [
                'padding' => [
                    'left' => 10,
                    'right' => 10,
                    'top' => 10,
                    'bottom' => 10,
                ],
            ],
        ];
    }
}
