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
<<<<<<< HEAD
    safelist: [
  {
    pattern: /bg-\[url\(.*\)\]/,
  },
    ],


    theme: {
  extend: {
    
    backgroundImage: {
      'ecommerce': "url('/images/blueback.jpg')",
    },
    colors: {
      primary: '#4CAF50',          // Vert principal
      'primary-dark': '#388E3C',   // Version foncée
      secondary: '#2196F3',        // Ajout d'une couleur secondaire
      background: '#f4f7f6',       // Fond clair
      foreground: '#333333',       // Texte sombre
      danger: '#f44336',           // Pour les erreurs
    },
    fontFamily: {
      sans: ['"Open Sans"', ...defaultTheme.fontFamily.sans], // Police personnalisée
    },
  },
},
=======

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
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c

    plugins: [forms],
};
