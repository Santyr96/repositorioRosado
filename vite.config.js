import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    esbuild: {
        loader: {
          '.js': 'jsx'
        },
      },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/js/components/flyout_menu.js'
            ],
            output: 'public/build',
            base: '/public/',
            refresh: true,
        }),
    ],
});
