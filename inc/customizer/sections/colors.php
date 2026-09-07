<?php
/**
 * Customizer Colors Section.
 *
 * @package Melina
 */

/**
 * Add support for colors settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melina_customize_register_colors( $wp_customize ) {
  $color_scheme = melina_get_color_scheme();

  // Add color scheme settings and controls.
  $wp_customize->add_setting( 'color_scheme', array(
		'default'  			    => 'default',
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'melina_sanitize_color_scheme',
	) );

  $wp_customize->add_control( 'color_scheme', array(
		'label'    		=> esc_html__( 'Base Color Scheme', 'melina' ),
		'section'  		=> 'colors',
		'type'     		=> 'select',
		'choices'     => melina_get_color_scheme_choices(),
		'priority'    => 1,
	) );

  // Add page background color settings and controls.
  $wp_customize->add_setting( 'page_background_color', array(
		'default'  			    => $color_scheme[1],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'page_background_color', array(
        'label'    => esc_html__( 'Page Background Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 10,
      )
    )
  );

  // Add secondary background color settings and controls.
  $wp_customize->add_setting( 'secondary_background_color', array(
		'default'  			    => $color_scheme[2],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'secondary_background_color', array(
        'label'    => esc_html__( 'Secondary Background Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 20,
      )
    )
  );

  // Add primary text color settings and controls.
  $wp_customize->add_setting( 'text_primary_color', array(
		'default'  			    => $color_scheme[3],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'text_primary_color', array(
        'label'    => esc_html__( 'Primary Text Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 30,
      )
    )
  );

  // Add secondary text color settings and controls.
  $wp_customize->add_setting( 'text_secondary_color', array(
		'default'  			    => $color_scheme[4],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'text_secondary_color', array(
        'label'    => esc_html__( 'Secondary Text Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 40,
      )
    )
  );

  // Add secondary text hover color settings and controls.
  $wp_customize->add_setting( 'text_secondary_hover_color', array(
		'default'  			    => $color_scheme[5],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'text_secondary_hover_color', array(
        'label'    => esc_html__( 'Secondary Text Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 50,
      )
    )
  );

  // Add accent color settings and controls.
  $wp_customize->add_setting( 'accent_color', array(
		'default'  			    => $color_scheme[6],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'accent_color', array(
        'label'    => esc_html__( 'Accent Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 60,
      )
    )
  );

  // Add accent hover color settings and controls.
  $wp_customize->add_setting( 'accent_hover_color', array(
    'default'  			    => $color_scheme[7],
    'transport' 		    => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'accent_hover_color', array(
        'label'    => esc_html__( 'Accent Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 70,
      )
    )
  );

  // Add success color settings and controls.
  $wp_customize->add_setting( 'success_color', array(
		'default'  			    => $color_scheme[8],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'success_color', array(
        'label'    => esc_html__( 'Success Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 80,
      )
    )
  );

  // Add info color settings and controls.
  $wp_customize->add_setting( 'info_color', array(
		'default'  			    => $color_scheme[9],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'info_color', array(
        'label'    => esc_html__( 'Info Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 90,
      )
    )
  );

  // Add warning color settings and controls.
  $wp_customize->add_setting( 'warning_color', array(
		'default'  			    => $color_scheme[10],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'warning_color', array(
        'label'    => esc_html__( 'Warning Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 100,
      )
    )
  );

  // Add danger color settings and controls.
  $wp_customize->add_setting( 'danger_color', array(
		'default'  			    => $color_scheme[11],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'danger_color', array(
        'label'    => esc_html__( 'Danger Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 110,
      )
    )
  );

  // Add borders color settings and controls.
  $wp_customize->add_setting( 'border_color', array(
		'default'  			    => $color_scheme[12],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'border_color', array(
        'label'    => esc_html__( 'Borders Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 120,
      )
    )
  );

  // Add header background color settings and controls.
  $wp_customize->add_setting( 'header_background_color', array(
		'default'  			    => $color_scheme[13],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_background_color', array(
        'label'    => esc_html__( 'HEADER: Background Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 130,
      )
    )
  );

  // Add header borders color settings and controls.
  $wp_customize->add_setting( 'header_border_color', array(
		'default'  			    => $color_scheme[14],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_border_color', array(
        'label'    => esc_html__( 'HEADER: Borders Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 140,
      )
    )
  );

  // Add header site title color settings and controls.
  $wp_customize->add_setting( 'header_site_title_color', array(
		'default'  			    => $color_scheme[15],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_site_title_color', array(
        'label'    => esc_html__( 'HEADER: Site Title Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 150,
      )
    )
  );

  // Add header site title hover color settings and controls.
  $wp_customize->add_setting( 'header_site_title_hover_color', array(
    'default'  			    => $color_scheme[16],
    'transport' 		    => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_site_title_hover_color', array(
        'label'    => esc_html__( 'HEADER: Site Title Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 160,
      )
    )
  );

  // Add header menu links color settings and controls.
  $wp_customize->add_setting( 'header_menu_link_color', array(
		'default'  			    => $color_scheme[17],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_menu_link_color', array(
        'label'    => esc_html__( 'HEADER: Menu Links Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 170,
      )
    )
  );

  // Add header menu links hover color settings and controls.
  $wp_customize->add_setting( 'header_menu_link_hover_color', array(
		'default'  			    => $color_scheme[18],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_menu_link_hover_color', array(
        'label'    => esc_html__( 'HEADER: Menu Links Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 180,
      )
    )
  );

  // Add header sub menu background color settings and controls.
  $wp_customize->add_setting( 'header_sub_menu_background_color', array(
		'default'  			    => $color_scheme[19],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_sub_menu_background_color', array(
        'label'    => esc_html__( 'HEADER: Sub Menu Background Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 190,
      )
    )
  );

  // Add header sub menu links color settings and controls.
  $wp_customize->add_setting( 'header_sub_menu_link_color', array(
		'default'  			    => $color_scheme[20],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_sub_menu_link_color', array(
        'label'    => esc_html__( 'HEADER: Sub Menu Links Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 200,
      )
    )
  );

  // Add header sub menu links hover color settings and controls.
  $wp_customize->add_setting( 'header_sub_menu_link_hover_color', array(
		'default'  			    => $color_scheme[21],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'header_sub_menu_link_hover_color', array(
        'label'    => esc_html__( 'HEADER: Sub Menu Links Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 210,
      )
    )
  );

  // Add main content text color settings and controls.
  $wp_customize->add_setting( 'main_content_color', array(
		'default'  			    => $color_scheme[22],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'main_content_color', array(
        'label'    => esc_html__( 'CONTENT: Text Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 220,
      )
    )
  );

  // Add footer background color settings and controls.
  $wp_customize->add_setting( 'footer_background_color', array(
		'default'  			    => $color_scheme[23],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_background_color', array(
        'label'    => esc_html__( 'FOOTER: Background Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 230,
      )
    )
  );

  // Add footer borders color settings and controls.
  $wp_customize->add_setting( 'footer_border_color', array(
		'default'  			    => $color_scheme[24],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_border_color', array(
        'label'    => esc_html__( 'FOOTER: Borders Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 240,
      )
    )
  );

  // Add footer title color settings and controls.
  $wp_customize->add_setting( 'footer_title_color', array(
		'default'  			    => $color_scheme[25],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_title_color', array(
        'label'    => esc_html__( 'FOOTER: Title Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 250,
      )
    )
  );

  // Add footer primary text color settings and controls.
  $wp_customize->add_setting( 'footer_text_primary_color', array(
		'default'  			    => $color_scheme[26],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_text_primary_color', array(
        'label'    => esc_html__( 'FOOTER: Primary Text Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 260,
      )
    )
  );

  // Add footer secondary text color settings and controls.
  $wp_customize->add_setting( 'footer_text_secondary_color', array(
		'default'  			    => $color_scheme[27],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_text_secondary_color', array(
        'label'    => esc_html__( 'FOOTER: Secondary Text Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 270,
      )
    )
  );

  // Add footer links color settings and controls.
  $wp_customize->add_setting( 'footer_link_color', array(
		'default'  			    => $color_scheme[28],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_link_color', array(
        'label'    => esc_html__( 'FOOTER: Links Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 280,
      )
    )
  );

  // Add footer links hover color settings and controls.
  $wp_customize->add_setting( 'footer_link_hover_color', array(
		'default'  			    => $color_scheme[29],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'footer_link_hover_color', array(
        'label'    => esc_html__( 'FOOTER: Links Hover Color', 'melina' ),
        'section'  => 'colors',
        'priority' => 290,
      )
    )
  );
}
add_action( 'customize_register', 'melina_customize_register_colors' );

/**
 * Registers color schemes for Melina.
 *
 * Can be filtered with {@see 'melina_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Secondary Background Color.
 * 4. Primary Text Color.
 * 5. Secondary Text Color.
 * 6. Secondary Text Hover Color.
 * 7. Accent Color.
 * 8. Accent Hover Color.
 * 9. Success Color.
 * 10. Info Color.
 * 11. Warning Color.
 * 12. Danger Color.
 * 13. Borders Color.
 * 14. HEADER: Background Color.
 * 15. HEADER: Borders Color.
 * 16. HEADER: Site Title Color.
 * 17. HEADER: Site Title Hover Color.
 * 18. HEADER: Menu Links Color.
 * 19. HEADER: Menu Links Hover Color.
 * 20. HEADER: Sub Menu Background Color.
 * 21. HEADER: Sub Menu Links Color.
 * 22. HEADER: Sub Menu Links Hover Color.
 * 23. CONTENT: Text Color.
 * 24. FOOTER: Background Color.
 * 25. FOOTER: Borders Color.
 * 26. FOOTER: Title Color.
 * 27. FOOTER: Primary Text Color.
 * 28. FOOTER: Secondary Text Color.
 * 29. FOOTER: Links Color.
 * 30. FOOTER: Links Hover Color.
 *
 * @return array An associative array of color scheme options.
 */
