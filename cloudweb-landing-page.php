<?php
/**
 * Plugin Name:       CloudWEB Landing Page
 * Description:       Add new template for landing page and new patterns blocks for Gutenberg.
 * Requires at least: 6.3
 * Requires PHP:      8.0
 * Version:           1.2.0
 * Author:            cloudWEB GmbH
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       poll
 *
 * @package           cloudweb-landing-page
 */

namespace Cloudweb\LandingPage;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

define( 'LANDINGPAGE_PLUGIN', __FILE__ );
define( 'LANDINGPAGE_PLUGIN_DIR', trailingslashit( __DIR__ ) );
define( 'LANDINGPAGE_PLUGIN_PATH', plugin_dir_path( LANDINGPAGE_PLUGIN ) );
define( 'LANDINGPAGE_PLUGIN_BASE', plugin_basename( LANDINGPAGE_PLUGIN ) );
$plugin_url = plugin_dir_url( __FILE__ );
if ( is_ssl() ) {
	$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
}

define( 'LANDINGPAGE_PLUGIN_URL', $plugin_url );
define( 'LANDINGPAGE_PLUGIN_ASSETS_URL', trailingslashit( LANDINGPAGE_PLUGIN_URL ) . 'assets/build/' );
define( 'LANDINGPAGE_PLUGIN_TEXT_DOMAIN', 'cloudWeb-landing-page' );

include( __DIR__ . '/lib/update.php' );
include( __DIR__ . '/lib/plugin.php' );

