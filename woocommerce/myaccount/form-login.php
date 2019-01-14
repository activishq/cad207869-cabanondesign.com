<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php wc_print_notices(); ?>

<div class="row justify-content-center">

	<div class="col-sm-6">

		<ul class="account-tab-list">
			<li class="account-tab-item">
				<a class="account-tab-link <?php echo ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' )  ? 'current':'registration_disabled' ?>" href="#login"><?php _e( 'Login', 'woocommerce' ); ?></a>
			</li>
		</ul>
		
		<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

		<div class="login-register-container">
				
			<div class="account-forms-container">		
						
				<div class="account-forms">
					
					<form id="login" method="post" class="login-form">
					
						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
							<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</p>
						<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
							<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
						</p>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<p class="form-row form-footer">
							<?php wp_nonce_field( 'woocommerce-login' ); ?>
							<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
							<br/><br/>
							<label for="rememberme" class="inline">
								<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
							</label>
							<a class="lost-pass-link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
						</p>
								
						<?php do_action( 'woocommerce_login_form_end' ); ?>
							
					</form>
				
				</div><!-- .account-forms-->
						
			</div><!-- .account-forms-container-->
		
		</div><!-- .login-register-container-->
		
		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	</div>

</div>

