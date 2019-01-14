<?php
/*
*
*	Activis Custom CSS Feature
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


/**
* Clear custom css cache on theme options and theme update/change
*
*/
add_action( 'redux/options/options/saved', 'activis_delete_cached_css' );
add_action( 'customize_save_after', 'activis_delete_cached_css' );
add_action( 'after_switch_theme', 'activis_delete_cached_css' );
add_action( 'delete_site_transient_update_themes', 'activis_delete_cached_css' );

/**
* Debug mode for custom css output
*
* return @bool
*/
function activis_custom_css_debug_mode() {
    return ( defined( 'ACTIVIS_CUSTOM_CSS_DEBUG' ) && ACTIVIS_CUSTOM_CSS_DEBUG === true ) || isset( $_GET['activis_custom_css_nocache'] );
}


/**
* Get the css output method from theme options
*
* return @string
*/
function activis_get_css_output_method() {
	$activis_options = activis_options();
	$styles_output = $activis_options['dynamic_styles_output'];

    return isset( $styles_output ) ? $styles_output : 'fs';
}


/**
* Get the filename for the custom css file
*
* return @string
*
*/
function activis_get_custom_css_filename() {
    return apply_filters( "activis_custom_css_filename", 'activis-custom' ) . '.css';
}


/**
* Enqueue the custom css file if set to fs or ajax output
*/
function activis_custom_css_enqueue() {
	if ( activis_get_css_output_method() == 'fs' ) {
        activis_custom_css_enqueue_fs();
    }

    if ( activis_get_css_output_method() == 'ajax' ) {
        activis_custom_css_enqueue_ajax();
    }
}
add_action( 'wp_enqueue_scripts', 'activis_custom_css_enqueue' );


/**
* Enqueue the custom css from the filesystem
*/
function activis_custom_css_enqueue_fs() {

    $upload_dir = wp_upload_dir();

    $filename = activis_get_custom_css_filename();

    $filepath = trailingslashit( $upload_dir['basedir'] ) . 'activis/' . $filename;

    if ( ! is_file( $filepath ) ) {

        // regenerate the CSS and save to filesystem
        activis_generate_custom_css();

    }

    // file should now exist
    if ( is_file( $filepath ) ) {

        $css_url = trailingslashit( $upload_dir['baseurl'] ) . 'activis/' . $filename;

        $protocol = is_ssl() ? 'https://' : 'http://';

        // ensure we're using the correct protocol
        $css_url = str_replace( array( "http://", "https://" ), $protocol, $css_url );

        wp_enqueue_style( 'activis-custom-css', $css_url, false, substr( md5( filemtime( $filepath ) ), 0, 6 ) );

    } else {

        // enqueue via AJAX for this request
        activis_custom_css_enqueue_ajax();

    }
}


/**
* Enqueue the custom css via AJAX
*/
function activis_custom_css_enqueue_ajax() {
    wp_enqueue_style( 'activis-custom-css', admin_url('admin-ajax.php') . '?action=activis_custom_css', false, NULL );
}


/**
* Generate the custom css for ajax output
*/
function activis_custom_css_ajax_output() {

    header("Content-type: text/css; charset: UTF-8");

    echo activis_get_custom_css();

    wp_die();
}
add_action( 'wp_ajax_activis_custom_css', 'activis_custom_css_ajax_output' );
add_action( 'wp_ajax_nopriv_activis_custom_css', 'activis_custom_css_ajax_output' );


/**
* Output the custom css to the head tag
*/
function activis_custom_css_head_output() {

    if ( activis_get_css_output_method() == 'head' ) {

        $css = activis_get_custom_css();

        echo '<style type="text/css">' . str_replace( array( "  ", "\n" ), '', $css ) . "</style>\n";

    }

}
add_action( 'wp_head', 'activis_custom_css_head_output', 9998 );


/**
* Get the custom css if cached, or generate it
*/
function activis_get_custom_css() {
    if ( ( $css = activis_get_cached_css() ) && ! activis_custom_css_debug_mode() ) {
        return $css;
    } else {
        return activis_generate_custom_css();
    }
}


/**
* Get the custom css transient key
*/
function activis_get_custom_css_transient_key() {
    return apply_filters( 'activis_custom_css_transient_key', 'activis-custom-css' );
}


/**
* Get the cached css
*/
function activis_get_cached_css() {
	return get_transient( activis_get_custom_css_transient_key() );
}


/**
* Set the cached css
*/
function activis_set_cached_css( $css ) {
    set_transient( activis_get_custom_css_transient_key(), $css, 0 );
}


/**
* Delete the cached css
*/
function activis_delete_cached_css() {
    global $wp_filesystem;

    if ( ! $wp_filesystem ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $upload_dir = wp_upload_dir();
    $filename = activis_get_custom_css_filename();
    $dir = trailingslashit( $upload_dir['basedir'] ) . 'activis/';

    WP_Filesystem( false, $upload_dir['basedir'], true );
    $wp_filesystem->rmdir( $dir, true );

    delete_transient( activis_get_custom_css_transient_key() );

    do_action( 'activis_after_delete_cached_css' );

    return true;
}


/**
* Generate the custom css
*/
function activis_generate_custom_css() {
	$css = activis_custom_styles_output();

	if ( strlen( $css ) ) {

	    $css .= "/** " . date('l jS \of F Y h:i:s A') . " **/";

	    activis_set_cached_css( $css );

	    if ( activis_get_css_output_method() == 'fs' ) {
	        activis_save_custom_css_to_fs( $css );
	    }

	}

	return $css;
}


/**
* Save custom css to file system
*/
function activis_save_custom_css_to_fs( $css ) {
    global $wp_filesystem;

    if ( ! $wp_filesystem ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $upload_dir = wp_upload_dir();
    $filename = activis_get_custom_css_filename();
    $dir = trailingslashit( $upload_dir['basedir'] ) . 'activis/';

    WP_Filesystem( false, $upload_dir['basedir'], true );
    $wp_filesystem->mkdir( $dir );

    if ( ! $wp_filesystem->put_contents( $dir . $filename, $css ) ) {

        // If the file write fails, update the theme option to ajax to prevent repeat fails
        $settings = get_option( 'activis_options' );
        $settings['dynamic_styles_output'] = 'ajax';
        update_option( 'activis_options', $settings );
    }
}
