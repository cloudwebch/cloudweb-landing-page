<?php
/**
 * Create and Add Page Template
 *
 * @package     CloudWeb\LandingPage\AddPageTemplate
 * @since       1.0.0
 * @author      cloudweb team @valentin
 * @link        https://www.cloudweb.ch
 * @license     GNU General Public License 2.0+
 *
 */

namespace CloudWeb\LandingPage;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}


class AddPageTemplate {
	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class and init actions and filters.
	 */

	public static function init() {
		$self            = new self();
		$self->templates = array();
		$theme_info      = wp_get_theme();
		$is_theme_block  = $theme_info->is_block_theme();

		$genesis_flavors = array(
			'genesis',
			'genesis-trunk',
		);

		$template_page = ! in_array( $theme_info->Template, $genesis_flavors ) ? 'cloudweb-landing-page.php' : 'genesis-landing-page.php';
		$template_name = ! in_array( $theme_info->Template, $genesis_flavors ) ? 'CloudWeb Landing Page' : 'CloudWeb Landing Page (Genesis)';
		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
			// 4.6 and older
			add_filter( 'page_attributes_dropdown_pages_args', array( $self, 'register_landing_page_template' ) );
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			add_filter( 'theme_page_templates', array( $self, 'landing_page_template' ) );
		}
		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', array( $self, 'register_landing_page_template' ) );
		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter( 'template_include', array( $self, 'view_landing_page' ) );
		// Add templates to this array.
		$self->templates = array( $template_page => $template_name, );

	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */


	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function landing_page_template( $posts_templates ) {
		return array_merge( $posts_templates, $this->templates );
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_landing_page_template( $atts ) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}
		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key, 'themes' );
		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );
		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;
	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_landing_page( $template ) {
		// Return the search template if we're searching (instead of the template for the first result)
		if ( is_search() ) {
			return $template;
		}
		// Get global post
		global $post;
		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}
		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[ get_post_meta(
				$post->ID, '_wp_page_template', true
			) ] ) ) {
			return $template;
		}
		// Allows filtering of file path
		$filepath = apply_filters( 'page_templater_plugin_dir_path', LANDINGPAGE_PLUGIN_PATH . 'lib/frontend/templates/' );
		$file     = $filepath . get_post_meta(
				$post->ID, '_wp_page_template', true
			);
		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		}

		// Return template
		return $template;
	}
}

add_action( 'plugins_loaded', array( 'CloudWeb\LandingPage\AddPageTemplate', 'init' ) );