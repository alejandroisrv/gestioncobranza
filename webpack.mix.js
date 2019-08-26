const mix = require('laravel-mix');

mix.js(['resources/js/app.js'], 'public/js/app.js').extract(['vue']);
mix.js('resources/js/login.js', 'public/js/login.js');
mix.sass('resources/sass/app.scss', 'public/css/app.css');
mix.styles(['resources/css/app.css'], 'public/css/app.css');
mix.version();