<?php

namespace App\Filament\Resources\GroundMonitorBoxDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\GroundMonitorBoxDetailResource;

class EditGroundMonitorBoxDetail extends EditRecord
{
    protected static string $resource = GroundMonitorBoxDetailResource::class;

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
                ->title('Ground Monitor Box Measurement')
                ->body('The Ground Monitor Box Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $groundmonitorboxdetail = $this->record;
        $register_no = $groundmonitorboxdetail->groundmonitorbox->register_no;

        Notification::make()
            ->success()
            ->title('Ground Monitor Box Measurement')
            ->body("The Ground Monitor Box Measurement for Register no {$register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GroundMonitorBoxDetailResource::getUrl('view', ['record' => $groundmonitorboxdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
