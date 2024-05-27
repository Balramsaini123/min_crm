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
        outDir: 'public/validation', // Specify the output directory
        emptyOutDir: true, // Clean the output directory before each build
      },

});
