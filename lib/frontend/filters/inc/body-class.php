<?php
/**
 *
 * Conditionally add body class.
 *
 * @package CloudWeb\LandingPage
 * @author  Valentin Zmaranda
 * @license GPL-2.0+
 * @link    https://www.cloudweb.ch/
 */

namespace CloudWeb\LandingPage;

use function is_page_template;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
function body_class( $classes ) {

	if ( is_page_template( 'cloudweb-landing-page.php' ) || is_page_template( 'genesis-landing-page.php' ) ) {
		$classes[] = 'cloudweb-landing-page';
	}

	return $classes;
}
