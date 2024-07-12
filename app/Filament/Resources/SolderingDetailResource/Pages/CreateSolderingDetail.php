<?php

namespace App\Filament\Resources\SolderingDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SolderingDetailResource;

class CreateSolderingDetail extends CreateRecord
{
    protected static string $resource = SolderingDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Soldering Measurement')
                ->body('The Soldering Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $solderingdetail = $this->record;
        $register_no = $solderingdetail->soldering->register_no;

        Notification::make()
            ->success()
            ->title('Soldering Measurement')
            ->body("The Soldering Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(SolderingDetailResource::getUrl('view', ['record' => $packagingdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
