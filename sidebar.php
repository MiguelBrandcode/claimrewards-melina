<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Melina
 */

$sidebar_position = get_theme_mod( 'sidebar_position', 'right' );
$sticky_sidebar = get_theme_mod( 'sticky_sidebar', 'enable' );

if ( ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === $sidebar_position ) && ! is_customize_preview() ) {
	return;
}

$content_layout = get_theme_mod( 'content_layout', 'classic' );
$content_layout_without_sidebar = array(
	'list-v2',
	'list-v4',
	'list-v6',
	'grid-v2',
	'grid-v4',
	'grid-v6',
	'grid-v7',
	'grid-v8',
	'grid-v9',
	'grid-v10',
	'masonry-v1',
	'masonry-v2',
);

if ( ! is_singular() && in_array( $content_layout, $content_layout_without_sidebar ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar<?php if ( 'enable' === $sticky_sidebar ) : ?> sidebar--sticky<?php endif; ?>">
	<div class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- .widget-area -->
</aside><!-- #secondary -->
