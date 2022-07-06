const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix
    .js('source/_assets/js/main.js', 'js').vue()
    .sass('source/_assets/sass/main.scss', 'css/main.css')
    .sass('source/_assets/sass/fonts.scss', 'css/fonts.css')
    .jigsaw({
        watch: ['config.php', 'source/**/*.md', 'source/**/*.php', 'source/**/*.scss'],
    })
    .options({
        processCssUrls: false,
        postCss: [
            require('tailwindcss'),
        ],
    })
    .sourceMaps()
    .version();