<?php
/**
 * Color Scheme CSS
 *
 * @package Melina
 */

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function melina_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = melina_get_color_scheme();

	$colors = array(
		'background_color'                 => $color_scheme[0],
		'page_background_color'            => $color_scheme[1],
		'secondary_background_color'       => $color_scheme[2],
		'text_primary_color'               => $color_scheme[3],
		'text_secondary_color'             => $color_scheme[4],
		'text_secondary_hover_color'       => $color_scheme[5],
		'accent_color'                     => $color_scheme[6],
		'accent_hover_color'               => $color_scheme[7],
		'success_color'                    => $color_scheme[8],
		'info_color'                       => $color_scheme[9],
		'warning_color'                    => $color_scheme[10],
		'danger_color'                     => $color_scheme[11],
		'border_color'                     => $color_scheme[12],
		'header_background_color'          => $color_scheme[13],
		'header_border_color'              => $color_scheme[14],
		'header_site_title_color'          => $color_scheme[15],
		'header_site_title_hover_color'    => $color_scheme[16],
		'header_menu_link_color'           => $color_scheme[17],
		'header_menu_link_hover_color'     => $color_scheme[18],
		'header_sub_menu_background_color' => $color_scheme[19],
		'header_sub_menu_link_color'       => $color_scheme[20],
		'header_sub_menu_link_hover_color' => $color_scheme[21],
		'main_content_color'               => $color_scheme[22],
		'footer_background_color'          => $color_scheme[23],
		'footer_border_color'              => $color_scheme[24],
		'footer_title_color'               => $color_scheme[25],
		'footer_text_primary_color'        => $color_scheme[26],
		'footer_text_secondary_color'      => $color_scheme[27],
		'footer_link_color'                => $color_scheme[28],
		'footer_link_hover_color'          => $color_scheme[29],
	);

  $color_scheme_css = melina_get_color_scheme_css( $colors );

	wp_add_inline_style( 'melina-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'melina_color_scheme_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function melina_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'background_color'                 => '',
		'page_background_color'            => '',
		'secondary_background_color'       => '',
		'text_primary_color'               => '',
		'text_secondary_color'             => '',
		'text_secondary_hover_color'       => '',
		'accent_color'                     => '',
		'accent_hover_color'               => '',
		'success_color'                    => '',
		'info_color'                       => '',
		'warning_color'                    => '',
		'danger_color'                     => '',
		'border_color'                     => '',
		'header_background_color'          => '',
		'header_border_color'              => '',
		'header_site_title_color'          => '',
		'header_site_title_hover_color'    => '',
		'header_menu_link_color'           => '',
		'header_menu_link_hover_color'     => '',
		'header_sub_menu_background_color' => '',
		'header_sub_menu_link_color'       => '',
		'header_sub_menu_link_hover_color' => '',
		'main_content_color'               => '',
		'footer_background_color'          => '',
		'footer_border_color'              => '',
		'footer_title_color'               => '',
		'footer_text_primary_color'        => '',
		'footer_text_secondary_color'      => '',
		'footer_link_color'                => '',
		'footer_link_hover_color'          => '',
	) );

	$css = '
		/* Color Scheme */
		:root {
			--body__BackgroundColor: ' . $colors['background_color'] . ';
			--site__BackgroundColor: ' . $colors['page_background_color'] . ';
			--secondary__BackgroundColor: ' . $colors['secondary_background_color'] . ';
			--text--primary__Color: ' . $colors['text_primary_color'] . ';
			--text--secondary__Color: ' . $colors['text_secondary_color'] . ';
			--text--secondary--hover__Color: ' . $colors['text_secondary_hover_color'] . ';
			--accent__Color: ' . $colors['accent_color'] . ';
			--accent--hover__Color: ' . $colors['accent_hover_color'] . ';
			--success__Color: ' . $colors['success_color'] . ';
			--info__Color: ' . $colors['info_color'] . ';
			--warning__Color: ' . $colors['warning_color'] . ';
			--danger__Color: ' . $colors['danger_color'] . ';
			--border__Color: ' . $colors['border_color'] . ';
			--header__BackgroundColor: ' . $colors['header_background_color'] . ';
			--header__BorderColor: ' . $colors['header_border_color'] . ';
			--site-title__Color: ' . $colors['header_site_title_color'] . ';
			--site-title--hover__Color: ' . $colors['header_site_title_hover_color'] . ';
			--header-menu-link__Color: ' . $colors['header_menu_link_color'] . ';
			--header-menu-link--hover__Color: ' . $colors['header_menu_link_hover_color'] . ';
			--header-sub-menu__BackgroundColor: ' . $colors['header_sub_menu_background_color'] . ';
			--header-sub-menu-link__Color: ' . $colors['header_sub_menu_link_color'] . ';
			--header-sub-menu-link--hover__Color: ' . $colors['header_sub_menu_link_hover_color'] . ';
			--content-text__Color: ' . $colors['main_content_color'] . ';
			--footer__BackgroundColor: ' . $colors['footer_background_color'] . ';
			--footer__BorderColor: ' . $colors['footer_border_color'] . ';
			--footer-title__Color: ' . $colors['footer_title_color'] . ';
			--footer-text--primary__Color: ' . $colors['footer_text_primary_color'] . ';
			--footer-text--secondary__Color: ' . $colors['footer_text_secondary_color'] . ';
			--footer-link__Color: ' . $colors['footer_link_color'] . ';
			--footer-link--hover__Color: ' . $colors['footer_link_hover_color'] . ';
		}
	';

	/**
	 * Filters custom colors CSS.
	 *
	 * @param string $css Base theme colors CSS.
	 */
	return apply_filters( 'melina_get_color_scheme_css', $css );
}

