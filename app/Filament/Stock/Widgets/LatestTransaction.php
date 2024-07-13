<?php

namespace App\Filament\Stock\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Transaction;

class LatestTransaction extends BaseWidget
{
    protected static ?string $heading = 'Latest Transactions';

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->latest('id')->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date(),
                Tables\Columns\TextColumn::make('material.sap_code')
                    ->label('SAP Code'),
                Tables\Columns\TextColumn::make('material.description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'IN' => 'info',
                        'OUT' => 'danger',
                        default => 'secondary',
                    })
                    ->icons([
                        'IN' => 'heroicon-o-arrow-left-end-on-rectangle',
                        'OUT' => 'heroicon-o-arrow-right-start-on-rectangle',
                    ]),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->badge(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Quantity')
                    ->numeric(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->badge(), 
                Tables\Columns\TextColumn::make('pic')
                    ->label('PIC'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan'),
                ]);
    }
}
