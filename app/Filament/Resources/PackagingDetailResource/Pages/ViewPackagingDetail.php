<?php

namespace App\Filament\Resources\PackagingDetailResource\Pages;

use App\Filament\Resources\PackagingDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPackagingDetail extends ViewRecord
{
    protected static string $resource = PackagingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
