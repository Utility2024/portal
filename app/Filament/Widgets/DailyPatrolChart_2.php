<?php

namespace App\Filament\Widgets;

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
        $filter = $this->filter;
        
        $data = $this->applyFilters(
            Trend::model(DailyPatrol::class)
        );

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

    protected function applyFilters($query)
    {
        switch ($this->filter) {
            case 'today':
                return $query->between(
                    start: now()->startOfDay(),
                    end: now()->endOfDay(),
                )->perHour()->count();
            case 'week':
                return $query->between(
                    start: now()->startOfWeek(),
                    end: now()->endOfWeek(),
                )->perDay()->count();
            case 'month':
                return $query->between(
                    start: now()->startOfMonth(),
                    end: now()->endOfMonth(),
                )->perDay()->count();
            case 'year':
            default:
                return $query->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )->perMonth()->count();
        }
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
