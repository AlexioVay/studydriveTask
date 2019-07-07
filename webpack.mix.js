const mix = require('laravel-mix');

mix.setPublicPath('public')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css')
    .sass('resources/sass/_global.sass', 'public/css')
    .sass('resources/sass/mqueries.sass', 'public/css')
    .styles([
    'public/css/bootstrap.min.css',
    'public/css/app.css',
    'public/css/mqueries.css',
    ],
    'public/css/app.css')
    .disableNotifications();
