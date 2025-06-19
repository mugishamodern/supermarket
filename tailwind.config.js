import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#dc3545',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],

    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },

    purge: {
        enabled: true,
        content: [
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
        ],
    },
};
