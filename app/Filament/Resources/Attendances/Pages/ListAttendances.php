<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource;
use App\Models\Attendance;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateToday')
                ->label('Generate Attendance Today')
                ->color('success')
                ->icon('heroicon-o-calendar')
                ->requiresConfirmation()
                ->action(function () {
                    
                    $employees = Employee::all();
                    $newRecordsCount = 0;

                    if ($employees->isEmpty()) {
                        Notification::make()
                            ->title('Gagal: Tidak ada Karyawan!')
                            ->body('Tidak ada data karyawan yang ditemukan untuk digenerate.')
                            ->danger()
                            ->send();
                        return;
                    }

                    foreach ($employees as $employee) {
                        $attendance = Attendance::firstOrCreate(
                            [
                                'employee_id' => $employee->employee_id,
                                'date' => today(),
                            ],
                            [
                                'status' => 'absent',
                            ]
                        );

                        // Cek apakah record ini BARU dibuat atau sudah ada
                        if ($attendance->wasRecentlyCreated) {
                            $newRecordsCount++;
                        }
                    }

                    // Notifikasi berdasarkan hasil
                    if ($newRecordsCount > 0) {
                        Notification::make()
                            ->title('Berhasil!')
                            ->body("{$newRecordsCount} data absensi baru telah digenerate.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Info')
                            ->body('Data absensi untuk hari ini sudah lengkap. Tidak ada data baru yang ditambahkan.')
                            ->info()
                            ->send();
                    }
                }),
        ];
    }
}