<?php

namespace App\Filament\Resources\GroundMonitorBoxDetailResource\Pages;

use App\Filament\Resources\GroundMonitorBoxDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroundMonitorBoxDetails extends ListRecords
{
    protected static string $resource = GroundMonitorBoxDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
