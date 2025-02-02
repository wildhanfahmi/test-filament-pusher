<?php

namespace App\Filament\Resources\ShiftMeetingResource\Widgets;

use App\Models\ParticipantShiftMeeting;
use App\Models\ShiftMeeting;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShiftmeetingScoreOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    //public $filters = ['startDate','endDate'];
    protected $listeners = [
        'updateFilterScoreShiftmeeting' => 'updateFilterScoreShiftmeeting'
        ];
    public $group, $dateStart, $dateEnd, $attendance, $absence, $percentage;
    protected function getStats(): array
    {
        $this->updateStats();
        return [
            Stat::make('Attendance', $this->dateStart??''),
            Stat::make('Absence', '21%'),
            Stat::make('Percentage', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }

    public function updateStats(){
        if($this->group == null && $this->dateStart == null & $this->dateEnd == null){
            $stats = ShiftMeeting::query()->with('participants')->latest()->first();
            @dd($stats->participants()->count());
        }
    }


    protected function getHeading(): ?string
    {
        return 'Shift Meeting Scoring';
    }

    protected function getDescription(): ?string
    {
        return 'An overview of meeting attendance analytics by operators.';
    }

    public function updateFilterScoreShiftmeeting($filters){
        @dd($filters);
        $this->dateStart = $filters['data']['startDate'];
        $this->dateEnd = $filters['data']['endDate'];
        $this->group = $filters['data']['group'];
    }
    
}
