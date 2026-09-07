<?php
/**
 * The front page template file.
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Melina
 */

get_header(); ?>

<div id="content-area" class="content-area">
	<main id="primary" class="main-content">

		<?php
		// Show the selected front page content.
		if ( have_posts() ) :

			/**
			 * Functions hooked in to melina_front_page action:
			 *
			 * @hooked melina_magazine_page_sections - 10
			 */
			do_action( 'melina_front_page' );

		// If no content, include the "No posts found" template.
		else : ?>

			<div class="container container--content-none">
				<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
			</div><!-- .container. -->

		<?php
		endif; ?>

	</main><!-- #primary -->
</div><!-- #content-area -->

<?php
get_footer();
