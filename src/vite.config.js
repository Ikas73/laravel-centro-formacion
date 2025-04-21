import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: { // <--- ¡AÑADE O MODIFICA ESTA SECCIÓN!
        hmr: {
            host: 'localhost', // Indica al cliente HMR que se conecte a localhost
        },
        host: '0.0.0.0', // Hace que Vite escuche en todas las interfaces dentro del contenedor
        watch: {
          usePolling: true // Ayuda a detectar cambios de archivo en Docker/WSL
        }
    }
});