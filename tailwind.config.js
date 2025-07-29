import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    bg: '#0f172a',     // dark slate
                    text: '#cbd5e1',   // slate-300
                },
                light: {
                    bg: '#f8fafc',     // slate-50
                    text: '#1e293b',   // slate-800
                },
            },

            backgroundImage: theme => ({
                'stars-dark': "radial-gradient(circle at 25% 25%, rgba(255,255,255,0.02) 0%, transparent 70%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.01) 0%, transparent 70%)",
                'gradient-subtle': "linear-gradient(to top, #0f172a, #1e293b)",
            }),
        },
    },
    plugins: [forms, typography],
    build: {
        rollupOptions: {
            external: ['alpinejs', '@alpinejs/focus']
        }
    }
};