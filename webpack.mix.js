let mix = require('laravel-mix');
mix.webpackConfig({ node: { fs: 'empty' }})
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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
/*
 |--------------------------------------------------------------------------
 | Admin Add Query
 |--------------------------------------------------------------------------
 |
 */
mix.scripts([
        'resources/assets/admin/js/jquery.min.js',
        'resources/assets/admin/plugins/select2/js/select2.full.min.js',
    ],
    'public/assets/admin/js/jquery.min.js');
mix.js(['resources/assets/js/spa.js'], 'public/assets/admin/js/spa.js');
mix.scripts([
    'resources/assets/admin/js/bootstrap.min.js',
    'resources/assets/admin/js/detect.js',
    'resources/assets/admin/js/fastclick.js',
    'resources/assets/admin/js/jquery.slimscroll.js',
    'resources/assets/admin/js/jquery.blockUI.js',
    'resources/assets/admin/js/waves.js',
    'resources/assets/admin/js/wow.min.js',
    'resources/assets/admin/js/jquery.nicescroll.js',
    'resources/assets/admin/js/jquery.scrollTo.min.js',
    'resources/assets/admin/js/modernizr.min.js',
    'resources/assets/admin/js/jquery.core.js',
    'resources/assets/admin/js/jquery.app.js',
    'resources/assets/admin/plugins/parsleyjs/parsley.min.js',
    'resources/assets/admin/plugins/switchery/js/switchery.min.js',
    'resources/assets/admin/plugins/voerro-vue-taginput/voerro-vue-tagsinput.js',
    'resources/assets/admin/plugins/vue-multiselect/vue-multiselect.min.js',
], 'public/assets/admin/js/admin.js');
mix.sass('resources/assets/sass/styles.scss','public/assets/admin/css/styles.css')
    .styles([
        'resources/assets/admin/css/bootstrap.min.css',
        'resources/assets/admin/css/core.css',
        'resources/assets/admin/css/components.css',
        'resources/assets/admin/css/icons.css',
        'resources/assets/admin/css/pages.css',
        'resources/assets/admin/css/responsive.css',
        'resources/assets/admin/plugins/switchery/css/switchery.min.css',
        'resources/assets/admin/plugins/select2/css/select2.min.css',
        'resources/assets/admin/plugins/voerro-vue-taginput/style.css',
        'public/assets/admin/css/styles.css',
        'public/vendor/laravel-filemanager/css/mime-icons.min.css',
        'public/vendor/laravel-filemanager/css/cropper.min.css',
        'public/vendor/laravel-filemanager/css/dropzone.min.css',
        'public/vendor/laravel-filemanager/css/lfm.css',
    ], 'public/assets/admin/css/admin.css').version();
mix.styles([
    'public/vendor/laravel-filemanager/css/mime-icons.min.css',
    'public/vendor/laravel-filemanager/css/cropper.min.css',
    'public/vendor/laravel-filemanager/css/dropzone.min.css',
    'public/vendor/laravel-filemanager/css/lfm.css',
], 'public/assets/admin/css/lfm.css').version();

mix.scripts(['resources/assets/admin/plugins/tinymce/tinymce.min.js'], 'public/assets/admin/plugins/tinymce/tinymce.min.js').version();
mix.copy('resources/assets/admin/plugins/tinymce/plugins', 'public/assets/admin/plugins/tinymce/plugins');
mix.copy('resources/assets/admin/plugins/tinymce/skins', 'public/assets/admin/plugins/tinymce/skins');
mix.copy('resources/assets/admin/plugins/tinymce/themes', 'public/assets/admin/plugins/tinymce/themes');
mix.copy([
    'resources/assets/admin/fonts',
], 'public/assets/admin/fonts');
mix.copy([
    'resources/assets/admin/images/users',
], 'storage/app/public/admin/images');
/*
 |--------------------------------------------------------------------------
 | Auth
 |--------------------------------------------------------------------------
 |
 */

mix.styles('resources/assets/auth/css/login.css', 'public/assets/auth/css/login.css').version();
mix.styles('resources/assets/auth/css/register.css', 'public/assets/auth/css/register.css').version();
mix.styles('resources/assets/auth/css/passwords.css', 'public/assets/auth/css/passwords.css').version();

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'resources/assets/admin/css/core.css',
    'resources/assets/admin/css/components.css',
    'resources/assets/admin/css/icons.css',
    'resources/assets/admin/css/pages.css',
    'resources/assets/admin/css/responsive.css',
    'resources/assets/admin/css/icons.css',
], 'public/assets/auth/css/auth.css').version();
