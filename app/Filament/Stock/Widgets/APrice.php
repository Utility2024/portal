<?php

namespace App\Filament\Stock\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\Carbon;

class APrice extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPriceIn = Transaction::sum('total_price_in');
        $totalPriceOut = Transaction::sum('total_price_out');
        $initialTime = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $initialDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $initialDay = Carbon::now('Asia/Jakarta')->format('l');

        return [
            Stat::make('Total Income', '$'. number_format($totalPriceIn, 2))
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Total Expense', '$'. number_format($totalPriceOut, 2))
                ->color('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Date', $initialDate)
                ->color('primary'),
        ];
    }
}
