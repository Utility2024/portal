<?php

namespace App\Filament\Resources\GloveDetailResource\Pages;

use App\Filament\Resources\GloveDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGloveDetail extends ViewRecord
{
    protected static string $resource = GloveDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
