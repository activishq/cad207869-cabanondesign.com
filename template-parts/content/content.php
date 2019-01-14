<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */

?>

<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-12 col-md-6 col-lg-4 grid-item'); ?>>
	
	<div class="hentry__wrapper">
		
		<?php if ( has_post_thumbnail() ) : ?>
		<!-- header__image -->
		<a class="hentry__thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<figure>
				<?php the_post_thumbnail('activis-blog'); ?>
			</figure>		
			<!-- hentry__author -->
			<div class="hentry__author">
				<?php activis_gravatar(); ?>
			</div>
			<!-- // hentry__author -->		
		</a>
		<!-- // header__image -->
		<?php endif; ?>

		<div class="hentry__content">
				
			<!-- hentry__header -->
			<div class="hentry__header">

				<div class="meta">
					<?php activis_article_categories(); ?>
				</div>

				<?php
					the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>			
			</div>
			<!-- // hentry__header -->	

			<div class="hentry__excerpt">
				<?php activis_the_excerpt(); ?>
			</div>
				
		</div>			

		<!-- hentry__footer -->
		<div class="hentry__footer">
			<?php activis_posted_on(); ?>
		</div>
		<!-- // hentry__footer -->

	</div>

</article>
<!-- article -->