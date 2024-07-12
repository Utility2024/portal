<?php

namespace App\Filament\Resources\EquipmentGroundResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EquipmentGroundResource;

class CreateEquipmentGround extends CreateRecord
{
    protected static string $resource = EquipmentGroundResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Equipment Ground')
                ->body('The Equipment Ground machine has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $equipmentground = $this->record;

        Notification::make()
            ->success()
            ->title('Master Equipment Ground')
            ->body("The Equipment Ground machine {$equipmentground->machine_name} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(EquipmentGroundResource::getUrl('view', ['record' => $equipmentground])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
