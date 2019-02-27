<?php
/**
*
*	Activis Template Functions
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

/**
* Search Layout
*/
if ( ! function_exists( 'activis_search_layout' ) ) {
	function activis_search_layout() {

		$options = activis_options();

		if ( $options['general_advanced_search'] =='1' && class_exists('SWP_Query') ) {
			get_template_part( 'template-parts/content/content', 'searchwp' );
		} else {
			get_template_part( 'template-parts/content/content', 'search' );
		}

	}
}

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
