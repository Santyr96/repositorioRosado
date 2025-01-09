import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/components/dashboards/admin-panel-extend.js',
                'resources/js/components/dashboards/load-view.js',
                'resources/js/components/dashboards/notification-extend.js',
                'resources/js/auth/auth.js',
                'resources/js/auth/validate-hairdresser.js',
                'resources/js/auth/validate-profile.js',
                'resources/js/auth/validate-reset-password.js',
                'resources/js/components/dashboards/calendar/show-calendar.js',
                'resources/js/components/dashboards/calendar/modal-appointment-edit-and-delete.js',
                'resources/js/components/dashboards/calendar/modal-appointment-create.js',
                'resources/js/components/dashboards/hairdresser/insert-hairdresser.js',
                'resources/js/components/dashboards/hairdresser/delete-hairdresser.js',
                'resources/js/components/dashboards/hairdresser/reload-select-hairdresser-view.js',
                'resources/js/components/dashboards/profile/update-avatar.js',
                'resources/js/components/dashboards/profile/update-profile.js',
                'resources/js/components/dashboards/services-hair/create-service.js',
                'resources/js/components/dashboards/services-hair/delete-service.js',
                'resources/js/components/dashboards/services-hair/update-service.js',
                'resources/js/components/dashboards/services-hair/services-manage.js',
                'resources/js/components/dashboards/signup/signup-hairdresser.js',
                'resources/js/components/layouts/flyout_menu.js',
                'resources/js/components/modals/close-modal.js',
                'resources/js/components/passwords/show-password.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js', 
        },
    },
    server: {
        host: '0.0.0.0', 
        port: 3000,  
        strictPort: true,
        hmr: {
            protocol: 'wss',
            host: 'localhost',
        }
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
