const { src, dest, parallel, watch } = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const webpack = require('webpack-stream');
const rename = require('gulp-rename');
const cssnano = require('gulp-cssnano');
const sourcemaps = require('gulp-sourcemaps');

function scss() {
  return src('assets/scss/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(cssnano())
    .pipe(sourcemaps.write())
    .pipe(dest('dist'))
    .pipe(browserSync.stream());
}

function js() {
  return src('assets/js/app.js')
    .pipe(webpack({
      // Before uploading to live change webpack mode to 'production' and run the js task
      mode: 'development',
      module: {
        rules: [
          {
            test: /\.(js)$/,
            exclude: /(node_modules)/,
            loader: 'babel-loader',
            query: {
              presets: [
                [
                  '@babel/env',
                  {
                    "targets": {
                      "esmodules": true
                    }
                  }
                ]
              ],
              plugins: ['@babel/transform-runtime']
            }
          }
        ]
      }
    })).on('error', function handleError() {
      this.emit('end')
    })
    .pipe(rename('app.min.js'))
    .pipe(dest('dist'))
    .pipe(browserSync.stream());
}

function startWatch() {
  watch(['**/*.php']).on('change', browserSync.reload);
  watch('assets/js/**/*.js', js);
  watch('assets/scss/**/*.scss', scss);
}

exports.style = scss;
exports.js = js;
exports.default = parallel(scss, js, startWatch);
