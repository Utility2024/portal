<?php

namespace App\Filament\Resources\FlooringDetailResource\Widgets;

use App\Models\FlooringDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class FlooringDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = FlooringDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('B1 ( Point to ground )', 'Standart : < 1.00E+9 Ohm' ),
        ];
    }
}
