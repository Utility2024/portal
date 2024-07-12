<?php

namespace App\Filament\Stock\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Material; // Ensure you import the Material model

class LatestMaterial extends BaseWidget
{
    protected static ?string $heading = 'New Material';

    public function table(Table $table): Table
    {
        return $table
            ->query(Material::latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sap_code')
                    ->label('SAP Code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Spare Part' => 'info',
                        'Indirect Material' => 'warning',
                        'Office Supply' => 'success',
                    })
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
    }
}
