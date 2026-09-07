<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Melina
 */

if ( ! function_exists( 'melina_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 * Does nothing if the custom logo is not available.
	 *
	 * Create your own melina_the_custom_logo() function to override in a child theme.
	 */
	function melina_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

if ( ! function_exists( 'melina_sticky_post' ) ) :
	/**
	 * Displays the sticky post HTML.
	 *
	 * Create your own melina_sticky_post() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_sticky_post() {
		if ( is_sticky() && is_home() && ! is_paged() ) :
			echo '<span class="sticky-post">' . esc_html__( 'Featured', 'melina' ) . '</span>';
		endif;
	}
endif;

if ( ! function_exists( 'melina_category' ) ) :
	/**
	 * Returns first category.
	 *
	 * Create your own melina_category() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_category() {
		// Display only first category, if post has more than one.
		$category = get_the_category();

		if ( ! empty( $category ) ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Category ', 'melina' ) . '</span><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->name ) . '</a></span>';
		}
	}
endif;

if ( ! function_exists( 'melina_categories_list' ) ) :
	/**
	 * Returns categories list.
	 *
	 * Create your own melina_categories_list() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_categories_list() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'melina' ) );

		if ( $categories_list && melina_categorized_blog() ) {
			/* translators: 1: list of categories. */
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Categories ', 'melina' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'melina_categorized_blog' ) ) :
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * Create your own melina_categorized_blog() function to override in a child theme.
	 *
	 * @return bool
	 */
	function melina_categorized_blog() {
		$category_count = get_transient( 'melina_categories' );

		if ( false === $category_count ) {
			// Create an array of all the categories that are attached to posts.
			$categories = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$category_count = count( $categories );

			set_transient( 'melina_categories', $category_count );
		}

		// Allow viewing case of 0 or 1 categories in post preview.
		if ( is_preview() ) {
			return true;
		}

		return $category_count > 1;
	}
endif;

/**
 * Flush out the transients used in melina_categorized_blog.
 */
function melina_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'melina_categories' );
}
add_action( 'edit_category', 'melina_category_transient_flusher' );
add_action( 'save_post',     'melina_category_transient_flusher' );

if ( ! function_exists( 'melina_post_format' ) ) :
	/**
	 * Returns post format.
	 *
	 * Create your own melina_post_format() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_post_format() {
		$format = get_post_format();

		if ( current_theme_supports( 'post-formats', $format ) ) {
			printf( '<span class="entry__format">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf( '<span class="screen-reader-text">%s </span>', esc_html_x( 'Format', 'Used before post format.', 'melina' ) ),
				esc_url( get_post_format_link( $format ) ),
				get_post_format_string( $format )
			);
		}
	}
endif;

if ( ! function_exists( 'melina_entry_date' ) ) :
	/**
	 * Gets a nicely formatted string for the published date.
	 *
	 * Create your own melina_entry_date() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_entry_date() {
		$time_string = '<time class="entry__date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry__date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		printf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s</span>', esc_html_x( 'Posted on ', 'Used before post date.', 'melina' ) ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'melina_edit_link' ) ) :
	/**
	 * Returns an accessibility-friendly link to edit a post or page.
	 *
	 * Create your own melina_edit_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_edit_link() {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit<span class="screen-reader-text"> %s</span>', 'melina' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'melina_tags_list' ) ) :
	/**
	 * Returns tags list.
	 *
	 * Create your own melina_tags_list() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_tags_list() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'melina' ) );

		if ( $tags_list ) {
			printf( '<span class="tags-links">%1$s %2$s</span>',
				esc_html_x( 'Tags:', 'Used before tag names.', 'melina' ),
				$tags_list
			);
		}
	}
endif;

if ( ! function_exists( 'melina_byline' ) ) :
	/**
	 * Returns byline.
	 *
	 * Create your own melina_byline() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_byline() {
		$author_avatar_size = apply_filters( 'melina_author_avatar_size', 40 );

		$byline = sprintf(
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ) . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'melina_comments_popup_link' ) ) :
	/**
	 * Returns comments popup link.
	 *
	 * Create your own melina_comments_popup_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_comments_popup_link() {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'melina' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}
endif;

if ( ! function_exists( 'melina_comments_count_link' ) ) :
	/**
	 * Returns comments count link.
	 *
	 * Create your own melina_comments_count_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_comments_count_link() {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( '0<span class="screen-reader-text"> comments on %s</span>', 'melina' ),
					array( 'span' => array( 'class' => array() ) )
				),
				get_the_title()
			),
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( '1<span class="screen-reader-text"> comment on %s</span>', 'melina' ),
					array( 'span' => array( 'class' => array() ) )
				),
				get_the_title()
			),
			sprintf(
				wp_kses(
					/* translators: %1$: comments number, %2$s: post title */
					__( '%1$s<span class="screen-reader-text"> comments on %2$s</span>', 'melina' ),
					array( 'span' => array( 'class' => array() ) )
				),
				get_comments_number(),
				get_the_title()
			)
		);
		echo '</span>';
	}
