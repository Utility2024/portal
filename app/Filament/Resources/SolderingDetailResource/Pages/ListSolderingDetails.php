<?php

namespace App\Filament\Resources\SolderingDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SolderingDetailResource;
use App\Filament\Resources\SolderingDetailResource\Widgets\SolderingDetailStatsOverview;

class ListSolderingDetails extends ListRecords
{
    protected static string $resource = SolderingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SolderingDetailStatsOverview::class,
        ];
    }
}
