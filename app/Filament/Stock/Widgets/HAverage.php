<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Filament\Stock\Resources\TransactionResource;
use Filament\Forms\Components\TextInput;
use Carbon\Carbon;

class HAverage extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static string $chartId = 'average';

    protected static ?string $heading = 'Average In, Out and Total Price Transactions';

    public string $year;

    public function __construct()
    {
        $this->year = Carbon::now()->format('Y');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('year')
                ->default($this->year)
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $this->year = $state;
                })
        ];
    }

    protected function getOptions(): array
    {
        $chartData = TransactionResource::getDataForYearlyChart($this->year);

        return [
            'series' => [
                [
                    'name' => 'In',
                    'type' => 'column',
                    'data' => $chartData['in'],
                    'color' => '#10b981', // Warna hijau untuk 'In'
                ],
                [
                    'name' => 'Out',
                    'type' => 'column',
                    'data' => $chartData['out'],
                    'color' => '#dc2626', // Warna merah untuk 'Out'
                ],
                [
                    'name' => 'Total Price',
                    'type' => 'line',
                    'data' => $chartData['total_price'],
                    'color' => '#1e40af', // Warna biru untuk 'Total Price'
                ],
            ],
            'chart' => [
                'height' => 350,
                'type' => 'line',
                'stacked' => false,
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'stroke' => [
                'width' => [1, 1, 4],
                'curve' => 'smooth', // Mengubah garis menjadi tidak lancip
            ],
            'title' => [
                'align' => 'left',
                'offsetX' => 110,
            ],
            'xaxis' => [
                'categories' => $chartData['months'],
            ],
            'yaxis' => [
                [
                    'min' => 0,
                    'seriesName' => 'In',
                    'axisTicks' => [
                        'show' => true,
                    ],
                    'axisBorder' => [
                        'show' => true,
                        'color' => '#10b981',
                    ],
                    'labels' => [
                        'style' => [
                            'colors' => '#10b981',
                        ],
                    ],
                    'title' => [
                        'text' => 'In (qty)',
                        'style' => [
                            'color' => '#10b981',
                        ],
                    ],
                    'tooltip' => [
                        'enabled' => true,
                    ],
                ],
                [
                    'min' => 0,
                    'seriesName' => 'Out',
                    'axisTicks' => [
                        'show' => true,
                    ],
                    'axisBorder' => [
                        'show' => true,
                        'color' => '#dc2626',
                    ],
                    'labels' => [
                        'style' => [
                            'colors' => '#dc2626',
                        ],
                    ],
                    'title' => [
                        'text' => 'Out (qty)',
                        'style' => [
                            'color' => '#dc2626',
                        ],
                    ],
                    'tooltip' => [
                        'enabled' => true,
                    ],
                ],
                [
                    'seriesName' => 'Total Price',
                    'opposite' => true,
                    'axisTicks' => [
                        'show' => true,
                    ],
                    'axisBorder' => [
                        'show' => true,
                        'color' => '#1e40af',
                    ],
                    'labels' => [
                        'style' => [
                            'colors' => '#1e40af',
                        ],
                    ],
                    'title' => [
                        'text' => 'Total Price (USD)',
                        'style' => [
                            'color' => '#1e40af',
                        ],
                    ],
                ],
            ],
            'tooltip' => [
                'fixed' => [
                    'enabled' => true,
                    'position' => 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    'offsetY' => 30,
                    'offsetX' => 60,
                ],
            ],
            'legend' => [
                'horizontalAlign' => 'left',
                'offsetX' => 40,
            ],
        ];
    }
}
