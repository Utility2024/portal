<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GloveDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Forms\Components\ToggleButtons;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GloveDetailResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\GloveDetailResource\RelationManagers;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\GloveDetailResource\Widgets\GloveDetailStatsOverview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class GloveDetailResource extends Resource
{
    protected static ?string $model = GloveDetail::class;

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
                    ]),
                Card::make()
                    ->schema([
                    Shout::make('so-important')
                        ->content('Glove Point to point ( 1.00E+5 - 1.00E+11 Ohm )')
                        ->color(Color::Yellow),
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
                    ]),
                Card::make()
                    ->schema([
                    Forms\Components\TextInput::make('remarks')
                        ->maxLength(255),
                ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('glove.sap_code')->label('SAP CODE'),
                    TextEntry::make('glove.description')->label('Description'),
                    TextEntry::make('glove.delivery')->label('Delivery'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('c1_scientific')->label('C1 Scientific'),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('glove.sap_code')->label('SAP CODE'),
                Tables\Columns\TextColumn::make('glove.description')->label('Description'),
                Tables\Columns\TextColumn::make('glove.delivery')->label('Delivery'),
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
                SelectFilter::make('sap_code')
                    ->label('SAP Code')
                    ->relationship('glove', 'sap_code')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('description')
                    ->label('Description')
                    ->relationship('glove', 'description'),
                SelectFilter::make('delivery')
                    ->label('Delivery')
                    ->relationship('glove', 'delivery'),
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
                                    Blade::render('GloveDetailpdf', ['records' => $records])
                                )->stream();
                            }, 'Report_glove_measurement.pdf');
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
            GloveDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGloveDetails::route('/'),
            'create' => Pages\CreateGloveDetail::route('/create'),
            'view' => Pages\ViewGloveDetail::route('/{record}'),
            'edit' => Pages\EditGloveDetail::route('/{record}/edit'),
        ];
    }

}
