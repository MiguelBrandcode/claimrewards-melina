<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Melina
 */

get_header(); ?>

<div id="content-area" class="content-area">
	<div class="container">
		<main id="primary" class="main-content">

			<?php /* Start the Loop */
			while ( have_posts() ) : the_post();

				do_action( 'melina_single_post_before' );

				// Include the post content template.
				get_template_part( 'template-parts/post/content', get_post_format() );

				/**
				 * Functions hooked in to melina_single_post_after action:
				 *
				 * @hooked melina_author_info     - 10
				 * @hooked melina_content_widgets - 20
				 */
				do_action( 'melina_single_post_after' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop. ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .container -->
</div><!-- #content-area -->

<?php
get_footer();
