<?php

namespace App\Filament\Stock\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Material;

class HWarningMaterialStock extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Warning Material Stock';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Material::query()
                    ->whereColumn('last_stock', '<=', 'minimum_stock')
            )
            ->columns([
                Tables\Columns\TextColumn::make('sap_code')
                    ->label('SAP Code'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('last_stock')
                    ->label('Last Stock')
                    ->badge(),
                Tables\Columns\TextColumn::make('minimum_stock')
                    ->label('Minimum Stock')
                    ->badge(),
            ]);
    }
}