function melina_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Melina.
	 *
	 * The default schemes include 'default'.
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *     }
	 * }
	 */
	return apply_filters( 'melina_color_schemes', array(
		'default' => array(
			'label'  => esc_html__( 'Default', 'melina' ),
			'colors' => array(
				'#e8e9ec', // Main Background Color
				'#ffffff', // Page Background Color
        '#f7f8fb', // Secondary Background Color
        '#17181e', // Primary Text Color
        '#707177', // Secondary Text Color
        '#4a4b51', // Secondary Text Hover Color
        '#d42929', // Accent Color
        '#c82f2f', // Accent Hover Color
        '#00c82c', // Success Color
        '#244580', // Info Color
        '#ffa138', // Warning Color
        '#d42929', // Danger Color
        '#e8e9ec', // Borders Color
        '#ffffff', // HEADER: Background Color
        '#e8e9ec', // HEADER: Borders Color
        '#17181e', // HEADER: Site Title Color
        '#17181e', // HEADER: Site Title Hover Color
        '#17181e', // HEADER: Menu Links Color
        '#d42929', // HEADER: Menu Links Hover Color
        '#17181e', // HEADER: Sub Menu Background Color
        '#999a9e', // HEADER: Sub Menu Links Color
        '#e8e9ec', // HEADER: Sub Menu Links Hover Color
        '#2d2e34', // CONTENT: Text Color
        '#17181e', // FOOTER: Background Color
        '#2d2e34', // FOOTER: Borders Color
        '#ffffff', // FOOTER: Title Color
        '#999a9e', // FOOTER: Primary Text Color
        '#707177', // FOOTER: Secondary Text Color
        '#999a9e', // FOOTER: Links Color
        '#e8e9ec', // FOOTER: Links Hover Color
			),
		),
	) );
}

