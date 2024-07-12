<?php

namespace App\Filament\Resources\GarmentResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class GarmentDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'garmentDetails';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    Forms\Components\Select::make('garment_id')
                        ->relationship('garment', 'nik')
                        ->required(),
                    Forms\Components\Select::make('name')
                        ->relationship('garment', 'name')
                        ->required(),
                    Forms\Components\TextInput::make('d1')
                        ->label('D1 ( Shirt point to point ( 1.00E+4 - 1.00E+11 Ohm ))')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('d1_scientific', $scientific);

                                $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                $set('judgement_d1', $judgement);
                            }
                        }),
                    Forms\Components\TextInput::make('d1_scientific')
                        ->required()
                        ->maxLength(255)  
                        ->label('D1 Scientific')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\ToggleButtons::make('judgement_d1')
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
                    Forms\Components\TextInput::make('d2')
                        ->label('D2 ( Pants point to point ( 1.00E+4 - 1.00E+11 Ohm ))')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('d2_scientific', $scientific);

                                $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                $set('judgement_d2', $judgement);
                            }
                        }),
                    Forms\Components\TextInput::make('d2_scientific')
                        ->required()
                        ->maxLength(255)  
                        ->label('D2 Scientific')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\ToggleButtons::make('judgement_d2')
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
                    Forms\Components\TextInput::make('d3')
                        ->label('D3 ( Cap point to point ( 1.00E+4 - 1.00E+11 Ohm ))')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('d3_scientific', $scientific);

                                $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                $set('judgement_d3', $judgement);
                            }
                        }),
                    Forms\Components\TextInput::make('d3_scientific')
                        ->required()
                        ->maxLength(255)  
                        ->label('D3 Scientific')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\ToggleButtons::make('judgement_d3')
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
                    Forms\Components\TextInput::make('d4')
                        ->label('D4 ( Hijab point to point ( 1.00E+4 - 1.00E+11 Ohm ))')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('d4_scientific', $scientific);

                                $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                $set('judgement_d4', $judgement);
                            }
                        }),
                    Forms\Components\TextInput::make('d4_scientific')
                        ->required()
                        ->maxLength(255)  
                        ->label('D4 Scientific')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\ToggleButtons::make('judgement_d4')
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
                        ->nullable(),

                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('d1_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d1')
                    ->sortable()
                    ->label('Judgement D1')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d2_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d2')
                    ->sortable()
                    ->label('Judgement D2')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d3_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d3')
                    ->sortable()
                    ->label('Judgement D3')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d4_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d4')
                    ->sortable()
                    ->label('Judgement D4')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('remarks')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date(),
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
