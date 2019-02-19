<?php
/*
*
*	Activis Admin Overrides
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

/* DASHBOARD CLEAN UP
================================================== */
if ( ! function_exists( 'activis_disable_default_dashboard_widgets' ) ) :
	function activis_disable_default_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    // Right Now Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // Activity Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Comments Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  // Incoming Links Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         // Plugins Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    // Quick Press Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     // Recent Drafts Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);           //
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);         //
		unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);           // Yoast's SEO Plugin Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);        // Gravity Forms Plugin Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);   // bbPress Plugin WidgetS
	}
	add_action( 'wp_dashboard_setup', 'activis_disable_default_dashboard_widgets' );
endif;


/* ADMIN ASSETS
================================================== */
if( !function_exists('activis_admin_script') ) :
	function activis_admin_script(){

		// Style
		wp_register_style('activis-login', ACTIVIS_LOCAL_PATH .'/public/css/admin.min.css', array(), null, 'all');
		wp_register_style('activis-fa5', ACTIVIS_LOCAL_PATH .'/public/fonts/fa5/web-fonts-with-css/css/fontawesome-all.min.css', array(), null, 'all');
		wp_enqueue_style(array(
			'activis-login',
			'activis-fa5'
		));

		// Script
		wp_register_script('activis-admin', ACTIVIS_LOCAL_PATH .'/public/js/admin.min.js', array('jquery'), null, true);
		wp_register_script('activis-admin-fa5', ACTIVIS_LOCAL_PATH .'/public/fonts/fa5/svg-with-js/js/fontawesome-all.min.js', array(), null, true);
		wp_enqueue_script(array(
			'activis-admin',
			//'activis-admin-fa5'
		));
	}
	add_action('admin_enqueue_scripts', 'activis_admin_script', 10);
endif;


/* CUSTOM LOGIN LOGO
================================================== */
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


/* CUSTUM LOGIN CSS
================================================== */
if(!function_exists('activis_login_css')){
	function activis_login_css(){
		wp_enqueue_style('activis-login-css', ACTIVIS_LOCAL_PATH .'/public/css/login.min.css', false);
	}
	add_action('login_enqueue_scripts', 'activis_login_css', 10);
}


/* CUSTOM LOGOUT URL
================================================== */
if ( ! function_exists( 'activis_login_url' ) ) :
	function activis_login_url() {
		return home_url();
	}
	add_filter( 'login_headerurl', 'activis_login_url' );
endif;


/* CUSTOM LOGIN FOOTER TEXT
================================================== */
if ( ! function_exists( 'activis_custom_admin_footer' ) ) :
	function activis_custom_admin_footer() {
		_e( '<span id="footer-thankyou"><a href="http://activis.ca" title="Activis, your web agency" target="_blank">Activis, your web agency</a></span>.', 'activis' );
	}
	add_filter( 'admin_footer_text', 'activis_custom_admin_footer' );
endif;


/* CUSTOM TOOLBAR
================================================== */
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


/* USER ACTIVIS CAN LOGIN FROM THE OFFICE ONLY
================================================== */
if(!function_exists('activis_authenticate')) :
	function activis_authenticate($user, $username, $password){

		/**
			TODO:
			- Check whitelisted hosts/IPv4 againts the authentification mecanism
		 */
		$options = activis_options();

		if ( (isset( $options['secure_backend_whitelisted'] ) ) && trim( $options['secure_backend_whitelisted'] ) != "" ) {
			$whitelisted = $options['secure_backend_whitelisted'];
		}

		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip_client = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_client = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip_client = $_SERVER['REMOTE_ADDR'];
		}

		if($ip_client == '127.0.0.1' OR $ip_client == '::1' ){
			$ip_client = gethostbyname(ACTIVIS_OFFICE_IP);
		}

		if( $username == 'activis' && $ip_client != gethostbyname( ACTIVIS_OFFICE_IP ) ) {
			$error = new WP_Error();
			$error->add('activis-login-protection', 'Activis login protection.');
			return $error;
		}
		else {
			return $user;
		}
	}
	//add_filter('authenticate', 'activis_authenticate', 30, 3);
endif;


/* ACTIVIS_WP_MAIL_FROM_NAME
================================================== */
if( !function_exists( 'activis_wp_mail_from_name' ) ) :
	function activis_wp_mail_from_name() {
		return get_bloginfo( 'name' );
	}
	add_filter( 'wp_mail_from_name', 'activis_wp_mail_from_name' );
