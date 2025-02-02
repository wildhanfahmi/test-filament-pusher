@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
{{-- @dd($participants); --}}
<div>
    {{-- <x-tabs></x-tabs> --}}
    <div class="text-2xl text-gray-600 dark:text-gray-400 sm:hidden">Halaman ini tidak dapat di akses pada ukuran layar kecil.</div>
    <div class="hidden sm:flex">
        <!-- Kolom Pertama: QR Code dan Hitungan Mundur -->
        <div class="w-1/2 p-4">
            <div class="bg-white dark:bg-gray-800 p-4 shadow rounded-lg">
                <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">Shift Meeting Operator</div>
                @if ($qrCode != null)
                            <div class=" p-4">
                                <div class="flex justify-between">
                                    {{-- @dd($data); --}}
                                    <div class="text-lg font-semibold text-gray-600 dark:text-gray-400">{{ $data["shiftmeeting"]["prev_shift"] }}
                                     <br>
                                     {{ $data["shiftmeeting"]["prev_group"] }}   
                                    </div>
                                    <div class="self-center object-center">
                                        @svg('fas-arrow-right-arrow-left','w-6 h-6 text-gray-600 dark:text-gray-400')
    
                                    </div>
                                    <div class="text-lg font-semibold text-gray-600 dark:text-gray-400">{{ $data["shiftmeeting"]["next_shift"] }}
                                        <br>
                                        {{ $data["shiftmeeting"]["next_group"] }}  
                                    </div>
                                </div>
                            </div>
                        
                            
                        @endif
                <div class="text-center">
                    <div class="mb-4 flex justify-center">
                        
                        <div class="p-4 {{ $countdown != 0 ? 'bg-white' : ''}}">
                            @if ($next_shift_time == null && $qrCode == null)
                                <p class="text-gray-600 dark:text-gray-400">Please wait...</p>
                            @elseif ($next_shift_time != null && $qrCode == null)
                                <p class="text-gray-600 dark:text-gray-400">Akses Shift Meeting berikutnya akan dibuka pada pukul {{ $next_shift_time }}</p>
                            @else
                            
                            {{ QrCode::size(200)->generate($qrCode) }}
                            
                                
                            @endif
                        </div>
                    </div>
                    <div class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                        @if ($countdown != 0)
                            <p>Waktu scan Shift Meeting akan berakhir dalam: {{ floor($countdown/60) }} menit {{ $countdown%60 }} detik</p>
                        
                            
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kedua: Daftar Participant -->
        <div class="w-1/2 p-4 h-full block">
            <div class="bg-white dark:bg-gray-900 p-4 shadow rounded-lg text-gray-600 dark:text-gray-400">
                
                <h2 class="text-xl font-semibold mb-4">Participants</h2>
                @if ($qrCode == null)
                    <p><i>Shift Meeting</i> belum dibuka</p>
                @else
                {{ $this->table; }}
                    {{-- <ul>
                        @foreach ($participants as $participant)
                            <li wire:key="{{ $participant->user->id }}" class="mb-2">
                                <div class="flex justify-between">
                                    <div>{{ $participant->user->name }}</div>
                                    <div>{{ $participant->user->group }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul> --}}
                @endif
            </div>
        </div>
    </div>

    <!-- Script untuk hitungan mundur -->
</div>
    <script >
        setInterval(() => {
        Livewire.dispatch('decrementCountdown');
    }, 1000);
   
    </script>
