<?php
/**
 * Customizer Magazine Page Section.
 *
 * @package Melina
 */

/**
 * Add support for magazine page settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_magazine_page( $wp_customize ) {
	// Add section to change magazine page.
	$wp_customize->add_section( 'melina_magazine_page', array(
		'title'       => esc_html__( 'Magazine Page Settings', 'melina' ),
		'description' => esc_html__( 'Magazine Page is displaying when in Homepage Settings homepage displays is set to a static page and static page displays is set to magazine page. Magazine Page displays the latest entries from the selected categories.', 'melina' ),
		'priority'    => 135,
	) );

	/**
	 * Filter number of magazine page sections.
	 *
	 * @param int $num_sections Number of magazine page sections.
	 */
	$num_sections = apply_filters( 'melina_magazine_page_sections', 7 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'magazine_section_' . $i, array(
			'default' 			    => 'none',
			'sanitize_callback' => 'melina_sanitize_choices',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'magazine_section_' . $i, array(
			/* translators: %d is the magazine page category section number */
			'label'    		    => sprintf( esc_html__( 'Category %d', 'melina' ), $i ),
			'description'     => ( 1 !== $i ? '' : esc_html__( 'Select the category from which entries will be displayed on the Magazine Page.', 'melina' ) ),
			'section'         => 'melina_magazine_page',
			'type'            => 'select',
			'choices'         => melina_get_list_of_categories(),
			'active_callback' => 'melina_is_magazine_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'magazine_section_' . $i, array(
			'selector'            => '#magazine-section-' . $i,
			'render_callback'     => 'melina_magazine_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'melina_customize_register_magazine_page' );

if ( ! function_exists( 'melina_get_list_of_categories' ) ) :
/**
 * Retrieves list of categories.
 *
 * Create your own melina_get_list_of_categories() function to override
 * in a child theme.
 *
 * @return array Array of categories.
 */
function melina_get_list_of_categories() {
	$categories       = get_categories();
	$category_options = array();

	$category_options[ 'none' ] = esc_html__( 'Don\'t display', 'melina' );

	foreach ( $categories as $category ) {
		$category_options[ $category->cat_ID ] = $category->cat_name;
	}

	return $category_options;
}
endif;

/**
 * Return whether we're previewing the front page and it's a static page.
 */
function melina_is_magazine_page() {
	return ( is_front_page() && ! is_home() && 'magazine_page' === get_theme_mod( 'static_page_content', 'homepage_content' ) );
}
