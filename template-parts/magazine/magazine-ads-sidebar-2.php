<?php
/**
 * Magazine page ads sidebar containing widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Melina
 */

if ( ! is_active_sidebar( 'magazine-ads-sidebar-2' ) && ! is_customize_preview() ) {
	return;
}
?>

<aside id="secondary" class="magazine-ads-sidebar magazine-ads-sidebar--2">
	<div class="container">
		<div class="widget-area">
			<?php dynamic_sidebar( 'magazine-ads-sidebar-2' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .container -->
</aside><!-- #secondary -->
