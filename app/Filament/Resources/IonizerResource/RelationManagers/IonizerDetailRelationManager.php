<?php

namespace App\Filament\Resources\IonizerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Forms\Components\Textarea;
use Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class IonizerDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'ionizerDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                    Forms\Components\Select::make('ionizer_id')
                        ->relationship('ionizer', 'register_no')
                        ->required()
                        ->label('Register No'),
                    Forms\Components\Select::make('area')
                        ->relationship('ionizer', 'area')
                        ->required()
                        ->label('Area'),
                    Forms\Components\Select::make('location')
                        ->relationship('ionizer', 'location')
                        ->required()
                        ->label('Location'),
                    Radio::make('pm_1')
                        ->label('PM 1')
                        ->options([
                            'FLASH' => 'FLASH',
                            'NO' => 'NO',
                        ])
                        ->inline()
                        ->required()
                        ->inlineLabel(false),
                    Radio::make('pm_2')
                        ->label('PM 2')
                        ->options([
                            'OK' => 'OK',
                            'NO' => 'NO',
                        ])
                        ->inline()
                        ->required()
                        ->inlineLabel(false),
                    Radio::make('pm_3')
                        ->label('PM 3')
                        ->options([
                            'YES' => 'YES',
                            'NO' => 'NO',
                        ])
                        ->inline()
                        ->required()
                        ->inlineLabel(false),
                    Forms\Components\TextInput::make('c1')
                        ->required()
                        ->numeric()
                        ->label('C1')
                        ->reactive() // Make the field reactive
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set the value of 'judgement' based on 'e1' value
                            $set('judgement_c1', $state > 8.00 ? 'NG' : 'OK');
                        }),
                    Forms\Components\ToggleButtons::make('judgement_c1')
                        ->options([
                            'OK' => 'OK',
                            'NG' => 'NG'
                        ])
                        ->colors([
                            'OK' => 'success',
                            'NG' => 'danger'
                        ])
                        ->inline()
                        ->label('Judgement C1')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\TextInput::make('c2')
                        ->required()
                        ->numeric()
                        ->label('C2')
                        ->reactive() // Make the field reactive
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set the value of 'judgement' based on 'e1' value
                            $set('judgement_c2', $state > 8.00 ? 'NG' : 'OK');
                        }),
                    Forms\Components\ToggleButtons::make('judgement_c2')
                        ->options([
                            'OK' => 'OK',
                            'NG' => 'NG'
                        ])
                        ->colors([
                            'OK' => 'success',
                            'NG' => 'danger'
                        ])
                        ->inline()
                        ->label('Judgement C2')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\TextInput::make('c3')
                        ->required()
                        ->numeric()
                        ->label('C3')
                        ->reactive() // Make the field reactive
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set the value of 'judgement_c3' based on 'c3' value
                            if ($state < -35.00 || $state > 35.00) {
                                $set('judgement_c3', 'NG');
                            } else {
                                $set('judgement_c3', 'OK');
                            }
                        }),
                    Forms\Components\ToggleButtons::make('judgement_c3')
                        ->options([
                            'OK' => 'OK',
                            'NG' => 'NG'
                        ])
                        ->colors([
                            'OK' => 'success',
                            'NG' => 'danger'
                        ])
                        ->inline()
                        ->label('Judgement C3')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\Textarea::make('remarks')
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
                Tables\Columns\TextColumn::make('pm_1')->label('PM 1')->sortable()->searchable()
                    ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'NO' => 'success',
                                    'FLASH' => 'danger',
                                }),
                Tables\Columns\TextColumn::make('pm_2')->label('PM 2')->sortable()->searchable()
                    ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'OK' => 'success',
                                    'NO' => 'danger',
                                }),
                Tables\Columns\TextColumn::make('pm_3')->label('PM 3')->sortable()->searchable()
                    ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'YES' => 'success',
                                    'NO' => 'danger',
                                }),
                Tables\Columns\TextColumn::make('c1')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_c1')->label('Judgement C1')->sortable()->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                Tables\Columns\TextColumn::make('c2')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_c2')->label('Judgement C2')->sortable()->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                Tables\Columns\TextColumn::make('c3')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_c3')->label('Judgement C3')->sortable()->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                Tables\Columns\TextColumn::make('remarks')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date()->label('Created At'),
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
