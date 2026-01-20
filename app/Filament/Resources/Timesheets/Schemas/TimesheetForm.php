<?php

namespace App\Filament\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TimesheetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('calendar_id')
                ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->required(),
                Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),
                // TextInput::make('type')
                //     ->required()
                //     ->default('work'),
                Select::make('type')
                ->options([
                    'work' => 'Workin',
                    'pause' => 'In pause',
                ]),
                DateTimePicker::make('day_in')
                    ->required(),
                DateTimePicker::make('day_out')
                    ->required(),
            ]);
    }
}
