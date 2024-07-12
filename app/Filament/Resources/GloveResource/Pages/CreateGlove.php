<?php

namespace App\Filament\Resources\GloveResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\GloveResource;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateGlove extends CreateRecord
{
    protected static string $resource = GloveResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Glove')
                ->body('The Glove has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $glove = $this->record;

        Notification::make()
            ->success()
            ->title('Master Glove')
            ->body("The Glove for SAP CODE {$glove->sap_code} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GloveResource::getUrl('view', ['record' => $glove])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
