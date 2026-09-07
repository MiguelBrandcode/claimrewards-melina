<?php
/**
 * The template for displaying archive pages.
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
			if ( have_posts() ) : ?>

				<header class="page__header">
					<?php
					the_archive_title( '<h1 class="page__title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				</header><!-- .page__header -->

				<?php /* Start the Loop */
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
