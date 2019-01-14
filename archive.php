<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
get_header();

if( is_category() ) :

	get_template_part( 'template-parts/archive/archive', 'category' );
	
elseif( is_tag() ) :

	get_template_part( 'template-parts/archive/archive', 'tag' );

elseif( is_author() ) :

	get_template_part( 'template-parts/archive/archive', 'author' );

elseif( is_year() ) :

	get_template_part( 'template-parts/archive/archive', 'date' );

elseif( is_month() ) :

	get_template_part( 'template-parts/archive/archive', 'date' );

elseif( is_day() ) :

	get_template_part( 'template-parts/archive/archive', 'date' );

elseif( is_post_type_archive() ) :

	get_template_part( 'template-parts/archive/archive', get_post_type() );

elseif( is_tax( 'post_format' ) ) :

	get_template_part( 'template-parts/archive/archive', get_post_format() );

elseif( is_tax() ) :

	get_template_part( 'template-parts/archive/archive', '' );

else :

	get_template_part( 'template-parts/archive/archive', '' );

endif;

get_footer();
