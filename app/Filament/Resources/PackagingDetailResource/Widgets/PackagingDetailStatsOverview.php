<?php

namespace App\Filament\Resources\PackagingDetailResource\Widgets;

use App\Models\PackagingDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PackagingDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = PackagingDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('F1 ( Dissipative packaging point to point )', 'Standart : 1.00E+4 - 1.00E+11 Ohm' ),
        ];
    }
}
