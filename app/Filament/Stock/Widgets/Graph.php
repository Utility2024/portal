<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Filament\Stock\Resources\TransactionResource;

class Graph extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'graph';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Transaction In and Out Materials';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = TransactionResource::getDataForChart();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 365,
                'stacked' => true,
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
                'categories' => $data['dates'],
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
                'title' => [
                    'text' => 'Jumlah'
                ],
            ],
        ];
    }
}
