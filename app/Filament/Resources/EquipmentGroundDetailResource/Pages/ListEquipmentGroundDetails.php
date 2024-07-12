<?php

namespace App\Filament\Resources\EquipmentGroundDetailResource\Pages;

use Filament\Actions;
use App\Models\EquipmentGroundDetail;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\EquipmentGroundDetailResource;
use App\Filament\Resources\EquipmentGroundDetailResource\Widgets\EquipmentGroundDetailStatsOverview;

class ListEquipmentGroundDetails extends ListRecords
{
    protected static string $resource = EquipmentGroundDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ExcelImportAction::make()
            //     ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            EquipmentGroundDetailStatsOverview::class,
        ];
    }

}
