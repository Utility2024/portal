<?php

namespace App\Filament\Resources\DailyPatrolResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\DailyPatrolResource;

class EditDailyPatrol extends EditRecord
{
    protected static string $resource = DailyPatrolResource::class;

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
                ->title('Daily Patrol')
                ->body('The Daily patrol has been updated successfully.');
    }

    protected function afterSave(): void
    {
            $this->dispatch('updateAuditsRelationManager');
            $dailypatrol = $this->record;

            Notification::make()
                ->success()
                ->title('Daily Patrol')
                ->body("The Daily patrol {$dailypatrol->description_problem} has been updated successfully.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(DailyPatrolResource::geturl('view', ['record' => $dailypatrol])),
                ])
                ->sendToDatabase(\auth()->user());
    }
}
