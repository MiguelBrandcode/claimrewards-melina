<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Melina
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php
		if ( 'post' === get_post_type() ) :
			melina_entry_meta();
		endif;

		the_title( sprintf( '<h2 class="entry__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry__header -->

	<?php
	melina_post_thumbnail();
	melina_excerpt(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
