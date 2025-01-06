import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js', 
        },
    },
    build: {
        onError: (error) => {
            console.error('Error de construcción:', error);
        },
        onWarn: (warning) => {
            console.warn('Advertencia de construcción:', warning);
        },
    },
});
