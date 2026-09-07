<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Three-column full-width grid layout".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div class="loop-container loop-container--grid">

	<?php /* Start the Loop */
	while ( have_posts() ) : the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called post-card-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'template-parts/post-card/post-card', get_post_format() );

	endwhile; ?>

</div><!-- .loop-container -->

<?php
/**
 * Functions hooked in to melina_loop_after action:
 *
 * @hooked melina_pagination - 10
 */
do_action( 'melina_loop_after' );
