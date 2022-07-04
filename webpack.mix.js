const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
                'src/Assets/form/components/*.js',
                'src/Assets/form/components/croppie/*.js',
                'src/Assets/form/components/charlimit/*.js',
                'src/Assets/form/multistepform/*.js',
                'src/Assets/jquery/*.js'
            ], 
            'src/Assets/dist/js/ascent-cms-bundle.js', 
            'src/Assets/dist/js'
            )

    .styles([
                'src/Assets/form/components/*.css',
                'src/Assets/form/components/croppie/*.css',
                'src/Assets/form/components/charlimit/*.css',
                'src/Assets/form/multistepform/*.css'
            ], 
                'src/Assets/dist/css/ascent-cms-bundle.css', 
                'src/Assets/dist/css'
                );
   
   
   
   
    // .minify(['assets/js/ascent-cms-bundle.js', 'assets/css/ascent-cms-bundle.css']);
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ]);
