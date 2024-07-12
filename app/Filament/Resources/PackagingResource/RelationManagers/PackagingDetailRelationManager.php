<?php

namespace App\Filament\Resources\PackagingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Packaging;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PackagingDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'packagingDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('packaging_id')
                            ->label('Packaging')
                            ->options(fn() => Packaging::pluck('register_no', 'id')->toArray())
                            ->rules('required'),

                        Select::make('status')
                            ->label('Status')
                            ->options(fn() => Packaging::pluck('status', 'id')->toArray())
                            ->rules('required'),

                        Select::make('item')
                            ->label('Item')
                            ->options(['Tray' => 'Tray', 'Black Box' => 'Black Box'])
                            ->rules('required'),

                        TextInput::make('f1')
                            ->label('F1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('f1_scientific', $scientific);
    
                                    // Update judgement
                                    $judgement = ($state < 10000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement', $judgement);
                                }
                            }),

                        TextInput::make('f1_scientific')
                            ->label('F1 Scientific')
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
                        Textarea::make('remarks')
                            ->label('Remarks'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('packaging_id')
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('item')->sortable()->searchable(),
                TextColumn::make('f1_scientific')->sortable()->searchable(),
                TextColumn::make('judgement')->sortable()->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                TextColumn::make('remarks')->sortable()->searchable(),
                TextColumn::make('created_at')->date()->sortable()->searchable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(), // Menambahkan tombol Add Action di header
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
