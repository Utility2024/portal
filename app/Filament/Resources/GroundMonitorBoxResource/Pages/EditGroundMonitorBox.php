<?php

namespace App\Filament\Resources\GroundMonitorBoxResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\GroundMonitorBoxResource;

class EditGroundMonitorBox extends EditRecord
{
    protected static string $resource = GroundMonitorBoxResource::class;

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
                ->title('Master Ground Monitor Box')
                ->body('The Ground Monitor Box has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $groundmonitorbox = $this->record;

        Notification::make()
            ->success()
            ->title('Master Ground Monitor Box')
            ->body("The Ground Monitor Box for Register no {$groundmonitorbox->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GroundMonitorBoxResource::getUrl('view', ['record' => $groundmonitorbox])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
