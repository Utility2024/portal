<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\FlooringDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Resources\FlooringDetailResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\FlooringDetailResource\RelationManagers;
use App\Filament\Resources\FlooringDetailResource\Widgets\FlooringDetailStatsOverview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class FlooringDetailResource extends Resource
{
    protected static ?string $model = FlooringDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

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
                    ]),
                Card::make()
                    ->schema([
                    Shout::make('so-important')
                        ->content('Standart : < 1.00E+9 Ohm')
                        ->color(Color::Yellow),
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
                    ]),
                Card::make()
                    ->schema([
                    Textarea::make('remarks')
                        ->maxLength(255)
                        ->label('Remarks'),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('flooring.register_no')->label('Register No'),
                    TextEntry::make('flooring.area')->label('Area'),
                    TextEntry::make('flooring.location')->label('Location'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('b1_scientific')->label('B1 Scientific'),
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
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('flooring.register_no')->label('Register No')->sortable()->searchable(),
                TextColumn::make('flooring.area')->label('Area')->sortable()->searchable(),
                TextColumn::make('flooring.location')->label('Location')->sortable()->searchable(),
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
                SelectFilter::make('register_no')
                    ->label('Register No')
                    ->relationship('flooring', 'register_no')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('area')
                    ->label('Area')
                    ->relationship('flooring', 'area')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location')
                    ->label('Location')
                    ->relationship('flooring', 'location')
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
            ])
            ->bulkActions([
                    Tables\Actions\BulkAction::make('Export Pdf')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->openUrlInNewTab()
                            ->deselectRecordsAfterCompletion()
                            ->action(function (Collection $records) {
                                return response()->streamDownload(function () use ($records) {
                                    echo Pdf::loadHTML(
                                        Blade::render('FlooringDetailpdf', ['records' => $records])
                                    )->stream();
                                }, 'Report_flooring_measurement.pdf');
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
            FlooringDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlooringDetails::route('/'),
            'create' => Pages\CreateFlooringDetail::route('/create'),
            'view' => Pages\ViewFlooringDetail::route('/{record}'),
            'edit' => Pages\EditFlooringDetail::route('/{record}/edit'),
        ];
    }
}
