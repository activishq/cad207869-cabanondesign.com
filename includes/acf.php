<?php
/*
*
*	Activis ACF Rules and Fields
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* ACTIVIS_ACF_SAVE_JSON
================================================== */
if( !function_exists( 'activis_acf_save_json' ) ) :

	function activis_acf_save_json( $path ) {
		$path = ACTIVIS_INCLUDES_PATH . '/acf';
		return $path;
	}
	add_filter('acf/settings/save_json', 'activis_acf_save_json');

endif;


/* ACTIVIS_ACF_LOAD_JSON
================================================== */
if( !function_exists( 'activis_acf_load_json' ) ) :

	function activis_acf_load_json( $paths ) {
		$paths = array( ACTIVIS_INCLUDES_PATH . '/acf' );
		return $paths;
	}
	add_filter('acf/settings/load_json', 'activis_acf_load_json');

endif;
