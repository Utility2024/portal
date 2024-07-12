<?php

namespace App\Filament\Resources\WorksurfaceDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\WorksurfaceDetailResource;
use App\Filament\Resources\WorksurfaceDetailResource\Widgets\WorksurfaceDetailStatsOverview;

class ListWorksurfaceDetails extends ListRecords
{
    protected static string $resource = WorksurfaceDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WorksurfaceDetailStatsOverview::class,
        ];
    }
}
