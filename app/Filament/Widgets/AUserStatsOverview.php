<?php

namespace App\Filament\Widgets;

use App\Models\DailyPatrol;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\Carbon;

class AUserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $closedCount = DailyPatrol::where('status', 'CLOSED')->count();
        $openCount = DailyPatrol::where('status', 'OPEN')->count();
        $waitingmaterialCount = DailyPatrol::where('status', 'WAITING MATERIAL')->count();
        $initialTime = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $initialDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $initialDay = Carbon::now('Asia/Jakarta')->format('l'); // Get the day of the week

        return [
            Stat::make('Current Day', $initialDay)
                ->color('primary'),
            Stat::make('Current Date', $initialDate)
                ->color('primary'),
            Stat::make('Current Time', $initialTime)
                ->color('primary'),
            Stat::make('Total Waiting Material Patrols', $waitingmaterialCount)
                ->chart([10, 5, 30, 10, 50, 20, 70])
                ->color('warning'),
            Stat::make('Total Open Patrols', $openCount)
                ->chart([10, 5, 30, 10, 50, 20, 70])
                ->color('danger'),
            Stat::make('Total Closed Patrols', $closedCount)
                ->chart([10, 5, 30, 10, 50, 20, 70])
                ->color('success'),
        ];
    }
}
