import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Allows access from any device on the network
        port: 5173, // Default Vite port
        hmr: {
            host: "192.168.0.31", // Replace with your local IP
        },
    },
    optimizeDeps: {
        include: ["flowbite"],
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
    ],
});
