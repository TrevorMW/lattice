# Skeleton Theme

### Installation

1. Install theme in themes directory and activate the theme.
2. Run `./setup` to install node dependencies and compile assets with gulp  

### Commands

This theme runs on Gulp.js, and therefore a few basic tasks are exposed for compiling assets

1. `gulp compile`   - runs all sass and js compialtion. Master task.
2. `gulp scripts`   - concatenates and uglifies JS into core.js file found in static folder
3. `gulp sass`      - compiles both core sass and admin sass stylesheets into their separate
4. `gulp coreSass`  - compiles only core boilerplate sass.
5. `gulp themeSass` - compiles theme specific sass.
6. `gulp adminSass` - compiles admin sass for plugin/admin modifications. Disabled by default.
