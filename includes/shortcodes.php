<?php 
/*
*
*	Activis Shortcodes
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

/* ACTIVIS_ADDSHORTCODE
================================================== */
if( !function_exists( 'activis_addshortcode_actcopy' ) ) :

	function activis_addshortcode_actcopy( $atts ) {

		ob_start();

			printf(
				'<a href="https://activis.ca/?utm_source=Referal&utm_medium=Client&utm_campaign=%1$s" target="_blank" class="actcopy" title="%2$s, %4$s">%2$s %3$s %4$s</a>',
				str_replace( 'www.', '', parse_url( site_url(), PHP_URL_HOST ) ),
				// __( '', 'activis' ), // Conception Activis
				'Conception Activis',
				'<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.0694 16.75"><g><path class="cls-1" d="M11.2508,11.5608,4.732,1.1886C4.4508.7411,4.6531.375,5.1816.375h7.4068a1.941,1.941,0,0,1,1.4724.8136l6.503,10.345c.29.4622.0816.8414-.466.8414H12.7241A1.942,1.942,0,0,1,11.2508,11.5608Z"/><path class="cls-2" d="M4.5315.9721.4331,15.4625a.6313.6313,0,0,0,.6331.9125H8.1556c.5365,0,.8117-.4962,1-1l1-5"/></g></svg>',
				__( 'Your web agency', 'activis' ) // Votre agence web
			);

		$ob_getClean = ob_get_clean();

		return $ob_getClean;

	}

	add_shortcode( 'actcopy', 'activis_addshortcode_actcopy' );
	
endif;