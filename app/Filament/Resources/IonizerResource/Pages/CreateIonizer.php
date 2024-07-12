<?php

namespace App\Filament\Resources\IonizerResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\IonizerResource;

class CreateIonizer extends CreateRecord
{
    protected static string $resource = IonizerResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Ionizer')
                ->body('The Ionizer has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $ionizer = $this->record;

        Notification::make()
            ->success()
            ->title('Master Ionizer')
            ->body("The Ionizer for Register no {$ionizer->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(IonizerResource::getUrl('view', ['record' => $ionizer])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
