<?php
/*
 * Template Name: Landing Page
 */
add_action( 'genesis_meta', 'cloudweb_landing_page_genesis_meta' );
add_action( 'widgets_init', 'cloudweb_remove_header_right', 9999 );

function cloudweb_remove_header_right() {
	unregister_sidebar( 'header-right' );
}

function cloudweb_landing_page_genesis_meta() {
	$header_primary_nav = get_priority( 'genesis_header', 'genesis_do_nav' );
	$primary_nav        = get_priority( 'genesis_after_header', 'genesis_do_nav' );
	$secondary_nav      = get_priority( 'genesis_after_header', 'genesis_do_subnav' );
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	remove_action( 'genesis_after_header', 'genesis_do_subnav', $secondary_nav );
	remove_action( 'genesis_after_header', 'genesis_do_nav', $primary_nav );
	remove_action( 'genesis_header', 'genesis_do_nav', $header_primary_nav );
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
}

function get_priority( $hook_name, $action_name ) {
	global $wp_filter;
	$has_action = false;
	foreach ( $wp_filter[ $hook_name ]->callbacks as $priority => $callbacks ) {
		foreach ( $callbacks as $callback ) {
			if ( $callback['function'] == $action_name ) {
				$has_action = $priority;
			}
		}
	}

	return $has_action;
}


genesis();

