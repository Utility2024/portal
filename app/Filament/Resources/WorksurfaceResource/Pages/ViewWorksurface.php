<?php

namespace App\Filament\Resources\WorksurfaceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\WorksurfaceResource;
use App\Filament\Resources\WorksurfaceDetailResource\Widgets\WorksurfaceDetailStatsOverview;

class ViewWorksurface extends ViewRecord
{
    protected static string $resource = WorksurfaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

}
