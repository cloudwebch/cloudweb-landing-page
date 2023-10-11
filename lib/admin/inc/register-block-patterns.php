<?php
/**
 * Register Plugin Block Patterns
 *
 * @package     CloudWeb\LandingPage\RegisterPatterns
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage\RegisterPatterns;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

function register_patterns() {
	$demo_cover_image                = trailingslashit( LANDINGPAGE_PLUGIN_URL ) . 'assets/images/cover-bg.png';
	$with_cover_gravity_form_pattern = sprintf( '<!-- wp:cover {"url":"%1$s","dimRatio":0.5,"isDark":false,"align":"full","className":"wp-block-gravity-forms-cover"} -->
<div class="wp-block-cover alignfull is-light wp-block-gravity-forms-cover"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="%1$s" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","placeholder":"Cover heading"} -->
<h2 class="wp-block-heading has-text-align-center"></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","placeholder":"Cover sub headline"} -->
<p class="has-text-align-center"></p>
<!-- /wp:paragraph -->

<!-- wp:gravityforms/form {"formId":"","inputPrimaryColor":"#204ce5"} /--></div></div>
<!-- /wp:cover -->', esc_url( $demo_cover_image ) );

	register_block_pattern_category(
		'landing-page',
		array( 'label' => __( 'Landing Page', 'cloudWeb-landing-page' ) )
	);


	register_block_pattern(
		'cloudWeb/with-cover-gravity-forms',
		array(
			'title'         => __( 'Cover With Gravity Form', 'cloudWeb-landing-page' ),
			'description'   => _x( 'Contain cover block with Gravity Form inside', 'Block pattern description', 'cloudWeb-landing-page' ),
			'content'       => $with_cover_gravity_form_pattern,
			'templateTypes' => array( 'cloudweb-landing-page.php', 'genesis-landing-page.php' ),
			'source'        => 'plugin',
			'categories'    => array( 'landing-page' ),
		)
	);
}

add_action( 'init', __NAMESPACE__ . '\register_patterns' );