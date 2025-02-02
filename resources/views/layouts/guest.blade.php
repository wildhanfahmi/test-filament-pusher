
<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @php
            if(request()->routeIs('shiftmeeting.room') || request()->routeIs('shiftmeeting.score')){
                $header = true;
            } else{
                $header = false;
            }
        @endphp
        <div class="min-h-screen flex flex-col  {{ $header ? '' : 'sm:justify-center'}} items-center  pt-6 bg-gray-100 dark:bg-gray-900">
            {{-- <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}
            @if ($header)
                <div class="sm:block hidden">
                    <x-tabs>
                      
                            <x-tabs-link index="first" :active="request()->routeIs('shiftmeeting.room')" :href="route('shiftmeeting.room')"  wire:navigate>Room</x-tabs-link>
                            <x-tabs-link index="last" :active="request()->routeIs('shiftmeeting.score')" :href="route('shiftmeeting.score')" wire:navigate>Score Board</x-tabs-link>
                       
                    </x-tabs>
                </div>
            @endif

            <div class="w-full sm:max-w-5xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        @filamentScripts
        @livewireScripts
    </body>
</html>
