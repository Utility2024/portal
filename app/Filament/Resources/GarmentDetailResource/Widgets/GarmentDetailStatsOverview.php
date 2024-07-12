<?php

namespace App\Filament\Resources\GarmentDetailResource\Widgets;

use App\Models\GarmentDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GarmentDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = GarmentDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('D1 ( Shirt Point to point )', 'Standart : 1.00E+5 - 1.00E+11 Ohm' ),
            Stat::make('D2 ( Pants to point )', 'Standart : 1.00E+5 - 1.00E+11 Ohm' ),
            Stat::make('D3 ( Cap to point )', 'Standart : 1.00E+5 - 1.00E+11 Ohm' ),
            Stat::make('D4 ( Hijab to point )', 'Standart : 1.00E+5 - 1.00E+11 Ohm' ),
        ];
    }
}
