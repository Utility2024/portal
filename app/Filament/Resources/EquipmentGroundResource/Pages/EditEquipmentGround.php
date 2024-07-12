<?php

namespace App\Filament\Resources\EquipmentGroundResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\EquipmentGroundResource;

class EditEquipmentGround extends EditRecord
{
    protected static string $resource = EquipmentGroundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Equipment Ground')
                ->body('The Equipment Ground machine has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $equipmentground = $this->record;

        Notification::make()
            ->success()
            ->title('Master Equipment Ground')
            ->body("The Equipment Ground machine {$equipmentground->machine_name} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(EquipmentGroundResource::getUrl('view', ['record' => $equipmentground])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
