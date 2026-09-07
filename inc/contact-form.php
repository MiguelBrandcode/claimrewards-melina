<?php
/**
 * Contact Form 7 Compatibility File
 *
 * @link https://wordpress.org/plugins/contact-form-7/
 *
 * @package Melina
 */

/**
 * Contact Form 7 specific scripts & stylesheets.
 *
 * @return void
 */
function melina_contact_form_scripts() {
	wp_enqueue_style( 'melina-contact-form-style', get_template_directory_uri() . '/assets/css/contact-form.css', array( 'melina-style' ) );
}
add_action( 'wp_enqueue_scripts', 'melina_contact_form_scripts' );
