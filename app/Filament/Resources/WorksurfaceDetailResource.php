<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\WorksurfaceDetail;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Forms\Components\ToggleButtons;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\WorksurfaceDetailResource\Pages;
use App\Filament\Resources\WorksurfaceDetailResource\Widgets\WorksurfaceDetailStatsOverview;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class WorksurfaceDetailResource extends Resource
{
    protected static ?string $model = WorksurfaceDetail::class;

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
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('worksurface_id')
                            ->label('Register No')
                            ->relationship('worksurface', 'register_no')
                            ->required(),
                        Forms\Components\Select::make('area')
                            ->label('Area')
                            ->relationship('worksurface', 'area')
                            ->required(),
                        Forms\Components\Select::make('location')
                            ->label('Location')
                            ->relationship('worksurface', 'location')
                            ->required(),
                        Forms\Components\Select::make('item')
                            ->options([
                                'TABLE' => 'Table',
                                'RACK LAYER 1' => 'Rack Layer 1',
                                'RACK LAYER 2' => 'Rack Layer 2',
                                'RACK LAYER 3' => 'Rack Layer 3',
                                'RACK LAYER 4' => 'Rack Layer 4',
                                'TROLLEY LAYER 1' => 'Trolley Layer 1',
                                'TROLLEY LAYER 2' => 'Trolley Layer 2',
                                'TROLLEY LAYER 3' => 'Trolley Layer 3',
                            ])
                            ->required(),
                        ]),
                Forms\Components\Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Mat surface point to ground  ( 1.00E+9 Ohm )')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('a1')
                            ->label('A1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('a1_scientific', $scientific);
    
                                    // Update judgement
                                    $judgement = $state > 1000000000 ? 'NG' : 'OK';
                                    $set('judgement_a1', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('a1_scientific')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_a1')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->label('Judgement A1')
                            ->disabled()
                            ->dehydrated(),
                        ]),
                Forms\Components\Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Mat surface static field voltage ( < +/- 100 Volts )')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('a2')
                            ->required()
                            ->numeric()
                            ->label('A2')
                            ->reactive() // Make the field reactive
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Set the value of 'judgement_c3' based on 'c3' value
                                if ($state < -100.00 || $state > 100.00) {
                                    $set('judgement_a2', 'NG');
                                } else {
                                    $set('judgement_a2', 'OK');
                                }
                            }),
                        Forms\Components\ToggleButtons::make('judgement_a2')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->label('Judgement A2')
                            ->disabled()
                            ->dehydrated(),
                        ]),
                Forms\Components\Card::make()
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
                    TextEntry::make('worksurface.register_no')->label('Register No'),
                    TextEntry::make('worksurface.area')->label('Area'),
                    TextEntry::make('worksurface.location')->label('Location'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('a1_scientific')->label('A1_Scientific'),
                    TextEntry::make('judgement_a1')->label('Judgement A1')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextEntry::make('a2')->label('A2'),
                    TextEntry::make('judgement_a2')->label('Judgement A2')
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
                Tables\Columns\TextColumn::make('worksurface.register_no')->label('Register No')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('worksurface.area')->label('Area')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('worksurface.location')->label('Location')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('item')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('a1_scientific')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_a1')->sortable()->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('a2')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('judgement_a2')->sortable()->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('remarks')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('register_no')
                    ->label('Register No')
                    ->relationship('worksurface', 'register_no')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('area')
                    ->label('Area')
                    ->relationship('worksurface', 'area')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location')
                    ->label('Location')
                    ->relationship('worksurface', 'location')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('judgement_a1')
                    ->label('Judgement A1')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                SelectFilter::make('judgement_a2')
                    ->label('Judgement A2')
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
                                            Blade::render('WorksurfaceDetailpdf', ['records' => $records])
                                        )->stream();
                                    }, 'Report_worksurface_measurement.pdf');
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
            WorksurfaceDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorksurfaceDetails::route('/'),
            'create' => Pages\CreateWorksurfaceDetail::route('/create'),
            'view' => Pages\ViewWorksurfaceDetail::route('/{record}'),
            'edit' => Pages\EditWorksurfaceDetail::route('/{record}/edit'),
        ];
    }
}
