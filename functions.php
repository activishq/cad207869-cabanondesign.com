<?php
/**
 * Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Variables
 */
$theme = wp_get_theme();
define('ACTIVIS_TEMPLATE_PATH', get_template_directory());
define('ACTIVIS_LOCAL_PATH', get_template_directory_uri());
define('ACTIVIS_INCLUDES_PATH', ACTIVIS_TEMPLATE_PATH . '/includes');
define('ACTIVIS_WIDGETS_PATH', ACTIVIS_INCLUDES_PATH . '/widgets');
define('ACTIVIS_KEY_GOOGLE', '');
define('ACTIVIS_OFFICE_IP', 'vpn.activis.ca');
define('ACTIVIS_THEME_VERSION', $theme->get( 'Version' ));
define('JETPACK_DEV_DEBUG', true);

/*
 * Includes
 */
include_once( ACTIVIS_INCLUDES_PATH . '/functions.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/init.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/hooks.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/cpt.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/acf.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/shortcodes.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/filters.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/admin.php' );
require_once( ACTIVIS_INCLUDES_PATH . '/modules/framework/options.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/modules/css/init.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/modules/css/variables.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/modules/css/styles.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/capabilities.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/endpoints.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/wpallimport.php' );
include_once( ACTIVIS_INCLUDES_PATH . '/wpallexport.php' );

if( is_session_started() === false ) :
	session_start();
endif;
