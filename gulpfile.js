const elixir = require('laravel-elixir');

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
    mix.sass('app.scss', 'public/assets/css')
       .styles([
            './resources/assets/plugins/sweetalert/dist/sweetalert.css',
            './resources/assets/plugins/select2/dist/css/select2.min.css',
            './resources/assets/plugins/bootstrap-fileinput/css/fileinput.min.css',
            './resources/assets/plugins/select2/dist/css/select2-bootstrap.min.css',
            './resources/assets/plugins/formvalidation/dist/css/formValidation.min.css',
            'custom.css'
        ], 'public/assets/css/static.css')
       .scripts([
            './node_modules/jquery/dist/jquery.min.js',
            './resources/assets/plugins/sweetalert/dist/sweetalert.min.js',
            './resources/assets/plugins/select2/dist/js/select2.full.min.js',
            './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
            './resources/assets/plugins/bootstrap-fileinput/js/fileinput.min.js',
            './resources/assets/plugins/formvalidation/dist/js/formValidation.popular.min.js',
            './resources/assets/plugins/formvalidation/dist/js/framework/bootstrap.min.js',
            'custom.js'
        ], 'public/assets/js')
        .copy("./node_modules/bootstrap-sass/assets/fonts", "public/assets/fonts/")
        .copy("./resources/assets/public_includes", "public/assets/plugins/");
});
