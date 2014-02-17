var gulp = require('gulp');
var notify = require('gulp-notify');
//var growl = require('gulp-notify-growl');
var phpunit = require('gulp-phpunit');

//var growlNotifier = growl();

gulp.task('phpunit', function() {
    gulp.src('./tests/**/*.php')
        .pipe(phpunit('phpunit'))
});

gulp.task('watch', function() {
     gulp.watch('./**/*.php', ['phpunit']);
});

gulp.task('default', ['phpunit', 'watch']);