/**
 * Enqueues front-end CSS for the page background color.
 *
 * @see wp_add_inline_style()
 */
function melina_page_background_color_css() {
	$color_scheme          = melina_get_color_scheme();
	$default_color         = $color_scheme[1];
	$page_background_color = get_theme_mod( 'page_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $page_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Page Background Color */
		:root {
			--site__BackgroundColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $page_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_page_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the secondary background color.
 *
 * @see wp_add_inline_style()
 */
function melina_secondary_background_color_css() {
	$color_scheme               = melina_get_color_scheme();
	$default_color              = $color_scheme[2];
	$secondary_background_color = get_theme_mod( 'secondary_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $secondary_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Secondary Background Color */
		:root {
			--secondary__BackgroundColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $secondary_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_secondary_background_color_css', 11 );

/**
 * Enqueues front-end CSS for primary text color.
 *
 * @see wp_add_inline_style()
 */
function melina_text_primary_color_css() {
	$color_scheme       = melina_get_color_scheme();
	$default_color      = $color_scheme[3];
	$text_primary_color = get_theme_mod( 'text_primary_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $text_primary_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Primary Text Color */
		:root {
			--text--primary__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $text_primary_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_text_primary_color_css', 11 );

/**
 * Enqueues front-end CSS for secondary text color.
 *
 * @see wp_add_inline_style()
 */
function melina_text_secondary_color_css() {
	$color_scheme         = melina_get_color_scheme();
	$default_color        = $color_scheme[4];
	$text_secondary_color = get_theme_mod( 'text_secondary_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $text_secondary_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Secondary Text Color */
		:root {
			--text--secondary__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $text_secondary_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_text_secondary_color_css', 11 );

/**
 * Enqueues front-end CSS for secondary text hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_text_secondary_hover_color_css() {
	$color_scheme               = melina_get_color_scheme();
	$default_color              = $color_scheme[5];
	$text_secondary_hover_color = get_theme_mod( 'text_secondary_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $text_secondary_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Secondary Text Hover Color */
		:root {
			--text--secondary--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $text_secondary_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_text_secondary_hover_color_css', 11 );

/**
 * Enqueues front-end CSS for accent color.
 *
 * @see wp_add_inline_style()
 */
function melina_accent_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[6];
	$accent_color  = get_theme_mod( 'accent_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $accent_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Accent Color */
		:root {
			--accent__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $accent_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_accent_color_css', 11 );

/**
 * Enqueues front-end CSS for accent hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_accent_hover_color_css() {
	$color_scheme       = melina_get_color_scheme();
	$default_color      = $color_scheme[7];
	$accent_hover_color = get_theme_mod( 'accent_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $accent_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Accent Hover Color */
		:root {
			--accent--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $accent_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_accent_hover_color_css', 11 );

/**
 * Enqueues front-end CSS for success color.
 *
 * @see wp_add_inline_style()
 */
function melina_success_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[8];
	$success_color = get_theme_mod( 'success_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $success_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Success Color */
		:root {
			--success__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $success_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_success_color_css', 11 );

/**
 * Enqueues front-end CSS for info color.
 *
 * @see wp_add_inline_style()
 */
function melina_info_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[9];
	$info_color    = get_theme_mod( 'info_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $info_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Info Color */
		:root {
			--info__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $info_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_info_color_css', 11 );

/**
 * Enqueues front-end CSS for warning color.
 *
 * @see wp_add_inline_style()
 */
function melina_warning_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[10];
	$warning_color = get_theme_mod( 'warning_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $warning_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Warning Color */
		:root {
			--warning__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $warning_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_warning_color_css', 11 );

/**
 * Enqueues front-end CSS for danger color.
 *
 * @see wp_add_inline_style()
 */
function melina_danger_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[11];
	$danger_color  = get_theme_mod( 'danger_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $danger_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Danger Color */
		:root {
			--danger__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $danger_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_danger_color_css', 11 );

/**
 * Enqueues front-end CSS for borders color.
 *
 * @see wp_add_inline_style()
 */
function melina_border_color_css() {
	$color_scheme  = melina_get_color_scheme();
	$default_color = $color_scheme[12];
	$border_color  = get_theme_mod( 'border_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $border_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Borders Color */
		:root {
			--border__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $border_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_border_color_css', 11 );

/**
 * Enqueues front-end CSS for header background color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_background_color_css() {
	$color_scheme            = melina_get_color_scheme();
	$default_color           = $color_scheme[13];
	$header_background_color = get_theme_mod( 'header_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Background Color */
		:root {
			--header__BackgroundColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_background_color_css', 11 );

/**
 * Enqueues front-end CSS for header borders color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_borders_color_css() {
	$color_scheme        = melina_get_color_scheme();
	$default_color       = $color_scheme[14];
	$header_border_color = get_theme_mod( 'header_border_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_border_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Borders Color */
		:root {
			--header__BorderColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_border_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_borders_color_css', 11 );

/**
 * Enqueues front-end CSS for header site title color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_site_title_color_css() {
	$color_scheme            = melina_get_color_scheme();
	$default_color           = $color_scheme[15];
	$header_site_title_color = get_theme_mod( 'header_site_title_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_site_title_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Site Title Color */
		:root {
			--site-title__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_site_title_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_site_title_color_css', 11 );

/**
 * Enqueues front-end CSS for header site title hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_site_title_hover_color_css() {
	$color_scheme                  = melina_get_color_scheme();
	$default_color                 = $color_scheme[16];
	$header_site_title_hover_color = get_theme_mod( 'header_site_title_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_site_title_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Site Title Hover Color */
		:root {
			--site-title--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_site_title_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_site_title_hover_color_css', 11 );

/**
 * Enqueues front-end CSS for header menu links color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_menu_link_color_css() {
	$color_scheme           = melina_get_color_scheme();
	$default_color          = $color_scheme[17];
	$header_menu_link_color = get_theme_mod( 'header_menu_link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_menu_link_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Menu Links Color */
		:root {
			--header-menu-link__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_menu_link_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_menu_link_color_css', 11 );

/**
 * Enqueues front-end CSS for header menu links hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_menu_link_hover_color_css() {
	$color_scheme                 = melina_get_color_scheme();
	$default_color                = $color_scheme[18];
	$header_menu_link_hover_color = get_theme_mod( 'header_menu_link_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_menu_link_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Menu Links Hover Color */
		:root {
			--header-menu-link--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_menu_link_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_menu_link_hover_color_css', 11 );

/**
 * Enqueues front-end CSS for header sub menu background color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_sub_menu_background_color_css() {
	$color_scheme                     = melina_get_color_scheme();
	$default_color                    = $color_scheme[19];
	$header_sub_menu_background_color = get_theme_mod( 'header_sub_menu_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_sub_menu_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Sub Menu Background Color */
		:root {
			--header-sub-menu__BackgroundColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_sub_menu_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_sub_menu_background_color_css', 11 );

/**
 * Enqueues front-end CSS for header sub menu links color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_sub_menu_link_color_css() {
	$color_scheme               = melina_get_color_scheme();
	$default_color              = $color_scheme[20];
	$header_sub_menu_link_color = get_theme_mod( 'header_sub_menu_link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_sub_menu_link_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Sub Menu Links Color */
		:root {
			--header-sub-menu-link__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_sub_menu_link_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_sub_menu_link_color_css', 11 );

/**
 * Enqueues front-end CSS for header sub menu links hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_header_sub_menu_link_hover_color_css() {
	$color_scheme                     = melina_get_color_scheme();
	$default_color                    = $color_scheme[21];
	$header_sub_menu_link_hover_color = get_theme_mod( 'header_sub_menu_link_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_sub_menu_link_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Sub Menu Links Hover Color */
		:root {
			--header-sub-menu-link--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $header_sub_menu_link_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_header_sub_menu_link_hover_color_css', 11 );

/**
 * Enqueues front-end CSS for main content color.
 *
 * @see wp_add_inline_style()
 */
function melina_main_content_color_css() {
	$color_scheme       = melina_get_color_scheme();
	$default_color      = $color_scheme[22];
	$main_content_color = get_theme_mod( 'main_content_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $main_content_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Main Content Color */
		:root {
			--content-text__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $main_content_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_main_content_color_css', 11 );

/**
 * Enqueues front-end CSS for footer background color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_background_color_css() {
	$color_scheme            = melina_get_color_scheme();
	$default_color           = $color_scheme[23];
	$footer_background_color = get_theme_mod( 'footer_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Background Color */
		:root {
			--footer__BackgroundColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_background_color_css', 11 );

/**
 * Enqueues front-end CSS for footer borders color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_border_color_css() {
	$color_scheme        = melina_get_color_scheme();
	$default_color       = $color_scheme[24];
	$footer_border_color = get_theme_mod( 'footer_border_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_border_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Border Color */
		:root {
			--footer__BorderColor: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_border_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_border_color_css', 11 );

/**
 * Enqueues front-end CSS for footer title color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_title_color_css() {
	$color_scheme       = melina_get_color_scheme();
	$default_color      = $color_scheme[25];
	$footer_title_color = get_theme_mod( 'footer_title_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_title_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Title Color */
		:root {
			--footer-title__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_title_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_title_color_css', 11 );

/**
 * Enqueues front-end CSS for footer primary text color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_text_primary_color_css() {
	$color_scheme              = melina_get_color_scheme();
	$default_color             = $color_scheme[26];
	$footer_text_primary_color = get_theme_mod( 'footer_text_primary_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_text_primary_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Primary Text Color */
		:root {
			--footer-text--primary__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_text_primary_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_text_primary_color_css', 11 );

/**
 * Enqueues front-end CSS for footer secondary text color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_text_secondary_color_css() {
	$color_scheme                = melina_get_color_scheme();
	$default_color               = $color_scheme[27];
	$footer_text_secondary_color = get_theme_mod( 'footer_text_secondary_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_text_secondary_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Secondary Text Color */
		:root {
			--footer-text--secondary__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_text_secondary_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_text_secondary_color_css', 11 );

/**
 * Enqueues front-end CSS for footer link color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_link_color_css() {
	$color_scheme      = melina_get_color_scheme();
	$default_color     = $color_scheme[28];
	$footer_link_color = get_theme_mod( 'footer_link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_link_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Link Color */
		:root {
			--footer-link__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_link_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_link_color_css', 11 );

/**
 * Enqueues front-end CSS for footer link hover color.
 *
 * @see wp_add_inline_style()
 */
function melina_footer_link_hover_color_css() {
	$color_scheme            = melina_get_color_scheme();
	$default_color           = $color_scheme[29];
	$footer_link_hover_color = get_theme_mod( 'footer_link_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $footer_link_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Footer Link Hover Color */
		:root{
			--footer-link--hover__Color: %1$s;
		}
	';

	wp_add_inline_style( 'melina-style', sprintf( $css, $footer_link_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'melina_footer_link_hover_color_css', 11 );
