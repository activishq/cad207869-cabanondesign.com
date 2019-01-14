<?php 
/**
*
* @package    /include/cpt.php
* 	
* @author     Activis
* 	
* @copyright  https://activis.ca/
*
**/


/* ACTIVIS_CUSTOM_POST_TYPES
================================================== */
if( !function_exists( 'activis_custom_post_types' ) ) :

	function activis_custom_post_types() {}
	add_action( 'init', 'activis_custom_post_types' );

endif;


/* ACTIVIS_AFTER_SWITCH_THEME
================================================== */
if( !function_exists( 'activis_after_switch_theme' ) ) :

	function activis_after_switch_theme() {
		activis_custom_post_types();
		flush_rewrite_rules();
	}
	add_action( 'after_switch_theme', 'activis_after_switch_theme' );

endif;