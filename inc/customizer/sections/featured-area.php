<?php
/**
 * Customizer Featured Area Section.
 *
 * @package Melina
 */

/**
 * Add support for featured area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_featured_area( $wp_customize ) {
	// Add section to change featured area.
	$wp_customize->add_section( 'melina_featured_area', array(
		'title'    => esc_html__( 'Featured Area Settings', 'melina' ),
		'priority' => 140,
	) );

	// Add featured content settings and controls.
	$wp_customize->add_setting( 'featured_content', array(
		'default' 			    => 'site-info',
		'sanitize_callback' => 'melina_sanitize_choices',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'featured_content', array(
		'label'    		=> esc_html__( 'Featured Content', 'melina' ),
		'description' => esc_html__( 'Select what type of content you want to see in featured area.', 'melina' ),
		'section'     => 'melina_featured_area',
		'type'        => 'radio',
		'choices'     => array(
			'no' 		      => esc_html__( 'Don\'t Display Featured Content', 'melina' ),
			'site-info'   => esc_html__( 'Tagline and Header Image', 'melina' ),
			'carousel-v1' => esc_html__( 'Wide Posts Carousel', 'melina' ),
			'carousel-v2' => esc_html__( 'Boxed Posts Carousel', 'melina' ),
			'carousel-v3' => esc_html__( 'Full Width Posts Carousel', 'melina' ),
			'carousel-v4' => esc_html__( 'Full Width Posts Carousel With Transparent Header', 'melina' ),
		),
		'priority' 		=> 1,
	) );

	$wp_customize->selective_refresh->add_partial( 'featured_content', array(
		'selector'            => '#featured-content-area',
		'render_callback'     => 'melina_featured_content',
    'container_inclusive' => true,
	) );
}
add_action( 'customize_register', 'melina_customize_register_featured_area' );
