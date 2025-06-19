import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Optimize build
        minify: 'terser',
        manifest: true,
        rollupOptions: {
            external: ['jquery'],
            output: {
                manualChunks: {
                    vendor: ['bootstrap'],
                },
            },
        },
    },
    optimizeDeps: {
        include: ['bootstrap'],
    },
    resolve: {
        alias: {
            '$': 'jquery',
            'jquery': 'jquery'
        }
    },
    publicDir: 'public',
    base: '/'
});
