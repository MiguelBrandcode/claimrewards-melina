<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Melina
 */

get_header(); ?>

<div id="content-area" class="content-area">
	<div class="container">
		<main id="primary" class="main-content">

			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page__title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php
				endif;

				/* Start the Loop */
				$content_layout = get_theme_mod( 'content_layout', 'classic' );
				get_template_part( 'template-parts/loop/loop', $content_layout );

			// If no content, include the "No posts found" template.
			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif; ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .container -->
</div><!-- #content-area -->

<?php
get_footer();
