<?php
/**
 * Template part for displaying the post navigation
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<!-- post-navigation -->
<section class="section section--navigation">
	
	<div class="container">

		<div class="post-navigation">

			<div class="previous-post">
				<?php $prev_post = get_adjacent_post( false, '', true, 'category' ); ?>
				<?php if ( is_a( $prev_post, 'WP_Post' ) ) { ?>
				<a class="btn-link" href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo get_the_title( $prev_post->ID ); ?>"><i class="fa fa-fw fa-angle-left" aria-hidden="true"></i><?php _e( 'Previous article', 'activis' ); ?></a>
				<?php } ?>
			</div>
			
			<div class="root">
				<a class="btn-link" href="<?php the_permalink( get_option( 'page_for_posts' ) ); ?>" title="<?php _e( 'All articles', 'activis' ); ?>"><i class="fa fa-fw fa-th" aria-hidden="true"></i><?php _e( 'All articles', 'activis' ); ?></a>
			</div>

			<div class="next-post">
				<?php $next_post = get_adjacent_post( false, '', false, 'category' ); ?>
				<?php if ( is_a( $next_post, 'WP_Post' ) ) {  ?>
				<a class="btn-link" href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo get_the_title( $next_post->ID ); ?>"><?php _e( 'Next article', 'activis' ); ?><i class="fa fa-fw fa-angle-right" aria-hidden="true"></i></a>
				<?php } ?>
			</div>

		</div>
		
	</div>

</section>
<!-- // post-navigation -->