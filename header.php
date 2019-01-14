<?php
/**
 * The header for our site.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package activis
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'activis_head_start' ); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php do_action( 'activis_after_body' ); ?>

<!-- App -->
<div class="app">

	<?php do_action( 'activis_site_header' ); ?>

	<!-- Site Main -->
	<main class="site-main" role="main">

        <?php do_action( 'activis_start_site_main' ); ?>
