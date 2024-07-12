<?php

namespace App\Filament\Resources\SolderingDetailResource\Widgets;

use App\Models\SolderingDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SolderingDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = SolderingDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('E1 ( Tip solder to ground )', 'Standart : < 10 Ohm' ),
        ];
    }
}
