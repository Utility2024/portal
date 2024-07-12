<?php

namespace App\Filament\Resources\GloveResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class GloveDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'gloveDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                    Forms\Components\Select::make('glove_id')
                        ->relationship('glove', 'sap_code')
                        ->required()
                        ->label('SAP CODE'),
                    Forms\Components\Select::make('description')
                        ->relationship('glove', 'description')
                        ->required()
                        ->label('Description'),
                    Forms\Components\Select::make('delivery')
                        ->relationship('glove', 'delivery')
                        ->required()
                        ->label('Delivery'),
                    Forms\Components\TextInput::make('c1')
                        ->label('C1')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Efficiently update b1_scientific and judgement
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('c1_scientific', $scientific);

                                // Update judgement
                                $judgement = $state > 1000000000 ? 'NG' : 'OK';
                                $set('judgement', $judgement);
                            }
                        }),

                    Forms\Components\TextInput::make('c1_scientific')
                        ->label('C1 Scientific')
                        ->rules('required')
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\ToggleButtons::make('judgement')
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
                    Forms\Components\TextInput::make('remarks')
                        ->maxLength(255),
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('delivery')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('c1_scientific'),
                Tables\Columns\TextColumn::make('judgement')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('remarks')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
