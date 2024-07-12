<?php

namespace App\Filament\Resources\WorksurfaceDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\WorksurfaceDetailResource;

class EditWorksurfaceDetail extends EditRecord
{
    protected static string $resource = WorksurfaceDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Worksurface Measurement')
                ->body('The Worksurface Measurement has been updated successfully.');
    }

    protected function afterSave(): void
    {
        $worksurfacedetail = $this->record;
        $register_no = $worksurfacedetail->worksurface->register_no;

        Notification::make()
            ->success()
            ->title('Worksurface Measurement')
            ->body("The Worksurface Measurement for Register no {$register_no} has been updated successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(WorksurfaceDetailResource::getUrl('view', ['record' => $worksurfacedetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
