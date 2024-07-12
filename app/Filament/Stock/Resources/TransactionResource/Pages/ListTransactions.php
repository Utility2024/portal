<?php

namespace App\Filament\Stock\Resources\TransactionResource\Pages;

use App\Filament\Stock\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'IN' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('transaction_type', 'IN')),
            'OUT' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('transaction_type', 'OUT')),
        ];
    }
}
