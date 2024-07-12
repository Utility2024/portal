<?php

namespace App\Filament\Resources\FlooringDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\FlooringDetailResource;

class EditFlooringDetail extends EditRecord
{
    protected static string $resource = FlooringDetailResource::class;

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
                ->title('Flooring Measurement')
                ->body('The Flooring Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $flooringdetail = $this->record;
        $registerNo = $flooringdetail->flooring->register_no;

        Notification::make()
            ->success()
            ->title('Flooring Measurement')
            ->body("The Flooring Measurement for register no {$registerNo} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(FlooringDetailResource::getUrl('view', ['record' => $flooringdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
