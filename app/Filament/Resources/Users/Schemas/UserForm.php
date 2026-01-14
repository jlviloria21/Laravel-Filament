<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Collection;
use App\Models\State;
use App\Models\City;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                ->schema([
                    TextInput::make('name')
                    ->required(),
                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->required(),
                    DateTimePicker::make('email_verified_at'),
                    TextInput::make('password')
                        ->password()
                        ->required(),
                ])->columns(4)
                ->columnSpan('full'),

                Section::make('Address Info')
                ->schema([
                    Select::make('country_id')
                        ->relationship('country',titleAttribute:'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('state_id', null);
                            $set('city_id', null);
                        })
                        ->required(),

                    Select::make('state_id')
                        ->options(fn (Get $get): Collection => $get('country_id')
                        ? State::where('country_id', $get('country_id'))
                            ->pluck('name', 'id')
                        : collect())
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('city_id')
                        ->options(fn (Get $get): Collection => $get('state_id')
                        ? City::where('state_id', $get('state_id'))
                            ->pluck('name', 'id')
                        : collect())
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('city_id', null);
                        })
                        ->required(),
                     TextInput::make('address')
                        ->label('Address')
                        ->required(),
                         TextInput::make('postal_code')
                        ->label('Postal Code')
                        ->required(),

                ])->columns(3)
                ->columnSpan('full')
            ]);
    }
}
