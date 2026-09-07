<?php
/**
 * MailChimp Compatibility File
 *
 * @link https://wordpress.org/plugins/mailchimp-for-wp/
 *
 * @package Melina
 */

/**
 * MailChimp specific scripts & stylesheets.
 *
 * @return void
 */
function melina_mailchimp_scripts() {
	wp_enqueue_style( 'melina-mailchimp-style', get_template_directory_uri() . '/assets/css/mailchimp.css', array( 'melina-style' ) );
}
add_action( 'wp_enqueue_scripts', 'melina_mailchimp_scripts' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function melina_mailchimp_customize_preview_js() {
	wp_enqueue_script( 'melina-mailchimp-customize-preview', get_theme_file_uri( '/assets/js/mailchimp-customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'melina_mailchimp_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function melina_mailchimp_customize_control_js() {
	wp_enqueue_script( 'melina-mailchimp-customize-controls', get_theme_file_uri( '/assets/js/mailchimp-customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'melina_mailchimp_customize_control_js' );

/**
 * Add support mailchimp form settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_mailchimp_form( $wp_customize ) {
	// Add MailChimp Form settings and controls.
	$wp_customize->add_setting( 'top_mailchimp_form', array(
		'default'  			    => 'enable',
		'sanitize_callback' => 'melina_sanitize_choices',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'top_mailchimp_form', array(
		'label'       => esc_html__( 'Top MailChimp Form', 'melina' ),
		'description' => esc_html__( 'Display MailChimp Form before the main content on the front page.', 'melina' ),
		'section'     => 'melina_content_area',
		'type'        => 'radio',
		'choices' 		=> array(
      'enable'    => esc_html__( 'Enable MailChimp Form', 'melina' ),
      'disable'   => esc_html__( 'Disable MailChimp Form', 'melina' ),
    ),
		'priority' => 50,
	) );

	$wp_customize->selective_refresh->add_partial( 'top_mailchimp_form', array(
		'selector'            => '#mailchimp-top-content-area',
		'render_callback'     => 'melina_top_mailchimp_form',
		'container_inclusive' => true,
	) );

	$wp_customize->add_setting( 'bottom_mailchimp_form', array(
		'default'  			    => 'enable',
		'sanitize_callback' => 'melina_sanitize_choices',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'bottom_mailchimp_form', array(
		'label'       => esc_html__( 'Bottom MailChimp Form', 'melina' ),
		'description' => esc_html__( 'Display MailChimp Form after the main content on the front page.', 'melina' ),
		'section'     => 'melina_content_area',
		'type'        => 'radio',
		'choices' 		=> array(
      'enable'    => esc_html__( 'Enable MailChimp Form', 'melina' ),
      'disable'   => esc_html__( 'Disable MailChimp Form', 'melina' ),
    ),
		'priority' => 60,
	) );

	$wp_customize->selective_refresh->add_partial( 'bottom_mailchimp_form', array(
		'selector'            => '#mailchimp-bottom-content-area',
		'render_callback'     => 'melina_bottom_mailchimp_form',
		'container_inclusive' => true,
	) );
}
add_action( 'customize_register', 'melina_customize_register_mailchimp_form' );

/**
 * Prints HTML for top MailChimp form
 */
function melina_top_mailchimp_form() {
	if ( 'enable' === get_theme_mod( 'top_mailchimp_form', 'enable' ) ) {
		// Display Mailchimp form.
		if ( function_exists( 'mc4wp_show_form' ) && is_front_page() && get_query_var( 'paged' ) == 0 ) {
			echo '<div id="mailchimp-top-content-area" class="mailchimp-content-area mailchimp-content-area--top">';
			echo '<div class="container">';
			mc4wp_show_form();
			echo '</div><!-- .container -->';
			echo '</div><!-- .mailchimp-content-area -->';
		}
	} elseif ( is_customize_preview() ) {
		// Or display Mailchimp form placeholder.
		echo '<div id="mailchimp-top-content-area" class="mailchimp-content-area mailchimp-content-area--top mailchimp-content-area--placeholder"><div class="container"><h3 class="placeholder__title">' . esc_html__( 'MailChimp Form Placeholder', 'melina' ) . '</h3></div></div>';
	}
}

/**
 * Prints HTML for bottom MailChimp form
 */
function melina_bottom_mailchimp_form() {
	if ( 'enable' === get_theme_mod( 'bottom_mailchimp_form', 'enable' ) ) {
		// Display Mailchimp form.
		if ( function_exists( 'mc4wp_show_form' ) && is_front_page() ) {
			echo '<div id="mailchimp-bottom-content-area" class="mailchimp-content-area mailchimp-content-area--bottom">';
			echo '<div class="container">';
			mc4wp_show_form();
			echo '</div><!-- .container -->';
			echo '</div><!-- .mailchimp-content-area -->';
		}
	} elseif ( is_customize_preview() ) {
		// Or display Mailchimp form placeholder.
		echo '<div id="mailchimp-bottom-content-area" class="mailchimp-content-area mailchimp-content-area--bottom mailchimp-content-area--placeholder"><div class="container"><h3 class="placeholder__title">' . esc_html__( 'MailChimp Form Placeholder', 'melina' ) . '</h3></div></div>';
	}
}

/**
 * Template hooks.
 */
add_action( 'melina_content_top',    'melina_top_mailchimp_form',    20 );
add_action( 'melina_content_bottom', 'melina_bottom_mailchimp_form', 5 );
