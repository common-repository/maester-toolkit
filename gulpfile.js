var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourcemaps = require('gulp-sourcemaps');
var prefix = require('gulp-autoprefixer');
var rename = require('gulp-rename');

gulp.task('default', function() {
    return sass('assets/scss/main.scss', { sourcemap: true, style: 'expanded' })
        .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('default.min', function() {
    return sass('assets/scss/main.scss', { sourcemap: true, style: 'compressed' })
        .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
        .pipe(rename('main.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
});


gulp.task('watch', function() {
    gulp.watch('assets/scss/*.scss', gulp.series('default'));
    gulp.watch('assets/scss/*.scss', gulp.series('default.min'));
});