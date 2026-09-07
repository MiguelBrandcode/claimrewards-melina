<?php
/**
 * Developer Share Buttons Compatibility File
 *
 * @link https://wordpress.org/plugins/developer-share-buttons/
 *
 * @package Melina
 */

/**
 * Developer Share Buttons specific scripts & stylesheets.
 *
 * @return void
 */
function melina_share_buttons_scripts() {
	wp_enqueue_style( 'melina-share-buttons-style', get_template_directory_uri() . '/assets/css/share-buttons.css', array( 'melina-style' ) );
}
add_action( 'wp_enqueue_scripts', 'melina_share_buttons_scripts' );

/**
 * Display Share Buttons
 */
function melina_display_share_buttons() {
	if ( ! is_singular() || is_page( array( 'Contact', 'Contact Us', 'Contact Me' ) ) ) {
		return;
	}

	if ( melina_is_woocommerce_activated() && ( is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}

	the_dev_share_buttons();
}
add_action( 'melina_post_content_bottom', 'melina_display_share_buttons', 20 );
add_action( 'melina_page_content_bottom', 'melina_display_share_buttons', 20 );
add_action( 'woocommerce_share',          'melina_display_share_buttons', 10 );
