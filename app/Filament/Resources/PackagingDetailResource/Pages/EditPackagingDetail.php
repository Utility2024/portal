<?php

namespace App\Filament\Resources\PackagingDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\PackagingDetailResource;

class EditPackagingDetail extends EditRecord
{
    protected static string $resource = PackagingDetailResource::class;

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
                ->title('Packaging Measurement')
                ->body('The Packaging Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $packagingdetail = $this->record;
        $register_no = $packagingdetail->packaging->register_no;

        Notification::make()
            ->success()
            ->title('Packaging Measurement')
            ->body("The Packaging Measurement for Register no {$register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(PackagingDetailResource::getUrl('view', ['record' => $packagingdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
