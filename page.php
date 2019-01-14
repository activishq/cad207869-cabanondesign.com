<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
get_header();

	do_action( 'activis_page_before' );

	/* Have Posts */
	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content/content', 'page' );

		endwhile;

	else :

		get_template_part( 'template-parts/content/content', 'none' );

	endif;

	do_action( 'activis_page_after' );

get_footer();
