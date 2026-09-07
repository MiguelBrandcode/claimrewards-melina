<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Two-column grid layout".
 *
 * @package Melina
 */

?>

<?php
do_action( 'melina_loop_before' ); ?>

<div class="loop-container loop-container--grid">

	<?php
	if ( is_active_sidebar( 'sidebar-1' ) && 'no' !== get_theme_mod( 'sidebar_position', 'right' ) ) :

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called post-card-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/post-card/post-card', get_post_format() );

		endwhile;

	else :

		/* Start the Loop */
		while ( have_posts() ) : the_post(); ?>

			<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
				<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 566px' ), true ); ?>

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
								echo mb_substr( $content, 0, 170 ) . '&hellip;';
							} else {
								echo mb_substr( $content, 0, 325 ) . '&hellip;';
							} ?>
						</div>
					<?php
					endif;

					melina_postcard_footer(); ?>
				</div>
			</article><!-- .post-card -->

		<?php
		endwhile;

	endif; ?>

</div><!-- .loop-container -->

<?php
/**
 * Functions hooked in to melina_loop_after action:
 *
 * @hooked melina_pagination - 10
 */
do_action( 'melina_loop_after' );
