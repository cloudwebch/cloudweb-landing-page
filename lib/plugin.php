<?php
/**
 * Plugin & Autoload & Install/Uninstall functions
 *
 * @package     CloudWeb\LandingPage
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

/**
 * Autoload plugin files.
 *
 * @return void
 * @since 1.0.0
 *
 */
function autoload() {
	$files = array(
		'admin/index.php',
		'frontend/index.php',
	);

	foreach ( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}

autoload();

function plugin_activation() {
	if ( ! is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
		deactivate_plugins( plugin_basename( LANDINGPAGE_PLUGIN ) ); // Deactivate ourself
		wp_die( __( 'You must install and activate Gravity Forms first.', 'cloudWeb-landing-page' ) );
	}
}

function plugin_install( $network_wide ) {
	global $wpdb;

	// Check if the plugin is being network-activated or not.
	if ( $network_wide ) {
		// Retrieve all site IDs from this network (WordPress >= 4.6 provides easy to use functions for that).
		if ( function_exists( 'get_sites' ) && function_exists( 'get_current_network_id' ) ) {
			$site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );
		} else {
			$site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
		}

		// Install the plugin for all these sites.
		foreach ( $site_ids as $site_id ) {
			switch_to_blog( $site_id );
			plugin_activation();
			restore_current_blog();
		}
	} else {
		plugin_activation();
	}
}


/**
 * Register the plugin.
 *
 * @param string $plugin_file
 *
 * @return void
 * @since 1.0.0
 *
 */
function register_plugin( $plugin_file ) {
	register_activation_hook( $plugin_file, __NAMESPACE__ . '\plugin_install' );
}

register_plugin( LANDINGPAGE_PLUGIN );

