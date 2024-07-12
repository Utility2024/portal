<?php

namespace App\Filament\Resources\EquipmentGroundResource\Pages;

use App\Filament\Resources\EquipmentGroundResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentGrounds extends ListRecords
{
    protected static string $resource = EquipmentGroundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
