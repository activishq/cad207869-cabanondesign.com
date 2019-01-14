<?php
/*
	Template name: Blank Page (No Header/Footer)
*/
?>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content/content', 'page' );

	endwhile;

else :

	get_template_part( 'template-parts/content/content', 'none' );

endif; 

wp_footer(); ?>
</body>
</html>
