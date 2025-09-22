<?php

namespace App\Filament\Resources;

use App\Enums\LanguageEnum;
use App\Filament\Resources\PersonResource\Pages;
use App\Helpers\SouthAfricanIdHelper;
use App\Helpers\SouthAfricanMobileHelper;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('surname')
                    ->required(),
                Forms\Components\TextInput::make('sa_id_number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(13)
                    ->numeric()
                    ->extraAttributes(['maxlength' => '13'])
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if (!SouthAfricanIdHelper::isValid($value)) {
                                    $fail('The SA ID number is not valid.');
                                }
                            };
                        }
                    ]),
                Forms\Components\TextInput::make('mobile_number')
                    ->required()
                    ->numeric()
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if (!SouthAfricanMobileHelper::isValid($value)) {
                                    $fail('The mobile number must be a valid South African mobile number (e.g., 0712345678 or 27712345678).');
                                }
                            };
                        }
                    ]),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\Select::make('language')
                    ->options(LanguageEnum::options())
                    ->required(),
                Forms\Components\Select::make('interests')
                    ->multiple()
                    ->relationship('interests', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ])
                    ->required(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('surname'),
                Infolists\Components\TextEntry::make('sa_id_number'),
                Infolists\Components\TextEntry::make('mobile_number'),
                Infolists\Components\TextEntry::make('email'),
                Infolists\Components\TextEntry::make('birth_date')
                    ->date(),
                Infolists\Components\TextEntry::make('language'),
                Infolists\Components\TextEntry::make('interests.name')
                    ->badge(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('surname')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sa_id_number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('language')
                ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('interests.name')
                    ->badge()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('restore')
                    ->icon('heroicon-m-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->restore())
                    ->visible(fn($record) => $record->trashed()),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(function ($record) {
                        if ($record->trashed()) {
                            return $record->forceDelete();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->trashed()) {
                                    $record->forceDelete();
                                } else {
                                    $record->delete();
                                }
                            }
                        }),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'view' => Pages\ViewPerson::route('/{record}'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
