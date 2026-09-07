<?php
/**
 * The template part for displaying an Author info.
 *
 * @package Melina
 */

?>

<div class="author-info">
	<div class="author-info__avatar">
		<?php
		/**
		 * Filter the Melina author info avatar size.
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$author_info_avatar_size = apply_filters( 'melina_author_info_avatar_size', 100 );

		echo get_avatar( get_the_author_meta( 'user_email' ), $author_info_avatar_size ); ?>
	</div><!-- .author-info__avatar -->

	<div class="author-info__description">
		<h2 class="author-info__title">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( esc_html__( 'View all posts by %s', 'melina' ), get_the_author() ); ?>" rel="author"><?php echo get_the_author(); ?></a>
		</h2>

		<p class="author-info__bio">
			<?php the_author_meta( 'description' ); ?>
		</p>
	</div><!-- .author-info__description -->
</div><!-- .author-info -->
