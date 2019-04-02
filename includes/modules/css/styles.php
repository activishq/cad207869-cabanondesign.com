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
	require( ACTIVIS_INCLUDES_PATH . '/modules/css/variables.php' );


	/* Default variables
	================================================== */
	$custom_styles = '';

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
