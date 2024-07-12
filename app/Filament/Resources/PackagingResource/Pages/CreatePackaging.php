<?php

namespace App\Filament\Resources\PackagingResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PackagingResource;

class CreatePackaging extends CreateRecord
{
    protected static string $resource = PackagingResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Packaging')
                ->body('The Packaging has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $packaging = $this->record;

        Notification::make()
            ->success()
            ->title('Master Packaging')
            ->body("The Packaging for Register no {$packaging->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(PackagingResource::getUrl('view', ['record' => $packaging])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
