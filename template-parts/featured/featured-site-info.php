<?php
/**
 * The template for displaying tagline and header image.
 *
 * @package Melina
 */

$description = get_bloginfo( 'description', 'display' );
?>

<?php
if ( get_header_image() || $description || is_customize_preview() ) : ?>

	<div id="featured-content-area" class="featured-content-area">
		<div class="featured featured--site-info<?php if ( get_header_image() ) : ?> featured--has-header-image<?php endif; ?><?php if ( $description ) : ?> featured--has-site-description<?php endif; ?>">
			<div class="container">

				<?php
				if ( get_header_image() ) :
					/**
					 * Filter the default Melina custom header sizes attribute.
					 *
					 * @param string $custom_header_sizes sizes attribute
					 * for Header Image. Default '(max-width: 479px) 777px, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, 100vw'.
					 */
					$custom_header_sizes = apply_filters( 'melina_custom_header_sizes', '(max-width: 479px) 777px, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, 100vw' ); ?>

					<div class="featured__header-image">
						<img src="<?php header_image(); ?>"
								 srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, array( 1920, 1280 ) ) ); ?>"
								 sizes="<?php echo esc_attr( $custom_header_sizes ); ?>"
								 width="<?php echo esc_attr( get_custom_header()->width ); ?>"
								 height="<?php echo esc_attr( get_custom_header()->height ); ?>"
								 alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</div><!-- .featured__header-image -->
				<?php
				endif; // End header image check.

				if ( $description || is_customize_preview() ) : ?>
					<div class="featured__site-description">
						<p class="site-description"><?php echo esc_attr( $description ); /* WPCS: xss ok. */ ?></p>
					</div><!-- .site-description__holder -->
				<?php
				endif; ?>

			</div><!-- .container -->
		</div><!-- .featured -->
	</div><!-- .featured-content-area -->

<?php
endif; ?>
