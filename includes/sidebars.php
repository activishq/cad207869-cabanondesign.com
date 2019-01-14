<?php
/**
*
*	Activis Sidebars
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! function_exists( 'activis_sidebars_init' ) ) :
	function activis_sidebars_init() {

		/**
		 * Default Sidebar
		 */
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'activis' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( '', 'activis' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

	}
	add_action( 'widgets_init', 'activis_sidebars_init' );
endif;
