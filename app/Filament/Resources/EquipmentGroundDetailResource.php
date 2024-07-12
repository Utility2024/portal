<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Tables\Columns\IconColumn;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Forms\Components\ToggleButtons;
use App\Models\EquipmentGroundDetail;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\EquipmentGroundDetailResource\Pages;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\EquipmentGroundDetailResource\RelationManagers;
use App\Filament\Resources\EquipmentGroundDetailResource\Widgets\EquipmentGroundDetailStatsOverview;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class EquipmentGroundDetailResource extends Resource
{
    protected static ?string $model = EquipmentGroundDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

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
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Standart : < 1.0 Ohm')
                            ->color(Color::Yellow),
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
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Standart : < 2.0 Volts')
                            ->color(Color::Yellow),
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
                    ]),
                Card::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
                            ->nullable()
                            ->maxLength(65535),
                    ]),
                        
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('equipmentground.machine_name')->label('Machine Name'),
                    TextEntry::make('equipmentground.area')->label('Area'),
                    TextEntry::make('equipmentground.location')->label('Location'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('measure_results_ohm')->label('Measure Results Ohm'),
                    TextEntry::make('judgement_ohm')->label('Judgement Ohm')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextEntry::make('measure_results_volts')->label('Measure Results Volts'),
                    TextEntry::make('judgement_volts')->label('Judgement Volts')
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
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('equipmentground.machine_name')->label('Machine Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('equipmentground.area')->label('Area')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('equipmentground.location')->label('Location')->sortable()->searchable(),
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
                SelectFilter::make('machine_name')
                    ->label('Machine Name')
                    ->relationship('equipmentground', 'machine_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('area')
                    ->label('Area')
                    ->relationship('equipmentground', 'area')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location')
                    ->label('Location')
                    ->relationship('equipmentground', 'location')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('judgement_ohm')
                    ->label('Judgement Ohm')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                SelectFilter::make('judgement_volts')
                    ->label('Judgement Volts')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Export Pdf')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->openUrlInNewTab()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                echo Pdf::loadHTML(
                                    Blade::render('EquipmentGroundDetailpdf', ['records' => $records])
                                )->stream();
                            }, 'Report_equipment_ground_measurement.pdf');
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
            EquipmentGroundDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentGroundDetails::route('/'),
            'create' => Pages\CreateEquipmentGroundDetail::route('/create'),
            'view' => Pages\ViewEquipmentGroundDetail::route('/{record}'),
            'edit' => Pages\EditEquipmentGroundDetail::route('/{record}/edit'),
        ];
    }
}
