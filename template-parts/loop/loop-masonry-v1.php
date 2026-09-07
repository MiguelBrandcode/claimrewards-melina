<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Three-column full-width masonry layout".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div id="loop-masonry-v1" class="loop-container loop-container--masonry masonry">

	<?php /* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<div class="masonry__item js-masonry-item">
			<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php melina_post_thumbnail_uncropped( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 364px' ) ); ?>

				<div class="post-card__body">
					<?php
					melina_postcard_meta();
					the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

					if ( ! post_password_required() && ! has_post_thumbnail() ) : ?>
						<div class="post-card__content">
							<?php
							$content = get_the_content( '' );
							$content = strip_tags( $content );
							echo mb_substr( $content, 0, 220 ) . '&hellip;'; ?>
						</div>
						<?php
						melina_postcard_footer();

					endif; ?>
				</div>
			</article><!-- .post-card -->
		</div><!-- .masonry__item -->

	<?php
	endwhile; ?>

</div><!-- .loop-container -->

<?php
/**
 * Functions hooked in to melina_loop_after action:
 *
 * @hooked melina_pagination - 10
 */
do_action( 'melina_loop_after' );
