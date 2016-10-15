var gulp       = require('gulp'),
    sass       = require('gulp-sass'),
    cleancss   = require('gulp-cleancss'),
    babel      = require('gulp-babel'),
    uglify     = require('gulp-uglify'),
    gzip       = require('gulp-gzip'),
    imagemin   = require('gulp-imagemin'),
    newer      = require('gulp-newer'),
    svgmin     = require('gulp-svgmin'),
    rename     = require('gulp-rename'),
    concat     = require('gulp-concat'),
    notify     = require('gulp-notify'),
    cache      = require('gulp-cache'),
    htmlmin    = require('gulp-htmlmin'),
    modernizr  = require('gulp-modernizr'),
    wrap       = require('gulp-wrap'),
    livereload = require('gulp-livereload'),
    del        = require('del');

var onBabelError = require('./babel-error.js');

var directories = {
    src  : 'resources',
    dest : 'public'
};
var paths = {

    styles  : {
        src  : directories.src + '/scss/**/*.scss',
        dest : directories.dest + '/css'
    },
    scripts : {
        project   : {
            src  : directories.src + '/scripts/**/*.js',
            dest : directories.dest + '/js'
        },
        vendor    : {
            src  : [
                'bower_components/jquery/dist/jquery.js',
                'bower_components/angular/angular.js',
                'bower_components/underscore/underscore.js',
                'bower_components/jquery-touchswipe/jquery.touchSwipe.js',
                'bower_components/jquery-placeholder/jquery.placeholder.js',
                'bower_components/jquery-ui/jquery-ui.js',
                'bower_components/jquery-ui/ui/i18n/datepicker-nl-BE.js',
                'bower_components/fastclick/lib/fastclick.js'
            ],
            dest : directories.dest + '/js'
        }
    },
    assets  : {
        images    : {
            src  : directories.src + '/assets/img/**/*',
            dest : directories.dest + '/assets/img'
        },
        cssimages : {
            src  : directories.src + '/assets/css-images/**/*',
            dest : directories.dest + '/css/img'
        },
        svg       : {
            src  : directories.src + '/assets/svg/**/*',
            dest : directories.dest + '/css/svg'
        },
        fonts     : {
            src  : [
                directories.src + '/assets/fonts/**/*',
                'bower_components/font-awesome/fonts/*'
            ],
            dest : directories.dest + '/css/fonts'
        }
    }
};

gulp.task('styles', function() {
    return gulp.src([paths.styles.src])
        .pipe(sass())
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(rename({suffix : '.min'}))
        .pipe(cleancss({keepBreaks : false}))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(notify({message : 'styles complete'}));
});

gulp.task('scripts',  function() {
    return gulp.src(paths.scripts.project.src)
        .pipe(babel()
            .on('error', onBabelError))
        .pipe(concat('main.js'))
        .pipe(gulp.dest(paths.scripts.project.dest))
        .pipe(rename({suffix : '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(paths.scripts.project.dest))
        .pipe(gzip())
        .pipe(gulp.dest(paths.scripts.project.dest))
        .pipe(notify({message : 'scripts complete'}));
});

gulp.task('vendor', function() {
    return gulp.src(paths.scripts.vendor.src)
        .pipe(babel()
            .on('error', onBabelError))
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(paths.scripts.vendor.dest))
        .pipe(rename({suffix : '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(paths.scripts.vendor.dest))
        .pipe(gzip())
        .pipe(gulp.dest(paths.scripts.vendor.dest))
        .pipe(notify({message : 'concat vendor complete'}));
});

gulp.task('assets', function() {
    return gulp.start('css images', 'images', 'svg', 'fonts');
});
gulp.task('css images', function() {
    return gulp.src(paths.assets.cssimages.src)
        .pipe(newer(paths.assets.cssimages.dest))
        .pipe(imagemin({optimizationLevel : 2, progressive : true, interlaced : false}))
        .pipe(gulp.dest(paths.assets.cssimages.dest))
});
gulp.task('images', function() {
    return gulp.src(paths.assets.images.src)
        .pipe(newer(paths.assets.images.dest))
        .pipe(imagemin({optimizationLevel : 2, progressive : true, interlaced : false}))
        .pipe(gulp.dest(paths.assets.images.dest))
});
gulp.task('svg', function() {
    return gulp.src(paths.assets.svg.src)
        .pipe(newer(paths.assets.svg.dest))
        .pipe(svgmin())
        .pipe(gulp.dest(paths.assets.svg.dest))
});
gulp.task('fonts', function() {
    return gulp.src(paths.assets.fonts.src)
        .pipe(gulp.dest(paths.assets.fonts.dest));
});

gulp.task('watch', function() {
    gulp.watch(paths.styles.src, ['styles']);
    gulp.watch(paths.scripts.project.src, ['scripts']);
    gulp.watch(paths.scripts.vendor.src, ['vendor']);
    gulp.watch(paths.assets.images.src, ['images']);
    gulp.watch(paths.assets.cssimages.src, ['css images']);
    gulp.watch(paths.assets.svg.src, ['svg']);

    livereload.listen();

    gulp.watch([directories.dest + '/**']).on('change', livereload.changed);
});

gulp.task('clean', function(cb) {
    del([paths.styles.dest,
        paths.scripts.project.dest,
        paths.assets.images.dest
    ], cb);
});
gulp.task('default', function() {
    return gulp.start('styles', 'scripts', 'vendor', 'assets');
});