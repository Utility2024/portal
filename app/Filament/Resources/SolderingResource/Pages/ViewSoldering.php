<?php

namespace App\Filament\Resources\SolderingResource\Pages;

use App\Filament\Resources\SolderingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSoldering extends ViewRecord
{
    protected static string $resource = SolderingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
