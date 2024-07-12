<?php

namespace App\Filament\Resources\DailyPatrolResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DailyPatrolResource;

class CreateDailyPatrol extends CreateRecord
{
    protected static string $resource = DailyPatrolResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Daily Patrol')
                ->body('The Daily patrol has been created successfully.');
    }

    protected function afterCreate(): void
    {
            $dailypatrol = $this->record;

            Notification::make()
                ->success()
                ->title('Daily Patrol')
                ->body("The Daily patrol {$dailypatrol->description_problem} has been created successfully.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(DailyPatrolResource::geturl('view', ['record' => $dailypatrol])),
                ])
                ->sendToDatabase(\auth()->user());
    }
}
