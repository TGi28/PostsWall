import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        withCredentials: true,
    },
});

window.Echo.channel("my-channel").listen(".my-event", (e) => {
    if (window.Livewire) {
        window.Livewire.dispatch("notification-received");
    }
});

if (window.authId) {
    window.Echo.private("messages." + window.authId).listen(
        ".message-created",
        (event) => {
            Livewire.dispatch("message-received");
        }
    );
}

window.Echo.private("users").listen(".user-status-changed", (event) => {
    Livewire.dispatch("user-status-changed", event);
});
