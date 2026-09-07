<?php
/**
 * Template part for displaying posts from the fourth category for magazine page.
 *
 * @package Melina
 */

global $melinacounter;
$category = get_theme_mod( 'magazine_section_' . $melinacounter, 'none' );
?>

<?php
// Params for our query.
$query_args = array (
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'cat'                 => $category,
	'posts_per_page'      => '5',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'meta_query'          => array (
		'relation'  => 'OR',
		array (
			'key'     => 'display_location_select',
			'compare' => '!=',
			'value'   => 'featured_area',
		),
		array (
			'key'     => 'display_location_select',
			'compare' => 'NOT EXISTS',
		),
	),
);

// The Query.
$query_category_posts = new WP_Query( $query_args );

if ( $query_category_posts->have_posts() ) : ?>

	<div id="magazine-section-<?php echo esc_attr( $melinacounter ); ?>" class="magazine-section magazine-section--<?php echo esc_attr( $melinacounter ); ?>">
		<div class="container">
			<div class="magazine-section__content">
				<div id="magazine-section-carousel" class="magazine-section__carousel carousel">

					<?php // Start the loop.
					while ( $query_category_posts->have_posts() ) : $query_category_posts->the_post(); ?>

						<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail post-card--image<?php endif; ?>">
							<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 867px, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, (max-width: 1439px) 1172px, 100vw' ), true ); ?>

							<div class="post-card__body<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card__overlay<?php endif; ?>">
								<?php
								melina_postcard_meta();
								the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

								if ( ! post_password_required() ) : ?>
									<div class="post-card__content">
										<?php
										$content = get_the_content( '' );
										$content = strip_tags( $content );
										echo mb_substr( $content, 0, 120 ) . '&hellip;'; ?>
									</div>
								<?php
								endif;

								melina_postcard_footer(); ?>
							</div>
						</article><!-- .post-card -->

					<?php // End the loop.
					endwhile; ?>
				</div><!-- .carousel -->
			</div><!-- .magazine-section__content -->
		</div><!-- .container -->
	</div><!-- .magazine-section -->

<?php
endif;

// Restore original Post Data
wp_reset_postdata();
