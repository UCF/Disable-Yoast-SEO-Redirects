const fs           = require('fs');
const browserSync  = require('browser-sync').create();
const gulp         = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS     = require('gulp-clean-css');
const include      = require('gulp-include');
const eslint       = require('gulp-eslint');
const isFixed      = require('gulp-eslint-if-fixed');
const babel        = require('gulp-babel');
const rename       = require('gulp-rename');
const sass         = require('gulp-sass');
const sassLint     = require('gulp-sass-lint');
const uglify       = require('gulp-uglify');
const readme       = require('gulp-readme-to-markdown');
const merge        = require('merge');


let config = {
  src: {
    scssPath: './src/scss',
    jsPath: './src/js'
  },
  dist: {
    cssPath: './static/css',
    jsPath: './static/js'
  },
  packagesPath: './node_modules',
  sync: false,
  syncTarget: 'http://localhost/wordpress/'
};

/* eslint-disable no-sync */
if (fs.existsSync('./gulp-config.json')) {
  const overrides = JSON.parse(fs.readFileSync('./gulp-config.json'));
  config = merge(config, overrides);
}
/* eslint-enable no-sync */


//
// Helper functions
//

// Base SCSS linting function
function lintSCSS(src) {
  return gulp.src(src)
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
}

// Base SCSS compile function
function buildCSS(src, dest) {
  dest = dest || config.dist.cssPath;

  return gulp.src(src)
    .pipe(sass({
      includePaths: [config.src.scssPath, config.packagesPath]
    })
      .on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(autoprefixer({
      // Supported browsers added in package.json ("browserslist")
      cascade: false
    }))
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest(dest));
}

// Base JS linting function (with eslint). Fixes problems in-place.
function lintJS(src, dest) {
  dest = dest || config.src.jsPath;

  return gulp.src(src)
    .pipe(eslint({
      fix: true
    }))
    .pipe(eslint.format())
    .pipe(isFixed(dest));
}

// Base JS compile function
function buildJS(src, dest) {
  dest = dest || config.dist.jsPath;

  return gulp.src(src)
    .pipe(include({
      includePaths: [config.packagesPath, config.src.jsPath]
    }))
    .on('error', console.log) // eslint-disable-line no-console
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename({
      extname: '.min.js'
    }))
    .pipe(gulp.dest(dest));
}

// BrowserSync reload function
function serverReload(done) {
  if (config.sync) {
    browserSync.reload();
  }
  done();
}

// BrowserSync serve function
function serverServe(done) {
  if (config.sync) {
    browserSync.init({
      proxy: {
        target: config.syncTarget
      }
    });
  }
  done();
}


//
// CSS
//

// Lint all plugin scss files
gulp.task('scss-lint-plugin', () => {
  return lintSCSS(`${config.src.scssPath}/*.scss`);
});

// Compile plugin stylesheet
gulp.task('scss-build-plugin', () => {
  return buildCSS(`${config.src.scssPath}/style.scss`);
});

// All plugin css-related tasks
gulp.task('css', gulp.series('scss-lint-plugin', 'scss-build-plugin'));


//
// JavaScript
//

// Run eslint on js files in src.jsPath
gulp.task('es-lint-plugin', () => {
  return lintJS([`${config.src.jsPath}/*.js`], config.src.jsPath);
});

// Concat and uglify js files through babel
gulp.task('js-build-plugin', () => {
  return buildJS(`${config.src.jsPath}/script.js`, config.dist.jsPath);
});

// All js-related tasks
gulp.task('js', gulp.series('es-lint-plugin', 'js-build-plugin'));


//
// Documentation
//

// Generates a README.md from README.txt
gulp.task('readme', () => {
  return gulp.src('readme.txt')
    .pipe(readme({
      details: false,
      screenshot_ext: [] // eslint-disable-line camelcase
    }))
    .pipe(gulp.dest('.'));
});


//
// Rerun tasks when files change
//
gulp.task('watch', (done) => {
  serverServe(done);

  gulp.watch(`${config.src.scssPath}/**/*.scss`, gulp.series('css', serverReload));
  gulp.watch(`${config.src.jsPath}/**/*.js`, gulp.series('js', serverReload));
  gulp.watch('./**/*.php', gulp.series(serverReload));
});


//
// Default task
//
gulp.task('default', gulp.series('css', 'js', 'readme'));
