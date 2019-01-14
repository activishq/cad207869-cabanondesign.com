<?php
/*
*
*	Activis Custom CSS Feature
*	------------------------------------------------
* 	Copyright Activis - http://www.activis.ca
*
*
*/


/* Get customisation variables
================================================== */
global $post;

$options 						= activis_options();

// Header
$header_initial_height			= $options['header_initial_height'];
$header_resized_height			= $options['header_resized_height'];
$header_brand_width				= $options['header_brand_width'];
$header_brand_width_resized		= $options['header_brand_width_resized'];

// Custom CSS
$custom_css                  	= $options['custom_css'];
