<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Events\PersonCreated;
use App\Filament\Resources\PersonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;

    protected function afterCreate(): void
    {
        event(new PersonCreated($this->record));
    }
}
