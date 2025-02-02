<?php

namespace App\Http\Controllers;

use App\Events\JoinedShiftmeeting;
use App\Models\ParticipantShiftMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class ShiftmeetingController extends Controller
{
    public function join($roomId,$openedAt){

//        $joinedAt = now()->format("H:i");
//        $diff = Carbon::createFromFormat("H:i", $openedAt)->diffInMinutes($joinedAt, true);
//        $point = $diff > 15 ? 1 : 2;
        $joined = ParticipantShiftMeeting::with('user')->updateOrCreate(
            ['user_id' => Auth::user()->id, 'shiftmeeting_id' => $roomId],
            ['user_id' => Auth::user()->id, 'shiftmeeting_id' => $roomId],

        );


        if($joined){
            JoinedShiftmeeting::dispatch($joined);
            return view('shiftmeeting.joined-room',['joined' => true]);
        } else{
            return view('shiftmeeting.joined-room',['joined' => false]);
        }
    }
}
