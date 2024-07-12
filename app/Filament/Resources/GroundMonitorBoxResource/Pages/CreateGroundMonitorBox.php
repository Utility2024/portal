<?php

namespace App\Filament\Resources\GroundMonitorBoxResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GroundMonitorBoxResource;

class CreateGroundMonitorBox extends CreateRecord
{
    protected static string $resource = GroundMonitorBoxResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Ground Monitor Box')
                ->body('The Ground Monitor Box has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $groundmonitorbox = $this->record;

        Notification::make()
            ->success()
            ->title('Master Ground Monitor Box')
            ->body("The Ground Monitor Box for Register no {$groundmonitorbox->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GroundMonitorBoxResource::getUrl('view', ['record' => $groundmonitorbox])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
