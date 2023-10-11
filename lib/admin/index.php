<?php
/**
 *
 * Load the admin files.
 *
 * @package CloudWeb\LandingPage
 * @author  Valentin Zmaranda
 * @license GPL-2.0+
 * @link    https://www.cloudweb.ch/
 */

namespace CloudWeb\LandingPage;

function load_admin_files() {
	$files = array(
		'add-page-template.php',
		'enqueue-assets.php',
		'register-block-patterns.php',
	);

	foreach ( $files as $file ) {
		include( __DIR__ . '/inc/' . $file );
	}
}

load_admin_files();