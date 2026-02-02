import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            // Maps "@images/..." to "public/images/..."
            '@images': path.resolve(__dirname, 'public/images'),
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',       // what the browser connects to
            port: 5173,              // WebSocket port for HMR
            clientPort: 5173,        // ensures browser uses the correct WS port
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
            // This is needed for Docker setups enabling HMR to work properly
            usePolling: true,
            interval: 100,
        },
    },
});
