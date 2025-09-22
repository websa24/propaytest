<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use App\Models\Person;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerson extends EditRecord
{
    protected static string $resource = PersonResource::class;

    public function getTitle(): string
    {
        return 'Editing : ' . $this->record->name . ' ' . $this->record->surname;
    }

    public function mount(int | string $record): void
    {
        $this->record = Person::with('interests')->find($record);

        $this->fillForm();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Delete ' . $this->record->name . ' ' . $this->record->surname),
        ];
    }
}
