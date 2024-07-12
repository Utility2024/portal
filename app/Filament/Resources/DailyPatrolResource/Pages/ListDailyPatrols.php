<?php

namespace App\Filament\Resources\DailyPatrolResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DailyPatrolResource;
use EightyNine\Approvals\Models\ApprovableModel;

class ListDailyPatrols extends ListRecords
{
    protected static string $resource = DailyPatrolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
