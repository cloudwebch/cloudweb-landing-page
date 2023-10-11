<?php
/**
 *
 * Load the all theme filters files.
 *
 * @package CloudWeb\LandingPage
 * @author  Valentin Zmaranda
 * @license GPL-2.0+
 * @link    https://www.cloudweb.ch/
 */

namespace CloudWeb\LandingPage;

function load_plugin_filters_files() {
	$filters = [ 'body-class.php' ];

	foreach ( $filters as $filter ) {
		include( __DIR__ . '/inc/' . $filter );
	}
}

load_plugin_filters_files();