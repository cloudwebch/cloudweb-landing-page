<?php
/**
 * Template Name: Landing Page
 *
 * @package CloudWeb\LandingPage
 * @since 1.0.0
 */
//d( get_option( 'cloudweb-landing-page-settings_data' ) );
$inline_style        = '';
$cloudweb_lp_options = get_option( 'cloudweb-landing-page-settings_data' );
$logo_id             = $cloudweb_lp_options['_logo'];
$logo_img            = $cloudweb_lp_options['_logo'] ? wp_get_attachment_image( $logo_id, 'full' ) : get_custom_logo();
//$logo_url            = wp_get_attachment_image_url( $logo_id, 'full' );
//$logo_alt            = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
$background_color = $cloudweb_lp_options['_bg_color'];

if ( $background_color ) {
	$inline_style = sprintf( 'style="--header-background-color: %s;"', $background_color );
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site">
    <a class="skip-link screen-reader-text" href="#main">
		<?php
		/* translators: Hidden accessibility text. */
		esc_html_e( 'Skip to content', 'cloudweb-landing-page' );
		?>
    </a>
    <header class="site-header" itemscope="" itemtype="https://schema.org/WPHeader" <?php echo $inline_style; ?>>
        <div class="wrap">
            <div class="site-branding"><?php echo $logo_img ?></div>
        </div>
    </header>
    <div class="site-content">
        <div class="content-area">
            <main id="main" class="site-main" role="main">
                <article class="<?php echo esc_attr( implode( ' ', get_post_class() ) ); ?>"
                         aria-label="<?php echo get_the_title(); ?>" itemscope=""
                         itemtype="https://schema.org/CreativeWork">
                    <div class="entry-content" itemprop="text">
						<?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
						?>
                    </div>
                </article>
            </main>
        </div>
    </div>
	<?php get_footer(); ?>
</div>
</body>
</html>
