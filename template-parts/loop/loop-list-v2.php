<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Full-width list layout".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div class="loop-container loop-container--list">

	<?php /* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<article class="post-card post-card--gorizontal<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
			<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 1023px) 404px, 600px' ), true ); ?>

			<div class="post-card__body">
				<?php
				melina_postcard_meta();
				the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

				if ( ! post_password_required() ) : ?>
					<div class="post-card__content">
						<?php
						$content = get_the_content( '' );
						$content = strip_tags( $content );

						if ( has_post_thumbnail() ) {
							echo mb_substr( $content, 0, 200 ) . '&hellip;';
						} else {
							echo mb_substr( $content, 0, 300 ) . '&hellip;';
						} ?>
					</div>
				<?php
				endif;

				melina_postcard_footer(); ?>
			</div>
		</article><!-- .post-card -->

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
