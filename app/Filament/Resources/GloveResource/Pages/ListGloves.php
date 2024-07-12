<?php

namespace App\Filament\Resources\GloveResource\Pages;

use App\Filament\Resources\GloveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGloves extends ListRecords
{
    protected static string $resource = GloveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
