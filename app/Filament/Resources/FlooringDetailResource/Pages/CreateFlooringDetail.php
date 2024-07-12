<?php

namespace App\Filament\Resources\FlooringDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FlooringDetailResource;

class CreateFlooringDetail extends CreateRecord
{
    protected static string $resource = FlooringDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Flooring Meaurement')
                ->body('The Flooring Meaurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $flooringdetail = $this->record;
        $registerNo = $flooringdetail->flooring->register_no;

        Notification::make()
            ->success()
            ->title('Flooring Meaurement')
            ->body("The Flooring Meaurement for register no {$registerNo} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(FlooringDetailResource::getUrl('view', ['record' => $flooringdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
