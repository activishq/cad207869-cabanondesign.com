<?php
/*
*
*	Activis Functions
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


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
 * Get Taxonomies Terms Menu
 */
if ( ! function_exists('activis_taxonomies_terms_menu') ) :
	function activis_taxonomies_terms_menu( $taxonomy = '' ) {

		$terms = get_terms( $taxonomy );
		$output = '';

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
			$output .= '<ul class="section__menu">';
			foreach ( $terms as $term ) {
				$class = ( get_queried_object()->slug == $term->slug ? 'current-cat' : '' );
				$output .= sprintf( '<li class="'. $class .'"><a href="%1$s">%2$s</a></li>',
					esc_url( get_term_link( $term->slug, $taxonomy ) ),
					esc_html( $term->name )
				);
			}
			$output .= '</ul>';
		endif;

		echo $output;

	}
endif;

/**
 * Get Taxonomies Terms Links
 */
if ( ! function_exists('activis_taxonomies_terms_links') ) :
	function activis_taxonomies_terms_links( $args = '' ) {

		global $post;

		$args = [
			'before'            => '', 
			'sep'               => ', ', 
			'after'             => '',
			'display_tax_name'  => false,
			'taxonomy_sep'      => '&raquo;&nbsp;&nbsp;',
			'multi_tax_sep'     => '',
			'hierarchical'      => true
		];
		
		$post_type = $post->post_type;
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		$output = [];
		
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
			if( $args['hierarchical'] == $taxonomy->hierarchical && has_term( '', $taxonomy_slug ) && 'post_format' != $taxonomy_slug ) {
				$term_list = get_the_term_list( $post->ID, $taxonomy_slug, $args['before'], $args['sep'], $args['after'] );

				if( true == $args['display_tax_name'] ){
					$output[] = strtoupper($taxonomy_slug) . $args['taxonomy_sep'] . $term_list;
				}else{
					$output[] = $term_list;
				}
			}
		}

		if( $output ) {  

			$count =  count( $output ); 
			if( 1 === $count ) {
				return implode( '', $output );
			} else {
				$multilist = [];
				foreach ( $output as $key=>$value ) {
					if (array_key_exists( $key + 1, $output ) ) {
						$multilist[] = $value . $args['multi_tax_sep'];
					} else {
						$multilist[] = $value;
					}
				}
				return implode( '', $multilist );
			}

		}

	}
endif;


/**
 * Get Page Description
 * Retrieve the page description from WPMU SmartCrawl or use the excerpt if empty
 */
if ( ! function_exists( 'activis_the_excerpt') ) :
	function activis_the_excerpt() {
		
		if ( get_field( '_wds_metadesc' ) != '' ) {
			$output = get_field( '_wds_metadesc' );
		}
		elseif ( get_the_excerpt( get_the_ID() ) != '' ) {
			$output = get_the_excerpt( get_the_ID() );
		} else {
			$output = '';
		}
		
		echo $output;
	}
endif;


/**
 * Get the post type name by post id
 */
if ( ! function_exists('activis_the_post_type_name') ) :
	function activis_the_post_type_name( $id ) {
		$post_type = get_post_type( $id );
		$cpt_obj = get_post_type_object( $post_type );
		echo ''.( $post_type == 'post' ? get_the_title( get_option('page_for_posts', true) ) : $cpt_obj->labels->name ).'';
	}
endif;


/**
 * Check if a post is a custom post type.
 * @param  mixed $post Post object or ID
 * @return boolean
 */
if ( ! function_exists('is_custom_post_type') ) {
	function is_custom_post_type( $post = NULL ) {

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