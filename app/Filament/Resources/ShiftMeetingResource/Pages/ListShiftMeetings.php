<?php

namespace App\Filament\Resources\ShiftMeetingResource\Pages;

use App\Filament\Resources\ShiftMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListShiftMeetings extends ListRecords
{
    protected static string $resource = ShiftMeetingResource::class;
    protected $listeners = ["update-shiftmeeting" => '$refresh'];
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    
}
