var gulp        = require('gulp'),
    typescript  = require('typescript'),
    ts          = require('gulp-typescript'),
    browserify  = require('browserify'),
    source      = require('vinyl-source-stream');


var project = ts.createProject('resources/assets/ts/tsconfig.json', {typescript: typescript});

gulp.task('compile', function () {
    var result = gulp.src('resources/assets/ts/**/*{ts,tsx}').pipe(ts(project));
    return result.js.pipe(gulp.dest('./webroot/js'));
});

gulp.task('bundle', ['compile'], function () {
    var b = browserify('./webroot/js/bootstrap.js');
    return b.bundle()
        .pipe(source('bundle.js'))
        .pipe(gulp.dest('./webroot/js'));
});
