<?php

/**
 * Melina functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Melina
 */

/**
 * Melina only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function melina_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on melina, use a find and replace
	 * to change 'melina' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('melina', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support('custom-logo', array(
		'height'      => 32,
		'width'       => 200,
		'flex-width'  => true,
	));

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(1920, 9999);

	// Set the default content width.
	$GLOBALS['content_width'] = 688;

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus(array(
		'header-menu' => esc_html__('Header Menu', 'melina'),
		'social-menu' => esc_html__('Social Menu', 'melina'),
	));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	// Set up the WordPress core custom background feature.
	$color_scheme             = melina_get_color_scheme();
	$default_background_color = trim($color_scheme[0], '#');

	add_theme_support('custom-background', apply_filters('melina_custom_background_args', array(
		'default-color' => $default_background_color,
	)));

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support('post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	));

	// Add support for Block Styles
	add_theme_support('wp-block-styles');

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for editor styles
	add_theme_support('editor-styles');

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('assets/css/style-editor.css', melina_fonts_url()));

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place widgets in the sidebar area.
			'sidebar-1' => array(
				'recent-comments',
				'recent-posts',
			),

			// Place widgets in the footer area.
			'footer-1' => array(
				'text_about',
			),

			'footer-2' => array(
				'recent-posts',
			),

			'footer-3' => array(
				'recent-comments',
			),

			'footer-4' => array(
				'text_business_info',
			),
		),

		// Specify the core-defined pages to create.
		'posts' => array(
			'home',
			'contact',
			'about',
		),

		// Set up nav menus for each of the tree areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "header" location.
			'header-menu' => array(
				'name' => esc_html__('Header Menu', 'melina'),
				'items' => array(
					'link_home',
					'page_contact',
					'page_about',
				),
			),

			// Assign a menu to the "social" location.
			'social-menu' => array(
				'name' => esc_html__('Social Menu', 'melina'),
				'items' => array(
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_pinterest',
				),
			),
		),
	);

	/**
	 * Filters Melina array of starter content.
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters('melina_starter_content', $starter_content);
	add_theme_support('starter-content', $starter_content);

	// Add support for featured content.
	add_theme_support('featured-content', array(
		'featured_content_filter' => 'melina_get_featured_posts',
		'max_posts' => 5,
	));
}
add_action('after_setup_theme', 'melina_setup');

/**
 * Getter function for Featured Content.
 *
 * @return array An array of WP_Post objects.
 */
