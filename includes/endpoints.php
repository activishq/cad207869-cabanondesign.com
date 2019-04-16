<?php
/**
*
*	Activis Endpoints
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/*
 * Endpoint: sys/deploy
 */
if ( ! function_exists( 'activis_init_sys' ) ) :
	function activis_init_sys() {
		flush_rewrite_rules();
		add_rewrite_endpoint( 'sys', EP_ROOT );
	}
	add_action( 'init', 'activis_init_sys' );
endif;

if ( ! function_exists( 'activis_template_redirect_sys' ) ) :
	function activis_template_redirect_sys() {

		global $wp_query;

		if( isset( $wp_query->query_vars['sys'] ) && $wp_query->query_vars['sys'] == 'flush-cache' ) :

			$cmd = 'sudo ee clean';
			$output = shell_exec( $cmd );
			exit( $cmd );

		elseif( isset( $wp_query->query_vars['sys'] ) && $wp_query->query_vars['sys'] == 'deploy' ) :

			if( isset( $_REQUEST[ 'payload' ] ) ) :
				$payload = json_decode( $_REQUEST[ 'payload' ] );
				if( $payload->ref === 'refs/heads/master' ) :
					$cmd = 'sudo ee clean && cd ' . get_template_directory() . ' && git reset --hard HEAD && git pull origin master';
					$output = shell_exec( $cmd );
					exit( $cmd );
				elseif( $payload->ref === 'refs/heads/staging' ) :
					$cmd = 'sudo ee clean && cd ' . get_template_directory() . ' && git reset --hard HEAD && git pull origin staging';
					$output = shell_exec( $cmd );
					exit( $cmd );
				endif;
			endif;

			exit();

		endif;

	}
	add_action( 'template_redirect', 'activis_template_redirect_sys' );
endif;
