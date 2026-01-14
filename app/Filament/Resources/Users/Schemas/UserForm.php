<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use App\Models\State;

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
                        ->afterStateUpdated(fn (Set $set) => $set('state_id', null)) // limpia el segundo select
                        ->required(),

                        Select::make('state_id')
                            ->options(fn (Get $get): Collection => $get('country_id')
                            ? State::where('country_id', $get('country_id'))
                                ->pluck('name', 'id')
                            : collect())
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                ])->columns(3)
                ->columnSpan('full')
            ]);
    }
}
