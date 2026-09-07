<?php
/**
 * Customizer Footer Area Section.
 *
 * @package Melina
 */

/**
 * Add support for footer area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_footer_area( $wp_customize ) {
	// Add section to change footer area.
	$wp_customize->add_section( 'melina_footer_area', array(
		'title'    => esc_html__( 'Footer Area Settings', 'melina' ),
		'priority' => 150,
	) );

	// Add footer copyright settings and controls.
	$wp_customize->add_setting( 'copyright_text', array(
		'default'       	  => esc_html__( '©2018. All rights reserved', 'melina' ),
		'sanitize_callback' => 'melina_sanitize_text',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'copyright_text', array(
		'label' 		  => esc_html__( 'Footer Copyright', 'melina' ),
		'description' => esc_html__( 'You can change footer copyright and use your own custom text from here.', 'melina' ),
		'section'  		=> 'melina_footer_area',
		'type'     		=> 'text',
		'priority' 		=> 10,
	) );

	$wp_customize->selective_refresh->add_partial( 'copyright_text', array(
		'selector'        => '.copyright__text',
		'render_callback' => 'melina_copyright_text',
	) );

	// Add footer theme author link settings and controls.
	$wp_customize->add_setting( 'hide_theme_author_link', array(
		'default'  			    => false,
		'sanitize_callback' => 'melina_sanitize_checkbox',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'hide_theme_author_link', array(
		'label'    => esc_html__( 'Hide Theme Author Link', 'melina' ),
		'section'  => 'melina_footer_area',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->selective_refresh->add_partial( 'hide_theme_author_link', array(
		'selector'        => '.theme-author-link',
		'render_callback' => 'melina_theme_author_link',
	) );
}
add_action( 'customize_register', 'melina_customize_register_footer_area' );

/**
 * Render the copyright text for the selective refresh partial.
 *
 * @return void
 */
function melina_copyright_text() {
	echo get_theme_mod( 'copyright_text' );
}
