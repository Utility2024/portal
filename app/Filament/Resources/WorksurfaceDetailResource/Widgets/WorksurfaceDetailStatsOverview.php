<?php

namespace App\Filament\Resources\WorksurfaceDetailResource\Widgets;

use App\Models\WorksurfaceDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class WorksurfaceDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = WorksurfaceDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('A1 ( Mat surface point to ground )', 'Standart : < 1.00E+9 Ohm' ),
            Stat::make('A2 ( Mat surface static field voltage )', 'Standart : + - < 100 Volts' ),
        ];
    }
}
