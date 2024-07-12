<?php

namespace App\Filament\Resources\IonizerResource\Pages;

use App\Filament\Resources\IonizerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIonizer extends ViewRecord
{
    protected static string $resource = IonizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
