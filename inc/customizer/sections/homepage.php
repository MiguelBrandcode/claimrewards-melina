<?php
/**
 * Customizer Homepage Section.
 *
 * @package Melina
 */

/**
 * Add support for static page content settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_static_page_content( $wp_customize ) {
  // Add static page content settings and controls.
  $wp_customize->add_setting( 'static_page_content', array(
		'default'  			    => 'homepage_content',
		'sanitize_callback' => 'melina_sanitize_choices',
	) );

  $wp_customize->add_control( 'static_page_content', array(
		'label'    		=> esc_html__( 'Your static page displays', 'melina' ),
		'section'  		=> 'static_front_page',
		'type'     		=> 'radio',
    'choices'     => array(
			'homepage_content' => esc_html__( 'Homepage content', 'melina' ),
			'magazine_page'    => esc_html__( 'Magazine page', 'melina' ),
		),
		'priority'    => 100,
	) );
}
add_action( 'customize_register', 'melina_customize_register_static_page_content' );
