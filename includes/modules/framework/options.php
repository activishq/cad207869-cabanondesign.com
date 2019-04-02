<?php

/**
 * For full documentation, please visit: http://docs.reduxframework.com/
 * For a more extensive sample-config file, you may look at:
 * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
 */

if ( ! class_exists( 'Redux' ) ) {
	return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "options";

// Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/redux-extensions/extensions/ad_remove' );

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	'opt_name' => 'options',
	'dev_mode' => FALSE,
	'use_cdn' => TRUE,
	'display_name' => 'Options',
	'display_version' => ACTIVIS_THEME_VERSION,
	'page_slug' => 'activis-framework',
	'page_title' => 'Theme Options',
	'google_api_key'       => ACTIVIS_KEY_GOOGLE,
	'google_update_weekly' => true,
	'async_typography'     => true,
	'update_notice' => FALSE,
	'intro_text' => '',
	'footer_text' => '',
	'admin_bar' => FALSE,
	'menu_type' => 'menu',
	'menu_title' => 'Theme Options',
	'allow_sub_menu' => TRUE,
	'page_parent' => 'themes.php',
	'page_parent_post_type' => 'your_post_type',
	'default_mark' => '*',
	'hints' => array(
		'icon_position' => 'right',
		'icon_size' => 'normal',
		'tip_style' => array(
			'color' => 'light',
			),
		'tip_position' => array(
			'my' => 'top left',
			'at' => 'bottom right',
			),
		'tip_effect' => array(
			'show' => array(
				'duration' => '500',
				'event' => 'mouseover',
				),
			'hide' => array(
				'duration' => '500',
				'event' => 'mouseleave unfocus',
				),
			),
		),
	'output' => TRUE,
	'output_tag' => TRUE,
	'settings_api' => TRUE,
	'cdn_check_time' => '1440',
	'page_permissions' => 'manage_options',
	'save_defaults' => TRUE,
	'show_import_export' => TRUE,
	'transient_time' => '3600',
	'network_sites' => FALSE,
	);

Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 *
 * ---> START SECTIONS
 *
 */

Redux::setSection( $opt_name, array(
	'title'      => __( 'General', 'activis-redux' ),
	'subsection' => false,
	'icon'       => 'fal fa-cogs',
	'fields'     => array(
		array (
			'title' => __('Login logo', 'activis-redux'),
			'subtitle' => __('Upload a 300 x 95px image here to replace the admin login logo.', 'activis-redux'),
			'id' => 'ui_custom_admin_login_logo',
			'type' => 'media',
			'url'=> true,
			'desc' => ''
		),
	)
));

Redux::setSection( $opt_name, array(
	'title' => __('Performance', 'activis-redux'),
	'desc' => '',
	'subsection' => false,
	'icon' => 'fal fa-fighter-jet',
	'fields' => array (
		array (
			'title' => __('Dynamic Styles Output', 'activis-redux'),
			'subtitle' => __("Select the output method for the theme's dynamic styles, File System is the best, but may not be supported by your hosting. <head> output will be defaulted to if any issues occur.", 'activis-redux'),
			'id' => 'dynamic_styles_output',
			'type' => 'select',
			'desc' => '',
			'options' => array(
				'fs' => 'File System (cached)',
				'ajax' => 'AJAX script',
				'head' => 'Head tag (source output)',
			),
			'default' => 'head'
		),
		array (
			'title' => __('Minimize JavaScript', 'activis-redux'),
			'subtitle' => __('Use minimized JavaScript code for better performance.', 'activis-redux'),
			'id' => 'general_minimize_js',
			'type' => 'switch',
			'on' => __('Enabled', 'activis-redux'),
			'off' => __('Disabled', 'activis-redux'),
			"default" => 0,
		),
		array (
			'title' => __('Minimize CSS', 'activis-redux'),
			'subtitle' => __('Use minimized CSS code for better performance.', 'activis-redux'),
			'id' => 'general_minimize_css',
			'type' => 'switch',
			'on' => __('Enabled', 'activis-redux'),
			'off' => __('Disabled', 'activis-redux'),
			"default" => 0,
		),
	),
));

Redux::setSection( $opt_name, array(
	'title'  => __( 'CSS / JavaScript', 'activis-redux' ),
	'icon'   => 'fal fa-code',
	'fields' => array(
		array (
			'title' => __('Custom CSS', 'activis-redux'),
			'subtitle' => __('Paste your custom CSS code here.', 'activis-redux'),
			'id' => 'custom_css',
			'type' => 'ace_editor',
			'mode' => 'css',
		),
		array (
			'title' => __('Header JavaScript Code', 'activis-redux'),
			'subtitle' => __('Paste your custom JavaScript code you might want to add to be loaded in the header of your site.', 'activis-redux'),
			'id' => 'header_js',
			'type' => 'ace_editor',
			'mode' => 'javascript',
		),
		array (
			'title' => __('Footer JavaScript Code', 'activis-redux'),
			'subtitle' => __('Paste your custom JavaScript code you might want to add to be loaded in the footer of your site.', 'activis-redux'),
			'id' => 'footer_js',
			'type' => 'ace_editor',
			'mode' => 'javascript',
		),
	)
));

Redux::setSection( $opt_name, array(
	'title'      => __( 'Analytics', 'activis-redux' ),
	'icon'       => 'fal fa-chart-line',
	'subsection' => false,
	'fields'     => array(
		array (
			'title' => __('Google API Key', 'activis-redux'),
			'subtitle' => '',
			'id' => 'analytics_google_api_key',
			'type' => 'text',
		),
		array (
			'title' => __('Google Analytics Code', 'activis-redux'),
			'subtitle' => '',
			'id' => 'analytics_google_analytics_code',
			'type'=> 'ace_editor',
			'mode' => 'javascript',
		),
		array (
			'title' => __('Google Tag Manager Code (Head)', 'activis-redux'),
			'subtitle' => '',
			'id' => 'analytics_google_tag_manager_code_head',
			'type'=> 'ace_editor',
			'mode' => 'javascript',
		),
		array (
			'title' => __('Google Tag Manager Code (Body)', 'activis-redux'),
			'subtitle' => '',
			'id' => 'analytics_google_tag_manager_code_body',
			'type'=> 'ace_editor',
			'mode' => 'javascript',
		),
	)
));


if ( file_exists( dirname( __FILE__ ) . '/../../README.md' ) ) {
	$section = array (
		'title'  => __( 'Change log', 'activis-redux' ),
		'icon'   => 'fal fa-code-branch',
		'fields' => array(
			array(
				'id'       => 'changelog',
				'type'     => 'raw',
				'markdown' => true,
				'content_path' => dirname( __FILE__ ) . '/../../README.md', // FULL PATH, not relative please
			),
		),
	);
	Redux::setSection( $opt_name, $section );
}

/*
 * <--- END SECTIONS
 */
