<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nip')
            ->label('Nomor Induk Pegawai'),
            ExportColumn::make('name')
            ->label('Nama'),
            ExportColumn::make('roles.name')
            ->label('Roles'),
            ExportColumn::make('date_of_birth')
            ->label('Tanggal Lahir'),
            ExportColumn::make('email')
            ->label('Email'),
            ExportColumn::make('phone')
            ->label('No. Hp'),
            ExportColumn::make('address')
            ->label('Alamat')

            
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
