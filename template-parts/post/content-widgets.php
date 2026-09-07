<?php
/**
 * The template for displaying widgets before the comments on posts.
 *
 * @package Melina
 */

if ( ! is_active_sidebar( 'content-1' ) ) {
	return;
}
?>

<aside id="content-widgets" class="content-widgets">
	<?php
	if ( is_active_sidebar( 'content-1' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'content-1' ); ?>
		</div><!-- .widget-area -->
	<?php
	endif; ?>
</aside><!-- .content-widgets -->
