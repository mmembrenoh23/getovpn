const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.sass('resources/assets/scss/style.scss','public/assets/css');


mix.copyDirectory('resources/assets/js', 'public/assets/js');

mix.copyDirectory('resources/src/js', 'public/src/js');
mix.copyDirectory('resources/theme-assets', 'public/theme-assets');


mix.version();
