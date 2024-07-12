<?php

namespace App\Filament\Resources\IonizerDetailResource\Pages;

use App\Filament\Resources\IonizerDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIonizerDetail extends EditRecord
{
    protected static string $resource = IonizerDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Ionizer Measurement')
                ->body('The Ionizer Measurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $ionizerdetail = $this->record;
        $register_no = $ionizerdetail->ionizer->register_no;

        Notification::make()
            ->success()
            ->title('Ionizer Measurement')
            ->body("The Ionizer Measurement for Register no {$register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(IonizerDetailResource::getUrl('view', ['record' => $ionizerdetail])),
            ])
            ->sendToDatabase(\auth()->user()); 
    }
}
