const mix = require('laravel-mix');

mix.version();

mix.js('resources/js/app.js', 'public/js').extract();
mix.js('resources/js/bootstrap.js', 'public/js');
mix.js('resources/js/history.js', 'public/js');

mix.sass('resources/sass/bootstrap.scss', 'public/css');

mix.copy('resources/css/app.css', 'public/css/app.css');
mix.copy('resources/css/applayout.css', 'public/css/applayout.css');
mix.copy('resources/css/history.css', 'public/css/history.css');
