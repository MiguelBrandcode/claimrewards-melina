<?php
/**
 * Template part for displaying gallery post cards.
 *
 * @package Melina
 */

?>

<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail post-card--gallery<?php endif; ?>">
	<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 867px, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 660px, (max-width: 1023px) 741px, 732px' ), true ); ?>

	<div class="post-card__body<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card__overlay<?php endif; ?>">
		<?php
		the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		melina_postcard_meta();

		if ( ! has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="post-card__content">
				<?php
				$content = get_the_content( '' );
				$content = strip_tags( $content );

				echo mb_substr( $content, 0, 325 ) . '&hellip;'; ?>
			</div>
		<?php
		endif; ?>
	</div>
</article><!-- .post-card -->
