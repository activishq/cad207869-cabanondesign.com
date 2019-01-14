<?php
/*
*
*	Activis Filters
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! function_exists( 'activis_body_classes' ) ) :
	function activis_body_classes( $classes ) {
		
		$options = activis_options();

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Check for header style
		if ( empty( $options['elementor_built_integration'] ) ) {
			if ( $options['header_style'] != '' ) {
				$classes[] = $options['header_style'];
			}
		}

		return $classes;
	}
	add_filter( 'body_class', 'activis_body_classes' );
endif;

/**
 * Redifine the excerpt more HTML output
*/
if ( ! function_exists('activis_excerpt_more') ) :
	function activis_excerpt_more($more) {
		global $post;
		return '... <br /><a class="read-more" href="'. get_permalink( $post->ID ) . '">'.__('Continue to read', 'activis').'</a>';
	}
	add_filter('excerpt_more', 'activis_excerpt_more');
endif;

/**
 * Custom excerpt length
 */
if ( ! function_exists('activis_excerpt_length') ) :
	function activis_excerpt_length( $length ) {
		return 30;
	}
	add_filter( 'excerpt_length', 'activis_excerpt_length', 999 );
endif;
