<?php
/**
*
*	Activis Custom Template Tags
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


/**
 * Article Categories
 */
if ( ! function_exists( 'activis_article_categories' ) ) :
	function activis_article_categories() {

		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'activis' ) );
			if ( $categories_list && activis_categorized_blog() ) {
				echo $categories_list;
			}
		}
	}
endif;


/**
 * Article Posted On
 */
if ( ! function_exists( 'activis_posted_on' ) ) :
	function activis_posted_on() {
		
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		// Human-readable time difference
		$hrtd = sprintf( _x( '%s ago', '%s = hrtd', 'activis' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'activis' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $hrtd . '</a>'
		);

		echo '<span class="posted-on"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i>' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;


/**
 * Article Gravator
 */
if ( ! function_exists( 'activis_gravatar' ) ) :
	function activis_gravatar() {
		$avatar = sprintf(
			''. get_avatar( get_the_author_meta( 'ID' ), 80 ) .''
		);
		echo '<span class="avatar">' . $avatar . '</span>'; // WPCS: XSS OK.
	}
endif;


/**
 * Article Footer
 */
if ( ! function_exists( 'activis_entry_footer' ) ) :
	function activis_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'activis' ) );
			if ( $categories_list && activis_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'activis' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'activis' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'activis' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'activis' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'activis' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Posts Pagination
 * Display navigation to next/previous set of posts when applicable.
 */
if ( ! function_exists( 'activis_paging_nav' ) ) {
	function activis_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'storefront' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'storefront' ),
			);

		the_posts_pagination( $args );
	}
}


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function activis_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'activis_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'activis_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so activis_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so activis_categorized_blog should return false.
		return false;
	}
}


/**
 * Flush out the transients used in activis_categorized_blog.
 */
function activis_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'activis_categories' );
}
add_action( 'edit_category', 'activis_category_transient_flusher' );
add_action( 'save_post',     'activis_category_transient_flusher' );
