<?php

namespace App\Filament\Resources\GloveDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GloveDetailResource;

class CreateGloveDetail extends CreateRecord
{
    protected static string $resource = GloveDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Glove Measurement')
                ->body('The Glove Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $glovedetail = $this->record;
        $sap_code = $glovedetail->glove->sap_code;

        Notification::make()
            ->success()
            ->title('Glove Measurement')
            ->body("The Glove Measurement for SAP CODE {$sap_code} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GloveDetailResource::getUrl('view', ['record' => $glovedetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
