<?php
/**
 * The template for displaying footer copyright.
 *
 * @package Melina
 */

$copyright_text = get_theme_mod( 'copyright_text', esc_html__( '©2018. All rights reserved', 'melina' ) );

if ( '' === $copyright_text && true === get_theme_mod( 'hide_theme_author_link' ) && ! is_customize_preview() ) {
	return;
}
?>

<div class="copyright">
	<?php
	if ( '' !== $copyright_text ) : ?>
		<span class="copyright__text">
			<?php echo wp_kses(
				$copyright_text,
				array(
					'a' => array(
						'href' => array(),
						'title' => array(),
					),
					'br' => array(),
					'i'  => array(),
					'em' => array(),
					'b'  => array(),
					'strong' => array(),
				)
			); ?>
		</span>
	<?php
	endif;

	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link();
	}

	/**
	 * Functions hooked in to melina_footer_copyrights action:
	 *
	 * @hooked melina_theme_author_link - 10
	 */
	do_action( 'melina_footer_copyrights' ); ?>
</div><!-- .copyright -->
