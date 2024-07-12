<?php

namespace App\Filament\Resources\EquipmentGroundDetailResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Carbon\Exceptions\Exception;
use Filament\Resources\Pages\ViewRecord;
use EightyNine\Approvals\Models\ApprovableModel;
use App\Filament\Resources\EquipmentGroundDetailResource;
use EightyNine\Approvals\Traits\HasApprovalHeaderActions;

class ViewEquipmentGroundDetail extends ViewRecord
{
    // use \EightyNine\Approvals\Traits\HasApprovalHeaderActions;
    
    protected static string $resource = EquipmentGroundDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    
    // /**
    //  * Get the completion action.
    //  *
    //  * @return Filament\Actions\Action
    //  * @throws Exception
    //  */
    // protected function getOnCompletionAction(): Action
    // {
    //     return Action::make("Done")
    //         ->color("success")
    //         // Do not use the visible method, since it is being used internally to show this action if the approval flow has been completed.
    //         // Using the hidden method add your condition to prevent the action from being performed more than once
    //         ->hidden(fn(ApprovableModel $record)=> $record->shouldBeHidden());
    // }
}
