<?php

namespace App\Filament\Resources\IonizerResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\IonizerResource;

class EditIonizer extends EditRecord
{
    protected static string $resource = IonizerResource::class;

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
                ->title('Master Ionizer')
                ->body('The Ionizer has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $ionizer = $this->record;

        Notification::make()
            ->success()
            ->title('Master Ionizer')
            ->body("The Ionizer for Register no {$ionizer->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(IonizerResource::getUrl('view', ['record' => $ionizer])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
