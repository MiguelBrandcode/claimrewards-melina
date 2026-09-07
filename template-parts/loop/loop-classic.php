<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Classic layout".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' );

/* Start the Loop */
while ( have_posts() ) : the_post();

	/*
	 * Include the Post-Format-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
	 */
	if ( is_search() ) :
		get_template_part( 'template-parts/post/content', 'search' );
	else :
		get_template_part( 'template-parts/post/content', get_post_format() );
	endif;

endwhile;

/**
 * Functions hooked in to melina_loop_after action:
 *
 * @hooked melina_pagination - 10
 */
do_action( 'melina_loop_after' );
