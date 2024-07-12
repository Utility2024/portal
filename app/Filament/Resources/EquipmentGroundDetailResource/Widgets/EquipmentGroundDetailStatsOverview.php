<?php

namespace App\Filament\Resources\EquipmentGroundDetailResource\Widgets;

use App\Models\EquipmentGroundDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card as Stat;

class EquipmentGroundDetailStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = '5';

    protected function getCards(): array
    {
        $totalData = EquipmentGroundDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Measurement Ohm', 'Standart : < 1.0 Ohm'),
            Stat::make('Measurement Volts', 'Standart : < 2.0 Volts'),
        ];
    }
}
