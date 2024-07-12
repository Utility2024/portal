<?php

namespace App\Filament\Resources\GroundMonitorBoxDetailResource\Pages;

use App\Filament\Resources\GroundMonitorBoxDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroundMonitorBoxDetail extends ViewRecord
{
    protected static string $resource = GroundMonitorBoxDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
