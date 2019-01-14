/**
 * 
 * Load Plugins.
 *
 */
var gulp		= require( 'gulp' );

// CSS related plugins
var sass         	= require('gulp-sass'); 
var minifycss    	= require('gulp-uglifycss'); 
var autoprefixer 	= require('gulp-autoprefixer'); 

// JS related plugins
var jshint 		= require('gulp-jshint');
var concat       	= require('gulp-concat'); 
var uglify       	= require('gulp-uglify'); 

// Image realted plugins
var imagemin     = require('gulp-imagemin'); 

// Utility related plugins
var gutil 		= require('gulp-util');
var plumber		= require('gulp-plumber');
var rename       = require('gulp-rename'); 
var lineec       	= require('gulp-line-ending-corrector');
var filter       	= require('gulp-filter'); 
var sourcemaps   = require('gulp-sourcemaps'); 
var notify       	= require('gulp-notify');
var browserSync  	= require('browser-sync').create();
var wpPot        	= require('gulp-wp-pot');
var sort 		= require('gulp-sort');
var reload       	= browserSync.reload;


/**
 * 
 * Project Settings
 *
 */
var settings = {

	// BrowserSync
	proxy: 'act25-base.devstack.sbouchard.activ.is',
	port: 3000,

	// Autoprefixer
	autoprefixer: [
		'last 2 version',
		'> 1%',
		'ie >= 9',
		'ie_mob >= 10',
		'ff >= 30',
		'chrome >= 34',
		'safari >= 7',
		'opera >= 23',
		'ios >= 7',
		'android >= 4',
		'bb >= 10'
	],

	// Translation
	textDomain: 'activis',
	translationFile: 'activis.pot',
	translationDestination: './languages',
	packageName: 'activis',
	bugReport: 'soutien@activis.ca',
	lastTranslator: 'Production Team <production@activis.ca>',
	team: 'Activis <production@activis.ca'
};

/**
 * 
 * Paths
 *
 */
var basePaths = {
	src: '_source/',
	dest: 'public/',
};

var paths = {
	jsvendor: {
		src: basePaths.src + 'js/vendor/',
		dest: basePaths.dest + 'js/'
	},
	jscustom: {
		src: basePaths.src + 'js/',
		dest: basePaths.dest + 'js/'
	},
	styles: {
		src: basePaths.src + 'sass/',
		dest: basePaths.dest + 'css/'
	},
	images: {
		src: basePaths.src + 'img/',
		dest: basePaths.dest + 'img/'
	},
	php: './**/*.php'
};

/**
 * 
 * Assets
 *
 */
var assets = {
	css: paths.styles.dest + 'styles.css',
	sass: paths.styles.src + '**/*.scss',
	jsvendor: [
		paths.jsvendor.src + '*.js',
	],
	jscustom: [
		paths.jscustom.src + '*.js'
	],
	jscustom: [
		paths.jscustom.src + 'admin.js',
		paths.jscustom.src + 'app.js'
	],
	images: [
		paths.images.src + '**/*.{png,jpg,gif,svg}'
	]
};

/**
 * 
 * Task: Browser Sync 
 *
 */
gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: settings.proxy,
		port: settings.port,
		injectChanges: true
	});
});

/**
 * 
 * Task: Browser Sync (Reload)
 *
 */
gulp.task('browser-sync-reload', function () {
	browserSync.reload();
});

/**
 * 
 * Task: sass
 *
 */
gulp.task('sass', function() {
	gulp.src( [ '_source/sass/**/*.scss', '!_source/sass/framework/**' ] )
	.pipe( sourcemaps.init( { loadMaps: true } ) )
	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		// outputStyle: 'compressed',
		// outputStyle: 'nested',
		// outputStyle: 'expanded',
		precision: 10
	} ) )
	.on( 'error', console.error.bind( console ) )
	.pipe( autoprefixer( settings.autoprefixer ))
	.pipe( lineec() )
	.pipe( sourcemaps.write ( 'maps/' ) )
	.pipe( gulp.dest( paths.styles.dest ) )
	.pipe( browserSync.stream() )
	.pipe( notify( { message: 'TASK: "sass/dev" Completed! 💯', onLast: true } ) )
});


