<?php

namespace App\Filament\Resources\WorksurfaceResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\WorksurfaceResource;

class EditWorksurface extends EditRecord
{
    protected static string $resource = WorksurfaceResource::class;

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
                ->title('Master Worksurface')
                ->body('The Worksurface has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $worksurface = $this->record;

        Notification::make()
            ->success()
            ->title('Master Worksurface')
            ->body("The Worksurface for Register no {$worksurface->register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(WorksurfaceResource::getUrl('view', ['record' => $worksurface])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
    
}
