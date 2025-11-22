import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: false,
    disableStats: true,
});

const userId = document.querySelector('meta[name="user-id"]').content;

// Listen for incoming video call signals
window.Echo.private(`video-call.${userId}`)
    .listen('VideoCallSignal', (e) => {
        console.log('Incoming signal:', e);
        // handle WebRTC offer/answer/ice here
    });

// Send a signal
async function sendSignal(signal, to) {
    await fetch('/video-call/signal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ signal, to }),
    });
}
