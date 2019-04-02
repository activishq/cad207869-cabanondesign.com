<?php
/*
*
*	Activis Custom Post Types
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/*
 * Custom Post Types
 */
if( !function_exists( 'activis_custom_post_types' ) ) :

	function activis_custom_post_types() {}
	add_action( 'init', 'activis_custom_post_types' );

endif;


/*
 * Flush rewrite
 */
if( !function_exists( 'activis_after_switch_theme' ) ) :
	function activis_after_switch_theme() {
		activis_custom_post_types();
		flush_rewrite_rules();
	}
	add_action( 'after_switch_theme', 'activis_after_switch_theme' );
endif;
