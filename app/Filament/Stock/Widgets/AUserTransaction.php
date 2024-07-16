<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Filament\Stock\Resources\TransactionResource;

class AUserTransaction extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'userTransaction';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'User Count Transaction By-Qty';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = TransactionResource::getDataForUserChart();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 365,
            ],
            'series' => [
                [
                    'name' => 'IN',
                    'data' => $data['in'],
                    'color' => '#10b981', // hijau
                ],
                [
                    'name' => 'OUT',
                    'data' => $data['out'],
                    'color' => '#ef4444', // merah
                ],
            ],
            'xaxis' => [
                'categories' => $data['pics'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'Jumlah'
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'PIC'
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => true,
                ],
            ],
            'legend' => [
                'position' => 'top',
            ],
            'tooltip' => [
                'shared' => true,
                'intersect' => false,
            ],
        ];
    }
}
