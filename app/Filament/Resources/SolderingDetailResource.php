<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Soldering;
use App\Models\SolderingDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Resources\SolderingDetailResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\SolderingDetailResource\Widgets\SolderingDetailStatsOverview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class SolderingDetailResource extends Resource
{
    protected static ?string $model = SolderingDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $navigationGroup = 'Data measurement';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Forms\Form $form): Forms\Form
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
                    ]),
                Card::make()
                    ->schema([
                    Shout::make('so-important')
                        ->content('Tip solder to ground ( 1.0 Ohm )')
                        ->color(Color::Yellow),
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
                    ]),
                Card::make()
                    ->schema([
                    Textarea::make('remarks')
                        ->label('Remarks'),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('soldering.register_no')->label('Register No'),
                    TextEntry::make('soldering.area')->label('Area'),
                    TextEntry::make('soldering.location')->label('Location'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('e1')->label('E1'),
                    TextEntry::make('judgement')->label('Judgement')
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

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('soldering.register_no')->label('Register no')->sortable()->searchable(),
                TextColumn::make('soldering.area')->label('Area')->sortable()->searchable(),
                TextColumn::make('soldering.location')->label('Location')->sortable()->searchable(),
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
                SelectFilter::make('register_no')
                    ->label('Register No')
                    ->relationship('soldering', 'register_no')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('area')
                    ->label('Area')
                    ->relationship('soldering', 'area')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location')
                    ->label('Location')
                    ->relationship('soldering', 'location')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('judgement')
                    ->label('Judgement')
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
                                            Blade::render('SolderingDetailpdf', ['records' => $records])
                                        )->stream();
                                    }, 'Report_soldering_measurement.pdf');
                                }),
                ExportBulkAction::make()
                    ->label('Export Excel'),
                Tables\Actions\DeleteBulkAction::make(),
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
            SolderingDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolderingDetails::route('/'),
            'create' => Pages\CreateSolderingDetail::route('/create'),
            'view' => Pages\ViewSolderingDetail::route('/{record}'),
            'edit' => Pages\EditSolderingDetail::route('/{record}/edit'),
        ];
    }
}
