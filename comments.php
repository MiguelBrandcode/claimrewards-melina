<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Melina
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="comments-area__wrapper">

		<?php
		if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				$comment_count = get_comments_number();

				if ( 1 === $comment_count ) {
					printf( esc_html_e( 'One Comment', 'melina' ) );
				} else {
					printf( // WPCS: XSS OK.
						/* translators: 1: comment count number. */
						esc_html( _nx( '%1$s Comment', '%1$s Comments', $comment_count, 'comments title', 'melina' ) ),
						number_format_i18n( $comment_count )
					);
				} ?>
			</h2><!-- .comments-title -->

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 50,
				) ); ?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation();

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'melina' ); ?></p>
			<?php
			endif;

		endif; // Check for have_comments().

		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		) ); ?>

	</div><!-- .comments-area__wrapper -->
</div><!-- #comments -->
