<?php

namespace App\Filament\Resources\IonizerDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\IonizerDetailResource;

class CreateIonizerDetail extends CreateRecord
{
    protected static string $resource = IonizerDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Ionizer Measurement')
                ->body('The Ionizer Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $ionizerdetail = $this->record;
        $register_no = $ionizerdetail->ionizer->register_no;

        Notification::make()
            ->success()
            ->title('Ionizer Measurement')
            ->body("The Ionizer Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(IonizerDetailResource::getUrl('view', ['record' => $ionizerdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
