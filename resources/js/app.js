import '@popperjs/core';
import 'bootstrap';
import '../css/app.css';
import './bootstrap';
import Echo from 'laravel-echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

//Put Pusher & Echo JS down here
window.Echo.channel('list.' + listId).listen('ListBroadcast', (e) => {
    if(e.action === 'created') {
        Livewire.emit('list-created');
    } else if(e.action === 'deleted') {
        Livewire.emit('list-deleted');
    }
});

window.Echo.channel('board.' + boardId).listen('BroadBroadcast', (e) => {
    if(e.action === 'created') {
        Livewire.emit('board-created');
    } else if(e.action === 'deleted') {
        Livewire.emit('board-deleted');
    }
});

window.Echo.channel('card.' + cardId).listen('ListBroadcast', (e) => {
    if(e.action === 'created') {
        Livewire.emit('card-created');
    } else if(e.action === 'deleted') {
        Livewire.emit('card-deleted');
    }
});