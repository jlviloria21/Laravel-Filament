<?php

namespace App\Filament\Resources\Holidays\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class HolidayForm
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
                Select::make('type')
                ->options([
                    'decline' => 'Decline',
                    'approve' => 'Approve',
                    'pending' => 'Pending',
                ]),
                DatePicker::make('day')
                    ->required(),
                // TextInput::make('type')
                //     ->required()
                //     ->default('pending'),
            ]);
    }
}
