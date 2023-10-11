<?php
/**
 *
 * Load the frontend files.
 *
 * @package CloudWeb\LandingPage
 * @author  Valentin Zmaranda
 * @license GPL-2.0+
 * @link    https://www.cloudweb.ch/
 */

namespace CloudWeb\LandingPage;

function load_frontend_files() {
	$files = [ 'filters/index.php' ];

	foreach ( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}

load_frontend_files();