/**
* Task: vendors-js
*
* Concatenate and uglify vendor JS scripts.
*
* This task does the following:
*     1. Gets the source folder for JS vendor files
*     2. Concatenates all the files and generates vendors.js
*     3. Renames the JS file with suffix .min.js
*     4. Uglifes/Minifies the JS file and generates vendors.min.js
*/
gulp.task( 'vendors-js', function() {
	gulp.src( assets.jsvendor )
	.pipe( concat( 'vendors' + '.js' ) )
	.pipe( lineec() )
	.pipe( gulp.dest( paths.jsvendor.dest ) )
	.pipe( rename( {
		basename: 'vendors',
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
	.pipe( gulp.dest( paths.jsvendor.dest ) )
	.pipe( browserSync.stream() )
	.pipe( notify( { message: 'TASK: "vendors-js" Completed! 💯', onLast: true } ) );
});

/**
* Task: custom-js
*
* Concatenate and uglify custom JS scripts.
*
* This task does the following:
*     1. Gets the source folder for JS custom files
*     2. Concatenates all the files and generates custom.js
*     3. Renames the JS file with suffix .min.js
*     4. Uglifes/Minifies the JS file and generates custom.min.js
*/
gulp.task( 'custom-js', function() {
	gulp.src( assets.jscustom )
	.pipe( lineec() )

	// Error Handling
	.pipe(plumber({ errorHandler: function(err) {
		notify.onError({
			title: "JavaScript error(s) in " + err.plugin,
			message:  err.toString()
		})(err);
	}}))

	// JSHint
	.pipe( jshint() )
	.pipe( jshint.reporter( 'jshint-stylish' ) )

	.pipe( gulp.dest( paths.jscustom.dest ) )

	// Minify
	.pipe( uglify() )
	.pipe( rename( {
		suffix: '.min'
	} ) )
	.pipe( lineec() )
	.pipe( gulp.dest( paths.jscustom.dest ) )

	// BrowserSync Stream
	.pipe( browserSync.stream() )
	.pipe( notify( { message: 'TASK: "custom-js" Completed! 💯', onLast: true } ) );
});

/**
* Task: images
*
* Minifies PNG, JPEG, GIF and SVG images.
*
* This task does the following:
*     1. Gets the source of images raw folder
*     2. Minifies PNG, JPEG, GIF and SVG images
*     3. Generates and saves the optimized images
*
* This task will run only once, if you want to run it
* again, do it with the command `gulp images`.
*/
gulp.task( '@images', function() {
	gulp.src( assets.images )
	.pipe( imagemin( {
		progressive: true,
		optimizationLevel: 3, // 0-7 low-high
		interlaced: true,
		svgoPlugins: [ { removeViewBox: false } ]
	} ) )
	.pipe( gulp.dest( paths.images.dest ))
	.pipe( notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
});

/**
* Task: WP POT Translation File Generator
*
* * This task does the following:
*     1. Gets the source of all the PHP files
*     2. Sort files in stream by path or any custom sort comparator
*     3. Applies wpPot with the variable set at the top of this file
*     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
*/
gulp.task( '@translate', function () {
	return gulp.src( paths.php )
	.pipe( sort() )
	.pipe( wpPot( {
		domain: settings.textDomain,
		destFile: settings.translationFile,
		package: settings.packageName,
		bugReport: settings.bugReport,
		lastTranslator: settings.lastTranslator,
		team: settings.team
	} ))
	.pipe( gulp.dest( settings.translationDestination ) )
	.pipe( notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) )
});

/**
* Task: dev
*
* Watches for file changes and runs specific tasks.
*/
gulp.task( '@dev', ['browser-sync'], function () {
	gulp.watch( paths.php, ['browser-sync-reload'] );
	gulp.watch( assets.sass, ['sass'] );
	gulp.watch( assets.jsvendor, ['vendors-js'] ); 
	gulp.watch( assets.jscustom, ['custom-js'] ); 
});

/**
* Task: prod
*
* Watches for file changes and runs specific tasks.
*/
gulp.task('@prod', function() {

	/* sass */ 
	gulp.src( [ '_source/sass/**/*.scss', '!_source/sass/framework/**' ] )
	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'compressed',
		// outputStyle: 'compressed',
		// outputStyle: 'nested',
		// outputStyle: 'expanded',
		precision: 10
	} ) )
	.on( 'error', console.error.bind( console ) )
	.pipe( autoprefixer( settings.autoprefixer ))
	.pipe( rename( { suffix: '.min' } ) )
	.pipe( minifycss( {
		maxLineLen: 10,
		keepSpecialComments: 1
	}))
	.pipe( lineec() )
	.pipe( gulp.dest( paths.styles.dest ) )
	.pipe( notify( { message: 'TASK: "sass/prod" Completed! 💯', onLast: true } ) )

	/* js-custom */ 
	gulp.src( assets.jscustom )
	.pipe(plumber({ errorHandler: function(err) {
		notify.onError({
			title: "JavaScript error(s) in " + err.plugin,
			message:  err.toString()
		})(err);
	}}))
	.pipe( uglify() )
	.pipe( rename( {
		suffix: '.min'
	} ) )
	.pipe( lineec() )
	.pipe( gulp.dest( paths.jscustom.dest ) )
	.pipe( notify( { message: 'TASK: "custom-js/prod" Completed! 💯', onLast: true } ) );

	/* js-vendor */
	gulp.src( assets.jsvendor )
	.pipe( concat( 'vendors' + '.js' ) )
	.pipe( rename( {
		basename: 'vendors',
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( paths.jsvendor.dest ) )
	.pipe( notify( { message: 'TASK: "vendors-js/prod" Completed! 💯', onLast: true } ) );	 

	/* images */
	gulp.src( assets.images )
	.pipe( imagemin( {
		progressive: true,
		optimizationLevel: 3, // 0-7 low-high
		interlaced: true,
		svgoPlugins: [ { removeViewBox: false } ]
	} ) )
	.pipe( gulp.dest( paths.images.dest ))
	.pipe( notify( { message: 'TASK: "images/prod" Completed! 💯', onLast: true } ) );

});
