<?php
/*
*
*	Activis Functions
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*	VARIABLE DEFINITIONS
*	REQUIRED PLUGINS
*	INIT & ADMIN OVERRIDES
*	SITE SETUP
*	ACTIVIS FRAMEWORK
*	ENQUEUE STYLESHEETS
*	ENQUEUE SCRIPTS
*	SIDEBARS
*	CUSTOM WIDGETS
*	FUNCTIONS, ACTIONS & FILTERS
*	CUSTOM CSS
*	ACF
*	PAGE BUILDER (TBD)
*/


/* VARIABLE DEFINITIONS
================================================== */
$theme = wp_get_theme();
define('ACTIVIS_TEMPLATE_PATH', get_template_directory());
define('ACTIVIS_LOCAL_PATH', get_template_directory_uri());
define('ACTIVIS_INCLUDES_PATH', ACTIVIS_TEMPLATE_PATH . '/includes');
define('ACTIVIS_WIDGETS_PATH', ACTIVIS_INCLUDES_PATH . '/widgets');
define('ACTIVIS_KEY_GOOGLE', '');
define('ACTIVIS_OFFICE_IP', 'vpn.activis.ca');
define('ACTIVIS_THEME_VERSION', $theme->get( 'Version' ));
define('JETPACK_DEV_DEBUG', true);

/* SETTINGS
================================================== */
//define('WP_POST_REVISIONS', 3);

/* INCLUDES
================================================== */
include_once( ACTIVIS_INCLUDES_PATH . '/functions.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/init.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/filters.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/template-functions.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/template-hooks.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/template-tags.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/extras.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/shortcodes.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/sidebars.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/cpt.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/acf.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/admin.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/redux/options.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/custom-css/init.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/custom-css/variables.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/custom-css/styles.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/wpallimport.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/wpallexport.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/tgmpa/tgmpa.php' );

// if( session_status() == PHP_SESSION_NONE ) :

// 	session_start();

// endif;

// echo '<pre class="debug">' . print_r( $_SESSION[ 'dynamicform' ], true ) . '</pre>';

// exit();


if( !function_exists( 'ajaxEventDynamicForm' ) ) :

	function ajaxEventDynamicForm(){

		if( !check_ajax_referer( get_bloginfo( 'name' ), 'nonce', false ) ) :

			wp_send_json( array( 'success' => false, 'error' => 'nonce error' ) );

		else :

			if( session_status() == PHP_SESSION_NONE ) :

				session_start();

			endif;

			/*----------  Get all variables  ----------*/

			stripslashes_deep( $_POST );

			$_POST[ 'dynamicform' ] = array_filter( $_POST[ 'dynamicform' ], function( $key ){

				return strpos( $key, 'dynamic_' ) === 0;

			}, ARRAY_FILTER_USE_KEY );

			$_SESSION[ 'dynamicform' ] = $_POST[ 'dynamicform' ];

			// echo '<pre class="debug">' . print_r( $_POST[ 'dynamicform' ], true ) . '</pre>';

			/*----------  Debug SQL query  ----------*/

			// echo '<pre class="debug">' . print_r( $post_variable, true ) . '</pre>';

			// exit();

			/*----------  Return JSON data  ----------*/

			wp_send_json( array( 'success' => true, 'output' => $_POST[ 'dynamicform' ] ) );

			exit();

		endif;

	}

	add_action( 'wp_ajax_nopriv_ajaxEventDynamicForm', 'ajaxEventDynamicForm' );

	add_action( 'wp_ajax_ajaxEventDynamicForm', 'ajaxEventDynamicForm' );

endif;