<?php

namespace App\Filament\Dcc\Resources\UserResource\Pages;

use App\Filament\Dcc\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
