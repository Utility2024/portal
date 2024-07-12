<?php

namespace App\Filament\Resources\PackagingDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PackagingDetailResource;

class CreatePackagingDetail extends CreateRecord
{
    protected static string $resource = PackagingDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Packaging Measurement')
                ->body('The Packaging Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $packagingdetail = $this->record;
        $register_no = $packagingdetail->packaging->register_no;

        Notification::make()
            ->success()
            ->title('Packaging Measurement')
            ->body("The Packaging Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(PackagingDetailResource::getUrl('view', ['record' => $packagingdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
