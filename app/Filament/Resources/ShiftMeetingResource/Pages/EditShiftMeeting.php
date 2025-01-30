<?php

namespace App\Filament\Resources\ShiftMeetingResource\Pages;

use App\Filament\Resources\ShiftMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShiftMeeting extends EditRecord
{
    protected static string $resource = ShiftMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

 
}
