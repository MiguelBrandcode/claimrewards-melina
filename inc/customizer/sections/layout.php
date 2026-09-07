<?php
/**
 * Customizer Layout Section.
 *
 * @package Melina
 */

/**
 * Add support for site layout settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_layout( $wp_customize ) {
	// Add section to change site layout.
	$wp_customize->add_section( 'melina_layout', array(
		'title'    => esc_html__( 'Site Layout', 'melina' ),
		'priority' => 25,
	) );

	// Add layout type settings and controls.
	$wp_customize->add_setting( 'layout_type', array(
		'default' 			    => 'wide',
		'sanitize_callback' => 'melina_sanitize_choices',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'layout_type', array(
		'label'    		=> esc_html__( 'Layout Type', 'melina' ),
		'description' => esc_html__( 'Select what type of layout you want to use in your site.', 'melina' ),
		'section'     => 'melina_layout',
		'type'        => 'radio',
		'choices'     => array(
			'wide'      => esc_html__( 'Wide Layout', 'melina' ),
			'boxed'     => esc_html__( 'Boxed Layout', 'melina' ),
		),
		'priority' 		=> 1,
	) );
}
add_action( 'customize_register', 'melina_customize_register_layout' );
