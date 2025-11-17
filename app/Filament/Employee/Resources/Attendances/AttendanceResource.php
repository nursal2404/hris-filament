<?php

namespace App\Filament\Employee\Resources\Attendances;

use BackedEnum;
use App\Models\Employee;
use App\Models\Attendance;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Employee\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Employee\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Employee\Resources\Attendances\Tables\AttendancesTable;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendancesTable::configure($table);
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
            'index' => ListAttendances::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $userId = Auth::id();

        // Cari data Employee yang berelasi dengan user_id yang sedang login
        $employee = Employee::where('user_id', $userId)->first();

        if (!$employee) {
            // Jika tidak ditemukan Employee, kembalikan query kosong
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }
        // Dapatkan employee_id dari data Employee yang ditemukan
        $employeeId = $employee->employee_id; 
        // Filter data Attendance berdasarkan employee_id
        return parent::getEloquentQuery()
            ->where('employee_id', $employeeId)
            ->orderBy('date', 'desc'); // Urutkan agar tanggal terbaru di atas    
    }
}
