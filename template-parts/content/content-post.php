<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-12 col-md-6 col-lg-4 grid-item'); ?>>

	<header class="hentry__featured" style="background-image:url(<?php echo esc_url( the_post_thumbnail_url('full') ); ?>)">

		<div class="container">
			
			<div class="hentry__meta">
				<?php activis_article_categories(); ?>
			</div>

			<?php the_title('<h1 class="section__title">', '</h1>'); ?>

			<div class="hentry__meta">
				<?php activis_posted_on(); ?>
			</div>

		</div>
	</header>
	
	<div class="container">	

		<!-- entry-content -->
		<div class="hentry__content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'activis' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'activis' ),
					'after'  => '</div>',
				) );
			?>
		</div>
		<!-- // entry-content -->

	</div>

</article>
<!-- article #post-## -->