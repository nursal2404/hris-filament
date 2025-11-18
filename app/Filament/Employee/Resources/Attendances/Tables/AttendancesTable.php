<?php

namespace App\Filament\Employee\Resources\Attendances\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_in')
                    ->time()
                    ->sortable(),
                TextColumn::make('check_out')
                    ->time()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success', 
                        'ongoing' => 'warning', 
                        'absent' => 'danger',   
                        'leave' => 'info',      
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('check_in')
                    ->label('Check In')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation() // Tampilkan modal konfirmasi
                    ->modalHeading('Konfirmasi Check In')
                    ->modalSubheading('Apakah Anda yakin ingin melakukan check in sekarang?')
                    ->modalButton('Ya, Check In')
                    ->action(function ($record) {
                        $now = Carbon::now('Asia/Jakarta');
                        $record->update([
                            'check_in' => $now, 
                            'status' => 'present',
                        ]);
                        Notification::make()
                            ->title('Check In Berhasil')
                            ->body('Anda berhasil check in pada jam ' . $now->format('H:i:s'))
                            ->success()
                            ->send();
                    })
                    ->visible(function ($record): bool {
                        // Ambil tanggal dan jam hari ini
                        $today = Carbon::now('Asia/Jakarta')->toDateString();
                        
                        // Tampilkan jika tanggal record adalah hari ini dan belum check in
                        return $record->date == $today && $record->check_in === null;
                    }),

                    Action::make('check_out')
                    ->label('Check Out')
                    ->icon('heroicon-o-arrow-left-end-on-rectangle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Check Out')
                    ->modalSubheading('Apakah Anda yakin ingin melakukan check out sekarang?')
                    ->modalButton('Ya, Check Out')
                    ->action(function ($record) {
                        $now = Carbon::now('Asia/Jakarta'); 
                        
                        $record->update([
                            'check_out' => $now,
                            'status' => 'present',
                        ]);

                        Notification::make()
                            ->title('Check Out Berhasil')
                            ->body('Anda berhasil check out pada jam ' . $now->format('H:i:s'))
                            ->success()
                            ->send();
                    })
                    ->visible(function ($record): bool {
                        // Ambil tanggal dan jam hari ini 
                        $today = Carbon::now('Asia/Jakarta')->toDateString();
                        
                        // Tampilkan jika tanggal record hari ini, sudah check in, tapi belum check out
                        return $record->date == $today && 
                                $record->check_in !== null && 
                                $record->check_out === null;
                    }),
            ])
            ->filters([
                //
            ]);
    }
}
