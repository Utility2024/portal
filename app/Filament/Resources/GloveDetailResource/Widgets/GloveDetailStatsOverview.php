<?php

namespace App\Filament\Resources\GloveDetailResource\Widgets;

use App\Models\GloveDetail;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GloveDetailStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalData = GloveDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('C1 ( Glove Point to point )', 'Standart : 1.00E+5 - 1.00E+11 Ohm' ),
        ];
    }
}
