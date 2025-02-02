<?php

namespace App\Livewire\Shiftmeeting;

use App\Events\ShiftmeetingCreated;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ParticipantShiftMeeting;
use App\Models\ShiftMeeting;
use App\ShiftManagement;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;


class RoomShiftmeeting  extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;

    public $roomId = null;
    public $countdown = 0;
    public $participants;
    public $qrCode = null;
    public $data = null;
    public $next_shift;
    public $header;
    public $next_shift_time;
    public $current_shift_time;
    public ParticipantShiftMeeting $participant_shiftmeeting;

    protected $listeners = [
        'refreshParticipants' => 'refreshParticipants',
        'decrementCountdown' => 'decrementCountdown',
        'shiftmeeting-created' => 'shiftmeetingCreated',
        'joinedParticipant' => 'newParticipant'
        ];

    public function mount()
    {
        $this->header = Route::current()->parameter('header');
        $sm = new ShiftManagement();
        $recent = $sm->getShift(now())->byTime(now()->format("H:i"));
        //@dd($recent);
        $this->nextShift($recent);
        $this->currentShift($recent);
        $this->isAvailable();
       
    }

    public function isAvailable(){
        $dtStart = now()->createFromTimeString($this->current_shift_time)->toDateTimeString();
        $dtEnd = now()->createFromTimeString(str_replace("00","30",$this->current_shift_time))->toDateTimeString();
        //@dd($dtStart);
        $data = ShiftMeeting::query()->whereBetween("created_at",[$dtStart,$dtEnd])->get()
        ->first();
        //@dd($data);
        //for tes
        //$data = ShiftMeeting::query()->latest()->firstOrFail();
        //@dd(Carbon::parse($data->created_at)->format("H:i"));
        if($data){
            $created_at = Carbon::parse($data->created_at);
            $this->countdown = count(CarbonInterval::minutes()->toPeriod($created_at->format("H:i"), $created_at->addMinutes(30-($created_at->diffInMinutes(now())))))*60;
            //@dd($this->countdown);
            if($this->countdown > 0){
                $this->shiftmeetingCreated(["shiftmeeting"=>$data]);
            } 

        }
    }

    public function currentShift($recent){
        switch($recent){
                case "Shift Malam":
                    $this->current_shift_time = "22:00";
                    break;
                case "Shift Pagi":
                    $this->current_shift_time = "08:00";
                    break;
                default:
                    $this->current_shift_time = "16:00";
                    break;
            }
    }
    public function nextShift($recent){
        switch($recent){
                case "Shift Malam":
                    $this->next_shift_time = "08:00";
                    break;
                case "Shift Pagi":
                    $this->next_shift_time = "16:00";
                    break;
                default:
                    $this->next_shift_time = "22:00";
                    break;
            }
        
    }

    public function shiftmeetingCreated($data){


        $this->data = $data;
        $this->roomId = $this->data["shiftmeeting"]["id"];
        //$this->next_shift_time = null;
        $this->generateQrCode();
        $this->refreshParticipants();
    }

    public function newParticipant(){
        $this->refreshParticipants();
    }

 

    public function generateQrCode()
    {
        //ShiftmeetingCreated::dispatch("tes");
        if($this->countdown == null){
            $this->countdown = 30*60;
        } // Reset hitungan mundur
        $this->qrCode = route('shiftmeeting.join', [
            $this->roomId,
            now()->format("H:i")
            ]);
    }

    public function refreshParticipants()
    {
        $this->resetTable();
    }



    public function table(Table $table){
        $participants = ParticipantShiftMeeting::where('shiftmeeting_id', $this->roomId)->with('user');
        //@dd($this->participants);
        return $table
        ->query($participants)
        //->relationship(fn (): BelongsTo => $this->participant_shiftmeeting->user())
        //->inverseRelationship('participants')
        ->columns([
                TextColumn::make('user.name')
                ->label("Name"),
                TextColumn::make('user.group')
                ->label('Grup'),
                TextColumn::make('created_at')
                ->label('Joined At')
                ->since()
            ])
            ->paginated(false)
            ->header(null);
    }

    public function decrementCountdown()
    {
        if ($this->countdown > 0) {
            $this->countdown--;
        } else{
            $this->roomId = null;
            $this->qrCode = null;
            $this->participants = null;
            //$this->next_shift_time = $this->nextShift($recent);
        }
    }
    #[Layout('layouts.guest',['header'=>true])]
    public function render()
    {
        return view('livewire.shiftmeeting.room');
    }
};
