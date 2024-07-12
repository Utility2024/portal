<?php

namespace App\Filament\Resources\GarmentResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\GarmentResource;

class EditGarment extends EditRecord
{
    protected static string $resource = GarmentResource::class;

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
                ->title('Master Garment')
                ->body('The Garment has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $garment = $this->record;

        Notification::make()
            ->success()
            ->title('Master Garment')
            ->body("The Garment for NIK {$garment->nik} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GarmentResource::getUrl('view', ['record' => $garment])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
