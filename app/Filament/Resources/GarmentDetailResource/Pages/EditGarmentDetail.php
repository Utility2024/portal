<?php

namespace App\Filament\Resources\GarmentDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\GarmentDetailResource;

class EditGarmentDetail extends EditRecord
{
    protected static string $resource = GarmentDetailResource::class;

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
                ->title('Garment Measurement')
                ->body('The Garment Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $garmentdetail = $this->record;
        $nik = $garmentdetail->garment->nik;

        Notification::make()
            ->success()
            ->title('Garment Measurement')
            ->body("The Garment Measurement for NIK {$nik} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GarmentDetailResource::getUrl('view', ['record' => $garmentdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
