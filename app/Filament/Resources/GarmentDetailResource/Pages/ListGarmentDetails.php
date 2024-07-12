<?php

namespace App\Filament\Resources\GarmentDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\GarmentDetailResource;
use App\Filament\Resources\GarmentDetailResource\Widgets\GarmentDetailStatsOverview;

class ListGarmentDetails extends ListRecords
{
    protected static string $resource = GarmentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GarmentDetailStatsOverview::class,
        ];
    }
}
