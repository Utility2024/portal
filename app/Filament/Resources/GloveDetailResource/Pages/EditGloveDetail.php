<?php

namespace App\Filament\Resources\GloveDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\GloveDetailResource;

class EditGloveDetail extends EditRecord
{
    protected static string $resource = GloveDetailResource::class;

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
                ->title('Glove Measurement')
                ->body('The Glove Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $glovedetail = $this->record;
        $sap_code = $glovedetail->glove->sap_code;

        Notification::make()
            ->success()
            ->title('Glove Measurement')
            ->body("The Glove Measurement for SAP CODE {$sap_code} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(GloveDetailResource::getUrl('view', ['record' => $glovedetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
