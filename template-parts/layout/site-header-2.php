<?php
/**
 * Template part for displaying the centered site header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */

?>

<!-- Site Header -->
<header class="header">
		
	<div class="container">

		<div class="header__wrapper">

			<div class="header__col">

				<nav class="main-navigation main-navigation--left" role="navigation">

					<?php 
						wp_nav_menu(array(
							'theme_location'	=> 'primary-navigation-left',
							'depth'		=> 3,
							'fallback_cb'	=> false,
							'container'		=> false,
							'items_wrap'	=> '<ul class="hidden-md-down menu %1$s">%3$s</ul>',
							'walker'		=> new Activis_MegaMenu_Walker_Nav_Menu()
						));
					?>
				</nav>
				
			</div>

			<div class="header__branding header__branding--center">
			<?php do_action( 'activis_header_branding' ); ?>
			</div>

			<div class="header__col">

				<nav class="main-navigation main-navigation--right" role="navigation">                    
					
					<?php 
						wp_nav_menu(array(
							'theme_location'	=> 'primary-navigation-right',
							'depth'		=> 3,
							'fallback_cb'	=> false,
							'container'		=> false,
							'items_wrap'	=> '<ul class="hidden-md-down menu %1$s">%3$s</ul>',
							'walker'		=> new Activis_MegaMenu_Walker_Nav_Menu()
						));
					?>
					
					<div class="hamburger">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</div>
				
				</nav>

			</div>

		</div>

	</div>

</header>
<!-- // Site Header -->