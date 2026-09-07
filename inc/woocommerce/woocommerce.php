<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Melina
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/
 *
 * @return void
 */
function melina_woocommerce_setup() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width'         => 566,
		'single_image_width'            => 566,
		'gallery_thumbnail_image_width' => 150,
		'product_grid' => array(
			'default_columns' => 2,
			'default_rows'    => 4,
			'min_columns'     => 2,
			'max_columns'     => 3,
			'min_rows'        => 1,
		),
	) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'melina_woocommerce_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function melina_woocommerce_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar', 'melina' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your store sidebar.', 'melina' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'melina_woocommerce_widgets_init' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function melina_woocommerce_scripts() {
	wp_enqueue_style( 'melina-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array( 'melina-style' ) );
	wp_enqueue_script( 'melina-init-product-gallery', get_template_directory_uri() . '/assets/js/init-product-gallery.js', array( 'slick' ), '20181116', true );
}
add_action( 'wp_enqueue_scripts', 'melina_woocommerce_scripts' );

/**
 * Add support WooCommerce settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_woocommerce( $wp_customize ) {
	// Add section to change WooCommerce sidebar position.
  $wp_customize->add_section( 'melina_woocommerce_sidebar', array(
    'title'    => esc_html__( 'Store Sidebar', 'melina' ),
    'priority' => 50,
		'panel'    => 'woocommerce',
  ) );

	// Add WooCommerce sidebar position settings and controls.
  $wp_customize->add_setting( 'woocommerce_sidebar_position', array(
    'default'  			    => 'right',
		'capability'        => 'manage_woocommerce',
    'sanitize_callback' => 'melina_sanitize_choices',
    //'transport' 		    => 'postMessage',
  ) );

  $wp_customize->add_control( 'woocommerce_sidebar_position', array(
    'label'    		=> esc_html__( 'Sidebar Position', 'melina' ),
    'description' => esc_html__( 'Select store sidebar position. You can also delete all widgets from the sidebar to turn on "Without sidebar" mode.', 'melina' ),
    'section'  		=> 'melina_woocommerce_sidebar',
    'type'     		=> 'radio',
    'choices' 		=> array(
      'right'     => esc_html__( 'Right sidebar', 'melina' ),
      'left'      => esc_html__( 'Left sidebar', 'melina' ),
      'no' 	      => esc_html__( 'Without sidebar', 'melina' ),
    ),
    'priority'    => 10,
  ) );
}
add_action( 'customize_register', 'melina_customize_register_woocommerce' );

/**
 * Checks if the current page is a store page
 *
 * @return bool
 */
function melina_is_store_page() {
	if ( melina_is_woocommerce_activated() ) {
		if ( is_woocommerce() ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
 * Add classes to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' and woocommerce sidebar classes.
 */
function melina_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	// Add woocommerce sidebar classes
	if ( melina_is_store_page() ) {
		$woocommerce_sidebar_position = get_theme_mod( 'woocommerce_sidebar_position', 'right' );

		if ( is_active_sidebar( 'sidebar-2' ) ) {
			if ( 'right' === $woocommerce_sidebar_position ) {
				$classes[] = 'woocommerce-sidebar--right';
			}

			if ( 'left' === $woocommerce_sidebar_position ) {
				$classes[] = 'woocommerce-sidebar--left';
			}
		}

		if ( ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === $woocommerce_sidebar_position ) ) {
			$classes[] = 'woocommerce-sidebar--no';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'melina_woocommerce_active_body_class' );

/**
 * Modifies product tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @param array $args Arguments for product tag cloud widget.
 * @return array A new modified arguments.
 */
function melina_widget_woocommerce_product_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'melina_widget_woocommerce_product_tag_cloud_args' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function melina_woocommerce_related_products_args( $args ) {
	$posts_per_page = 2;
	$columns = 2;

	if ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === get_theme_mod( 'woocommerce_sidebar_position', 'right' ) ) {
		$posts_per_page = 3;
		$columns = 3;
	}

	$defaults = array(
		'posts_per_page' => $posts_per_page,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'melina_woocommerce_related_products_args' );

/**
 * Up Sells Products Args.
 *
 * @param array $args up sells products args.
 * @return array $args up sells products args.
 */
function melina_woocommerce_upsell_products_args( $args ) {
	$posts_per_page = 2;
	$columns = 2;

	if ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === get_theme_mod( 'woocommerce_sidebar_position', 'right' ) ) {
		$posts_per_page = 3;
		$columns = 3;
	}

	$defaults = array(
		'posts_per_page' => $posts_per_page,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_upsell_display_args', 'melina_woocommerce_upsell_products_args' );

/**
 * Cross Sells Products Columns.
 *
 * @param array $args cross sells products args.
 * @return array $args cross sells products args.
 */
function melina_woocommerce_cross_sells_columns() {
	$columns = 2;

	if ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === get_theme_mod( 'woocommerce_sidebar_position', 'right' ) ) {
		$columns = 3;
	}

	return $columns;
}
add_filter( 'woocommerce_cross_sells_columns', 'melina_woocommerce_cross_sells_columns' );

/**
 * Cross Sells Products Limit.
 *
 * @param array $args cross sells products args.
 * @return array $args cross sells products args.
 */
function melina_woocommerce_cross_sells_limit() {
	$limit = 2;

	if ( ! is_active_sidebar( 'sidebar-2' ) || 'no' === get_theme_mod( 'woocommerce_sidebar_position', 'right' ) ) {
		$limit = 3;
	}

	return $limit;
}
add_filter( 'woocommerce_cross_sells_total', 'melina_woocommerce_cross_sells_limit' );
