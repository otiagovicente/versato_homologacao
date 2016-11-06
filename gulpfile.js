const elixir = require('laravel-elixir');

require('laravel-elixir-vue');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
        .styles(['../../../node_modules/animate.css/animate.min.css',
            '../../../node_modules/google-code-prettify/bin/prettify.min.css',
            'dropzone.css'
        ])
        .webpack('app.js');

});
