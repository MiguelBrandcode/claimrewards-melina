<?php
/**
 * Template hooks.
 *
 * @package Melina
 */

/**
 * General
 *
 * @see melina_skip_link()
 * @see melina_featured_content()
 * @see melina_post_navigation()
 * @see melina_related_posts()
 * @see melina_footer_instagram_widget()
 * @see melina_scroll_to_top()
 * @see melina_search_overlay()
 */
add_action( 'melina_site_before',    'melina_skip_link',               0 );
add_action( 'melina_content_top',    'melina_featured_content',        10 );
add_action( 'melina_content_bottom', 'melina_post_navigation',         10 );
add_action( 'melina_content_bottom', 'melina_related_posts',           20 );
add_action( 'melina_content_bottom', 'melina_footer_instagram_widget', 30 );
add_action( 'melina_site_after',     'melina_scroll_to_top',           10 );
add_action( 'melina_site_after',     'melina_search_overlay',          20 );

/**
 * Header
 *
 * @see melina_header_classes()
 * @see melina_site_branding()
 * @see melina_header_menu()
 */
add_action( 'melina_header_classes', 'melina_header_classes', 10 );
add_action( 'melina_header',         'melina_site_branding',  10 );
add_action( 'melina_header',         'melina_header_menu',    20 );

/**
 * Loop
 *
 * @see melina_pagination()
 */
add_action( 'melina_loop_after', 'melina_pagination', 10 );

/**
 * Post
 *
 * @see melina_page_links()
 * @see melina_author_info()
 * @see melina_content_widgets()
 */
add_action( 'melina_post_content_bottom', 'melina_page_links',      10 );
add_action( 'melina_single_post_after',   'melina_author_info',     10 );
add_action( 'melina_single_post_after',   'melina_content_widgets', 20 );

/**
 * Page
 *
 * @see melina_page_links()
 */
add_action( 'melina_page_content_bottom', 'melina_page_links', 10 );

/**
 * Footer
 *
 * @see melina_footer_widgets()
 * @see melina_copyright()
 * @see melina_social_menu()
 * @see melina_theme_author_link()
 */
add_action( 'melina_footer',            'melina_footer_widgets',    10 );
add_action( 'melina_footer',            'melina_copyright',         20 );
add_action( 'melina_footer',            'melina_social_menu',       30 );
add_action( 'melina_footer_copyrights', 'melina_theme_author_link', 10 );

/**
 * Front Page
 *
 * @see melina_magazine_page_sections()
 * @see melina_first_magazine_ads_sidebar()
 * @see melina_second_magazine_ads_sidebar()
 */
add_action( 'melina_front_page',               'melina_magazine_page_sections',      10 );
add_action( 'melina_magazine_section_2_after', 'melina_first_magazine_ads_sidebar',  10 );
add_action( 'melina_magazine_section_6_after', 'melina_second_magazine_ads_sidebar', 10 );