endif;


/* ACTIVIS_WP_MAIL_FROM_EMAIL
================================================== */
if( !function_exists( 'activis_wp_mail_from_email' ) ) :
	function activis_wp_mail_from_email() {
		return 'no-reply@' . parse_url( get_option( 'siteurl' ), PHP_URL_HOST );
	}
	add_filter( 'wp_mail_from', 'activis_wp_mail_from_email' );
endif;


/* ACTIVIS_INIT_SYS
================================================== */
if ( ! function_exists( 'activis_init_sys' ) ) :

	function activis_init_sys() {
		flush_rewrite_rules();
		add_rewrite_endpoint( 'sys', EP_ROOT );
	}
	add_action( 'init', 'activis_init_sys' );

endif;


/* ACTIVIS_TEMPLATE_REDIRECT_SYS
================================================== */
if ( ! function_exists( 'activis_template_redirect_sys' ) ) :

	function activis_template_redirect_sys() {

		global $wp_query;

		if( isset( $wp_query->query_vars['sys'] ) && $wp_query->query_vars['sys'] == 'flush-cache' ) :

			$cmd = 'sudo ee clean';

			$output = shell_exec( $cmd );

			exit( $cmd );

		elseif( isset( $wp_query->query_vars['sys'] ) && $wp_query->query_vars['sys'] == 'deploy' ) :

				if( isset( $_REQUEST[ 'payload' ] ) ) :

					$payload = json_decode( $_REQUEST[ 'payload' ] );

					if( $payload->ref === 'refs/heads/master' ) :

						$cmd = 'sudo ee clean && cd ' . get_template_directory() . ' && git reset --hard HEAD && git pull origin master';

						$output = shell_exec( $cmd );

						exit( $cmd );

					elseif( $payload->ref === 'refs/heads/staging' ) :

						$cmd = 'sudo ee clean && cd ' . get_template_directory() . ' && git reset --hard HEAD && git pull origin staging';

						$output = shell_exec( $cmd );

						exit( $cmd );

					endif;

				endif;

				exit();

		endif;

	}

	add_action( 'template_redirect', 'activis_template_redirect_sys' );

endif;


