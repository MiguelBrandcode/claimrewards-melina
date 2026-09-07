<?php
/**
 * Template part for displaying posts from the first category for magazine page.
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

if ( $query_category_posts->have_posts() ) :
	$i = 0; ?>

	<div id="magazine-section-<?php echo esc_attr( $melinacounter ); ?>" class="magazine-section magazine-section--<?php echo esc_attr( $melinacounter ); ?>">
		<div class="container">
			<header class="magazine-section__header">
				<?php
				echo '<h2 class="magazine-section__title"><a href="' . get_category_link( $category ) . '">' . get_cat_name( $category ) . '</a></h2>';
				echo '<a class="magazine-section__view-all" href="' . get_category_link( $category ) . '">' . esc_html__( 'View All', 'melina' ) . '</a>'; ?>
			</header>

			<div class="magazine-section__content">
				<?php // Start the loop.
				while ( $query_category_posts->have_posts() ) : $query_category_posts->the_post();

					if ( $i % 5 == 2 ) : ?>

						<article class="post-card post-card--tall<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
							<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, 915px' ), true ); ?>

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
							<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 364px' ), true ); ?>

							<div class="post-card__body">
								<?php
								melina_postcard_meta();
								the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

								if ( ! post_password_required() && ! has_post_thumbnail() ) : ?>
									<div class="post-card__content">
										<?php
										$content = get_the_content( '' );
										$content = strip_tags( $content );
										echo mb_substr( $content, 0, 180 ) . '&hellip;'; ?>
									</div>
									<?php
									melina_postcard_footer();

								endif; ?>
							</div>
						</article><!-- .post-card -->

					<?php
					endif;

					$i++;

				// End the loop.
				endwhile; ?>
			</div><!-- .magazine-section__content -->
		</div><!-- .container -->
	</div><!-- .magazine-section -->

<?php
endif;

// Restore original Post Data
wp_reset_postdata();
