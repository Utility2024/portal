<?php

namespace App\Filament\Resources\SolderingDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\SolderingDetailResource;

class EditSolderingDetail extends EditRecord
{
    protected static string $resource = SolderingDetailResource::class;

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
                ->title('Soldering Measurement')
                ->body('The Soldering Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $solderingdetail = $this->record;
        $register_no = $solderingdetail->soldering->register_no;

        Notification::make()
            ->success()
            ->title('Soldering Measurement')
            ->body("The Soldering Measurement for Register no {$register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(SolderingDetailResource::getUrl('view', ['record' => $solderingdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
