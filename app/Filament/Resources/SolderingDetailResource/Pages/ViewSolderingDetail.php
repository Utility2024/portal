<?php

namespace App\Filament\Resources\SolderingDetailResource\Pages;

use App\Filament\Resources\SolderingDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSolderingDetail extends ViewRecord
{
    protected static string $resource = SolderingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