endif;

if ( ! function_exists( 'melina_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Create your own melina_post_thumbnail() function to override in a child theme.
	 */
	function melina_post_thumbnail( $size = 'post-thumbnail', $classes = 'post__thumbnail', $custom_attr = array(), $wrapping_link = false ) {
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}

		$sidebar_position = get_theme_mod( 'sidebar_position', 'right' );

		$template_without_sidebar = array(
			'page-templates/without-sidebar-post.php',
			'page-templates/without-sidebar-page.php',
		);

		if ( is_singular() && ! $wrapping_link ) :

			if ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === $sidebar_position || is_page_template( $template_without_sidebar ) ) {
				$default_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, (max-width: 1279px) 928px, 1920px' );
			} else {
				$default_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, 768px' );
			}

			$attr = array_merge( $default_attr, $custom_attr ); ?>

			<div class="<?php echo esc_attr( $classes ); ?>">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</div><!-- .post__thumbnail -->

		<?php
		else :

			if ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === $sidebar_position || is_page_template( $template_without_sidebar ) ) {
				$default_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, (max-width: 1023px) 768px, (max-width: 1279px) 928px, 968px', 'alt' => the_title_attribute( 'echo=0' ) );
			} else {
				$default_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 688px, 768px', 'alt' => the_title_attribute( 'echo=0' ) );
			}

			$attr = array_merge( $default_attr, $custom_attr ); ?>

			<a class="<?php echo esc_attr( $classes ); ?>" href="<?php esc_url( the_permalink() ); ?>" aria-hidden="true">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</a><!-- .post__thumbnail -->

		<?php
		endif; // End is_singular()
	}
endif;

if ( ! function_exists( 'melina_post_thumbnail_uncropped' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element and adds a padding-top style
	 * to the anchor depending on the aspect ratio of the post thumbnail.
	 *
	 * Create your own melina_post_thumbnail_uncropped() function to override in a child theme.
	 */
	function melina_post_thumbnail_uncropped( $size = 'post-thumbnail', $classes = 'post__thumbnail', $custom_attr = array() ) {
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}

		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );

		// Calculate aspect ratio: h / w * 100%.
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;

		$default_attr = array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, 364px', 'alt' => the_title_attribute( 'echo=0' ) );
		$attr = array_merge( $default_attr, $custom_attr ); ?>

		<a class="<?php echo esc_attr( $classes ); ?>" href="<?php esc_url( the_permalink() ); ?>" style="padding-top: <?php echo esc_attr( $ratio ); ?>%" aria-hidden="true">
			<?php the_post_thumbnail( $size, $attr ); ?>
		</a><!-- .post__thumbnail -->

	<?php
	}
endif;

if ( ! function_exists( 'melina_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own melina_excerpt() function to override in a child theme.
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function melina_excerpt( $class = 'entry__summary' ) {
		if ( has_excerpt() || is_search() ) :
			echo '<div class="' . esc_attr( $class ) . '">';
			the_excerpt();
			echo '</div><!--' . esc_attr( $class ) . '-->';
		endif;
	}
endif;

if ( ! function_exists( 'melina_excerpt_more' ) && ! is_admin() ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own melina_excerpt_more() function to override in a child theme.
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function melina_excerpt_more() {
		$link = sprintf( '<br /><br /><a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'melina' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);
		return ' &hellip; ' . $link;
	}
	add_filter( 'excerpt_more', 'melina_excerpt_more' );
endif;

if ( ! function_exists( 'melina_more_link' ) ) :
	/**
	 * Prints HTML with read more link.
	 *
	 * Create your own melina_more_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_more_link() {
		printf( '<span><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'melina' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 */
		do_action( 'wp_body_open' );
	}
endif;
