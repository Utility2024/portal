<?php

namespace App\Filament\Resources\EquipmentGroundDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\EquipmentGroundDetailResource;

class EditEquipmentGroundDetail extends EditRecord
{
    protected static string $resource = EquipmentGroundDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Equipment Ground Measurement')
                ->body('The Equipment Ground Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $equipmentgrounddetail = $this->record;
        $machineName = $equipmentgrounddetail->equipmentground->machine_name;

        Notification::make()
            ->success()
            ->title('Equipment Ground Measurement')
            ->body("The Equipment Ground Measurement for machine {$machineName} has been updated     successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(EquipmentGroundDetailResource::getUrl('view', ['record' => $equipmentgrounddetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
