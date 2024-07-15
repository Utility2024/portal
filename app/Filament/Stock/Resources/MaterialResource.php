<?php

namespace App\Filament\Stock\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Material;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Hidden;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Stock\Resources\MaterialResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Stock\Resources\MaterialResource\RelationManagers;
use App\Filament\Stock\Resources\MaterialResource\RelationManagers\TransactionRelationManager;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('sap_code')
                            ->required()
                            ->label('SAP Code'),
                        TextInput::make('description')
                            ->required()
                            ->label('Description'),
                        ToggleButtons::make('type')
                            ->options([
                                'Spare Part' => 'Spare Part',
                                'Indirect Material' => 'Indirect Material',
                                'Office Supply' => 'Office Supply'
                            ])
                            ->icons([
                                'Spare Part' => 'heroicon-o-cog-6-tooth',
                                'Indirect Material' => 'heroicon-o-archive-box-arrow-down',
                                'Office Supply' => 'heroicon-o-pencil',
                            ])
                            ->colors([
                                'Spare Part' => 'info',
                                'Indirect Material' => 'warning',
                                'Office Supply' => 'success',
                            ])
                            ->inline(),
                        TextInput::make('qty_first')
                            ->numeric()
                            ->required()
                            ->label('Quantity First')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $price = $get('price');
                                $set('total_price', $price * $state);
                            }),
                        Forms\Components\Hidden::make('in')
                            ->label('In')
                            ->nullable(),
                        Forms\Components\Hidden::make('out')
                            ->label('Out')
                            ->nullable(),
                        Forms\Components\Hidden::make('last_stock')
                            ->label('Last Stock')
                            ->nullable(),
                        TextInput::make('minimum_stock')
                            ->numeric()
                            ->required()
                            ->label('Minimum Stock'),
                        TextInput::make('unit')
                            ->required()
                            ->label('Unit'),
                        TextInput::make('price')
                            ->numeric()
                            ->label('Price')
                            ->prefix('$')
                            ->maxValue(42949672.95)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $qty = $get('qty_first');
                                $set('total_price', $state * $qty);
                            }),
                        TextInput::make('total_price')
                            ->numeric()
                            ->label('Total Price')
                            ->prefix('$')
                            ->maxValue(42949672.95),
                    ])->columns(2),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('sap_code'),
                    TextEntry::make('description'),
                    TextEntry::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Spare Part' => 'info',
                        'Indirect Material' => 'warning',
                        'Spare Part' => 'success',
                    })
                    ->icons([
                        'Spare Part' => 'heroicon-o-cog-6-tooth',
                        'Indirect Material' => 'heroicon-o-archive-box-arrow-down',
                        'Office Supply' => 'heroicon-o-pencil',
                    ]),
                    TextEntry::make('qty_first'),
                    TextEntry::make('in'),
                    TextEntry::make('out'),
                    TextEntry::make('last_stock'),
                    TextEntry::make('minimum_stock'),
                    TextEntry::make('unit'),
                    TextEntry::make('information'),
                    TextEntry::make('price')
                        ->money('USD')
                        ->badge(),
                    TextEntry::make('total_price')
                        ->money('USD')
                        ->badge(),
                    TextEntry::make('created_at')->date(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('sap_code')
                    ->label('SAP Code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Spare Part' => 'info',
                        'Indirect Material' => 'warning',
                        'Office Supply' => 'success',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty_first')
                    ->label('Quantity First')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('in')
                    ->label('In')
                    ->sortable(),
                Tables\Columns\TextColumn::make('out')
                    ->label('Out')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_stock')
                    ->label('Last Stock')
                    ->sortable()
                    ->searchable(),                                                       
                Tables\Columns\TextColumn::make('minimum_stock')
                    ->label('Minimum Stock')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Unit')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('information')
                    ->label('Information')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->badge()
                    ->summarize(Sum::make()->money('USD')),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable()
                    ->badge()
                    ->summarize(Sum::make()->money('USD')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            TransactionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'view' => Pages\ViewMaterial::route('/{record}'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }

    public static function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Spare Part' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('type', 'Spare Part');
                }),
            'Indirect Material' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('type', 'Indirect Material');
                }),
            'Office Supply' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('type', 'Office Supply');
                }),
        ];
    }

    public static function getLatestMaterials(int $limit = 5)
    {
        return Material::latest()->limit($limit)->get();
    }
}
