<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPerson extends ViewRecord
{
    protected static string $resource = PersonResource::class;

    public function getTitle(): string
    {
        return 'Viewing : ' . $this->record->name . ' ' . $this->record->surname;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('restore')
                ->icon('heroicon-m-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->restore())
                ->visible(fn ($record) => $record->trashed()),
            Actions\DeleteAction::make()
                ->modalHeading('Delete ' . $this->record->name . ' ' . $this->record->surname)
                ->requiresConfirmation(),
        ];
    }
}
