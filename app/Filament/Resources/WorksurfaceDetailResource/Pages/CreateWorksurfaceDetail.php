<?php

namespace App\Filament\Resources\WorksurfaceDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WorksurfaceDetailResource;

class CreateWorksurfaceDetail extends CreateRecord
{
    protected static string $resource = WorksurfaceDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Worksurface Measurement')
                ->body('The Worksurface Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $worksurfacedetail = $this->record;
        $register_no = $worksurfacedetail->worksurface->register_no;

        Notification::make()
            ->success()
            ->title('Worksurface Measurement')
            ->body("The Worksurface Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(WorksurfaceDetailResource::getUrl('view', ['record' => $worksurfacedetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
