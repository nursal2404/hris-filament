<?php

namespace App\Filament\Employee\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('check_in'),
                TimePicker::make('check_out'),
                Select::make('status')
                    ->options([
            'present' => 'Present',
            'permit' => 'Permit',
            'sick' => 'Sick',
            'leave' => 'Leave',
            'absent' => 'Absent',
        ])
                    ->default('absent')
                    ->required(),
            ]);
    }
}
