<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use App\Models\EquipmentGroundDetail;
use App\Models\FlooringDetail;
use App\Models\SolderingDetail;
use App\Models\PackagingDetail;
use App\Models\GroundMonitorBoxDetail;
use App\Models\GarmentDetail;
use App\Models\WorksurfaceDetail;
use App\Models\GloveDetail;
use App\Models\IonizerDetail;

class CountMeasurement extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';
    
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'countMeasurement';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Count Measurement';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $title = $this->filterFormData['title'] ?? 'Data pengukuran ESD';
        $dateStart = $this->filterFormData['date_start'] ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateEnd = $this->filterFormData['date_end'] ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $data = $this->getDataRange($dateStart, $dateEnd);
        $dateLabels = $this->generateDateLabels($dateStart, $dateEnd);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 600, // Increased height to accommodate multiple series
            ],
            'series' => $data['series'],
            'xaxis' => [
                'categories' => $dateLabels,
                'type' => 'date', // Set type to 'datetime' to use dates as x-axis
                'labels' => [
                    'datetimeUTC' => false,
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
            'colors' => ['#f59e0b', '#00bcd4', '#4caf50', '#f44336', '#9c27b0', '#ffc107', '#2196f3', '#795548', '#607d8b'],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'barHeight' => '80%',
                ],
            ],
            'legend' => [
                'position' => 'bottom', // Menempatkan legend di bawah chart
                'horizontalAlign' => 'center', // Posisi horizontal di tengah
                'floating' => false, // Tidak mengambang
            ],
            'tooltip' => [
                'y' => [
                    'formatter' => "function (val) { return val }"
                ]
            ],
            'title' => [
                'text' => $title,
            ],
        ];
    }

    /**
     * Generate date labels based on start and end dates
     *
     * @param string $start
     * @param string $end
     * @return array
     */
    protected function generateDateLabels(string $start, string $end): array
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $dateLabels = [];

        while ($startDate <= $endDate) {
            $dateLabels[] = $startDate->format('d M Y');
            $startDate->addDay();
        }

        return $dateLabels;
    }

    /**
     * Get data based on date range
     *
     * @param string $start
     * @param string $end
     * @return array
     */
    protected function getDataRange(string $start, string $end): array
    {
        $models = $this->getModels();
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end)->endOfDay();

        return $this->getDataFromModels($models, $startDate, $endDate, 'DAY(created_at)');
    }

    /**
     * Get models list
     *
     * @return array
     */
    protected function getModels(): array
    {
        return [
            'EquipmentGroundDetail' => EquipmentGroundDetail::class,
            'FlooringDetail' => FlooringDetail::class,
            'SolderingDetail' => SolderingDetail::class,
            'PackagingDetail' => PackagingDetail::class,
            'GroundMonitorBoxDetail' => GroundMonitorBoxDetail::class,
            'GarmentDetail' => GarmentDetail::class,
            'WorksurfaceDetail' => WorksurfaceDetail::class,
            'GloveDetail' => GloveDetail::class,
            'IonizerDetail' => IonizerDetail::class,
        ];
    }

    /**
     * Get data from models
     *
     * @param array $models
     * @param Carbon $start
     * @param Carbon $end
     * @param string $groupBy
     * @return array
     */
    protected function getDataFromModels(array $models, Carbon $start, Carbon $end, string $groupBy): array
    {
        $series = [];
        $categories = [];

        foreach ($models as $modelName => $modelClass) {
            $counts = [];

            $query = $modelClass::whereBetween('created_at', [$start, $end])
                ->selectRaw("COUNT(id) as count, {$groupBy} as period")
                ->groupByRaw('period')
                ->orderBy('period', 'asc')
                ->get();

            foreach ($query as $item) {
                $counts[] = $item->count;
                if (empty($categories)) {
                    $categories[] = $item->period;
                }
            }

            $series[] = [
                'name' => $this->getModelDisplayName($modelName), // Menggunakan fungsi untuk mendapatkan nama model yang ditampilkan
                'data' => $counts,
            ];
        }

        return [
            'series' => $series,
            'categories' => $categories,
        ];
    }

    /**
     * Get display name for model
     *
     * @param string $modelName
     * @return string
     */
    protected function getModelDisplayName(string $modelName): string
    {
        // Contoh sederhana untuk mengubah nama model menjadi lebih ramah pengguna
        $displayNameMap = [
            'EquipmentGroundDetail' => 'Equipment Ground',
            'FlooringDetail' => 'Flooring',
            'SolderingDetail' => 'Soldering',
            'PackagingDetail' => 'Packaging',
            'GroundMonitorBoxDetail' => 'Ground Monitor Box',
            'GarmentDetail' => 'Garment',
            'WorksurfaceDetail' => 'Worksurface',
            'GloveDetail' => 'Glove',
            'IonizerDetail' => 'Ionizer',
        ];

        return $displayNameMap[$modelName] ?? $modelName;
    }

    /**
     * Get form schema for the widget configuration
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->default('Data Pengukuran ESD')
                ->live(),

            DatePicker::make('date_start')
                ->default(Carbon::now()->startOfWeek()->format('Y-m-d'))
                ->live(),

            DatePicker::make('date_end')
                ->default(Carbon::now()->endOfWeek()->format('Y-m-d'))
                ->live(),
        ];
    }
}
