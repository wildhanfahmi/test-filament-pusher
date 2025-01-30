import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
})

var channel = window.Echo.channel('operator');
channel.listen('ShiftmeetingCreated', (event) => {
    console.log(event);
    Livewire.dispatch('shiftmeeting-created', {data: event});
});
channel.listen('JoinedShiftmeeting', (event) => {
    console.log(event);
    Livewire.dispatch('joinedParticipant', {data: event});
});