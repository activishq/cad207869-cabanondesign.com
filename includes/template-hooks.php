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
add_action( 'activis_after_body', 'activis_mobile_navigation', 20 );


/**
 * Site Header
 *
 * @see template-functions -> activis_header_layout()
 * @see template-functions -> activis_header_brand()
 *
 */
add_action( 'activis_site_header', 'activis_header_layout', 10 );
add_action( 'activis_header_branding', 'activis_header_brand', 10 );

/**
 * Page
 *
 * @see template-functions -> activis_page_header
 * @see template-functions -> activis_404_layout
 * @see template-functions -> activis_search_layout
 *
 */
add_action( 'activis_page_notfound', 'activis_notfound_layout', 10 );
add_action( 'activis_page_search', 'activis_search_layout', 10 );

/**
 * Loop
 *
 * @see template-tags -> activis_paging_nav
 *
 */
add_action( 'activis_loop_before', 'activis_loop_before_layout', 10 );
add_action( 'activis_loop_after', 'activis_loop_after_layout', 10 );
add_action( 'activis_loop_after', 'activis_paging_nav', 10 );

/**
 * Site Footer
 *
 * @see template-functions -> activis_footer_layout()
 *
 */
add_action( 'activis_site_footer', 'activis_footer_layout', 10 );

/**
 * Footer
 *
 * @see template-functions -> activis_ga_js()
 * @see template-functions -> activis_footer_js()
 *
 */
add_action( 'wp_footer', 'activis_ga_js', 10 );
add_action( 'wp_footer', 'activis_footer_js', 20 );
