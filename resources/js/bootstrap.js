
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from "laravel-echo"
 
window.io = require('socket.io-client');
 
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':2053',
	transports: ['websocket', 'polling', 'flashsocket']
});

window.Echo.channel('statistics')
    .listen('.statistics', (e) => {
        console.log(e);
    });
