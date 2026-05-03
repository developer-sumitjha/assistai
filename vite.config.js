import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        // VitePWA({
        //     registerType: 'autoUpdate',
        //     injectRegister: 'auto',
        //     workbox: {
        //         globPatterns: ['**/*.{js,css,html,ico,png,svg,woff,woff2}'],
        //         cleanupOutdatedCaches: true,
        //     },
        //     manifest: {
        //         name: 'AssistAI User App',
        //         short_name: 'AssistAI',
        //         description: 'Progressive Web App for AssistAI Users',
        //         theme_color: '#2563EB',
        //         background_color: '#ffffff',
        //         display: 'standalone',
        //         orientation: 'portrait',
        //         scope: '/',
        //         start_url: '/app/login',
        //         icons: [
        //             {
        //                 src: '/pwa-icon.png',
        //                 sizes: '192x192',
        //                 type: 'image/png'
        //             },
        //             {
        //                 src: '/pwa-icon.png',
        //                 sizes: '512x512',
        //                 type: 'image/png'
        //             },
        //             {
        //                 src: '/pwa-icon.png',
        //                 sizes: '512x512',
        //                 type: 'image/png',
        //                 purpose: 'maskable'
        //             }
        //         ]
        //     }
        // })
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
