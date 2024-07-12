<?php

namespace App\Filament\Resources\PackagingResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\PackagingResource;

class EditPackaging extends EditRecord
{
    protected static string $resource = PackagingResource::class;

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
                ->title('Master Packaging')
                ->body('The Packaging has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $packaging = $this->record;

        Notification::make()
            ->success()
            ->title('Master Packaging')
            ->body("The Packaging for Register no {$packaging->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(PackagingResource::getUrl('view', ['record' => $packaging])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
