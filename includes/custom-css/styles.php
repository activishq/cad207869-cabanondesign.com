<?php
/*
*
*	Activis Custom CSS Feature
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/



/**
* Output the customizer styles to the site's frontend
*/
function activis_custom_styles_output() {

	/* Get Customizer Variables
	================================================== */
	require( ACTIVIS_INCLUDES_PATH . '/custom-css/variables.php' );


	/* Default variables
	================================================== */
	$custom_styles = '';

	/* Header
	================================================== */
	$custom_styles .= '.header__wrapper { height: '. $header_initial_height .'px; }';
	$custom_styles .= '.header__branding { width: '. $header_brand_width .'px; }';
	$custom_styles .= '.main-navigation > .menu > li .sub-menu { top: '. $header_initial_height .'px; }';
	$custom_styles .= '.device--has-scrolled.header-is-sticky-resize-on-scroll .header__wrapper { height: '. $header_resized_height .'px; }';
	$custom_styles .= '.device--has-scrolled.header-is-sticky-resize-on-scroll .header__wrapper .header__branding .brand img { width: '. $header_brand_width_resized .'px; }';
	$custom_styles .= '.device--has-scrolled.header-is-sticky-resize-on-scroll .main-navigation > .menu > li .sub-menu { top: '. $header_resized_height .'px; }';
	
	/* User Custom CSS
	================================================== */
	if ( $custom_css ) {
		$custom_styles .= $custom_css;
	}

	/* Output Processing
	================================================== */

	// Remove comments
	$custom_styles = preg_replace( '#/\*.*?\*/#s', '', $custom_styles );
	// Remove whitespace
	$custom_styles = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $custom_styles );

	/* Final Output
	================================================== */
	return $custom_styles;

}
