<?php
/**
 * Template Name: Landing Page
 *
 * @package CloudWeb\LandingPage
 * @since 1.0.0
 */
?>
<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

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
    <header class="site-header" itemscope="" itemtype="https://schema.org/WPHeader">
        <div class="wrap">
            <div class="site-branding"><?php echo get_custom_logo(); ?></div>
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
