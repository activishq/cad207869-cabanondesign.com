<?php
/**
*
*	Activis Capabilities
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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
