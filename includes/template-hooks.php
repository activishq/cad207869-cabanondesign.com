<?php
/**
*
*	Activis Template Hooks
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


/**
 * Head
 *
 * @see template-functions -> activis_ga_tag_js_head()
 *
 *
 */
add_action( 'wp_head', 'activis_ga_tag_js_head', 10 );
add_action( 'wp_head', 'activis_header_js', 99 );

/**
 * Body
 *
 * @see template-functions -> activis_ga_tag_js_body()
 * @see template-functions -> activis_mobile_navigation()
 *
 */
add_action( 'activis_after_body', 'activis_ga_tag_js_body', 10 );
add_action( 'elementor/page_templates/canvas/before_content', 'activis_ga_tag_js_body', 10 );

/**
 * Footer
 *
 * @see template-functions -> activis_ga_js()
 * @see template-functions -> activis_footer_js()
 *
 */
add_action( 'wp_footer', 'activis_ga_js', 10 );
add_action( 'wp_footer', 'activis_footer_js', 20 );
