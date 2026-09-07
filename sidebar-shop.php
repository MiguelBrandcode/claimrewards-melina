<?php
/**
 * The sidebar containing WooCommerce widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Melina
 */

$woocommerce_sidebar_position = get_theme_mod( 'woocommerce_sidebar_position', 'right' );
$sticky_sidebar = get_theme_mod( 'sticky_sidebar', 'enable' );

if ( ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === $woocommerce_sidebar_position ) && ! is_customize_preview() ) {
	return;
}
?>

<aside id="secondary" class="woocommerce-sidebar<?php if ( 'enable' === $sticky_sidebar ) : ?> sidebar--sticky<?php endif; ?>">
	<div class="widget-area">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- .widget-area -->
</aside><!-- #secondary -->
