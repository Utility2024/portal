<?php

namespace App\Filament\Resources\SolderingResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\SolderingResource;

class EditSoldering extends EditRecord
{
    protected static string $resource = SolderingResource::class;

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
                ->title('Master Soldering')
                ->body('The Soldering has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $soldering = $this->record;

        Notification::make()
            ->success()
            ->title('Master Soldering')
            ->body("The Soldering for Register no {$soldering->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(SolderingResource::getUrl('view', ['record' => $soldering])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
