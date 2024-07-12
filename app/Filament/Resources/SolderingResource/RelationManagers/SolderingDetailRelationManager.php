<?php

namespace App\Filament\Resources\SolderingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Soldering;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;

class SolderingDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'solderingDetails';

    protected static ?string $recordTitleAttribute = 'area';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('soldering_id')
                        ->label('Soldering')
                        ->options(fn() => Soldering::pluck('register_no', 'id')->toArray())
                        ->rules('required'),
                    Select::make('area')
                        ->label('Area')
                        ->options(fn() => Soldering::pluck('area', 'id')->toArray())
                        ->rules('required'),
                    Select::make('location')
                        ->label('Location')
                        ->options(fn() => Soldering::pluck('location', 'id')->toArray())
                        ->rules('required'),
                    TextInput::make('e1')
                        ->required()
                        ->numeric()
                        ->label('E1')
                        ->reactive() // Make the field reactive
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set the value of 'judgement' based on 'e1' value
                            $set('judgement', $state > 10.00 ? 'NG' : 'OK');
                        }),
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('e1')->label('E1')->sortable()->searchable(),
                TextColumn::make('judgement')->label('Judgement')->sortable()->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                TextColumn::make('remarks')->label('Remarks')->sortable()->searchable(),
                TextColumn::make('created_at')->date()->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('judgement')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('From'),
                        DatePicker::make('created_until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
