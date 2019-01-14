<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */

?>

<div class="container">

	<div class="not-found">

		<header class="section section--is-header">
			<div class="container">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'activis' ); ?></h1>
			</div>
		</header>

		<div class="page-content">
			
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'activis' ); ?></p>
	
			<div class="search">

				<?php get_search_form(); ?>

			</div>

		</div>

	</div> 

</div>
