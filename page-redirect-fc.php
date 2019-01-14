<?php
/*
	Template name: First Child Redirect
*/

$childs = get_pages("child_of=".$post->ID."&sort_column=menu_order");

if ( $childs ) :
	$first_child = $childs[0];
	wp_redirect( get_permalink( $first_child->ID ) );
endif;
