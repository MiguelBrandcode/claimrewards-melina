<?php
/**
 * Customizer Content Area Section.
 *
 * @package Melina
 */

/**
 * Add support for content area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_content_area( $wp_customize ) {
  // Add section to change content area.
  $wp_customize->add_section( 'melina_content_area', array(
    'title'    => esc_html__( 'Content Area Settings', 'melina' ),
    'priority' => 145,
  ) );

  // Add layout settings and controls.
	$wp_customize->add_setting( 'content_layout', array(
		'default'  			    => 'classic',
		'sanitize_callback' => 'melina_sanitize_choices',
	) );

	$wp_customize->add_control( 'content_layout', array(
		'label'    		=> esc_html__( 'Content Layout', 'melina' ),
		'description' => esc_html__( 'Select the layout to display your posts list.', 'melina' ),
		'section'  		=> 'melina_content_area',
		'type'     		=> 'radio',
		'choices' 		=> array(
			'classic'    => esc_html__( 'Classic layout', 'melina' ),
      'list-v1'    => esc_html__( 'List layout', 'melina' ),
      'list-v2'    => esc_html__( 'Full-width list layout', 'melina' ),
      'list-v3'    => esc_html__( 'First large then list', 'melina' ),
      'list-v4'    => esc_html__( 'First large then list (full-width)', 'melina' ),
      'list-v5'    => esc_html__( 'Mixed: large and list', 'melina' ),
      'list-v6'    => esc_html__( 'Mixed: large and list (full-width)', 'melina' ),
      'grid-v1'    => esc_html__( 'Two-column grid layout', 'melina' ),
      'grid-v2'    => esc_html__( 'Two-column grid layout (full-width)', 'melina' ),
      'grid-v3'    => esc_html__( 'First large then two-column grid', 'melina' ),
      'grid-v4'    => esc_html__( 'First large then two-column grid (full-width)', 'melina' ),
      'grid-v5'    => esc_html__( 'Mixed: large and two-column grid', 'melina' ),
      'grid-v6'    => esc_html__( 'Mixed: large and two-column grid (full-width)', 'melina' ),
      'grid-v7'    => esc_html__( 'Three-column full-width grid layout', 'melina' ),
      'grid-v8'    => esc_html__( 'First large then three-column grid (full-width)', 'melina' ),
      'grid-v9'    => esc_html__( 'Mixed: large and three-column grid (full-width)', 'melina' ),
      'grid-v10'   => esc_html__( 'Mixed: large and small post cards (full-width)', 'melina' ),
      'masonry-v1' => esc_html__( 'Three-column full-width masonry layout', 'melina' ),
      'masonry-v2' => esc_html__( 'Mixed three-column full-width masonry layout', 'melina' ),
		),
		'priority'    => 10,
	) );

  // Add post navigation settings and controls.
	$wp_customize->add_setting( 'post_navigation', array(
		'default'  					=> 'enable',
		'sanitize_callback' => 'melina_sanitize_choices',
    'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'post_navigation', array(
		'label'    		=> esc_html__( 'Post Navigation', 'melina' ),
    'description' => esc_html__( 'Display post navigation before the footer.', 'melina' ),
		'section'  		=> 'melina_content_area',
		'type'     		=> 'radio',
    'choices' 		=> array(
      'enable'    => esc_html__( 'Enable Post Navigation', 'melina' ),
      'disable'   => esc_html__( 'Disable Post Navigation', 'melina' ),
    ),
		'priority' 		=> 20,
	) );

  $wp_customize->selective_refresh->add_partial( 'post_navigation', array(
		'selector'            => '#post-navigation-area',
		'render_callback'     => 'melina_post_navigation',
    'container_inclusive' => true,
	) );

  // Add related posts settings and controls.
	$wp_customize->add_setting( 'related_posts', array(
		'default'  					=> 'enable',
		'sanitize_callback' => 'melina_sanitize_choices',
    'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'related_posts', array(
		'label'    		=> esc_html__( 'Related Posts', 'melina' ),
    'description' => esc_html__( 'Display related posts before the footer.', 'melina' ),
		'section'  		=> 'melina_content_area',
		'type'     		=> 'radio',
    'choices' 		=> array(
      'enable'    => esc_html__( 'Enable Related Posts', 'melina' ),
      'disable'   => esc_html__( 'Disable Related Posts', 'melina' ),
    ),
		'priority' 		=> 30,
	) );

  $wp_customize->selective_refresh->add_partial( 'related_posts', array(
		'selector'            => '#related-posts',
		'render_callback'     => 'melina_related_posts',
    'container_inclusive' => true,
	) );

  // Add sidebar position settings and controls.
  $wp_customize->add_setting( 'sidebar_position', array(
    'default'  			    => 'right',
    'sanitize_callback' => 'melina_sanitize_choices',
    'transport' 		    => 'postMessage',
  ) );

  $wp_customize->add_control( 'sidebar_position', array(
    'label'    		=> esc_html__( 'Sidebar Position', 'melina' ),
    'description' => esc_html__( 'Select sidebar position. You can also delete all widgets from the sidebar to turn on "Without sidebar" mode.', 'melina' ),
    'section'  		=> 'melina_content_area',
    'type'     		=> 'radio',
    'choices' 		=> array(
      'right'     => esc_html__( 'Right sidebar', 'melina' ),
      'left'      => esc_html__( 'Left sidebar', 'melina' ),
      'no' 	      => esc_html__( 'Without sidebar', 'melina' ),
    ),
    'priority'    => 40,
  ) );

  // Add sticky sidebar settings and controls.
	$wp_customize->add_setting( 'sticky_sidebar', array(
		'default'  					=> 'enable',
		'sanitize_callback' => 'melina_sanitize_choices',
    'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'sticky_sidebar', array(
		'label'    		=> esc_html__( 'Sticky Sidebar', 'melina' ),
    'description' => esc_html__( 'Make the sidebar stick to the top of the window when scrolling.', 'melina' ),
		'section'  		=> 'melina_content_area',
		'type'     		=> 'radio',
    'choices' 		=> array(
      'enable'    => esc_html__( 'Enable Sticky Sidebar', 'melina' ),
      'disable'   => esc_html__( 'Disable Sticky Sidebar', 'melina' ),
    ),
		'priority' 		=> 50,
	) );
}
add_action( 'customize_register', 'melina_customize_register_content_area' );
