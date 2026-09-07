<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package Melina
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function melina_body_classes( $classes ) {
	// Adds layout type class.
	$classes[] = 'layout--' . get_theme_mod( 'layout_type', 'wide' );

	// Add class on front page.
	if ( is_front_page() && ! is_home() && 'homepage_content' !== get_theme_mod( 'static_page_content', 'homepage_content' ) ) {
		$classes[] = 'front-page';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of content layout to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'content-layout--' . get_theme_mod( 'content_layout', 'default' );
	}

	// Adds sidebar position class.
	$sidebar_position = get_theme_mod( 'sidebar_position', 'right' );

	$template_without_sidebar = array(
		'page-templates/without-sidebar-post.php',
		'page-templates/without-sidebar-page.php',
	);

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		if ( is_page_template( $template_without_sidebar ) || melina_is_magazine_page() ) {
			$classes[] = 'sidebar--no';
		} else {
			if ( 'right' === $sidebar_position ) {
				$classes[] = 'sidebar--right';
			}

			if ( 'left' === $sidebar_position ) {
				$classes[] = 'sidebar--left';
			}
		}
	}

	if ( ( ! is_active_sidebar( 'sidebar-1' ) || 'no' === $sidebar_position ) ) {
		$classes[] = 'sidebar--no';
	}

	// Get the color scheme or the default if there isn't one.
	$classes[] = 'color-scheme--' . get_theme_mod( 'color_scheme', 'default' );

	// Add classes if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'melina-customizer';

		if ( is_front_page() && get_query_var( 'paged' ) == 0 ) {
			$classes[] = 'featured--enabled';

			if ( 'carousel-v4' === get_theme_mod( 'featured_content', 'site-info' ) ) {
				$classes[] = 'header-transparent--activated';
			}
		}
	}

	return $classes;
}
add_filter( 'body_class', 'melina_body_classes' );

/**
 * Adds classes for header.
 *
 * @param array $classes Classes for header element.
 * @return array
 */
function melina_add_header_classes( $classes = '' ) {
	$classes = array();

	$classes[] = 'header--default';

	if ( is_front_page() && get_query_var( 'paged' ) == 0 ) {
		$featured_content = get_theme_mod( 'featured_content', 'site-info' );

		if ( ( 'site-info' === $featured_content && get_header_image() ) || 'carousel-v1' === $featured_content || 'carousel-v3' === $featured_content ) {
			$classes[] = 'header--without-border';
		}

		if ( 'carousel-v4' === $featured_content ) {
			$classes[] = 'header--transparent';
		}
	}

	return array_unique( $classes );
}

/**
 * Get classes for header.
 *
 * @param array $class Classes for header element.
 */
function melina_header_classes( $classes = '' ) {
	// Separates classes with a single space
	echo join( ' ', melina_add_header_classes( $classes ) );
}

/**
 * Template functions to display template parts.
 *
 * Template parts for this functions can be found
 * in the "template-parts" folder.
 */

if ( ! function_exists( 'melina_skip_link' ) ) :
	/**
	 * Prints HTML for skip link.
	 *
	 * Create your own melina_skip_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function melina_skip_link() {
		?>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'melina' ); ?></a>
		<?php
	}
endif;

/**
 * Prints HTML for site branding.
 */
function melina_site_branding() {
	get_template_part( 'template-parts/header/site', 'branding' );
}

/**
 * Prints HTML for header menu.
 */
function melina_header_menu() {
	get_template_part( 'template-parts/navigation/header-menu' );
}

/**
 * Prints HTML for featured content.
 */
function melina_featured_content() {
	if ( is_front_page() && get_query_var( 'paged' ) == 0 ) {
		$featured_content = get_theme_mod( 'featured_content', 'site-info' );

		if ( 'no' !== $featured_content ) :
			// Display featured content.
			get_template_part( 'template-parts/featured/featured', $featured_content );
		elseif ( is_customize_preview() ) :
			// Or display featured content placeholder.
			echo '<div id="featured-content-area" class="featured-content-area featured-content-area--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Featured Content Placeholder', 'melina' ) . '</h3></div>';
		endif;
	}
}

