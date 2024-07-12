<?php

namespace App\Filament\Resources\GarmentResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GarmentResource;

class CreateGarment extends CreateRecord
{
    protected static string $resource = GarmentResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Garment')
                ->body('The Garment has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $garment = $this->record;

        Notification::make()
            ->success()
            ->title('Master Garment')
            ->body("The Garment for NIK {$garment->nik} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GarmentResource::getUrl('view', ['record' => $garment])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
