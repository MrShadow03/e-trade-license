import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //include all files in public/assets/css and public/assets/js
                './public/assets/plugins/global/font-awesome.css',
                './public/assets/plugins/global/swal2.css',
                './public/assets/css/style.bundle.css',
                './public/assets/css/custom.css',
                './public/assets/plugins/global/fv-plugin.js',
                './public/assets/plugins/global/swal2.js',
                './public/assets/js/scripts.bundle.js',
            ],
            refresh: true,
        }),
        purge({
            // templates: ['blade'],
            paths: ['resources/views/admin/pages/login.blade.php']
        }),
    ],
});
