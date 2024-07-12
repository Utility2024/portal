<?php

namespace App\Filament\Resources\IonizerDetailResource\Pages;

use App\Filament\Resources\IonizerDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIonizerDetail extends ViewRecord
{
    protected static string $resource = IonizerDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
