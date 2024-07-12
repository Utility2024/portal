<?php

namespace App\Filament\Resources\FlooringResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FlooringResource;

class CreateFlooring extends CreateRecord
{
    protected static string $resource = FlooringResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Flooring')
                ->body('The Flooring has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $flooring = $this->record;

        Notification::make()
            ->success()
            ->title('Master Flooring')
            ->body("The Flooring for register no {$flooring->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(FlooringResource::getUrl('view', ['record' => $flooring])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
