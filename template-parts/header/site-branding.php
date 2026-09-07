<?php
/**
 * The template for displaying site branding.
 *
 * @package Melina
 */

?>

<div class="site__branding">
	<?php
	melina_the_custom_logo();

	if ( is_front_page() ) : ?>
		<h1 class="site__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<?php
	else : ?>
		<p class="site__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
	<?php
	endif; ?>
</div><!-- .site__branding -->
