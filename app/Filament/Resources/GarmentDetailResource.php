<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GarmentDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GarmentDetailResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\GarmentDetailResource\RelationManagers;
use App\Filament\Resources\GarmentDetailResource\Widgets\GarmentDetailStatsOverview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class GarmentDetailResource extends Resource
{
    protected static ?string $model = GarmentDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data measurement';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('garment_id')
                            ->relationship('garment', 'nik')
                            ->required()
                            ->label('NIK'),
                        Forms\Components\Select::make('name')
                            ->relationship('garment', 'name')
                            ->required()
                            ->label('Name'),
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Shirt point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d1')
                            //->label('D1 (Shirt point to point (1.00E+4 - 1.00E+11 Ohm))')
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
                            // ->required()
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
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Pants point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d2')
                            //->label('D2 (Pants point to point (1.00E+4 - 1.00E+11 Ohm))')
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
                            // ->required()
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
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Cap point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d3')
                            //->label('D3 (Cap point to point (1.00E+4 - 1.00E+11 Ohm))')
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
                            // ->required()
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
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Hijab point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d4')
                            //->label('D4 (Hijab point to point (1.00E+4 - 1.00E+11 Ohm))')
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
                            // ->required()
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
                    ]),
                Card::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
                            ->nullable(),

                        ])
                ]);
                
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('garment.nik')->label('NIK'),
                    TextEntry::make('garment.name')->label('Name'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('d1_scientific')->label('D1 Scientific'),
                    TextEntry::make('judgement_d1')->label('Judgement D1')
                        ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'OK' => 'success',
                                    'NG' => 'danger',
                                }),
                    TextEntry::make('d2_scientific')->label('D2 Scientific'),
                    TextEntry::make('judgement_d2')->label('Judgement D2')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextEntry::make('d3_scientific')->label('D3 Scientific'),
                    TextEntry::make('judgement_d3')->label('Judgement D3')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextEntry::make('d4_scientific')->label('D4 Scientific'),
                    TextEntry::make('judgement_d4')->label('Judgement D4')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('remarks')->label('Remarks'),
                    TextEntry::make('created_at')->label('Created At')->date(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('garment.nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('garment.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
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
                SelectFilter::make('nik')
                    ->label('NIK')
                    ->relationship('garment', 'nik')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('name')
                    ->label('Name')
                    ->relationship('garment', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('judgement_d1')
                    ->label('Judgement D1')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                SelectFilter::make('judgement_d2')
                    ->label('Judgement D2')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                SelectFilter::make('judgement_d3')
                    ->label('Judgement D3')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                SelectFilter::make('judgement_d4')
                    ->label('Judgement D4')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
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
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                 
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                 
                        return $indicators;
                    })
                ])->filtersTriggerAction(
                    fn (Action $action) => $action
                        ->button()
                        ->label('Filter'))
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Export Pdf')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->openUrlInNewTab()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                echo Pdf::loadHTML(
                                    Blade::render('GarmentDetailpdf', ['records' => $records])
                                )->stream();
                            }, 'Report_garment_measurement.pdf');
                        }),
                    ExportBulkAction::make()
                        ->label('Export Excel'),
                    Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }

    public static function getWidget(): array
    {
        return
        [
            GarmentDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGarmentDetails::route('/'),
            'create' => Pages\CreateGarmentDetail::route('/create'),
            'view' => Pages\ViewGarmentDetail::route('/{record}'),
            'edit' => Pages\EditGarmentDetail::route('/{record}/edit'),
        ];
    }
}
