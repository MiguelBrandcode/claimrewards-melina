<?php
/**
 * Template part for displaying gallery posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Melina
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php
		melina_entry_meta();

		if ( is_singular() ) :
			the_title( '<h1 class="entry__title">', '</h1>' );
		else :
			the_title( '<h2 class="entry__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; ?>
	</header><!-- .entry__header -->

	<?php
	if ( '' !== get_the_post_thumbnail() && ! get_post_gallery() || is_single() ) :
		melina_post_thumbnail();
	endif;

	// If not a single post, highlight the gallery.
	if ( ! is_single() ) {
		if ( get_post_gallery() ) {
			echo '<div class="entry__gallery">';
			echo get_post_gallery();
			echo '</div>';
		}
	}

	melina_excerpt();

	if ( is_single() || ( ! get_post_gallery() && ! has_excerpt() ) ) : ?>
		<div class="entry__content">
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'melina' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			/**
			 * Functions hooked in to melina_post_content_bottom action:
			 *
			 * @hooked melina_page_links - 10
			 */
			do_action( 'melina_post_content_bottom' ); ?>
		</div><!-- .entry__content -->
	<?php
	endif;

	melina_entry_footer(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
