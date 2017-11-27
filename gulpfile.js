var config = require('./package.json'),
gulp = require('gulp'),
del = require('del'),
runSequence = require('run-sequence'),
plugins = require('gulp-load-plugins')(),
browserSync = require('browser-sync').create(),
options  = {
  dev : {
    tasks : ['dev:css','dev:js','dev:img','dev:fonts'],
    dir: 'build'
  },
  dist : {
    tasks : ['clean','dist:fonts','dist:css','dist:js','dist:img'],
    dir: 'dist'
  }
};

// -------------------------------------
// Development Tasks
// -------------------------------------

gulp.task('dev:css', function(){
  return gulp.src('src/scss/main.scss')
  .pipe( plugins.compass({
    css : options.dev.dir + '/css',
    sass : 'src/scss',
    require : ['susy'],
    sourcemap : true
  }) )
  .pipe( plugins.sourcemaps.init({ loadMaps: true }) )
  .pipe( plugins.autoprefixer({ browsers: [ 'ie >= 10', 'android >= 4.1' ] }) )
  .pipe( plugins.sourcemaps.write('.') )
  .pipe( gulp.dest( options.dev.dir + '/css' ) )
  .pipe( plugins.notify({ message: 'Styles task complete' }) );
});

gulp.task('dev:js', function(){
  return gulp.src( ['src/js/plugins.js','src/js/plugins/*.js','src/js/main.js'] )
    .pipe( plugins.sourcemaps.init() )
    .pipe( plugins.concat('main.js') )
    .pipe( plugins.sourcemaps.write('.') )
    .pipe( gulp.dest( options.dev.dir + '/js' ) )
    .pipe( plugins.notify({ message: 'Scripts task complete' }) );
});

gulp.task('dev:img',function(){
  return gulp.src( ['src/img/**/*','!src/img/**/*.fw.png','!src/img/**/*.ai'] )
  .pipe( plugins.newer( options.dev.dir + '/img' ) )
  .pipe( gulp.dest( options.dev.dir + '/img' ) )
  .pipe( plugins.notify({ message: 'Images task complete' }) );
});

gulp.task('dev:fonts',function(){
  return gulp.src( ['src/webfonts/**/*'] )
  .pipe( plugins.newer( options.dev.dir + '/webfonts' ) )
  .pipe( gulp.dest( options.dev.dir + '/webfonts' ) )
  .pipe( plugins.notify({ message: 'Fonts task complete' }) );
});

gulp.task( 'dev', function() {
  options.dev.tasks.forEach( function( task ) {
    gulp.start( task );
  });
});

// -------------------------------------
// Production Tasks
// -------------------------------------

gulp.task('dist:css', function(){
  return gulp.src('src/scss/main.scss')
  .pipe( plugins.compass({
    css : options.dist.dir + '/css',
    sass : 'src/scss',
    require : ['susy'],
    sourcemap : false
  }) )
  .pipe( plugins.autoprefixer({ browsers: [ 'ie >= 10', 'android >= 4.1' ] }) )
  .pipe( plugins.cleanCss({ 
    level: {
      1: {
        cleanupCharsets: true,
        specialComments: 0
      }
    }
  }) 
  )
  .pipe( gulp.dest( options.dist.dir + '/css' ) )
  .pipe( plugins.notify({ message: 'Styles task complete' }) );
});

gulp.task('dist:html', function() {
  return gulp.src( ['*.html','*.php'] )
    .pipe( plugins.htmlmin({ 
      collapseWhitespace: true,
      removeComments: true,
      minifyJS: true }))
    .pipe( plugins.replace('build/img', 'img') )
    .pipe( plugins.replace('build/css/main.css', 'css/main.css') )
    .pipe( plugins.replace('build/js/main.js', 'js/main.js') )
    .pipe( plugins.replace('</html>', '</html>\n<!-- Made by Reformat (madebyreformat.co.uk) -->') )
    .pipe( gulp.dest( options.dist.dir ) );
});

gulp.task('dist:js', function(){
  return gulp.src( ['src/js/plugins.js','src/js/plugins/*.js','src/js/main.js'] )
    .pipe( plugins.concat('main.js') )
    .pipe( plugins.uglify() )
    .pipe( gulp.dest( options.dist.dir + '/js' ) )
    .pipe( plugins.notify({ message: 'Scripts task complete' }) );
});

gulp.task('dist:fonts',function(){
  return gulp.src( ['src/webfonts/**/*'] )
  .pipe( gulp.dest( options.dist.dir + '/webfonts' ) )
  .pipe( plugins.notify({ message: 'Fonts task complete' }) );
});

gulp.task('dist:img',function(){
  return gulp.src( ['src/img/**/*','!src/img/**/*.fw.png','!src/img/**/*.ai'] )
  .pipe( plugins.image() )
  .pipe( gulp.dest( options.dist.dir + '/img' ) );
});

gulp.task( 'dist', function(callback) {
  runSequence(options.dist.tasks, callback);
});

// -------------------------------------
// Utility Tasks
// -------------------------------------


gulp.task('serve', ['dev:css'], function() {
    
    browserSync.init({
        port: 3000,
        proxy: config.url,
        files: "build/css/**/*.css",
        open: false
    });

    gulp.watch('src/scss/**/*.scss', ['dev:css']);
    gulp.watch('src/js/**/*.js', ['dev:js']).on('change', browserSync.reload);
    gulp.watch('src/img/**/*', ['dev:img']).on('change', browserSync.reload);
    gulp.watch('src/webfonts/**/*', ['dev:fonts']).on('change', browserSync.reload);
    gulp.watch("*.php").on('change', browserSync.reload);

});

gulp.task('clean', function(callback) {
    plugins.cache.clearAll();
    del( options.dist.dir, callback);
});

gulp.task('default', ['serve']);