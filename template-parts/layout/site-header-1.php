<?php
/**
 * Template part for displaying the conventional site header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package activis
 */
?>

<!-- Site Header -->
<header class="header" role="banner">

	<div class="container">

		<div class="header__wrapper">

			<div class="header__branding header__branding--left">
				<?php do_action( 'activis_header_branding' ); ?>
			</div>

			<div class="header__col">

				<nav class="main-navigation" role="navigation">

					<?php
						wp_nav_menu(array(
							'theme_location'  => 'primary-navigation',
							'depth'		=> 3,
							'fallback_cb'     => false,
							'container'       => false,
							'items_wrap'	=> '<ul class="menu %1$s">%3$s</ul>',
							'walker'          => new Activis_MegaMenu_Walker_Nav_Menu()
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
