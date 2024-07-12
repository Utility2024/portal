<?php

namespace App\Filament\Resources\EquipmentGroundDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EquipmentGroundDetailResource;

class CreateEquipmentGroundDetail extends CreateRecord
{
    protected static string $resource = EquipmentGroundDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Equipment Ground Measurement')
                ->body('The Equipment Ground Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $equipmentgrounddetail = $this->record;
        $machineName = $equipmentgrounddetail->equipmentground->machine_name;

        Notification::make()
            ->success()
            ->title('Equipment Ground Measurement')
            ->body("The Equipment Ground Measurement for machine {$machineName} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(EquipmentGroundDetailResource::getUrl('view', ['record' => $equipmentgrounddetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }

}
