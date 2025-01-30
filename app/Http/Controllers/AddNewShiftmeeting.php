<?php

namespace App\Http\Controllers;

use App\Events\ShiftmeetingCreated;
use App\Filament\Resources\ShiftMeetingResource;
use App\Filament\Resources\ShiftMeetingResource\Pages\ListShiftMeetings;
use App\Livewire\ShiftmeetingClient;
use App\Models\ShiftMeeting;
use App\ShiftManagement;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Features\SupportEvents\HandlesEvents;
use Livewire\Livewire;
use Livewire\Volt\Component as VoltComponent;

use function Laravel\Prompts\error;

class AddNewShiftmeeting extends Controller
{
    /**
     * Handle the incoming request.
     */
    use HandlesEvents;

    
    public function __invoke(Request $request)
    {
        $shiftManagement = new ShiftManagement();
        $getShift = $shiftManagement->getShift(now());
        $currenShift = $getShift->byTime(now()->format("H:i"));
        $grupShift = $getShift->byShift($currenShift);
        switch($currenShift){
            case "Shift Pagi":
                $next_shift = "Shift Sore";
                $next_group = $getShift->byShift($next_shift);
                break;
            case "Shift Sore":
                $next_shift = "Shift Malam";
                $next_group = $getShift->byShift($next_shift);
                break;
            default:
                $next_shift = "Shift Pagi";
                $next_group = $getShift->byShift($next_shift);
                break;
        }
        
        $created = ShiftMeeting::create([
            "prev_group" => $grupShift,
            "next_group" => $next_group,
            "prev_shift" => $currenShift,
            "next_shift" => $next_shift,

        ]);


        if($created){
            ShiftmeetingCreated::dispatch($created);
        }
    }
}
