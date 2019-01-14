<?php
/*
*
*	Activis Init
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/

/* THEME SETUP
================================================== */
if ( ! function_exists( 'activis_setup' ) ) {

	function activis_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'activis', ACTIVIS_TEMPLATE_PATH . '/languages' );

		/* Theme Support */
		//add_theme_support( 'structured-post-formats', array('audio', 'gallery', 'image', 'link', 'video') );
		//add_theme_support( 'post-formats', array('link', 'image', 'quote') );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'featured-image' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		));

		/* Custom Logo */
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// WooCommerce support
		add_theme_support( 'woocommerce', apply_filters( 'activis_woocommerce_args', array(
			'single_image_width'    => 416,
			'thumbnail_image_width' => 324,
			'product_grid'          => array(
				'default_columns' => 3,
				'default_rows'    => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
				'min_rows'        => 1
			)
		) ) );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Define Navigation Locations
		register_nav_menus( array(
			'primary-navigation' => esc_html__( 'Primary Navigation', 'activis' ),
			'primary-navigation-left' => esc_html__( 'Primary Navigation (Left)', 'activis' ),
			'primary-navigation-right' => esc_html__( 'Primary Navigation (Right)', 'activis' ),
			'mobile-navigation' => esc_html__( 'Mobile Navigation', 'activis' ),
		));

		/* Define Thumbnail Sizes */
		set_post_thumbnail_size( 150, 150, false);

		// Custom CSS for the backend editor
		add_editor_style( ACTIVIS_LOCAL_PATH . '/public/css/editor.min.css' );

	}
	add_action( 'after_setup_theme', 'activis_setup' );
}


/* ENQUEUE CSS
================================================== */
if ( ! function_exists( 'activis_enqueue_styles' ) ) {
	function activis_enqueue_styles() {

		$options = activis_options();

		if ( ( isset( $options['general_minimize_css'] ) ) && ( $options['general_minimize_css'] == "1" ) ) {
			wp_register_style( 'activis-style', get_stylesheet_directory_uri() .'/public/css/style.min.css', array(), null, 'all');
		} else {
			wp_register_style( 'activis-style', get_stylesheet_directory_uri() .'/public/css/style.css', array(), null, 'all');
		}

		wp_enqueue_style( array(
			'activis-style'
		));
	}
	add_action( 'wp_enqueue_scripts', 'activis_enqueue_styles' );
}


/* ENQUEUE JS
================================================== */
if ( ! function_exists( 'activis_enqueue_scripts' ) ) {
	function activis_enqueue_scripts() {

		if ( !is_admin() ) {
			
			$options = activis_options();

			// Register Scripts
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), FALSE, NULL, TRUE );
			wp_register_script( 'activis-modernizr', ACTIVIS_LOCAL_PATH . '/public/js/modernizr.min.js', array(), NULL, FALSE );

			if ( ( isset( $options['general_minimize_js'] ) ) && ( $options['general_minimize_js'] == "1" ) ) {
				wp_register_script( 'activis-vendors', ACTIVIS_LOCAL_PATH . '/public/js/vendors.min.js', array(), NULL, TRUE );
				wp_register_script( 'activis-app', ACTIVIS_LOCAL_PATH . '/public/js/app.min.js', array('activis-vendors'), NULL, TRUE );
			} else {
				wp_register_script( 'activis-vendors', ACTIVIS_LOCAL_PATH . '/public/js/vendors.js', array(), NULL, TRUE );
				wp_register_script( 'activis-app', ACTIVIS_LOCAL_PATH . '/public/js/app.js', array('activis-vendors'), NULL, TRUE );
			}

			// Enqueue Scripts
			wp_enqueue_script( array(
				'jquery',
				'activis-modernizr',
				'activis-vendors',
				'activis-app'
			));

			if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
				wp_enqueue_script( 'comment-reply' );
			endif;

			wp_localize_script( 'activis-app', 'vars', array(
				'home' 			=> get_stylesheet_directory_uri(),
				'nonce' 		=> wp_create_nonce( get_bloginfo( 'name' ) ),
				'ajax' 			=> admin_url( 'admin-ajax.php' ),
				'loadingText' 	=> __( '', 'activis' )
			) );

		}
	}
	add_action('wp_enqueue_scripts', 'activis_enqueue_scripts');
}


/* HEAD CLEANUP
================================================== */
if ( ! function_exists( 'activis_head_cleanup' ) ) :
	function activis_head_cleanup() {
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
	}
	add_action('init', 'activis_head_cleanup');
endif;

// Set the content width in pixels, based on the theme's design and stylesheet.
function activis_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'activis_content_width', 1140 );
}
add_action( 'after_setup_theme', 'activis_content_width', 0 );

// Remove injected CSS for recent comments widget
function activis_remove_wp_widget_recent_comments_style() {
	if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style' );
	}
}

// Remove injected CSS from recent comments widget
function activis_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

// Remove injected CSS from gallery
function activis_gallery_style($css) {
	return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}