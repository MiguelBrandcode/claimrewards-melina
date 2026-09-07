<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
					<h1 class="page__title"><?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'melina' ), '<span>' . get_search_query() . '</span>' );
					?></h1>
				</header><!-- .page-header -->

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
