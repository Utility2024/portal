<?php

namespace App\Filament\Stock\Resources\UserResource\Pages;

use App\Filament\Stock\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
