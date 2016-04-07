var gulp            = require('gulp');
var browserSync     = require('browser-sync');
var reload          = browserSync.reload;
var sass            = require('gulp-sass');
var minifyCss       = require('gulp-clean-css');
var sourcemaps      = require('gulp-sourcemaps');
var autoprefixer    = require('gulp-autoprefixer');
var gp_concat       = require('gulp-concat');
var gp_rename       = require('gulp-rename');
var gp_uglify       = require('gulp-uglify');
var bourbon         = require('bourbon').includePaths;
var neat            = require('bourbon-neat').includePaths;

gulp.task('serve', ['sass'], function() {

    browserSync.init({
        proxy: "localhost/single-malt"
    });

    gulp.watch("dev/sass/**/*.scss", ['sass']);
    gulp.watch("../*.php").on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
    return gulp.src("dev/sass/*.scss")
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: [].concat(bourbon, neat),
            errLogToConsole: true,
            outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
        }))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("../"))
        .pipe(browserSync.stream());
});

gulp.task('vendor-minify-css', function() {
  return gulp.src(['dev/css/vendor/*.css'])
    .pipe(gp_concat('vendor.css'))
    .pipe(gp_rename('vendor.min.css'))
    .pipe(minifyCss())
    .pipe(gulp.dest('dist/css/'))
});

gulp.task('app-minify-css', function() {
  return gulp.src('../style.css')
    .pipe(minifyCss({compatibility: 'ie8', keepBreaks:false}))
    .pipe(gp_rename({ suffix: '.min' }))
    .pipe(gulp.dest('dist/css/'));
});

gulp.task('vendor-js-merge', function(){
    return gulp.src(['dev/js/vendor/*.js'])
        .pipe(gp_concat('vendor.js'))
        .pipe(gp_rename('vendor.min.js'))
        .pipe(gp_uglify())
        .pipe(gulp.dest('dist/js/'))
});

gulp.task('app-js-merge', function(){
    return gulp.src(['dev/js/*.js','!dev/js/modernizr.js'])
        .pipe(gp_concat('app.js'))
        .pipe(gp_rename('app.min.js'))
        .pipe(gp_uglify())
        .pipe(gulp.dest('dist/js/'))
});

gulp.task('modernizr-minify', function(){
    return gulp.src(['dev/js/modernizr.js'])
        .pipe(gp_rename('modernizr.min.js' ))
        .pipe(gp_uglify())
        .pipe(gulp.dest('dist/js/'));
});

// Build task
gulp.task('build', ['sass', 'vendor-minify-css', 'app-minify-css', 'modernizr-minify', 'vendor-js-merge', 'app-js-merge']);
 
// Default task to be run with `gulp`
gulp.task('default', ['serve']);

