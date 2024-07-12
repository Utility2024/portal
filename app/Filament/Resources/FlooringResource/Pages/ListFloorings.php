<?php

namespace App\Filament\Resources\FlooringResource\Pages;

use App\Filament\Resources\FlooringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFloorings extends ListRecords
{
    protected static string $resource = FlooringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
