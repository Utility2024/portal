<?php

namespace App\Filament\Stock\Resources\MaterialResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use Filament\Resources\RelationManagers\RelationManager;

class TransactionRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('material_id')
                            ->label('SAP Code')
                            ->required()
                            ->relationship('material', 'sap_code')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $material = Material::find($state);
                                if ($material) {
                                    $set('description_id', $material->description);
                                    $set('type', $material->type);
                                    $set('last_stock', $material->last_stock);
                                    $set('price', $material->price); // Use 'price' from material
                                } else {
                                    $set('description_id', null);
                                    $set('type', null);
                                    $set('last_stock', null);
                                    $set('price', null);
                                }
                            }),
                        Forms\Components\TextInput::make('description_id')
                            ->label('Description')
                            ->required(),
                        Forms\Components\TextInput::make('type')
                            ->label('Type')
                            ->required(),
                        Forms\Components\TextInput::make('last_stock')
                            ->label('Last Stock')
                            ->disabled(),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->label('Price')
                            ->prefix('$'), // Make price read-only
                        Forms\Components\ToggleButtons::make('transaction_type')
                            ->options([
                                'IN' => 'IN',
                                'OUT' => 'OUT'
                            ])
                            ->icons([
                                'IN' => 'heroicon-o-arrow-left-end-on-rectangle',
                                'OUT' => 'heroicon-o-arrow-right-start-on-rectangle',
                            ])
                            ->colors([
                                'IN' => 'info',
                                'OUT' => 'danger'
                            ])
                            ->inline(),
                        Forms\Components\DatePicker::make('date')
                            ->required(),
                        Forms\Components\TextInput::make('qty')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('pic')
                            ->required()
                            ->label('PIC')
                            ->maxLength(255),
                        Forms\Components\TextArea::make('keterangan')
                            ->required()
                            ->maxLength(255),
                    ])->Columns(2),
            ]);
    }

    // public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             InfolistCard::make([
    //                 TextEntry::make('material.sap_code')
    //                     ->label('SAP Code')
    //             ])->columns(2),
    //             InfolistCard::make([
    //                 TextEntry::make('material.description')
    //                     ->label('Description'),
    //                 TextEntry::make('material.type')
    //                     ->label('Type')
    //                     ->badge()
    //                     ->color(fn (string $state): string => match ($state) {
    //                         'Spare Part' => 'info',
    //                         'Indirect Material' => 'warning',
    //                         'Spare Part' => 'success',
    //                     }),
    //                 TextEntry::make('transaction_type')
    //                     ->badge()
    //                     ->color(fn (string $state): string => match ($state) {
    //                         'IN' => 'info',
    //                         'OUT' => 'danger'
    //                     })
    //                     ->icons([
    //                         'IN' => 'heroicon-o-arrow-left-end-on-rectangle',
    //                         'OUT' => 'heroicon-o-arrow-right-start-on-rectangle',
    //                     ])
    //             ])->columns(2),
    //             InfolistCard::make([
    //                 TextEntry::make('date')
    //                     ->date(),
    //                 TextEntry::make('qty'),
    //                 TextEntry::make('pic')
    //                     ->label('PIC'),
    //                 TextEntry::make('keterangan')
    //                     ->label('Keterangan')
    //             ])
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('material_id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material.sap_code')
                    ->label('SAP Code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('material.description')
                    ->label('Description')
                    ->sortable(),
                Tables\Columns\TextColumn::make('material.type')
                    ->label('Type')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Spare Part' => 'info',
                        'Indirect Material' => 'warning',
                        'Office Supply' => 'success',
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'IN' => 'info',
                            'OUT' => 'danger'
                        })
                        ->icons([
                            'IN' => 'heroicon-o-arrow-left-end-on-rectangle',
                            'OUT' => 'heroicon-o-arrow-right-start-on-rectangle',
                        ]),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('pic')
                    ->searchable()
                    ->label('PIC'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable()
                    ->label('Keterangan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
