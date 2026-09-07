<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "First large then list".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div class="loop-container loop-container--list">

	<?php
	$i = 0;

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		if ( $i == 0 ) : ?>

			<article class="post-card post-card--large<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php // Set the size of the images depending on the presence of the sidebar
				if ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === get_theme_mod( 'sidebar_position', 'right' ) ) {
					$thumbnail_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, 1172px' );
				} else {
					$thumbnail_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, 768px' );
				}

				melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', $thumbnail_attr, true ); ?>

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
		else : ?>

			<article class="post-card post-card--gorizontal<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php // Set the size of the images depending on the presence of the sidebar
				if ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === get_theme_mod( 'sidebar_position', 'right' ) ) {
					$thumbnail_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 1023px) 404px, 600px' );
				} else {
					$thumbnail_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 1279px) 404px, 464px' );
				}

				melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', $thumbnail_attr, true ); ?>

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
								echo mb_substr( $content, 0, 150 ) . '&hellip;';
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
