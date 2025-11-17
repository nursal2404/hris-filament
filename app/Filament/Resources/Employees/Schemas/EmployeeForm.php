<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Employee Name')
                    ->relationship('user', 'name', fn ($query) =>
                                    $query->where('role', 'employee')
                    )
                    ->required(),
                TextInput::make('address')
                    ->required(),
                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->required(),
                Select::make('position_id')
                    ->label('Position')
                    ->relationship('position', 'title')
                    ->required(),
            ]);
    }
}
