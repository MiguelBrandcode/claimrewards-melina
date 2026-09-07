<?php
/**
 * The template for displaying post navigation.
 *
 * @package Melina
 */

?>

<div id="post-navigation-area" class="post-navigation-area">
	<div class="container">

		<?php // Previous/next post navigation.
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next post', 'melina' ) . '</span> ' .
				'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'melina' ) . '</span> ' .
				'<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous post', 'melina' ) . '</span> ' .
				'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'melina' ) . '</span> ' .
				'<span class="post-title">%title</span>',
		) ); ?>

	</div><!-- .container -->
</div><!-- .post-navigation-area -->
