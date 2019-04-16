<?php
/**
*
*	Activis Template Hooks
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Head
 *
 * @see includes/functions -> activis_ga_tag_js_head()
 *
 *
 */
add_action( 'wp_head', 'activis_ga_tag_js_head', 10 );
add_action( 'wp_head', 'activis_header_js', 99 );


/**
 * Body
 *
 * @see includes/functions -> activis_ga_tag_js_body()
 *
 */
add_action( 'activis_after_body', 'activis_ga_tag_js_body', 10 );
add_action( 'elementor/page_templates/canvas/before_content', 'activis_ga_tag_js_body', 10 );


/**
 * Footer
 *
 * @see includes/functions -> activis_ga_js()
 * @see includes/functions -> activis_footer_js()
 *
 */
add_action( 'wp_footer', 'activis_ga_js', 10 );
add_action( 'wp_footer', 'activis_footer_js', 20 );
