<?php

namespace App\Filament\Resources\WorksurfaceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\WorksurfaceDetailResource\Widgets\WorksurfaceDetailStatsOverview;

class WorksurfaceDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'worksurfaceDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('worksurface_id')
                            ->label('Register No')
                            ->relationship('worksurface', 'register_no')
                            ->required(),
                        Forms\Components\Select::make('area')
                            ->label('Area')
                            ->relationship('worksurface', 'area')
                            ->required(),
                        Forms\Components\Select::make('location')
                            ->label('Location')
                            ->relationship('worksurface', 'location')
                            ->required(),
                        Forms\Components\Select::make('item')
                            ->options([
                                'TABLE' => 'Table',
                                'RACK LAYER 1' => 'Rack Layer 1',
                                'RACK LAYER 2' => 'Rack Layer 2',
                                'RACK LAYER 3' => 'Rack Layer 3',
                                'RACK LAYER 4' => 'Rack Layer 4',
                                'TROLLEY LAYER 1' => 'Trolley Layer 1',
                                'TROLLEY LAYER 2' => 'Trolley Layer 2',
                                'TROLLEY LAYER 3' => 'Trolley Layer 3',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('a1')
                            ->label('A1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('a1_scientific', $scientific);

                                    // Update judgement
                                    $judgement = $state > 1000000000 ? 'NG' : 'OK';
                                    $set('judgement_a1', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('a1_scientific')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_a1')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->label('Judgement A1')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('a2')
                            ->required()
                            ->numeric()
                            ->label('A2')
                            ->reactive() // Make the field reactive
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Set the value of 'judgement_c3' based on 'c3' value
                                if ($state < -100.00 || $state > 100.00) {
                                    $set('judgement_a2', 'NG');
                                } else {
                                    $set('judgement_a2', 'OK');
                                }
                            }),
                        Forms\Components\ToggleButtons::make('judgement_a2')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->label('Judgement A2')
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
            ->recordTitleAttribute('area')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('item')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('a1_scientific')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_a1')->sortable()->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('a2')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_a2')->sortable()->searchable()
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
