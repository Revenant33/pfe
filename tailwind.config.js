import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
             colors: {
      primary: '#4CAF50',         // Soft green
        'primary-dark': '#388E3C',
        background: '#f4f7f6',       // Light soft background
        foreground: '#333333',       // Darker text
    }
        },
    },

    plugins: [forms],
};
