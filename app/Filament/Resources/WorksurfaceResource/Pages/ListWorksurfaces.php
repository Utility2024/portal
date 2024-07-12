<?php

namespace App\Filament\Resources\WorksurfaceResource\Pages;

use App\Filament\Resources\WorksurfaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorksurfaces extends ListRecords
{
    protected static string $resource = WorksurfaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
