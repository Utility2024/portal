<?php

namespace App\Filament\Resources\GroundMonitorBoxResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class GroundMonitorBoxDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'groundMonitorBoxDetails'; // Assuming this is the correct relationship name in the GroundMonitorBox model

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('ground_monitor_box_id')
                        ->relationship('groundMonitorBox', 'register_no')
                        ->required()
                        ->label('Ground Monitor Box'),
                    Select::make('area')
                        ->relationship('groundMonitorBox', 'area')
                        ->required()
                        ->label('Area'),
                    Select::make('location')
                        ->relationship('groundMonitorBox', 'location')
                        ->required()
                        ->label('Location'),
                    Forms\Components\ToggleButtons::make('g1')
                        ->options([
                            'YES' => 'YES',
                            'NO' => 'NO'
                        ])
                        ->colors([
                            'YES' => 'success',
                            'NO' => 'danger'
                        ])
                        ->inline(),
                    Forms\Components\ToggleButtons::make('g2')
                        ->options([
                            'YES' => 'YES',
                            'NO' => 'NO'
                        ])
                        ->colors([
                            'YES' => 'success',
                            'NO' => 'danger'
                        ])
                        ->inline(),
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
                TextColumn::make('g1')->sortable()->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'YES' => 'success',
                            'No' => 'danger',
                        }),
                TextColumn::make('g2')->sortable()->searchable()
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'YES' => 'success',
                            'NO' => 'danger',
                        }),
                TextColumn::make('remarks')->sortable()->searchable(),
                TextColumn::make('created_at')->date()->sortable()->searchable(),
            ])
            ->filters([
                // Add filters if necessary
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\VIewAction::make(),
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
