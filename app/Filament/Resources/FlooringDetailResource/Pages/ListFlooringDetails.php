<?php

namespace App\Filament\Resources\FlooringDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FlooringDetailResource;
use App\Filament\Resources\FlooringDetailResource\Widgets\FlooringDetailStatsOverview;

class ListFlooringDetails extends ListRecords
{
    protected static string $resource = FlooringDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FlooringDetailStatsOverview::class,
        ];
    }
}
