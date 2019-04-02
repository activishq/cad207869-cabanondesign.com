<?php
/*
*
*	Activis Admin Overrides
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Dashboard Cleanup
 */
if ( ! function_exists( 'activis_disable_default_dashboard_widgets' ) ) :
	function activis_disable_default_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
	}
	add_action( 'wp_dashboard_setup', 'activis_disable_default_dashboard_widgets' );
endif;


/*
 * Enqueue JavaScript & CSS
 */
if( !function_exists('activis_admin_script') ) :
	function activis_admin_script(){

		// Style
		wp_register_style('activis-login', ACTIVIS_LOCAL_PATH .'/public/css/admin.min.css', array(), null, 'all');
		wp_enqueue_style(array(
			'activis-login',
		));

		// Script
		wp_register_script('activis-admin', ACTIVIS_LOCAL_PATH .'/public/js/admin.min.js', array('jquery'), null, true);
		wp_register_script('activis-admin-fa5', ACTIVIS_LOCAL_PATH .'/public/fonts/fa5/svg-with-js/js/fontawesome-all.min.js', array(), null, true);
		wp_enqueue_script(array(
			'activis-admin',
			'activis-admin-fa5'
		));
	}
	add_action('admin_enqueue_scripts', 'activis_admin_script', 10);
endif;


/*
 * Custom Login Logo
 */
if ( ! function_exists( 'activis_login_logo' ) ) :
	function activis_login_logo() {

		$options = activis_options();

		if ( ( isset( $options['ui_custom_admin_login_logo']['url'] ) ) && ( trim( $options['ui_custom_admin_login_logo']['url'] ) != "" ) ) :
			$activis_login_logo = $options['ui_custom_admin_login_logo']['url'];
		endif; ?>

		<style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php echo esc_url($activis_login_logo); ?>);
				width: 100%;
				background-size: contain;
			}
		</style>

	<?php }
	add_action( 'login_enqueue_scripts', 'activis_login_logo' );
endif;


/*
 * Custom Login CSS
 */
if(!function_exists('activis_login_css')){
	function activis_login_css(){
		wp_enqueue_style('activis-login-css', ACTIVIS_LOCAL_PATH .'/public/css/login.min.css', false);
	}
	add_action('login_enqueue_scripts', 'activis_login_css', 10);
}


/*
 * Custom Logout URL
 */
if ( ! function_exists( 'activis_login_url' ) ) :
	function activis_login_url() {
		return home_url();
	}
	add_filter( 'login_headerurl', 'activis_login_url' );
endif;


/*
 * Custom Dashboard Footer Text
 */
if ( ! function_exists( 'activis_custom_admin_footer' ) ) :
	function activis_custom_admin_footer() {
		_e( '<span id="footer-thankyou"><a href="http://activis.ca" title="Activis, your web agency" target="_blank">Activis, your web agency</a></span>.', 'activis' );
	}
	add_filter( 'admin_footer_text', 'activis_custom_admin_footer' );
endif;


/*
 * Custom Dashboard Toolbar
 */
if ( ! function_exists( 'actvis_custom_toolbar' ) ) :
	function actvis_custom_toolbar($wp_admin_bar) {
		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
	}
	add_action('admin_bar_menu', 'actvis_custom_toolbar', 11);
endif;
