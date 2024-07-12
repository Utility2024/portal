<?php

namespace App\Filament\Resources\SolderingResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SolderingResource;

class CreateSoldering extends CreateRecord
{
    protected static string $resource = SolderingResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Soldering')
                ->body('The Soldering has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $soldering = $this->record;

        Notification::make()
            ->success()
            ->title('Master Soldering')
            ->body("The Soldering for Register no {$soldering->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(SolderingResource::getUrl('view', ['record' => $soldering])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
