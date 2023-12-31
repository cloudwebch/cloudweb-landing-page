<?php
/**
 * Enqueue assets
 *
 * @package     CloudWeb\LandingPage\EnqueueAssets
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage\EnqueueAssets;

use function is_page_template;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

/**
 * Gutenberg scripts and styles
 *
 */
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\gutenberg_scripts' );

function gutenberg_scripts() {
	$variations_asset_file_path = LANDINGPAGE_PLUGIN_PATH . 'assets/build/js/variations.asset.php';
	$plugin_assets_file_path    = LANDINGPAGE_PLUGIN_PATH . 'assets/build/js/plugin.asset.php';
	$demo_cover_image           = trailingslashit( LANDINGPAGE_PLUGIN_URL ) . 'assets/images/cover-bg.png';
	if ( file_exists( $variations_asset_file_path ) ) {
		$variations_assets = require_once $variations_asset_file_path;
		wp_enqueue_style(
			LANDINGPAGE_PLUGIN_TEXT_DOMAIN . '-editor-style',
			LANDINGPAGE_PLUGIN_URL . 'assets/css/editor-style.css',
			array(),
			null
		);

		wp_enqueue_script(
			LANDINGPAGE_PLUGIN_TEXT_DOMAIN . '-blocks',
			LANDINGPAGE_PLUGIN_ASSETS_URL . 'js/variations.js',
			$variations_assets['dependencies'],
			$variations_assets['version'],
			true
		);
		wp_localize_script( LANDINGPAGE_PLUGIN_TEXT_DOMAIN . '-blocks', 'l18n_js_landing_page', array(
			'cover_bg' => $demo_cover_image,
		) );
	}
	if ( file_exists( $plugin_assets_file_path ) ) {
		$plugin_assets = require_once $plugin_assets_file_path;
		wp_enqueue_script(
			LANDINGPAGE_PLUGIN_TEXT_DOMAIN . '-plugin',
			LANDINGPAGE_PLUGIN_ASSETS_URL . 'js/plugin.js',
			$plugin_assets['dependencies'],
			$plugin_assets['version'],
			true
		);
	}
}

function enqueue_assets() {
	$site_size       = 1180;
	$inner_container = 860;
	wp_register_style( 'landing-page-css-handle', [], true );

	if ( is_page_template( 'genesis-landing-page.php' ) || is_page_template( 'cloudweb-landing-page.php' ) ) {
		wp_enqueue_style( 'landing-page-css-handle' );
		$custom_css = <<<CSS
		.cloudweb-landing-page{overflow-x: hidden;}
		hr{margin:0}
		.cloudweb-landing-page .site-header{background-color: var(--header-background-color);display: block;}
		.site-header .wrap{display:flex;}
		.site-branding a{display: block;}
		.site-branding img{display:block;max-width: 180px;width: 100%;height: auto;}
		.cloudweb-landing-page .site-title,.cloudweb-landing-page .site-description{clip: rect(0 0 0 0);clip-path: inset(50%);height: 1px;overflow: hidden;position: absolute;white-space: nowrap;width: 1px;}
		.cloudweb-landing-page .wrap,.cloudweb-landing-page .content-area{width: 100%;float:none;}
		.cloudweb-landing-page .site-content{padding-inline:5%;}
		.cloudweb-landing-page .site-inner,.cloudweb-landing-page .wrap,.cloudweb-landing-page .content-area{ max-width:{$site_size}px;margin-inline:auto; }
		.wrap .title-area{margin-left:0;}
		.cloudweb-landing-page .genesis-responsive-menu{display: none;}
		.cloudweb-landing-page .wp-block-gravity-forms-cover.alignfull,.cloudweb-landing-page .wp-block-gravity-forms-cover.full{margin-inline:-5dvw;width:auto;max-width:none;padding-bottom:100px;}
		body.cloudweb-landing-page .wp-block-gravity-forms-cover.alignfull,body.cloudweb-landing-page .wp-block-gravity-forms-cover.full{margin-inline:-5dvw;width:auto!important;max-width:100dvw;}
		.wp-block-gravity-forms-cover{padding-top: 90px;}
		.wp-block-gravity-forms-cover img{-webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image:gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));}
		.wp-block-gravity-forms-cover .wp-block-cover__inner-container{margin-inline:auto;max-width: {$inner_container}px;}
		.wp-block-gravity-forms-cover .wp-block-heading{margin-bottom:15px;font-size:48px;font-weight:400;}
		.wp-block-gravity-forms-cover .wp-block-heading ~ p{margin-bottom:49px;font-size:25px;font-weight:400;}
		.wp-block-gravity-forms-cover .wp-block-heading:empty,.wp-block-gravity-forms-cover .wp-block-heading ~ p:empty{display: none;}
		.wp-block-gravity-forms-cover .gform_wrapper{background-color: var(--wp-block-gravity-forms-cover--background);padding:33px 5px 33px;box-shadow: 0 7px 8px rgba(0, 0, 0, 0.04), 0 1px 4px rgba(0, 0, 0, 0.12);}
		.wp-block-gravity-forms-cover .gform_title{margin-bottom:15px;font-size:38px;}
		.wp-block-gravity-forms-cover .gform_wrapper .gfield_description{color: #000;font-size:38px;}
		.wp-block-gravity-forms-cover .gform_heading, .wp-block-gravity-forms-cover .gform_wrapper .gfield--type-html,.wp-block-gravity-forms-cover .gform_wrapper .gfield_description{text-align: center;}
		body .wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox{display: flex;flex-direction: row; gap: 22px;flex-wrap: wrap;justify-content: center;margin-bottom:13px;}
		.wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox input {position:absolute;clip:rect(0,0,0,0);}
		.wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox input + label {background-color: var(--gf-color-secondary);border:2px solid var(--gf-ctrl-border-color);color: var(--gf-color-secondary-contrast);margin-inline:0;padding:10px;cursor:pointer;min-width:225px;text-align: center;}
		.wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox input:checked + label, .wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox input + label:hover,.wp-block-gravity-forms-cover .gform_wrapper .ginput_container_checkbox .gfield_checkbox input + label:focus{color: var(--gf-color-secondary-contrast);background-color: var(--gf-ctrl-border-color);}
		.wp-block-gravity-forms-cover .gform_wrapper .gchoice{position:relative;padding-inline-end:0;padding-block-end:0;}
		.wp-block-gravity-forms-cover .gform-theme--foundation .gfield.gf_list_inline .gfield_checkbox .gchoice, .wp-block-gravity-forms-cover .gform-theme--foundation .gfield.gf_list_inline .gfield_radio .gchoice{padding-inline-end:0;padding-block-end:0;}
		.wp-block-gravity-forms-cover .gform_wrapper .gform_footer, .wp-block-gravity-forms-cover .gform_wrapper .gform_page_footer{padding-inline:5%;margin-block:24px;justify-content: center;}
		.wp-block-gravity-forms-cover .gform_wrapper .gform_footer input[type="button"],.wp-block-gravity-forms-cover .gform_wrapper .gform_page_footer input[type="button"]{border-radius:0;font-size:14px;font-weight:400;}
		@media screen and (min-width:1280px) {
			body.cloudweb-landing-page .wp-block-gravity-forms-cover.alignfull, body.cloudweb-landing-page .wp-block-gravity-forms-cover.full{margin-inline: calc(-100vw / 2 + 100% / 2);padding-bottom:200px;}
			.wp-block-gravity-forms-cover .gform_wrapper{padding-inline:60px;}
		};
		CSS;
		wp_add_inline_style( 'landing-page-css-handle', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );