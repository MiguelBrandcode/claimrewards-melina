<?php
/**
 * The template for displaying WP Instagram Widget in the footer.
 *
 * @package Melina
 */

if ( ! is_active_sidebar( 'footer-5' ) && ! is_customize_preview() ) {
	return;
}
?>

<aside id="instagram-area" class="instagram-area">
	<?php
	if ( is_active_sidebar( 'footer-5' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'footer-5' ); ?>
		</div><!-- .widget-area -->
	<?php
	endif; ?>
</aside><!-- .instagram-area -->