if ( ! function_exists( 'melina_get_color_scheme' ) ) :
/**
 * Retrieves the current Melina color scheme.
 *
 * Create your own melina_get_color_scheme() function to override in a child theme.
 *
 * @return array An associative array of either the current or default color scheme HEX values.
 */
function melina_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = melina_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif;

if ( ! function_exists( 'melina_get_color_scheme_choices' ) ) :
/**
 * Retrieves an array of color scheme choices registered for Melina.
 *
 * Create your own melina_get_color_scheme_choices() function to override in a child theme.
 *
 * @return array Array of color schemes.
 */
function melina_get_color_scheme_choices() {
	$color_schemes                = melina_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif;

if ( ! function_exists( 'melina_sanitize_color_scheme' ) ) :
/**
 * Handles sanitization for Melina color schemes.
 *
 * Create your own melina_sanitize_color_scheme() function to override in a child theme.
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function melina_sanitize_color_scheme( $value ) {
	$color_schemes = melina_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		return 'default';
	}

	return $value;
}
endif;

/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function melina_color_scheme_css_template() {
	$colors = array(
		'background_color'                 => '{{ data.background_color }}',
		'page_background_color'            => '{{ data.page_background_color }}',
    'secondary_background_color'       => '{{ data.secondary_background_color }}',
    'text_primary_color'               => '{{ data.text_primary_color }}',
    'text_secondary_color'             => '{{ data.text_secondary_color }}',
    'text_secondary_hover_color'       => '{{ data.text_secondary_hover_color }}',
    'accent_color'                     => '{{ data.accent_color }}',
    'accent_hover_color'               => '{{ data.accent_hover_color }}',
    'success_color'                    => '{{ data.success_color }}',
    'info_color'                       => '{{ data.info_color }}',
    'warning_color'                    => '{{ data.warning_color }}',
    'danger_color'                     => '{{ data.danger_color }}',
    'border_color'                     => '{{ data.border_color }}',
    'header_background_color'          => '{{ data.header_background_color }}',
    'header_border_color'              => '{{ data.header_border_color }}',
    'header_site_title_color'          => '{{ data.header_site_title_color }}',
    'header_site_title_hover_color'    => '{{ data.header_site_title_hover_color }}',
    'header_menu_link_color'           => '{{ data.header_menu_link_color }}',
    'header_menu_link_hover_color'     => '{{ data.header_menu_link_hover_color }}',
    'header_sub_menu_background_color' => '{{ data.header_sub_menu_background_color }}',
    'header_sub_menu_link_color'       => '{{ data.header_sub_menu_link_color }}',
    'header_sub_menu_link_hover_color' => '{{ data.header_sub_menu_link_hover_color }}',
    'main_content_color'               => '{{ data.main_content_color }}',
    'footer_background_color'          => '{{ data.footer_background_color }}',
    'footer_border_color'              => '{{ data.footer_border_color }}',
    'footer_title_color'               => '{{ data.footer_title_color }}',
    'footer_text_primary_color'        => '{{ data.footer_text_primary_color }}',
    'footer_text_secondary_color'      => '{{ data.footer_text_secondary_color }}',
    'footer_link_color'                => '{{ data.footer_link_color }}',
    'footer_link_hover_color'          => '{{ data.footer_link_hover_color }}',
	);
	?>
	<script type="text/html" id="tmpl-melina-color-scheme">
		<?php echo melina_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'melina_color_scheme_css_template' );
