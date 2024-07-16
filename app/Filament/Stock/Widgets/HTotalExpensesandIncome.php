<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;

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
    protected static ?string $heading = 'Expenses and Income';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Fetch dynamic data for chart
        $year = $this->filterFormData['year'] ?? date('Y');
        $chartData = $this->getDataForChart($year);

        $totalPriceInData = $chartData['total_price_in'] ?? [];
        $totalPriceOutData = $chartData['total_price_out'] ?? [];
        $months = $chartData['months'] ?? [];

        return [
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
            'chart' => [
                'height' => 350,
                'type' => 'area',
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'xaxis' => [
                'categories' => $months,
            ],
            'tooltip' => [
                'x' => [
                    'format' => 'dd/MM/yy HH:mm',
                ],
            ],
            'colors' => ['#10b981', '#dc2626'],
        ];
    }

    /**
     * Get the form schema for the filter form
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('year')
                ->options($this->getYears())
                ->default(date('Y'))
                ->label('Year'),
        ];
    }

    /**
     * Get the available years from the transactions table
     *
     * @return array
     */
    protected function getYears(): array
    {
        $years = DB::table('transactions')
            ->selectRaw('DISTINCT YEAR(date) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return array_combine($years, $years);
    }

    /**
     * Get data for the chart based on the selected year
     *
     * @param int $year
     * @return array
     */
    protected function getDataForChart(int $year): array
    {
        $results = DB::table('transactions')
            ->select(
                DB::raw('DATE_FORMAT(date, "%m") as month'),
                DB::raw('SUM(CASE WHEN transaction_type = "IN" THEN total_price ELSE 0 END) as total_price_in'),
                DB::raw('SUM(CASE WHEN transaction_type = "OUT" THEN total_price ELSE 0 END) as total_price_out')
            )
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [
            '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
            '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
        ];

        $chartData = [
            'months' => array_values($months),
            'total_price_in' => array_fill(0, 12, 0),
            'total_price_out' => array_fill(0, 12, 0),
        ];

        foreach ($results as $result) {
            $index = (int)$result->month - 1;
            $chartData['total_price_in'][$index] = $result->total_price_in;
            $chartData['total_price_out'][$index] = $result->total_price_out;
        }

        return $chartData;
    }
}
