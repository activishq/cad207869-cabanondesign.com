<?php
/*
*
*	Activis Functions
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
* Get Options
*/
if ( ! function_exists('activis_options') ) {
	function activis_options() {
		global $options;
		return $options;
	}
}

/**
 * Is WooCommerce Activated
 */
if ( ! function_exists( 'activis_is_woocommerce_activated' ) ) {
	function activis_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/**
 * Check if a post is a custom post type.
 * @param  mixed $post Post object or ID
 * @return boolean
 */
if ( ! function_exists('activis_is_custom_post_type') ) {
	function activis_is_custom_post_type( $post = NULL ) {

		$all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

	    // there are no custom post types
		if ( empty ( $all_custom_post_types ) )
			return FALSE;

		$custom_types      = array_keys( $all_custom_post_types );
		$current_post_type = get_post_type( $post );

	    // could not detect current type
		if ( ! $current_post_type )
			return FALSE;

		return in_array( $current_post_type, $custom_types );
	}
}


/**
 * Page Navigation
 */
if ( ! function_exists( 'activis_page_navigation' ) ) {
	function activis_page_navigation() {
		global $wp_query;
		$bignum = 999999999;
		if ( $wp_query->max_num_pages <= 1 )
			return;
		$output = '';
		$output .= '<nav class="page-pagination">';
		$output .= paginate_links( array(
			'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format'       => '',
			'current'      => max( 1, get_query_var('paged') ),
			'total'        => $wp_query->max_num_pages,
			'prev_text'    => '&larr;',
			'next_text'    => '&rarr;',
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3
			) );
		$output .= '</nav>';
		echo $output;
	}
}


/**
 * Get Child Pages Listing
 */
if ( ! function_exists( 'activis_subpage_navigation' ) ) :
	function activis_subpage_navigation() {

		global $post;

		if ( $post->post_parent ) {

			$children = wp_list_pages( array(
				'title_li' => '',
				'child_of' => $post->post_parent,
				'echo'     => 0,
				'depth' => 1
				) );
			$title = get_the_title( $post->post_parent );

		} else {

			$children = wp_list_pages( array(
				'title_li' => '',
				'child_of' => $post->ID,
				'echo'     => 0,
				'depth' => 1
				) );
			$title = get_the_title( $post->ID );

		}

		if ( $children ) : ?>
		<aside id="secondary" class="widget-area" role="complementary">
			<section class="widget widget_categories">
				<h3 class="widget-title"><?php echo esc_attr( $title ); ?></h3>
				<ul>
					<?php echo $children; ?>
				</ul>
			</section>
		<aside>
		<?php endif;
	}
endif;


/**
 * Google Analytics Code
 */
if ( ! function_exists( 'activis_ga_js' ) ) {
	function activis_ga_js() {
		$options = activis_options();
		if ( (isset( $options['analytics_google_analytics_code'] ) ) && trim( $options['analytics_google_analytics_code'] ) != "" ) {
			echo $options['analytics_google_analytics_code'];
		}
	}
}


/**
 * Google Tag Manager (Head)
 */
if ( ! function_exists( 'activis_ga_tag_js_head' ) ) {
	function activis_ga_tag_js_head() {
		$options = activis_options();
        $setting = $options['analytics_google_tag_manager_code_head'];
		if ( (isset( $options['analytics_google_tag_manager_code_head'] ) ) && trim( $options['analytics_google_tag_manager_code_head'] ) != "" ) {
			echo $options['analytics_google_tag_manager_code_head'];
		}
	}
}


/**
 * Google Tag Manager (Body)
 */
if ( ! function_exists( 'activis_ga_tag_js_body' ) ) {
	function activis_ga_tag_js_body() {
		$options = activis_options();
		if ( (isset( $options['analytics_google_tag_manager_code_body'] ) ) && trim( $options['analytics_google_tag_manager_code_body'] ) != "" ) {
			echo $options['analytics_google_tag_manager_code_body'];
		}
	}
}


/**
 * JS Header
 */
if ( ! function_exists( 'activis_header_js' ) ) {
	function activis_header_js() {
		$options = activis_options();
		if ( (isset( $options['header_js'] ) ) && trim( $options['header_js'] ) != "" ) {
			echo $options['header_js'];
		}
	}
}


/**
 * JS Footer
 */
if ( ! function_exists( 'activis_footer_js' ) ) {
	function activis_footer_js() {
		$options = activis_options();
		if ( (isset( $options['footer_js'] ) ) && trim( $options['footer_js'] ) != "" ) {
			echo $options['footer_js'];
		}
	}
}

/**
 * is_session_started
 */
if( !function_exists( 'is_session_started' ) ) :
	function is_session_started(){

	    if( php_sapi_name() !== 'cli' ) :
	        if( version_compare( phpversion(), '5.4.0', '>=' ) ) :
	            return ( session_status() === PHP_SESSION_ACTIVE ? true : false );
	        else :
	            return ( session_id() === '' ? false : true );
	        endif;
	    endif;

	    return false;
	}
endif;


/**
 * ajaxEventDynamicForm
 */
if( !function_exists( 'ajaxEventDynamicForm' ) ) :

	function ajaxEventDynamicForm(){
		if( !check_ajax_referer( get_bloginfo( 'name' ), 'nonce', false ) ) :
			wp_send_json( array( 'success' => false, 'error' => 'nonce error' ) );
		else :

			if( is_session_started() === false ) :
				session_start();
			endif;

			stripslashes_deep( $_POST );

			$_POST[ 'dynamicform' ] = array_filter( $_POST[ 'dynamicform' ], function( $key ){
				return strpos( $key, 'dynamic_' ) === 0;
			}, ARRAY_FILTER_USE_KEY );

			$_POST['dynamicform']['dynamic_phone'] = str_replace( array( '(', ')', '-', ' ' ), '', $_POST['dynamicform']['dynamic_phone'] );
			$_SESSION[ 'dynamicform' ] = $_POST[ 'dynamicform' ];
			wp_send_json( array( 'success' => true, 'output' => $_POST[ 'dynamicform' ] ) );

			exit();

		endif;
	}
	add_action( 'wp_ajax_nopriv_ajaxEventDynamicForm', 'ajaxEventDynamicForm' );
	add_action( 'wp_ajax_ajaxEventDynamicForm', 'ajaxEventDynamicForm' );
endif;
