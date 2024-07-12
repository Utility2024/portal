<?php

namespace App\Filament\Resources\WorksurfaceResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WorksurfaceResource;

class CreateWorksurface extends CreateRecord
{
    protected static string $resource = WorksurfaceResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Master Worksurface')
                ->body('The Worksurface has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $worksurface = $this->record;

        Notification::make()
            ->success()
            ->title('Master Worksurface')
            ->body("The Worksurface for Register no {$worksurface->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(WorksurfaceResource::getUrl('view', ['record' => $worksurface])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