if ( ! function_exists( 'melina_pagination' ) ) :
	/**
	 * Prints HTML for previous/next page navigation.
	 *
	 * Create your own melina_pagination() function to override in a child theme.
	 */
	function melina_pagination() {
		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => esc_html__( 'Previous', 'melina' ),
			'next_text'          => esc_html__( 'Next', 'melina' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'melina' ) . ' </span>',
		) );
	}
endif;

if ( ! function_exists( 'melina_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post - category, date/time and edit link.
	 *
	 * Create your own melina_entry_meta() function to override in a child theme.
	 */
	function melina_entry_meta() {
		echo '<div class="entry__meta">';
		melina_sticky_post();

		// Hide category and post format for pages.
		if ( 'post' === get_post_type() ) {
			melina_categories_list();
			melina_post_format();
		}

		// Hide date for pages.
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			melina_entry_date();
		}

		melina_edit_link();
		echo '</div><!-- .entry__meta -->';
	}
endif;

if ( ! function_exists( 'melina_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the current post - tags, author and comments link.
	 *
	 * Create your own melina_entry_footer() function to override in a child theme.
	 */
	function melina_entry_footer() {
		// Visible only on single post.
		if ( is_singular() && 'post' === get_post_type() ) {
			echo '<footer class="entry__footer">';
			melina_tags_list();
			melina_byline();
			echo '</footer><!-- .entry__footer -->';
		}
	}
endif;

if ( ! function_exists( 'melina_postcard_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post - category, date/time and comments.
	 *
	 * Create your own melina_postcard_meta() function to override in a child theme.
	 */
	function melina_postcard_meta( $class = 'post-card__meta' ) {
		// Hide for pages.
		if ( 'post' === get_post_type() ) :
			echo '<div class="' . esc_attr( $class ) . '">';
			melina_category();
			melina_entry_date();
			echo '</div><!--' . esc_attr( $class ) . '-->';
		endif;
	}
endif;

if ( ! function_exists( 'melina_postcard_footer' ) ) :
	/**
	 * Prints HTML with read more link.
	 *
	 * Create your own melina_postcard_footer() function to override in a child theme.
	 */
	function melina_postcard_footer( $class = 'post-card__footer' ) {
		echo '<div class="' . esc_attr( $class ) . '">';
		melina_more_link();
		echo '</div><!-- .' . esc_attr( $class ) . ' -->';
	}
endif;

if ( ! function_exists( 'melina_page_links' ) ) :
	/**
	 * Prints HTML for page links.
	 *
	 * Create your own melina_page_links() function to override in a child theme.
	 */
	function melina_page_links() {
		if ( is_singular() ) {
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'melina' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'melina' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		}
	}
endif;

/**
 * Prints HTML for author info.
 */
function melina_author_info() {
	if ( '' !== get_the_author_meta( 'description' ) ) :
		get_template_part( 'template-parts/post/author-info' );
	endif;
}

/**
 * Prints HTML for post navigation.
 */
function melina_post_navigation() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( 'enable' === get_theme_mod( 'post_navigation', 'enable' ) ) :
		get_template_part( 'template-parts/navigation/post-navigation' );
	elseif ( is_customize_preview() ) :
		echo '<div id="post-navigation-area" class="post-navigation-area post-navigation-area--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Post Navigation Placeholder', 'melina' ) . '</h3></div>';
	endif;
}

/**
 * Prints HTML for content widgets.
 */
function melina_content_widgets() {
	if ( is_singular( 'post' ) ) :
		get_template_part( 'template-parts/post/content-widgets' );
	endif;
}

/**
 * Prints HTML for related posts.
 */
function melina_related_posts() {
	if ( ! is_single() ) {
		return;
	}

	if ( 'enable' === get_theme_mod( 'related_posts', 'enable' ) ) :
		get_template_part( 'template-parts/related-posts' );
	elseif ( is_customize_preview() ) :
		echo '<section id="related-posts" class="related-posts related-posts--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Related Posts Placeholder', 'melina' ) . '</h3></section>';
	endif;
}

/**
 * Prints HTML for footer instagram widget.
 */
function melina_footer_instagram_widget() {
	get_template_part( 'template-parts/footer/footer', 'instagram' );
}

/**
 * Prints HTML for footer widgets.
 */
function melina_footer_widgets() {
	get_template_part( 'template-parts/footer/footer', 'widgets' );
}

/**
 * Prints HTML for copyright.
 */
function melina_copyright() {
	get_template_part( 'template-parts/footer/footer', 'copyright' );
}

/**
 * Prints HTML for theme author link.
 */
function melina_theme_author_link() {
	if ( false === get_theme_mod( 'hide_theme_author_link' ) ) :
		echo '<span class="theme-author-link">';
		/* translators: 1: Theme author. */
		printf( esc_html__( 'Developed by %1$s', 'melina' ), '<a href="https://themeforest.net/user/v_kulesh">Vladimir Kulesh</a>' );
		echo '</span>';
	elseif ( is_customize_preview() ) :
		echo '<span class="theme-author-link theme-author-link--placeholder"></span>';
	endif;
}

/**
 * Prints HTML for social menu.
 */
function melina_social_menu() {
	if ( has_nav_menu( 'social-menu' ) ) :
		get_template_part( 'template-parts/navigation/social-menu' );
	endif;
}

/**
 * Prints HTML for scroll to top button.
 */
function melina_scroll_to_top() {
	get_template_part( 'template-parts/scroll-to-top' );
}

/**
 * Prints HTML for search overlay.
 */
function melina_search_overlay() {
	get_template_part( 'template-parts/search-overlay' );
}

/**
 * Display a category section for magazine page.
 *
 * @param WP_Customize_Partial $partial Partial associated with a selective refresh request.
 * @param integer              $id Magazine page category section to display.
 */
function melina_magazine_page_section( $partial = null, $id = 0 ) {
	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		// Find out the id and set it up during a selective refresh.
		global $melinacounter;
		$id = str_replace( 'magazine_section_', '', $partial->id );
		$melinacounter = $id;
	}

	if ( 'none' !== get_theme_mod( 'magazine_section_' . $id, 'none' ) ) {
		get_template_part( 'template-parts/magazine/magazine-section', $id );
	} elseif ( is_customize_preview() ) {
		// The output placeholder anchor.
		echo '<section id="magazine-section-' . $id . '" class="magazine-section magazine-section--' . $id . ' magazine-section--placeholder"><h3 class="placeholder__title">' . sprintf( esc_html__( 'Magazine Section %1$s Placeholder', 'melina' ), $id ) . '</h3></section>';
	}
}

/**
 * Count our number of active magazine page sections.
 * Primarily used to see if we have any sections active.
 */
function melina_magazine_page_sections_count() {
	$magazine_sections_count = 0;

	/**
	 * Filter number of magazine page sections.
	 *
	 * @param int $num_sections Number of magazine page sections.
	 */
	$num_sections = apply_filters( 'melina_magazine_page_sections', 7 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		if ( get_theme_mod( 'magazine_section_' . $i ) ) {
			$magazine_sections_count++;
		}
	}

	return $magazine_sections_count;
}

/**
 * Display all sections for magazine page.
 */
function melina_magazine_page_sections() {
	// Get each of our sections and show the post data.
	if ( 0 !== melina_magazine_page_sections_count() || is_customize_preview() ) : // If we have sections to show.
		/**
		 * Filter number of magazine page sections.
		 *
		 * @param int $num_sections Number of magazine page sections.
		 */
		$num_sections = apply_filters( 'melina_magazine_page_sections', 7 );
		global $melinacounter;

		// Get our sections.
		for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
			$melinacounter = $i;

			do_action( 'melina_magazine_section_' . esc_attr( $i ) . '_before' );
			melina_magazine_page_section( null, $i );
			do_action( 'melina_magazine_section_' . esc_attr( $i ) . '_after' );
		}
	endif;
}

/**
 * Prints HTML for magazine page ads sidebar 1.
 */
function melina_first_magazine_ads_sidebar() {
	get_template_part( 'template-parts/magazine/magazine-ads-sidebar', '1' );
}

/**
 * Prints HTML for magazine page ads sidebar 2.
 */
function melina_second_magazine_ads_sidebar() {
	get_template_part( 'template-parts/magazine/magazine-ads-sidebar', '2' );
}
