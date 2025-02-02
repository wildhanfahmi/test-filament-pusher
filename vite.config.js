import { defineConfig } from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    server:{
        host: '192.168.67.198',
        port: 8000,
        

    },
    plugins: [
        laravel({

            input: ['resources/css/app.css', 'resources/js/app.js'],
            // refresh: true
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
            
        }),
    ],
});
