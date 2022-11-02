// ==== CONFIGURATION ==== //

// Project paths
const project = "innovationtracker"; // The directory name for your theme; change this at the very least!
const src = "./src/"; // The raw material of your theme: custom scripts, SCSS source files, PHP files, images, etc.; do not delete this folder!
const build = "./build/"; // A temporary directory containing a development version of your theme; delete it anytime
const dist = "./dist/"; // The distribution package that you'll be uploading to your server; delete it anytime
const assets = "./assets/"; // A staging area for assets that require processing before landing in the source folder (example: icons before being added to a sprite sheet)
const modules = "./node_modules/"; // npm packages

// Project settings
module.exports = {
  images: {
    build: {
      // Copies images from `src` to `build`; does not optimize
      src: src + "**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)",
      dest: build,
    },
    dist: {
      src: [
        dist + "**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)",
        "!" + dist + "screenshot.png",
      ], // The source is actually `dist` since we are minifying images in place
      imagemin: {
        optimizationLevel: 7,
        progressive: true,
        interlaced: true,
      },
      dest: dist,
    },
  },

  scripts: {
    minify: {
      src: src + "js/**/*.js",
      uglify: {}, // Default options
      dest: build + "js/",
    },
    lint: {
      src: src + "js/**/*.js",
      lint: {
        useEslintrc: "true",
      },
    },
  },

  styles: {
    build: {
      src: src + "scss/**/*.scss",
      dest: build,
    },
    compiler: "libsass",
    autoprefixer: {
      browsers: ["> 3%", "last 2 versions", "ie 9", "ios 6", "android 4"],
    },
    minify: { safe: true },
    libsass: {
      includePaths: ["./src/scss", modules], // Adds Bower and npm directories to the load path so you can @import directly
      precision: 6,
      quietDeps: true,
      onError: function (err) {
        return console.error(err);
      },
    },
  },

  theme: {
    php: {
      src: [src + "**/*.php", src + "inc/*.php", src + "inc/pages/*.php"],
      dest: build,
    },
    app: {
      src: [src + "app/build/*", src + "app/build/**/*", src + "app/build/**/**/*"],
      dest: build + "app/"
    },
    twig: {
      src: src + "templates/**/*.twig",
      dest: build,
    },
    fonts: {
      src: src + "**/*(*.eot|*.svg|*.ttf|*.woff|*.woff2)",
      dest: build,
    },
  },

  utils: {
    clean: [build + "**/.DS_Store"], // A glob pattern matching junk files to clean out of `build`; feel free to add to this array
    wipe: [dist], // Clean this out before creating a new distribution copy
    dist: {
      src: [build + "**/*", "!" + build + "**/*.map"],
      dest: dist,
    },
    normalize: {
      // Copies `normalize.css` from `node_modules` to `src/scss` and renames it to allow for it to imported as a Sass file
      src: modules + "normalize.css/normalize.css",
      dest: src + "scss",
      rename: "_normalize.scss",
    },
  },

  watch: {
    // What to watch before triggering each specified task
    src: {
      styles: src + "scss/**/*.scss",
      scripts: src + "js/**/*.js",
      images: src + "**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)",
      theme: [
        src + "templates/**/*.twig",
        src + "*.php",
        src + "**/*.php",
        src + "**/**/*.php",
        src + "app/build/*",
        src + "app/build/**/*",
        src + "app/build/**/**/*"
      ],
      livereload: build + "**/*",
      fonts: src + "**/*(*.eot|*.svg|*.ttf|*.woff|*.woff2)",
    },
  },
};
