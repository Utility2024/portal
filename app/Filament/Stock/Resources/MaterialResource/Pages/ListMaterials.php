<?php

namespace App\Filament\Stock\Resources\MaterialResource\Pages;

use App\Filament\Stock\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

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
            'Spare Part' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Spare Part')),
            'Indirect Material' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Indirect Material')),
            'Office Supply' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'Office Supply')),
        ];
    }
}
