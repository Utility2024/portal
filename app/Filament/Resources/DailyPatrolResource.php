<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DailyPatrol;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DailyPatrolResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use EightyNine\Approvals\Action\Actions\ApprovalActions;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use EightyNine\Approvals\Tables\Columns\ApprovalStatusColumn;
use App\Filament\Resources\DailyPatrolResource\RelationManagers;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class DailyPatrolResource extends Resource
{
    protected static ?string $model = DailyPatrol::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
                        TextArea::make('description_problem')
                            ->required()
                            ->label('Description of Problem'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextInput::make('area')
                            ->required()
                            ->label('Area'),
                        TextInput::make('location')
                            ->required()
                            ->label('Location'),
                        ToggleButtons::make('status')
                            ->options([
                                'OPEN' => 'OPEN',
                                'WAITING MATERIAL' => 'WAITING MATERIAL',
                                'CLOSED' => 'CLOSED'
                            ])
                            ->icons([
                                'OPEN' => 'heroicon-o-arrow-path-rounded-square',
                                'WAITING MATERIAL' => 'heroicon-o-clock',
                                'CLOSED' => 'heroicon-o-check-circle',
                            ])
                            ->colors([
                                'OPEN' => 'danger',
                                'WAITING MATERIAL' => 'warning',
                                'CLOSED' => 'success',
                            ])
                            ->inline(),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        FileUpload::make('photo_before')
                            ->label('Photo Before')
                            ->disk('storage/public'),
                        FileUpload::make('photo_after')
                            ->label('Photo After')
                            ->disk('storage/public'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextArea::make('corrective_action')
                            ->label('Corrective Action'),
                        DatePicker::make('date_corrective')
                            ->label('Date of Corrective Action'),
                    ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('description_problem'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('area'),
                    TextEntry::make('location'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OPEN' => 'danger',
                            'WAITING MATERIAL' => 'warning',
                            'CLOSED' => 'success',
                        }),
                ])->columns(2),
                InfolistCard::make([
                    ImageEntry::make('photo_before'),
                    ImageEntry::make('photo_after'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('corrective_action'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('date_corrective')->date(),
                    TextEntry::make('created_at')->date(),
                    CommentsEntry::make('filament_comments'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                TextColumn::make('description_problem')
                    ->label('Description of Problem')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('area')
                    ->label('Area')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OPEN' => 'danger',
                        'WAITING MATERIAL' => 'warning',
                        'CLOSED' => 'success',
                    }),
                ImageColumn::make('photo_before')
                    ->label('Photo Before')
                    ->disk('storage/public'),
                ImageColumn::make('photo_after')
                    ->label('Photo After')
                    ->disk('storage/public'),
                TextColumn::make('corrective_action')
                    ->label('Corrective Action')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date_corrective')
                    ->label('Date of Corrective Action')
                    ->sortable()
                    ->date(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
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
                                Blade::render('DailyPatrolpdf', ['records' => $records])
                            )->stream();
                        }, 'Report_daily_patrol.pdf');
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyPatrols::route('/'),
            'create' => Pages\CreateDailyPatrol::route('/create'),
            'view' => Pages\ViewDailyPatrol::route('/{record}'),
            'edit' => Pages\EditDailyPatrol::route('/{record}/edit'),
        ];
    }
}
