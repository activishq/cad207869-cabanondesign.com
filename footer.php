<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package activis
 */
?>

        <?php do_action( 'activis_end_site_main' ); ?>

	</main>
	<!-- // Site Main -->

	<?php do_action( 'activis_site_footer' ); ?>

</div>
<!-- // App -->

<?php
	wp_footer();
	do_action( 'activis_after_footer' );
?>
</body>
</html>
