<?php

namespace App\Filament\Resources\GloveDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\GloveDetailResource;
use App\Filament\Resources\GloveDetailResource\Widgets\GloveDetailStatsOverview;

class ListGloveDetails extends ListRecords
{
    protected static string $resource = GloveDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GloveDetailStatsOverview::class,
        ];
    }
}
