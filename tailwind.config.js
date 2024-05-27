import defaultTheme from 'tailwindcss/defaultTheme';
import preset from './vendor/filament/support/tailwind.config.preset'


/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './vendor/filament/**/*.blade.php',

    
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/css/**/*.css',
    './app/Http/Livewire/**/*.php',
    './vendor/filament/**/*.blade.php', 
  ],
  theme: {
    extend: {
        fontFamily: {
            sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
    },
},

plugins: [
  require('@tailwindcss/forms'),
  require('@tailwindcss/typography'),
],
}

