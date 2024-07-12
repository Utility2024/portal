<?php

namespace App\Filament\Stock\Resources\TransactionResource\Pages;

use App\Filament\Stock\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
