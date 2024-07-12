<?php

namespace App\Filament\Stock\Resources\MaterialResource\Pages;

use App\Filament\Stock\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterial extends ViewRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
