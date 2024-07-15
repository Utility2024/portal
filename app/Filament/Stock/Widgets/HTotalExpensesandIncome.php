<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Filament\Stock\Resources\TransactionResource;

class HTotalExpensesandIncome extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'totalExpensesandIncome';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'TotalExpensesandIncome';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Fetch dynamic data from TransactionResource
        $chartData = TransactionResource::getDataForChart();
    
        // Check if keys are set before accessing
        $totalPriceInData = isset($chartData['total_price_in']) ? [$chartData['total_price_in']] : [];
        $totalPriceOutData = isset($chartData['total_price_out']) ? [$chartData['total_price_out']] : [];
        $dates = isset($chartData['dates']) ? $chartData['dates'] : [];
    
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total Income',
                    'data' => $totalPriceInData,
                ],
                [
                    'name' => 'Total Expenses',
                    'data' => $totalPriceOutData,
                ],
            ],
            'xaxis' => [
                'categories' => $dates,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#dc2626'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];

    }

}
