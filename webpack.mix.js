const mix           = require('laravel-mix');
const webpack       = require('webpack');
const tailwindcss   = require('tailwindcss');

// require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Custom Mix setup
 |--------------------------------------------------------------------------
 |
 */

mix.webpackConfig({
    plugins: [
        // load only armenian locales to reduce moment.js size
        new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /hy-am/),

        // load jquery for other plugins
        // new webpack.ProvidePlugin({
        //     $: 'jquery',
        //     jQuery: 'jquery',
        //     'window.jQuery': 'jquery'
        // }),
    ],
});
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


mix.js('resources/js/app.js', 'public/assets/js')
    .sass('resources/sass/app.scss', 'public/assets/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    });
