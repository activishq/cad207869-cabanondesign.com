<?php
/**
 * Template part for displaying the site footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<!-- Site Footer -->
<footer class="site-footer" role="contentinfo">

	<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'footer-sidebar' ); ?>

	<?php endif; ?>

</footer>
<!-- // Site Footer -->