<?php
/**
 * Prints HTML for related posts.
 */

global $post;
$categories = get_the_category( $post->ID );
$categories_array = '';

if ( $categories ) {
	foreach ( $categories as $category ) {
		$categories_array .= $category->slug . ',';
	}

	// Params for our query.
	$args = array(
		'post_type'           => 'post',
		'post__not_in'        => array( $post->ID ),
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'category_name'       => $categories_array,
		'orderby'             => 'rand'
	);

	// The Query.
	$related_posts = new WP_Query( $args );

	// The loop.
	if ( $related_posts->have_posts() ) : ?>

		<section id="related-posts" class="related-posts">
			<div class="container">
				<header class="related-posts__header">
					<h2 class="related-posts__title"><?php esc_html_e( 'Related Posts', 'melina' ); ?></h2>
				</header><!-- .related-posts__header -->

				<div class="related-posts__list">

					<?php // Start the loop.
					while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

						<div class="related-posts__item">
							<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
								<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 364px' ), true ); ?>

								<div class="post-card__body">
									<?php
									the_title( '<h3 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
									melina_postcard_meta(); ?>
								</div>
							</article><!-- .post-card -->
						</div><!-- .related-posts__item -->

					<?php // End the loop.
					endwhile; ?>

				</div><!-- .related-posts__list -->
			</div><!-- .container -->
		</section><!-- .related-posts -->

	<?php
	endif;

	// Restore original Post Data
	wp_reset_postdata();
}
