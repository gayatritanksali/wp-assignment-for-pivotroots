<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
	<link rel='stylesheet' href='<?php echo get_template_directory_uri() ?>/lsb.css' type='text/css' media='all'/>
	<link rel='stylesheet' id='custom-css' href='<?php echo get_template_directory_uri() ?>/custom.css' type='text/css' media='all'/>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/js/lsb.min.js"></script>
	<script>
      $(window).load(function() {
        $.fn.lightspeedBox();
      });
    </script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentynineteen' ); ?></a>

		<header id="masthead" class="<?php echo is_singular() && twentynineteen_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; ?>">

			<div class="site-branding-container">
				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
			</div><!-- .site-branding-container -->

			<?php if ( is_singular() && twentynineteen_can_show_post_thumbnail() ) : ?>
				<div class="site-featured-image">
					<?php
						twentynineteen_post_thumbnail();
						the_post();
						$discussion = ! is_page() && twentynineteen_can_show_post_thumbnail() ? twentynineteen_get_discussion_data() : null;

						$classes = 'entry-header';
					if ( ! empty( $discussion ) && absint( $discussion->responses ) > 0 ) {
						$classes = 'entry-header has-discussion';
					}
					?>
					<div class="<?php echo $classes; ?>">
						<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
					</div><!-- .entry-header -->
					<?php rewind_posts(); ?>
				</div>
			<?php endif; ?>
		</header><!-- #masthead -->

	<div id="content" class="site-content">
