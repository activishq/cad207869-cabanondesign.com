<?php
/*
*
*	Activis Filters
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! function_exists( 'activis_body_classes' ) ) :
	function activis_body_classes( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
	add_filter( 'body_class', 'activis_body_classes' );
endif;

/**
 * activis_ninja_forms_render_default_value
 */
if( !function_exists('activis_ninja_forms_render_default_value') ) :
	function activis_ninja_forms_render_default_value( $default_value, $field_type, $field_settings ) {
		if( substr( $field_settings[ 'key' ], 0, 8 ) === 'dynamic_' && $field_type != 'listselect' ) :
			$default_value = $_SESSION[ 'dynamicform' ][ $field_settings[ 'key' ] ];
		endif;
		return $default_value;
	}
	add_filter( 'ninja_forms_render_default_value', 'activis_ninja_forms_render_default_value', 10, 3 );
endif;


/**
 * activis_ninja_forms_render_options_listselect
 */
if( !function_exists('activis_ninja_forms_render_options_listselect') ) :

	function activis_ninja_forms_render_options_listselect( $field_options, $field_settings ){

		if( is_singular('cabanons') ):

			$formProduct = 'Cabanon';
			$formModel = get_the_title();

		elseif( is_singular('garages') ):

			$formProduct = 'Garage';
			$formModel = get_the_title();

		endif;

		if( substr( $field_settings[ 'key' ], 0, 8 ) === 'dynamic_' ) :

			if( $field_settings[ 'key' ] == 'dynamic_product' ) :

				foreach($field_options as &$option):
					if( $option['value'] == $formProduct ):
						$option['selected'] = true;
					else:
						$option['selected'] = false;
					endif;
				endforeach;

			elseif( $field_settings[ 'key' ] == 'dynamic_model_cabanon' || $field_settings[ 'key' ] == 'dynamic_model_garage' ) :

				foreach($field_options as &$option):
					if( $option['value'] == $formModel ):
						$option['selected'] = true;
					else:
						$option['selected'] = false;
					endif;
				endforeach;

			else :

				foreach($field_options as &$option):
					if( $option['value'] == $_SESSION[ 'dynamicform' ][ 'nf-field-' . $field_settings[ 'id' ] ] ):
						$option['selected'] = true;
					else:
						$option['selected'] = false;
					endif;
				endforeach;

			endif;
		endif;

		return $field_options;

	}
	add_filter( 'ninja_forms_render_options_listselect', 'activis_ninja_forms_render_options_listselect', 10, 2 );
endif;
