// project_root/gulpfile.js

var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');

gulp.task('minify-css', function() {
  return gulp.src('src/**/*.css')
    .pipe(minifyCss())
    .pipe(gulp.dest('dist/css'));
});

gulp.task('watch:css', function () {
    gulp.watch('src/scss/**/*.css', ['minify-css']);
});

gulp.task('default', ['minify-css', 'watch:css']);