/* ACTIVIS_INIT_ROLE
================================================== */
if ( ! function_exists( 'activis_init_role' ) ) :

	function activis_init_role(){

		$capabilities = array(
			// Administrator
			'create_users' => true,
			'delete_users' => true,
			'edit_users' => true,
			'export' => true,
			'import' => true,
			'list_users' => true,
			'manage_options' => true,
			'promote_users' => true,
			'remove_users' => true,
			'edit_dashboard' => true,
			'customize' => true,

			// Editor
			'moderate_comments' => true,
			'manage_categories' => true,
			'manage_links' => true,
			'edit_others_posts' => true,
			'edit_pages' => true,
			'edit_others_pages' => true,
			'edit_published_pages' => true,
			'publish_pages' => true,
			'delete_pages' => true,
			'delete_others_pages' => true,
			'delete_published_pages' => true,
			'delete_others_posts' => true,
			'delete_private_posts' => true,
			'edit_private_posts' => true,
			'read_private_posts' => true,
			'delete_private_pages' => true,
			'edit_private_pages' => true,
			'read_private_pages' => true,
			'unfiltered_html' => true,

			// Author
			'edit_published_posts' => true,
			'upload_files' => true,
			'publish_posts' => true,
			'delete_published_posts' => true,

			// Contributor
			'edit_posts' => true,
			'delete_posts' => true,

			// Subscriber
			'read' => true,

			// DuplicatePost
            'copy_posts' => true,

			// WooCommerce
			'manage_woocommerce' => true,
			'view_woocommerce_reports' => true,
			'edit_product' => true,
			'read_product' => true,
			'delete_product' => true,
			'edit_products' => true,
			'edit_others_products' => true,
			'publish_products' => true,
			'read_private_products' => true,
			'delete_products' => true,
			'delete_private_products' => true,
			'delete_published_products' => true,
			'delete_others_products' => true,
			'edit_private_products' => true,
			'edit_published_products' => true,
			'manage_product_terms' => true,
			'edit_product_terms' => true,
			'delete_product_terms' => true,
			'assign_product_terms' => true,
			'edit_shop_order' => true,
			'read_shop_order' => true,
			'delete_shop_order' => true,
			'edit_shop_orders' => true,
			'edit_others_shop_orders' => true,
			'publish_shop_orders' => true,
			'read_private_shop_orders' => true,
			'delete_shop_orders' => true,
			'delete_private_shop_orders' => true,
			'delete_published_shop_orders' => true,
			'delete_others_shop_orders' => true,
			'edit_private_shop_orders' => true,
			'edit_published_shop_orders' => true,
			'manage_shop_order_terms' => true,
			'edit_shop_order_terms' => true,
			'delete_shop_order_terms' => true,
			'assign_shop_order_terms' => true,
			'edit_shop_coupon' => true,
			'read_shop_coupon' => true,
			'delete_shop_coupon' => true,
			'edit_shop_coupons' => true,
			'edit_others_shop_coupons' => true,
			'publish_shop_coupons' => true,
			'read_private_shop_coupons' => true,
			'delete_shop_coupons' => true,
			'delete_private_shop_coupons' => true,
			'delete_published_shop_coupons' => true,
			'delete_others_shop_coupons' => true,
			'edit_private_shop_coupons' => true,
			'edit_published_shop_coupons' => true,
			'manage_shop_coupon_terms' => true,
			'edit_shop_coupon_terms' => true,
			'delete_shop_coupon_terms' => true,
			'assign_shop_coupon_terms' => true,

			// WPML
			// 'wpml_manage_translation_management' => true,
			// 'wpml_manage_languages' => true,
			// 'wpml_manage_translation_options' => true,
			// 'wpml_manage_troubleshooting' => true,
			// 'wpml_manage_taxonomy_translation' => true,
			// 'wpml_manage_wp_menus_sync' => true,
			// 'wpml_manage_translation_analytics' => true,
			// 'wpml_manage_string_translation' => true,
			// 'wpml_manage_sticky_links' => true,
			// 'wpml_manage_navigation' => true,
			// 'wpml_manage_theme_and_plugin_localization' => true,
			// 'wpml_manage_media_translation' => true,
			// 'wpml_manage_support' => true,
			// 'wpml_manage_woocommerce_multilingual' => true,
			// 'wpml_operate_woocommerce_multilingual' => true,
		);

		remove_role( 'subscriber' );
		remove_role( 'contributor' );
		remove_role( 'author' );
		remove_role( 'editor' );
		remove_role( 'client' );
		remove_role( 'wpseo_editor' );
		remove_role( 'wpseo_manager' );

		add_role( 'client', 'Client', $capabilities );
	}

	add_action( 'after_setup_theme', 'activis_init_role' );

endif;


/* ACTIVIS_EDITABLE_ROLES
================================================== */
if ( ! function_exists( 'activis_editable_roles' ) ) :

	function activis_editable_roles( $roles ) {

		if ( $user = wp_get_current_user() ) :

			if( !in_array( 'administrator', $user->roles ) ) :
				   
				  unset( $roles[ 'administrator' ] );

			endif;

		endif;

		return $roles;

	}

	add_filter( 'editable_roles', 'activis_editable_roles' );

endif;


/* ACTIVIS_PRE_USER_QUERY
================================================== */
if ( ! function_exists( 'activis_pre_user_query' ) ) :

	function activis_pre_user_query($user_search) {

		if ( $user = wp_get_current_user() ) :

			if( !in_array( 'administrator', $user->roles ) ) :
				   
				global $wpdb;

				$user_search->query_where = str_replace(
					'WHERE 1=1', 
					"WHERE 1=1 AND {$wpdb->users}.ID IN (
						SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
							WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
							AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
					$user_search->query_where
				);


			endif;

		endif;

	}

	add_action('pre_user_query','activis_pre_user_query');

endif;


/* ACTIVIS_VIEWS_USERS
================================================== */
if ( ! function_exists( 'activis_views_users' ) ) :

	function activis_views_users( $view ) {

		if ( $user = wp_get_current_user() ) :

			if( !in_array( 'administrator', $user->roles ) ) :

				unset( $view[ 'all' ] );

				unset( $view[ 'administrator' ] );

			endif;

		endif;

		return $view;

	}

	add_filter( "views_users" , 'activis_views_users', 10, 1);

endif;