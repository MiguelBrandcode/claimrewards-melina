<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Mixed: large and small post cards (full-width)".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div class="loop-container loop-container--grid">

	<?php
	$i = 0;

	/* Start the Loop */
	while ( have_posts() ) : the_post();

	 	if ( $i % 4 == 0 || $i % 4 == 3 ) : ?>

			<article class="post-card post-card--wide<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 641px, (max-width: 1023px) 719px, (max-width: 1279px) 1104px, 768px' ), true ); ?>

				<div class="post-card__body">
					<?php
					melina_postcard_meta();
					the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

					if ( ! post_password_required() && ! has_post_thumbnail() ) : ?>
						<div class="post-card__content">
							<?php
							$content = get_the_content( '' );
							$content = strip_tags( $content );
							echo mb_substr( $content, 0, 330 ) . '&hellip;'; ?>
						</div>
						<?php
						melina_postcard_footer();

					endif; ?>
				</div>
			</article><!-- .post-card -->

		<?php
		else : ?>

			<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 641px, (max-width: 1023px) 719px, (max-width: 1279px) 1104px, 711px' ), true ); ?>

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

		<?php
		endif;

		$i++;
	endwhile; ?>

</div><!-- .loop-container -->

<?php
/**
 * Functions hooked in to melina_loop_after action:
 *
 * @hooked melina_pagination - 10
 */
do_action( 'melina_loop_after' );
