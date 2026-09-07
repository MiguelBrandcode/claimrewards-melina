<?php
/**
 * The template for displaying image attachments.
 *
 * @package Melina
 */

get_header(); ?>

<div id="content-area" class="content-area">
	<div class="container">
		<main id="primary" class="main-content">

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<nav id="image-navigation" class="navigation image-navigation">
						<div class="nav-links">
							<div class="nav-previous"><?php previous_image_link( false, esc_html__( 'Previous Image', 'melina' ) ); ?></div>
							<div class="nav-next"><?php next_image_link( false, esc_html__( 'Next Image', 'melina' ) ); ?></div>
						</div><!-- .nav-links -->
					</nav><!-- .image-navigation -->

					<header class="entry__header">
						<?php
						melina_entry_meta();

						the_title( '<h1 class="entry__title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry__content">
						<div class="entry__attachment">
							<?php
							/**
							 * Filter the default melina image attachment size.
							 *
							 * @param string $image_size Image size. Default 'large'.
							 */
							$image_size = apply_filters( 'melina_attachment_size', 'large' );

							echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>

							<?php the_excerpt( 'entry__caption' ); ?>
						</div><!-- .entry__attachment -->

						<?php
						the_content();

						/**
						 * Functions hooked in to melina_post_content_bottom action:
						 *
						 * @hooked melina_page_links - 10
						 */
						do_action( 'melina_post_content_bottom' ); ?>
					</div><!-- .entry-content -->

					<footer class="entry__footer">
						<?php
						// Retrieve attachment metadata.
						$metadata = wp_get_attachment_metadata();

						if ( $metadata ) {
							printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
								esc_html_x( 'Full size', 'Used before full size attachment link.', 'melina' ),
								esc_url( wp_get_attachment_url() ),
								absint( $metadata['width'] ),
								absint( $metadata['height'] )
							);
						} ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

				<?php
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => wp_kses( _x( '<span class="nav-link-meta"><span class="meta-nav">Published in</span><span class="post-title">%title</span></span>', 'Parent post link', 'melina' ), array( 'span' => array( 'class' => array() ) ) ),
				) );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop. ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .container -->
</div><!-- #content-area -->

<?php
get_footer();
