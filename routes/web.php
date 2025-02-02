<?php

use App\Events\ShiftmeetingCreated;
use App\Livewire\Shiftmeeting\RoomShiftmeeting;
use App\Livewire\Shiftmeeting\ScoreShiftmeeting;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get("/shiftmeeting/room", RoomShiftmeeting::class)
    ->name('shiftmeeting.room');
Route::get("/shiftmeeting/score", ScoreShiftmeeting::class)
    ->name('shiftmeeting.score');

require __DIR__.'/auth.php';
