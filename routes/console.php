<?php

use App\Http\Controllers\AddNewShiftmeeting;
use App\Models\ShiftMeeting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(new AddNewShiftmeeting)
->dailyAt("08:00");
Schedule::call(new AddNewShiftmeeting)
->dailyAt("16:00");
Schedule::call(new AddNewShiftmeeting)
->dailyAt("22:00");
Schedule::call(new AddNewShiftmeeting)
->dailyAt("23:15");