const elixir = require('laravel-elixir');
const path = require('path');

require('laravel-elixir-vue-2');
require('laravel-elixir-webpack-official');

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

Elixir.webpack.config.module.loaders = [];

Elixir.webpack.mergeConfig({
    resolveLoader: {
        root: path.join(__dirname, 'node_modules'),
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel',
                exclude: /node_modules/
            },
            {
                test: /\.css$/,
                loader: 'style!css'
            }
        ]
    }
});


elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');

    // less
    mix.less('app.less', 'resources/assets/less/css/');

    // styles
    mix.styles([
        // theme style
        "public/css/theme.src.css",

        // dependencies
        'public/bower_components/toastr/toastr.css',

        // main styles
        'resources/assets/less/css/*.css',
    ], 'public/css/app.src.css', './');

    // scripts
    mix.scripts([
        // theme script
        'public/js/theme.src.js',

        // dependencies
        'public/bower_components/toastr/toastr.js',

        // main vue js
        'public/js/app.js',
    ], 'public/js/app.src.js', './');

    // versions
    mix.version([
        "public/css/app.src.css",
        "public/js/app.src.js",
    ]);

});
