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
    safelist: [
  {
    pattern: /bg-\[url\(.*\)\]/,
  },
    ],


    theme: {
  extend: {
    
    backgroundImage: {
      'ecommerce': "url('xampp\htdocs\pfe-main\pfe-main\public\images\blueback.jpg')",
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

    plugins: [forms],
};
