const { mix } = require('laravel-mix');

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
//
// mix.js('resources/assets/js/app.js', 'public/js')
//     .sass('resources/assets/sass/app.scss', 'public/css');

mix.sass('app.scss', '/public/css')
    .sass('../../../node_modules/materialize-css/sass/materialize.scss', '/public/css')
    // .styles([
    //     '../../../node_modules/animate.css/animate.min.css',
    //     // '../../../node_modules/google-code-prettify/bin/prettify.min.css',
    //     '../../../node_modules/daterangepicker/daterangepicker-bs3.min.css',
    //     // 'dropzone.css'
    // ])
    .js('app.js', '/public/js');