<?php

namespace App\Filament\Resources\GloveResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\GloveResource;

class EditGlove extends EditRecord
{
    protected static string $resource = GloveResource::class;

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
                ->title('Master Glove')
                ->body('The Glove has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $glove = $this->record;

        Notification::make()
            ->success()
            ->title('Master Glove')
            ->body("The Glove for SAP CODE {$glove->sap_code} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GloveResource::getUrl('view', ['record' => $glove])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
