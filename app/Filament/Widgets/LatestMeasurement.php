<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LatestMeasurement extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        // Define the base query for each model
        $queries = [
            \App\Models\EquipmentGroundDetail::query()->select('id', 'created_at', DB::raw("'EquipmentGroundDetail' as resource_name")),
            \App\Models\FlooringDetail::query()->select('id', 'created_at', DB::raw("'FlooringDetail' as resource_name")),
            \App\Models\GarmentDetail::query()->select('id', 'created_at', DB::raw("'GarmentDetail' as resource_name")),
            \App\Models\GloveDetail::query()->select('id', 'created_at', DB::raw("'GloveDetail' as resource_name")),
            \App\Models\GroundMonitorBoxDetail::query()->select('id', 'created_at', DB::raw("'GroundMonitorBoxDetail' as resource_name")),
            \App\Models\IonizerDetail::query()->select('id', 'created_at', DB::raw("'IonizerDetail' as resource_name")),
            \App\Models\PackagingDetail::query()->select('id', 'created_at', DB::raw("'PackagingDetail' as resource_name")),
            \App\Models\SolderingDetail::query()->select('id', 'created_at', DB::raw("'SolderingDetail' as resource_name")),
            \App\Models\WorksurfaceDetail::query()->select('id', 'created_at', DB::raw("'WorksurfaceDetail' as resource_name")),
        ];

        // Combine the queries using unionAll
        $unionQuery = array_shift($queries);
        foreach ($queries as $query) {
            $unionQuery->unionAll($query);
        }

        // Use a raw query to combine all subqueries into a single query
        return \App\Models\EquipmentGroundDetail::query()
            ->select('*')
            ->from(DB::raw("({$unionQuery->toSql()}) as sub"))
            ->mergeBindings($unionQuery->getQuery())
            ->orderBy('created_at', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('index')
                ->label('No')
                ->getStateUsing(function ($rowLoop, $record) {
                    $totalRows = $this->getTableQuery()->count();
                    return $totalRows - $rowLoop->iteration + 1;
                }),

            TextColumn::make('resource_name')
                ->label('Measurement Type')
                ->badge()
                ->color(function ($state) {
                    return match ($state) {
                        'EquipmentGroundDetail' => 'primary',
                        'FlooringDetail' => 'success',
                        'GarmentDetail' => 'danger',
                        'GloveDetail' => 'warning',
                        'GroundMonitorBoxDetail' => 'info',
                        'IonizerDetail' => 'secondary',
                        'PackagingDetail' => 'light',
                        'SolderingDetail' => 'dark',
                        'WorksurfaceDetail' => 'muted',
                        default => 'primary',
                    };
                }),

            TextColumn::make('created_at')
                ->label('Date')
                ->date()
                ->sortable(),

            TextColumn::make('count')
                ->label('Count')
                ->getStateUsing(function ($record) {
                    $modelClass = '\\App\\Models\\' . $record->resource_name;
                    return $modelClass::whereDate('created_at', $record->created_at->toDateString())->count();
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns($this->getTableColumns());
    }
}

