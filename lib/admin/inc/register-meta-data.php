<?php
/**
 * Register Plugin Meta Data
 *
 * @package     CloudWeb\LandingPage\RegisterMetaData
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage\RegisterMetaData;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

function plugin_init() {

	register_setting(
		'cloudweb-landing-page-settings',
		'cloudweb-landing-page-settings_data',
		array(
			'type'          => 'object',
			'default'       => array(
				'_logo'     => 0,
				'_bg-color' => '',
			),
			'auth_callback' => function ( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
				return current_user_can( 'edit_post', $post_id );
			},
			'show_in_rest'  => array(
				'schema' => array(
					'type'       => 'object',
					'properties' => array(
						'_logo'     => array(
							'type' => 'integer',
						),
						'_bg_color' => array(
							'type' => 'string',
						),
					),
				),
			),
		)
	);
}

add_action( 'init', __NAMESPACE__ . '\plugin_init' );