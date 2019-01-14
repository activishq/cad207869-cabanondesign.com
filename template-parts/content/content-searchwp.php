<?php
/**
 * Template part for displaying results in search pages (advanced).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */

global $post;

// retrieve our search query if applicable
$query = isset( $_REQUEST['s'] ) ? sanitize_text_field( $_REQUEST['s'] ) : '';

// retrieve our pagination if applicable
$page = isset( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : 1;

if ( class_exists('SWP_Query') ) :

	$searchwp = new SWP_Query(
		array(
			's'      => $query,
			'page'   => $page,
		)
	);

	// set up pagination
	$pagination = paginate_links( array(
		'format'  => '?page=%#%',
		'type' => 'list',
		'current' => $page,
		'total'   => $searchwp->max_num_pages,
	) );
	
endif;

?>

<header class="section section--is-header">
	<h1 class="page-title"><?php printf( esc_html__( 'Search Results', 'activis' ) ); ?></h1>
	<?php
	printf(
		_n( '%1$d result for %2$s', '%1$d results for %2$s', ( $searchwp->found_posts == 0 ? 1 : $searchwp->found_posts ) , 'activis'),
		esc_attr( $searchwp->found_posts ),
		get_search_query()
	);
	?>
</header>

<section class="section section--is-search">

	<div class="container">
	
		<?php get_search_form(); ?>
		
		<div class="results">

			<ul class="results__list">
			<?php

				if ( $searchwp->posts ) :

					foreach( $searchwp->posts as $post ) : setup_postdata( $post ); ?>

						<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<a class="hentry__title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <span class="badge badge-secondary"><?php activis_the_post_type_name( get_the_ID() ); ?></span>
							<p class="hentry__permalink"><?php the_permalink(); ?></p>
							<p class="hentry__excerpt"><?php activis_the_excerpt(); ?></p>
						</li>

						<?php wp_reset_postdata();
					
					endforeach;
			
				else :

			?>
			
				<li>
					<?php esc_attr_e('No results found...', 'activis'); ?>
				</li>
			
			<?php endif; ?>
			</ul>


			<?php if ( $searchwp->max_num_pages > 1 ) : ?>
			<div class="post-pagination" role="navigation">
				<?php echo wp_kses_post( $pagination ); ?>
			</div>
			<?php endif;  ?>

	
		</div>

	</div>

</section>