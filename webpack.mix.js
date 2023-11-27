let mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js");
mix.js("resources/js/proveedor.js", "public/js");
mix.js("resources/js/producto.js", "public/js");
mix.js("resources/stock.js", "public/js");
mix.js("resources/js/categoria.js", "public/js");
mix.js("resources/js/factura.js", "public/js");
mix.js("resources/js/informe.js", "public/js");
mix.js("resources/js/role.js", "public/js");
mix.js("resources/js/usuario.js", "public/js");
mix.js("resources/js/cliente.js", "public/js");
mix.js("resources/js/panel.js", "public/js");
//mix.sass("resources/assets/sass/app.scss", "public/css");

mix.browserSync('127.0.0.1:8000/login')
