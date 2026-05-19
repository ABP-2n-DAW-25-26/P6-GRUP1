import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
        }),
        inertia(),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'auto',
            manifestFilename: 'manifest.webmanifest',
            includeAssets: ['favicon.svg', 'favicon.ico', 'cendraquest-256.png'],
            manifest: {
                name: 'CendraQuest',
                short_name: 'CendraQuest',
                description: 'Plataforma de activitats i gimcanes educatives',
                theme_color: '#4dbcad',
                background_color: '#ffffff',
                display: 'standalone',
                scope: '/',
                start_url: '/',
                icons: [
                    {
                        src: '/cendraquest-256.png',
                        sizes: '256x256',
                        type: 'image/png',
                        purpose: 'any',
                    },
                    {
                        src: '/cendraquest-256.png',
                        sizes: '256x256',
                        type: 'image/png',
                        purpose: 'maskable',
                    },
                ],
            },
            workbox: {
                navigateFallback: null,
                navigateFallbackDenylist: [/^\/(?!build\/)/],
                globPatterns: ['**/*.{js,css,ico,png,svg,webp,woff,woff2}'],
            },
        }),
    ],
});
