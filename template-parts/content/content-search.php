<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */

?>

<?php if ( have_posts() ) : ?>

	<header class="section section--is-header">
		<h1 class="page-title"><?php printf( esc_html__( 'Search Results', 'activis' ) ); ?></h1>
		<p><?php _e( 'You searched for', 'activis'); ?> <?php echo get_search_query(); ?></p>
	</header>

	<section class="section section--is-search">

		<div class="container">

			<?php get_search_form(); ?>

			<div class="results">

				<ul class="results__list">
				
				<?php
				
				/* Start the Loop */
				while ( have_posts() ) : the_post(); ?>

					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<a class="hentry__title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <span class="badge badge-secondary"><?php activis_the_post_type_name( get_the_ID() ); ?></span>
						<p class="hentry__permalink"><?php the_permalink(); ?></p>
						<p class="hentry__excerpt"><?php activis_the_excerpt(); ?></p>
					</li>

				<?php endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content/content', 'none' ); ?>
				
				</ul>

			</div>

		</div>

	</section>

<?php endif; 