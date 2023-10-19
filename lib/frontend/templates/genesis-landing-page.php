<?php
/*
 * Template Name: Landing Page
 */


add_action( 'genesis_meta', 'cw_lp_genesis_meta' );
add_action( 'widgets_init', 'cw_lp_remove_header_right', 9999 );

function cw_lp_remove_header_right() {
	unregister_sidebar( 'header-right' );
}

function cw_lp_genesis_meta() {
	$header_primary_nav = cw_lp_get_priority( 'genesis_header', 'genesis_do_nav' );
	$primary_nav        = cw_lp_get_priority( 'genesis_after_header', 'genesis_do_nav' );
	$secondary_nav      = cw_lp_get_priority( 'genesis_after_header', 'genesis_do_subnav' );
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	add_filter( 'genesis_attr_site-header', 'cw_lp_get_bg_color' );
	remove_action( 'genesis_after_header', 'genesis_do_subnav', $secondary_nav );
	remove_action( 'genesis_after_header', 'genesis_do_nav', $primary_nav );
	remove_action( 'genesis_header', 'genesis_do_nav', $header_primary_nav );
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	add_action( 'genesis_site_title', 'cw_lp_get_the_logo', 0 );
}

function cw_lp_get_bg_color( $attributes ) {
	$lp_options = get_option( 'cloudweb-landing-page-settings_data' );
	$bg_color   = $lp_options['_bg_color'];
	if ( ! $bg_color ) {
		return $attributes;
	}
	$attributes['style'] = sprintf( '--header-background-color: %s;', $bg_color );

	return $attributes;

}

function cw_lp_get_the_logo() {
	$lp_options = get_option( 'cloudweb-landing-page-settings_data' );
	$logo_id    = $lp_options['_logo'];

	echo $lp_options['_logo'] ?
		sprintf( '<a href="%s" title="%s">%s</a>',
			esc_url( trailingslashit( home_url() ) ),
			esc_attr( get_bloginfo( 'description' ) ),
			wp_get_attachment_image( $logo_id, 'full' )
		)
		: get_custom_logo();
}

function cw_lp_get_priority( $hook_name, $action_name ) {
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

