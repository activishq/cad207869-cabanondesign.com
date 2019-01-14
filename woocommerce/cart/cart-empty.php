<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<header class="section section--is-header">

	<div class="container-fluid">
		<h1 class="section__title size--large">
			<?php do_action( 'woocommerce_cart_is_empty' ); ?>
		</h1>
	</div>

</header>

<section class="section section--is-woocommerce">

<div class="row justify-content-center">
	<div class="col-sm-8">
		
		<p class="return-to-shop ta--center"><a class="wc-backward" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Return to shop', 'woocommerce' ) ?></a></p>

	</div>
</div>

</section>