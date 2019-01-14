<?php
/**
 * Template part for displaying the mobile navigation sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<!-- Mobile Navigation -->
<div class="nav" id="sidebar">
	
	<div class="menu">
		
		<?php wp_nav_menu( array(
			'menu' 			=> '',
			'theme_location' 		=> 'mobile-navigation',
			'depth' 			=> 2,
			'container' 		=> false,
			'container_class' 	=> false,
			'container_id' 		=> '',
			'menu_class' 		=> 'menu',
		)); ?>			

	</div>

</div>
<!-- // Mobile Navigation -->