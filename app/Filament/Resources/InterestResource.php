<?php

namespace App\Filament\Resources;

use App\Models\Interest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InterestResource extends Resource
{
    protected static ?string $model = Interest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rules(function ($get, $set, $livewire) {
                        $record = $livewire->record ?? null;
                        return $record ? ['unique:interests,name,' . $record->id] : ['unique:interests,name'];
                    })
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->withCount('people'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('people_count')
                    ->label('People interested in')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        $count = $record->people()->count();
                        if ($count > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Cannot delete interest')
                                ->body("This interest is linked to {$count} person(s).")
                                ->danger()
                                ->send();
                            throw new \Filament\Support\Exceptions\Halt('Deletion prevented');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                $count = $record->people()->count();
                                if ($count > 0) {
                                    \Filament\Notifications\Notification::make()
                                        ->title('Cannot delete interests')
                                        ->body("Some interests are linked to people and cannot be deleted.")
                                        ->danger()
                                        ->send();
                                    throw new \Filament\Support\Exceptions\Halt('Bulk deletion prevented');
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\InterestResource\Pages\ListInterests::route('/'),
            'create' => \App\Filament\Resources\InterestResource\Pages\CreateInterest::route('/create'),
            'edit' => \App\Filament\Resources\InterestResource\Pages\EditInterest::route('/{record}/edit'),
        ];
    }
}
