<?php

namespace App\Filament\Resources\GarmentDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GarmentDetailResource;

class CreateGarmentDetail extends CreateRecord
{
    protected static string $resource = GarmentDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Garment Measurement')
                ->body('The Garment Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $garmentdetail = $this->record;
        $nik = $garmentdetail->garment->nik;

        Notification::make()
            ->success()
            ->title('Garment Measurement')
            ->body("The Garment Measurement for NIK {$nik} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GarmentDetailResource::getUrl('view', ['record' => $garmentdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
