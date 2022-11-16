// ==== GULPFILE ==== //

// This configuration follows the modular design of the `gulp-starter` project by Dan Tello: https://github.com/greypants/gulp-starter
// Explore `tasks` for more...

const gulp = require("gulp");
const gutil = require("gulp-util");
const plugins = require("gulp-load-plugins")({ 
  camelize: true, 
  postRequireTransforms: {
    sass: function(sass) {
      return sass(require('sass'));
    }
  } 
});
const sass = require('gulp-sass')(require('sass'));
const del = require("del");
const merge = require("merge-stream");
const config = require("../gulpconfig");
const autoprefixer = require("autoprefixer");
const processors = [autoprefixer(config.autoprefixer)]; // Add additional PostCSS plugins to this array as needed



// Used to get around Sass's inability to properly @import vanilla CSS; see: https://github.com/sass/sass/issues/556
gulp.task("utils-normalize", async () => {
  return gulp
    .src(config.utils.normalize.src)
    .pipe(plugins.changed(config.utils.normalize.dest))
    .pipe(plugins.rename(config.utils.normalize.rename))
    .pipe(gulp.dest(config.utils.normalize.dest));
});

// One-off setup tasks
gulp.task("setup", gulp.series("utils-normalize"));

// Copy changed images from the source folder to `build` (fast)
gulp.task("images", () => {
  return gulp
    .src(config.images.build.src)
    .pipe(plugins.changed(config.images.build.dest))
    .pipe(gulp.dest(config.images.build.dest));
});

// Minify scripts in place
gulp.task("scripts-minify", async () => {
  return (gulp
      .src(config.scripts.minify.src)
      .pipe(plugins.sourcemaps.init())
      // .pipe(plugins.uglify(config.minify.uglify))
      .pipe(plugins.sourcemaps.write("./"))
      .pipe(gulp.dest(config.scripts.minify.dest)) );
});

// Master script task; lint -> bundle -> minify
gulp.task("scripts", gulp.series("scripts-minify"));

// Build stylesheets from source Sass files, autoprefix, and write source maps (for debugging) with libsass
gulp.task("styles-libsass", async () => {
  return gulp
    .src(config.styles.build.src)
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass(config.styles.libsass))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.cssnano(config.styles.minify))
    .pipe(plugins.sourcemaps.write("./")) // Writes an external sourcemap
    .pipe(gulp.dest(config.styles.build.dest)); // Drops the unminified CSS file into the `build` folder
});

// Easily configure the Sass compiler from `/gulpconfig.js`
gulp.task("styles", gulp.series("styles-" + config.styles.compiler));

// Copy PHP source files to the `build` folder
gulp.task("theme-php", async () => {
  return gulp
    .src(config.theme.php.src)
    .pipe(plugins.changed(config.theme.php.dest))
    .pipe(gulp.dest(config.theme.php.dest));
});

// Copy Tracker app source files to the `build` folder
gulp.task("theme-app", async () => {
  return gulp
    .src(config.theme.app.src)
    .pipe(plugins.changed(config.theme.app.dest))
    .pipe(gulp.dest(config.theme.app.dest));
});

// Copy Twig source files to the 'build/templates' folder
gulp.task("theme-twig", async () => {
  return gulp
    .src(config.theme.twig.src)
    .pipe(plugins.changed(config.theme.twig.dest))
    .pipe(plugins.flatten())
    .pipe(gulp.dest(config.theme.twig.dest));
});

// Copy fonts to the build/templates folder
gulp.task("theme-fonts", async () => {
  return gulp
    .src(config.theme.fonts.src)
    .pipe(plugins.changed(config.theme.fonts.dest))
    .pipe(gulp.dest(config.theme.fonts.dest));
});

// All the theme tasks in one
gulp.task("theme", gulp.series("theme-php", "theme-app", "theme-twig", "theme-fonts"));

// Build a working copy of the theme
gulp.task("build", gulp.series("images", "scripts", "styles", "theme"));

// Totally wipe the contents of the `dist` folder to prepare for a clean build; additionally trigger Bower-related tasks to ensure we have the latest source files
gulp.task(
  "utils-wipe",
  gulp.series("setup", async () => {
    return del(config.utils.wipe);
  })
);

// Clean out junk files after build
gulp.task(
  "utils-clean",
  gulp.series("build", "utils-wipe", async () => {
    return del(config.utils.clean);
  })
);

// Copy files from the `build` folder to `dist/[project]`
gulp.task(
  "utils-dist",
  gulp.series("utils-clean", async () => {
    return gulp
      .src(config.utils.dist.src)
      .pipe(gulp.dest(config.utils.dist.dest));
  })
);

// Optimize images in the `dist` folder (slow)
gulp.task(
  "images-optimize",
  gulp.series("utils-dist", async () => {
    return gulp
      .src(config.images.dist.src)
      .pipe(plugins.imagemin(config.images.dist.imagemin))
      .pipe(gulp.dest(config.images.dist.dest));
  })
);

// Dist task chain: wipe -> build -> clean -> copy -> compress images
// NOTE: this is a resource-intensive task!
gulp.task("dist", gulp.series("images-optimize"));

gulp.task("sync", gulp.series("build"));

gulp.task(
  "watch-sync",
  gulp.parallel("sync", () => {
    gulp.watch(config.watch.src.styles, gulp.series("styles"));
    gulp.watch(config.watch.src.scripts, gulp.series("scripts"));
    gulp.watch(config.watch.src.images, gulp.series("images"));
    gulp.watch(config.watch.src.theme, gulp.series("theme"));
  })
);

// Master control switch for the watch task
gulp.task("watch", gulp.series("watch-sync"));

gulp.task("default", gulp.series("watch"));
