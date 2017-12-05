'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

var sass_path = './src/public/assets/scss';
var css_path  = './src/public/assets/css';


gulp.task('sass', function () {
    return gulp.src(sass_path + '/*.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest(css_path));
});


gulp.task('sass:watch', function () {
    gulp.watch(sass_path + '/*.scss', ['sass']);
});


gulp.task('default', ['sass', 'sass:watch']);