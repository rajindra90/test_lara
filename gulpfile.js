var gulp = require("gulp"),
    elixir = require('laravel-elixir'),
    eslint = require('laravel-elixir-eslint'),
    shell = require('gulp-shell'),
    minify = require('gulp-minify'),
    rename = require('gulp-rename'),
    cleanCSS = require('gulp-clean-css'),
    htmlmin = require('gulp-htmlmin'),
    sourcemaps = require('gulp-sourcemaps'),
    ngAnnotate = require('gulp-ng-annotate'),
    livereload = require('gulp-livereload');
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

var Task = elixir.Task;


/*
 |--------------------------------------------------------------------------
 | Extended Elixir Task for Minify JS
 |--------------------------------------------------------------------------
 */
elixir.extend('minifyJS', function () {

    new Task('minifyVendorJS', function () {
        return gulp.src('public/app/js/vendors.js')
            .pipe(minify())
            .pipe(gulp.dest('public/app/js/'));

    }).watch(['public/app/js/vendors.js']);


    new Task('minifyAppJS', function () {
        return gulp.src('public/app/js/app.js')
            .pipe(ngAnnotate())
            .pipe(minify())
            .pipe(gulp.dest('public/app/js/'));

    }).watch(['public/app/js/app.js']);

});

/*
 |--------------------------------------------------------------------------
 | Extended Elixir Task for Minify CSS
 |--------------------------------------------------------------------------
 */
elixir.extend('minifyCSS', function () {

    new Task('minifyCSS', function () {
        return gulp.src(['public/app/css/vendors.css'])
            .pipe(cleanCSS({compatibility: 'ie10'}))
            .pipe(rename({
                suffix: "-min"
            }))
            .pipe(gulp.dest('public/app/css/'));
    }).watch(
        ['public/app/css/vendors.css']);
});
/*
 |--------------------------------------------------------------------------
 | Extended Elixir Task for Minify HTML
 |--------------------------------------------------------------------------
 */
elixir.extend('minifyHTML', function () {

    new Task('minifyHTML', function () {

        return gulp.src('resources/assets/templates/**/*.html')
            .pipe(htmlmin(
                {
                    collapseWhitespace: true,
                    removeComments: true
                }
            ))
            .pipe(gulp.dest('public/app/templates'));

    }).watch('resources/assets/templates/**/*.html');

});
elixir(function (mix) {

    /*
     |--------------------------------------------------------------------------
     |Frontend Asset Management
     |--------------------------------------------------------------------------
     */

    //sass
    mix.sass('app.scss')

        .styles([
            "../vendors/bootstrap/css/*.css",
            "../vendors/fontawesome/css/*.css",
            "../vendors/select2/select2.css",
            "../build/css/skins/*.css",
            "../build/css/*.css"
        ], 'public/app/css/vendors.css')

        //vendor js
        .scripts([
            "../vendors/bootstrap-wizard/jquery.bootstrap.wizard.js",
            "../vendors/select2/select2.js",
            "../vendors/input-mask/jquery.inputmask.js",
            "../vendors/input-mask/jquery.inputmask.date.extensions.js",
            "../vendors/input-mask/jquery.inputmask.extensions.js",
            "../vendors/daterangepicker/daterangepicker.js",
            "../vendors/datepicker/bootstrap-datepicker.js",
            "../vendors/timepicker/bootstrap-timepicker.js",
            "../vendors/iCheck/iCheck.js",
            "../vendors/fastclick/fastclick.js",
            "../vendors/sparkline/jquery.sparkline.js",
            "../vendors/slimScroll/jquery.slimscroll.js",
            "../vendors/jvectormap/*.js",
            "../vendors/chartjs/Chart.js",
            "../build/js/app.js",
            "../build/js/demo.js",
            "../vendors/angular/angular-route.js",
            "../vendors/angular/angular-cookies.js",
        ], 'public/app/js/vendors.js')

        //application js
        .scripts([
            "../js/app/*.js",
            "../js/app/**/*.js"
        ], 'public/app/js/app.js')

        .copy('resources/assets/fonts', 'public/app/fonts')
        .copy('resources/assets/bootstrap/fonts', 'public/app/fonts')
        .copy('resources/assets/vendors/fontawesome/fonts', 'public/app/fonts');

    //  mix.minifyCSS();
    // mix.minifyJS();
    mix.minifyHTML();
});