import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // --- Añadir esta sección ---
    server: {
        host: '0.0.0.0', // Escucha en todas las interfaces de red
        port: 5173,      // Puerto estándar de Vite
        hmr: {
            host: 'localhost', // El host que usará el navegador para conectar a HMR
        }
    }
    // --- Fin de la sección ---
});