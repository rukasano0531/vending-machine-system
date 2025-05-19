const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // Laravel フレームワークの Pagination ビュー
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    // キャッシュされたビュー
    './storage/framework/views/*.php',
    // Blade ファイル全般
    './resources/views/**/*.blade.php',
    // JavaScript ファイル (Vue/React など含む)
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
    './resources/js/**/*.jsx',
    './resources/js/**/*.tsx',
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
  ],
};