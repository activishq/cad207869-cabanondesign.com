<?php
/**
 * Template part for displaying the 404 page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<header class="jumbotron">
	<div class="container">
		<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'activis' ); ?></h1>
	</div>
</header>

<div class="container">

	<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'activis' ); ?></p>

	<?php get_search_form(); ?>

</div>
