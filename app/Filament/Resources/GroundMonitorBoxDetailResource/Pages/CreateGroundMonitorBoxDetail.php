<?php

namespace App\Filament\Resources\GroundMonitorBoxDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GroundMonitorBoxDetailResource;

class CreateGroundMonitorBoxDetail extends CreateRecord
{
    protected static string $resource = GroundMonitorBoxDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Ground Monitor Box Measurement')
                ->body('The Ground Monitor Box Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $groundmonitorboxdetail = $this->record;
        $register_no = $groundmonitorboxdetail->groundmonitorbox->register_no;

        Notification::make()
            ->success()
            ->title('Ground Monitor Box Measurement')
            ->body("The Ground Monitor Box Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GroundMonitorBoxDetailResource::getUrl('view', ['record' => $groundmonitorboxdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
