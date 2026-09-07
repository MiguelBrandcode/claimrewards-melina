<?php
/**
 * The template for displaying social menu.
 *
 * @package Melina
 */

?>

<nav id="social-navigation" class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'melina' ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'social-menu',
		'menu_class'     => 'menu--social',
		'depth'          => 1,
		'link_before'    => '<span class="screen-reader-text">',
		'link_after'     => '</span>',
	) ); ?>
</nav><!-- .social-navigation -->
