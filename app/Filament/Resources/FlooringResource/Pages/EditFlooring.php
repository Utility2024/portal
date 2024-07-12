<?php

namespace App\Filament\Resources\FlooringResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\FlooringResource;

class EditFlooring extends EditRecord
{
    protected static string $resource = FlooringResource::class;

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
                ->title('Flooring Measurement')
                ->body('The Flooring Measurement has been updated successfully.');
    }

    protected function afterSaved(): void
    {
        $flooring = $this->record;

        Notification::make()
            ->success()
            ->title('Flooring')
            ->body("The Flooring Measurement for register no {$flooring->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(FlooringResource::getUrl('view', ['record' => $flooring])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
