<?php
/**
*
* @package    single.php
* 	
* @author     activis
* 	
* @copyright  https://activis.ca/
* 
**/
get_header();

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/post/content', get_post_format() );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			//comments_template();
		endif;

		get_template_part( 'template-parts/structure/post', 'navigation' );

	endwhile; // End of the loop.

get_footer(); 