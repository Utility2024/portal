<?php

namespace App\Filament\Resources\DailyPatrolResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DailyPatrol;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPatrol extends BaseWidget
{
    protected int | string | array $columnSpan = '1';

    public function table(Table $table): Table
    {
        return $table
            ->query(DailyPatrol::query())
            ->defaultPaginationPageOption(5)
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('description_problem')
                    ->label('Description of Problem'),
                // TextColumn::make('area')
                //     ->label('Area'),
                // TextColumn::make('location')
                //     ->label('Location'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'WAITING MATERIAL' => 'warning',
                        'CLOSED' => 'success',
                        'OPEN' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date(),
            ]);
    }
}
