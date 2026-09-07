<?php
/**
 * WP Instagram Widget Compatibility File
 *
 * @link https://wordpress.org/plugins/wp-instagram-widget/
 *
 * @package Melina
 */

/**
 * WP Instagram Widget specific scripts & stylesheets.
 *
 * @return void
 */
function melina_instagram_widget_scripts() {
	wp_enqueue_style( 'melina_instagram_widget-style', get_template_directory_uri() . '/assets/css/instagram-widget.css', array( 'melina-style' ) );
}
add_action( 'wp_enqueue_scripts', 'melina_instagram_widget_scripts' );
