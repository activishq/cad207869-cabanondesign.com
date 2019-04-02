<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php while ( have_posts() ) : the_post(); ?>

<main id="main" <?php post_class( 'site-main' ); ?> role="main">

	<div class="page-content">
		<?php the_content(); ?>
	</div>

</main>

<?php endwhile;