function melina_get_featured_posts()
{
	/**
	 * Filter the featured posts to return in Melina.
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters('melina_get_featured_posts', array());
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function melina_has_featured_posts()
{
	return ! is_paged() && (bool) melina_get_featured_posts();
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether is WooCommerce activated.
 */
function melina_is_woocommerce_activated()
{
	return class_exists('WooCommerce') ? true : false;
}

/**
 * Register custom fonts.
 */
function melina_fonts_url()
{
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Lora, Josefin Sans or Crimson Text, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$lora = esc_html_x('on', 'Lora font: on or off', 'melina');
	$josefin_sans = esc_html_x('on', 'Josefin Sans font: on or off', 'melina');
	$crimson_text = esc_html_x('on', 'Crimson Text font: on or off', 'melina');

	if ('off' !== $lora && 'off' !== $josefin_sans && 'off' !== $crimson_text) {
		$font_families = array();

		$font_families[] = 'Lora:400,400i,700,700i';
		$font_families[] = 'Josefin Sans:300,400,600';
		$font_families[] = 'Crimson Text:400,400i';

		$query_args = array(
			'family' => urlencode(implode('|', $font_families)),
			'subset' => urlencode('latin'),
		);

		$fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
	}

	return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function melina_resource_hints($urls, $relation_type)
{
	if (wp_style_is('melina-fonts', 'queue') && 'preconnect' === $relation_type) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter('wp_resource_hints', 'melina_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function melina_widgets_init()
{
	/* Recent Posts Widget */
	require get_template_directory() . '/inc/widgets/recent-posts.php';
	register_widget('Melina_Recent_Posts_Widget');

	/* Most Commented Widget */
	require get_template_directory() . '/inc/widgets/most-commented.php';
	register_widget('Melina_Most_Commented_Widget');

	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'melina'),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Content', 'melina'),
		'id'            => 'content-1',
		'description'   => esc_html__('Add widgets here to appear before the comments on posts.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Magazine Page Ads Sidebar 1', 'melina'),
		'id'            => 'magazine-ads-sidebar-1',
		'description'   => esc_html__('Add widgets here to appear in your magazine page ads sidebar.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Magazine Page Ads Sidebar 2', 'melina'),
		'id'            => 'magazine-ads-sidebar-2',
		'description'   => esc_html__('Add widgets here to appear in your magazine page ads sidebar.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer 1', 'melina'),
		'id'            => 'footer-1',
		'description'   => esc_html__('Add widgets here to appear in your footer.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer 2', 'melina'),
		'id'            => 'footer-2',
		'description'   => esc_html__('Add widgets here to appear in your footer.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer 3', 'melina'),
		'id'            => 'footer-3',
		'description'   => esc_html__('Add widgets here to appear in your footer.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer 4', 'melina'),
		'id'            => 'footer-4',
		'description'   => esc_html__('Add widgets here to appear in your footer.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer Instagram', 'melina'),
		'id'            => 'footer-5',
		'description'   => esc_html__('Simple add a single widget using "WP Instagram Widget" plugin.', 'melina'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'melina_widgets_init');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function melina_javascript_detection()
{
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'melina_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function melina_pingback_header()
{
	if (is_singular() && pings_open()) {
		echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
	}
}
add_action('wp_head', 'melina_pingback_header');

/**
 * Enqueue scripts and styles.
 */
function melina_scripts()
{
	$featured_content = get_theme_mod('featured_content', 'site-info');
	$content_layout = get_theme_mod('content_layout', 'classic');
	$magazine_section_4_content = get_theme_mod('magazine_section_4', 'none');
	$magazine_section_6_content = get_theme_mod('magazine_section_6', 'none');

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style('melina-fonts', melina_fonts_url(), array(), null);

	// Add Font Awesome and Ionicons, used in the main stylesheet.
	wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/vendor/ionicons/css/ionicons.min.css', array(), '4.2.6');
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/vendor/font-awesome/css/brands.min.css', array(), '5.3.1');

	// Theme stylesheet.
	wp_enqueue_style('melina-style', get_stylesheet_uri());

	// Add Slick Carousel stylesheet.
	if (in_array($featured_content, array('carousel-v1', 'carousel-v2', 'carousel-v3', 'carousel-v4')) || 'none' !== $magazine_section_4_content || melina_is_woocommerce_activated() || is_customize_preview()) {
		wp_enqueue_style('slick', get_template_directory_uri() . '/assets/vendor/slick/slick.css', array('melina-style'), '1.8.0');
	}

	wp_enqueue_script('melina-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_singular() && wp_attachment_is_image()) {
		wp_enqueue_script('melina-keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array('jquery'), '20171002');
	}

	// Add Slick Carousel js.
	if (in_array($featured_content, array('carousel-v1', 'carousel-v2', 'carousel-v3', 'carousel-v4')) || 'none' !== $magazine_section_4_content || melina_is_woocommerce_activated() || is_customize_preview()) {
		wp_enqueue_script('slick', get_template_directory_uri() . '/assets/vendor/slick/slick.min.js', array('jquery'), '1.8.0', true);
	}

	if ('carousel-v1' === $featured_content) {
		wp_enqueue_script('melina-init-carousel-v1', get_template_directory_uri() . '/assets/js/init-carousel-v1.js', array('slick'), '20180826', true);
	}

	if ('carousel-v2' === $featured_content) {
		wp_enqueue_script('melina-init-carousel-v2', get_template_directory_uri() . '/assets/js/init-carousel-v2.js', array('slick'), '20181002', true);
	}

	if ('carousel-v3' === $featured_content) {
		wp_enqueue_script('melina-init-carousel-v3', get_template_directory_uri() . '/assets/js/init-carousel-v3.js', array('slick'), '20181023', true);
	}

	if ('carousel-v4' === $featured_content) {
		wp_enqueue_script('melina-init-carousel-v4', get_template_directory_uri() . '/assets/js/init-carousel-v4.js', array('slick'), '20181024', true);
	}

	if (melina_is_magazine_page()) {
		if ('none' !== $magazine_section_4_content) {
			wp_enqueue_script('melina-init-magazine-carousel', get_template_directory_uri() . '/assets/js/init-magazine-carousel.js', array('slick'), '20180908', true);
		}

		if ('none' !== $magazine_section_6_content) {
			wp_enqueue_script('melina-init-magazine-section-6', get_template_directory_uri() . '/assets/js/init-magazine-section-6.js', array('slick'), '20181029', true);
		}
	}

	// Add imagesLoaded js.
	if (in_array($content_layout, array('grid-v2', 'masonry-v1', 'masonry-v2')) || 'none' !== $magazine_section_6_content || is_customize_preview()) {
		wp_enqueue_script('imagesloaded');
	}

	if ('grid-v2' === $content_layout) {
		wp_enqueue_script('init-grid-v2', get_template_directory_uri() . '/assets/js/init-grid-v2.js', array('jquery'), '20181021', true);
	}

	// Add Masonry js.
	if ('masonry-v1' === $content_layout || 'masonry-v2' === $content_layout || is_customize_preview()) {
		wp_enqueue_script('masonry');
	}

	if ('masonry-v1' === $content_layout) {
		wp_enqueue_script('init-masonry-v1', get_template_directory_uri() . '/assets/js/init-masonry-v1.js', array('jquery'), '20181229', true);
	}

	if ('masonry-v2' === $content_layout) {
		wp_enqueue_script('init-masonry-v2', get_template_directory_uri() . '/assets/js/init-masonry-v2.js', array('jquery'), '20181229', true);
	}

	wp_enqueue_script('melina-script', get_template_directory_uri() . '/assets/js/functions.js', array('jquery'), '20181229', true);

	wp_enqueue_script('jquery-scrollto', get_template_directory_uri() . '/assets/js/jquery.scrollTo.js', array('jquery'), '2.1.2', true);

	wp_localize_script('melina-script', 'screenReaderText', array(
		'expand'   => esc_html__('expand child menu', 'melina'),
		'collapse' => esc_html__('collapse child menu', 'melina'),
	));

	wp_localize_script('melina-script', 'showCommentsText', array(
		'show'   => esc_html__('Show Comments', 'melina'),
		'close' => esc_html__('Close Comments', 'melina'),
	));
}
add_action('wp_enqueue_scripts', 'melina_scripts');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function melina_content_image_sizes_attr($sizes, $size)
{
	$sidebar_position = get_theme_mod('sidebar_position', 'right');
	$width = $size[0];

	if (768 <= $width && melina_is_magazine_page()) {
		$sizes = '(max-width: 959px) 688px, (max-width: 1023px) 768px, 1172px';
	} elseif (768 <= $width && (! is_active_sidebar('sidebar-1') || 'no' === $sidebar_position)) {
		$sizes = '(max-width: 959px) 688px, (max-width: 1023px) 768px, (max-width: 1279px) 848px, 888px';
	} elseif (768 <= $width) {
		$sizes = '(max-width: 959px) 688px, 768px';
	} elseif (768 > $width) {
		$sizes = '(max-width: 479px) 90vw, (max-width: 599px) 432px, 536px';
	}

	return $sizes;
}
add_filter('wp_calculate_image_sizes', 'melina_content_image_sizes_attr', 10, 2);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function melina_widget_tag_cloud_args($args)
{
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter('widget_tag_cloud_args', 'melina_widget_tag_cloud_args');

/**
 * Modefies archive title.
 */
function melina_remove_archive_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	}

	return $title;
}
add_filter('get_the_archive_title', 'melina_remove_archive_title');

/**
 * Use front-page.php when homepage displays is set to a static page.
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function melina_front_page_template($template)
{
	if ('homepage_content' !== get_theme_mod('static_page_content', 'homepage_content')) {
		return is_home() ? '' : $template;
	}
}
add_filter('frontpage_template', 'melina_front_page_template');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Template hooks.
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Color Scheme CSS file
 */
require get_template_directory() . '/inc/color-scheme-css.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if (! class_exists('Featured_Content') && 'plugins.php' !== $GLOBALS['pagenow']) {
	require get_template_directory() . '/inc/featured-content.php';
}

/**
 * Load TGM Plugin Activation file.
 */
require get_template_directory() . '/inc/plugins/theme-required-plugins.php';

/**
 * Load Developer Share Buttons compatibility file.
 */
if (class_exists('DeveloperShareButtons')) {
	require get_template_directory() . '/inc/share-buttons.php';
}

/**
 * Load Contact Form 7 compatibility file.
 */
if (class_exists('WPCF7')) {
	require get_template_directory() . '/inc/contact-form.php';
}

/**
 * Load MailChimp compatibility file.
 */
if (class_exists('MC4WP_MailChimp')) {
	require get_template_directory() . '/inc/mailchimp.php';
}

/**
 * Load WP Instagram Widget compatibility file.
 */
if (class_exists('null_instagram_widget')) {
	require get_template_directory() . '/inc/instagram-widget.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (melina_is_woocommerce_activated()) {
	require get_template_directory() . '/inc/woocommerce/woocommerce.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-hooks.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-functions.php';
}

// -----------------------------------------------------------------#
// DEWENIR
// -----------------------------------------------------------------#
// Libreria less
require_once('wp-less/wp-less.php');

foreach (glob(dirname(__FILE__) .  '/dewenir/includes/*.php') as $filename) {
	require_once dirname(__FILE__) . '/dewenir/includes/' . basename($filename);
}
function restringir_menu_para_kaspersky()
{
	// Obtener el usuario actual
	$current_user = wp_get_current_user();

	// Comprobar si el usuario tiene el rol 'kaspersky_gifts'
	if (in_array('kaspersky_gifts', $current_user->roles)) {
		global $menu, $submenu;

		// Mantener solo los CPT 'cliente' y 'producto'
		$cpts_permitidos = array(
			'edit.php?post_type=cliente',
			'edit.php?post_type=producto'
		);

		// Recorremos los elementos del menú principal
		foreach ($menu as $key => $item) {
			if (!in_array($item[2], $cpts_permitidos)) {
				unset($menu[$key]);
			}
		}

		// Opcional: eliminar submenús que no sean de los CPT permitidos
		foreach ($submenu as $parent => $sub_items) {
			if (!in_array('edit.php?post_type=' . $parent, $cpts_permitidos)) {
				unset($submenu[$parent]);
			}
		}
	}
}
add_action('admin_menu', 'restringir_menu_para_kaspersky', 999);

function restringir_menu_para_kaspersky_solo_clientes()
{
	// Obtener el usuario actual
	$current_user = wp_get_current_user();

	// Comprobar si el usuario tiene el rol 'kaspersky_gifts'
	if (in_array('zona_clientes', $current_user->roles)) {
		global $menu, $submenu;

		// Mantener solo los CPT 'cliente' y 'producto'
		$cpts_permitidos = array(
			'edit.php?post_type=cliente',
		);

		// Recorremos los elementos del menú principal
		foreach ($menu as $key => $item) {
			if (!in_array($item[2], $cpts_permitidos)) {
				unset($menu[$key]);
			}
		}

		// Opcional: eliminar submenús que no sean de los CPT permitidos
		foreach ($submenu as $parent => $sub_items) {
			if (!in_array('edit.php?post_type=' . $parent, $cpts_permitidos)) {
				unset($submenu[$parent]);
			}
		}
	}
}
add_action('admin_menu', 'restringir_menu_para_kaspersky_solo_clientes', 999);