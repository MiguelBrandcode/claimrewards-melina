<?php
/**
 * Template part for displaying default post cards.
 *
 * @package Melina
 */

?>

<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
	<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 364px' ), true ); ?>

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
					echo mb_substr( $content, 0, 120 ) . '&hellip;';
				} else {
					echo mb_substr( $content, 0, 220 ) . '&hellip;';
				} ?>
			</div>
		<?php
		endif;

		melina_postcard_footer(); ?>
	</div>
</article><!-- .post-card -->
