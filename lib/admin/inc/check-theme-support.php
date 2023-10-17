<?php
/**
 * Enqueue assets
 *
 * @package     CloudWeb\LandingPage\ChechThemeSupport
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage\ChechThemeSupport;

function add_logo_support() {
	if ( ! current_theme_supports( 'custom-logo' ) ) {
		add_theme_support( 'custom-logo' );
	}
}

add_action( 'init', __NAMESPACE__ . '\add_logo_support' );