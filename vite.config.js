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
        outDir: 'public/build',
        rollupOptions: {
            external: ['jquery'],
            output: {
                manualChunks: {
                    vendor: ['bootstrap'],
                },
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.').at(1);
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        extType = 'img';
                    }
                    return `assets/${extType}/[name]-[hash][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
            },
        },
    },
    optimizeDeps: {
        include: ['bootstrap'],
    },
    resolve: {
        alias: {
            '$': 'jquery',
            'jquery': 'jquery',
            '@': '/resources',
        }
    },
    publicDir: false,
    base: '/'
});
