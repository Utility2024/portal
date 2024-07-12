<?php

namespace App\Filament\Resources\GloveResource\Pages;

use App\Filament\Resources\GloveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGlove extends ViewRecord
{
    protected static string $resource = GloveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
