<?php

namespace App\Filament\Resources\EquipmentGroundResource\Pages;

use App\Filament\Resources\EquipmentGroundResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEquipmentGround extends ViewRecord
{
    protected static string $resource = EquipmentGroundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
