<?php

namespace App\Filament\Resources\EquipmentGroundResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class EquipmentGroundDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'equipmentGroundDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('equipment_ground_id')
                            ->relationship('equipmentground', 'machine_name')
                            ->required()
                            ->label('Register No')
                            ->suffixIcon('heroicon-m-wrench-screwdriver'),
                        Forms\Components\Select::make('area')
                            ->relationship('equipmentground', 'area')
                            ->required()
                            ->label('Area')
                            ->suffixIcon('heroicon-m-arrow-left-start-on-rectangle'),
                        Forms\Components\Select::make('location')
                            ->relationship('equipmentground', 'location')
                            ->required()
                            ->label('Location')
                            ->suffixIcon('heroicon-m-globe-europe-africa'),
                        Forms\Components\TextInput::make('measure_results_ohm')
                            ->required()
                            ->label('Measure Results Ohm')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('judgement_ohm', $state > 1.00 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_ohm')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('measure_results_volts')
                            ->required()
                            ->label('Measure Results Volts')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('judgement_volts', $state > 2.00 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_volts')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Textarea::make('remarks')
                            ->nullable()
                            ->maxLength(65535),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('area')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('measure_results_ohm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_ohm')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('measure_results_volts')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_volts')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('remarks')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable()->searchable(),
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
