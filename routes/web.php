<?php

use App\Events\ShiftmeetingCreated;
use App\Livewire\ShiftmeetingClient;
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
Route::get("/shiftmeeting", ShiftmeetingClient::class)
    ->name('shiftmeeting.client');

require __DIR__.'/auth.php';
