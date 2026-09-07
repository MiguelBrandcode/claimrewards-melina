<?php
/**
 * The template for displaying boxed featured posts carousel.
 *
 * @package Melina
 */

?>

<?php if ( melina_has_featured_posts() ) :
	$featured_posts = melina_get_featured_posts(); ?>

	<div id="featured-content-area" class="featured-content-area">
		<div class="featured featured--carousel-v2">
			<div class="container">
				<div id="carousel-v2" class="carousel">

					<?php // Start the loop.
					foreach ( (array) $featured_posts as $order => $post ) :
						setup_postdata( $post ); ?>

						<article class="carousel__item carousel-item<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> carousel-item--has-thumbnail<?php endif; ?>">
							<?php melina_post_thumbnail( 'post-thumbnail', 'carousel-item__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, (max-width: 1279px) 840px, 960px' ), true ); ?>

							<div class="carousel-item__body">
								<?php
								melina_postcard_meta( 'carousel-item__meta' );
								the_title( '<h2 class="carousel-item__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

								if ( ! post_password_required() ) : ?>
									<div class="carousel-item__content">
										<?php
										$content = get_the_content( '' );
										$content = strip_tags( $content );
										echo mb_substr( $content, 0, 120 ) . '&hellip;'; ?>
									</div>
								<?php
								endif;

								melina_postcard_footer( 'carousel-item__footer' ); ?>
							</div><!-- .carousel-item__body -->
						</article>
					<?php
					// End the loop.
					endforeach;

					// Restore original Post Data
					wp_reset_postdata(); ?>

				</div><!-- .carousel -->
			</div><!-- .container -->
		</div><!-- .featured -->
	</div><!-- .featured-content-area -->
<?php endif; ?>
