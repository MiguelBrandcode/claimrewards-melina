<?php
/**
 * The template for displaying header menu.
 *
 * @package Melina
 */

?>

<button id="menu-toggle" class="button--menu-toggle">
	<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'melina' ); ?></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>

<nav id="header-menu" class="header__menu" aria-label="<?php esc_attr_e( 'Header Menu', 'melina' ); ?>">
	<?php
	if ( has_nav_menu( 'header-menu' ) ) :
		wp_nav_menu( array(
			'theme_location' => 'header-menu',
			'menu_id'        => 'menu-primary',
			'menu_class'     => 'header__menu--primary',
		) );
	endif; ?>

	<ul id="menu-secondary" class="header__menu--secondary">
		<?php do_action( 'melina_menu_secondary_search_before' ); ?>
		<li id="menu-item-search" class="menu-item menu-item--search">
			<a href="#"><span><?php esc_html_e( 'Search', 'melina' ); ?></span></a>
		</li>
		<?php do_action( 'melina_menu_secondary_search_after' ); ?>
	</ul>
</nav><!-- .header__menu -->
