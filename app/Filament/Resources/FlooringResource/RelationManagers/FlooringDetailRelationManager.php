<?php

namespace App\Filament\Resources\FlooringResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;

class FlooringDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'flooringDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('flooring_id')
                        ->relationship('flooring', 'register_no')
                        ->required()
                        ->label('Register No'),
                    Select::make('area')
                        ->relationship('flooring', 'area')
                        ->required()
                        ->label('Area'),
                    Select::make('location')
                        ->relationship('flooring', 'location')
                        ->required(),
                    TextInput::make('b1')
                        ->label('B1')
                        ->rules('required|numeric|min:0|max:1000000000000000000')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state !== null && is_numeric($state)) {
                                $scientific = sprintf('%.2E', $state);
                                $set('b1_scientific', $scientific);

                                $judgement = $state > 1000000000 ? 'NG' : 'OK';
                                $set('judgement', $judgement);
                            }
                        }),
                    TextInput::make('b1_scientific')
                        ->required()
                        ->maxLength(255)
                        ->label('B1 Scientific')
                        ->disabled()
                        ->dehydrated(),
                    ToggleButtons::make('judgement')
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
                    Textarea::make('remarks')
                        ->maxLength(255)
                        ->label('Remarks'),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('area')
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('b1_scientific')->sortable()->searchable()->label('B1 Scientific'),
                TextColumn::make('judgement')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                TextColumn::make('remarks')->sortable()->searchable()->label('Remarks'),
                TextColumn::make('created_at')->date()->sortable()->searchable(),
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
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
