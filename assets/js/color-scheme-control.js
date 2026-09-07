/**
* Add a listener to the Color Scheme control to update other color controls to new values/defaults.
* Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	"use strict";

	var cssTemplate = wp.template( 'melina-color-scheme' ),
		colorSchemeKeys = [
			'background_color',
			'page_background_color',
			'secondary_background_color',
			'text_primary_color',
			'text_secondary_color',
			'text_secondary_hover_color',
			'accent_color',
			'accent_hover_color',
			'success_color',
			'info_color',
			'warning_color',
			'danger_color',
			'border_color',
			'header_background_color',
			'header_border_color',
			'header_site_title_color',
			'header_site_title_hover_color',
			'header_menu_link_color',
			'header_menu_link_hover_color',
			'header_sub_menu_background_color',
			'header_sub_menu_link_color',
			'header_sub_menu_link_hover_color',
			'main_content_color',
			'footer_background_color',
			'footer_border_color',
			'footer_title_color',
			'footer_text_primary_color',
			'footer_text_secondary_color',
			'footer_link_color',
			'footer_link_hover_color',
		],
		colorSettings = [
			'background_color',
			'page_background_color',
			'secondary_background_color',
			'text_primary_color',
			'text_secondary_color',
			'text_secondary_hover_color',
			'accent_color',
			'accent_hover_color',
			'success_color',
			'info_color',
			'warning_color',
			'danger_color',
			'border_color',
			'header_background_color',
			'header_border_color',
			'header_site_title_color',
			'header_site_title_hover_color',
			'header_menu_link_color',
			'header_menu_link_hover_color',
			'header_sub_menu_background_color',
			'header_sub_menu_link_color',
			'header_sub_menu_link_hover_color',
			'main_content_color',
			'footer_background_color',
			'footer_border_color',
			'footer_title_color',
			'footer_text_primary_color',
			'footer_text_secondary_color',
			'footer_link_color',
			'footer_link_hover_color',
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					var colors = colorScheme[value].colors;

					// Update Background Color.
					var color = colors[0];
					api( 'background_color' ).set( color );
					api.control( 'background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Page Background Color.
					color = colors[1];
					api( 'page_background_color' ).set( color );
					api.control( 'page_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Secondary Background Color.
					color = colors[2];
					api( 'secondary_background_color' ).set( color );
					api.control( 'secondary_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Primary Text Color.
					color = colors[3];
					api( 'text_primary_color' ).set( color );
					api.control( 'text_primary_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Secondary Text Color.
					color = colors[4];
					api( 'text_secondary_color' ).set( color );
					api.control( 'text_secondary_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Secondary Text Hover Color.
					color = colors[5];
					api( 'text_secondary_hover_color' ).set( color );
					api.control( 'text_secondary_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Accent Color.
					color = colors[6];
					api( 'accent_color' ).set( color );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Accent Hover Color.
					color = colors[7];
					api( 'accent_hover_color' ).set( color );
					api.control( 'accent_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Success Color.
					color = colors[8];
					api( 'success_color' ).set( color );
					api.control( 'success_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Info Color.
					color = colors[9];
					api( 'info_color' ).set( color );
					api.control( 'info_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Warning Color.
					color = colors[10];
					api( 'warning_color' ).set( color );
					api.control( 'warning_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Danger Color.
					color = colors[11];
					api( 'danger_color' ).set( color );
					api.control( 'danger_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Borders Color.
					color = colors[12];
					api( 'border_color' ).set( color );
					api.control( 'border_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Background Color.
					color = colors[13];
					api( 'header_background_color' ).set( color );
					api.control( 'header_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Borders Color.
					color = colors[14];
					api( 'header_border_color' ).set( color );
					api.control( 'header_border_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Site Title Color.
					color = colors[15];
					api( 'header_site_title_color' ).set( color );
					api.control( 'header_site_title_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Site Title Hover Color.
					color = colors[16];
					api( 'header_site_title_hover_color' ).set( color );
					api.control( 'header_site_title_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Menu Links Color.
					color = colors[17];
					api( 'header_menu_link_color' ).set( color );
					api.control( 'header_menu_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Menu Links Hover Color.
					color = colors[18];
					api( 'header_menu_link_hover_color' ).set( color );
					api.control( 'header_menu_link_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Sub Menu Background Color.
					color = colors[19];
					api( 'header_sub_menu_background_color' ).set( color );
					api.control( 'header_sub_menu_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Sub Menu Links Color.
					color = colors[20];
					api( 'header_sub_menu_link_color' ).set( color );
					api.control( 'header_sub_menu_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Header Sub Menu Links Hover Color.
					color = colors[21];
					api( 'header_sub_menu_link_hover_color' ).set( color );
					api.control( 'header_sub_menu_link_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Main Content Color.
					color = colors[22];
					api( 'main_content_color' ).set( color );
					api.control( 'main_content_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Background Color.
					color = colors[23];
					api( 'footer_background_color' ).set( color );
					api.control( 'footer_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Borders Color.
					color = colors[24];
					api( 'footer_border_color' ).set( color );
					api.control( 'footer_border_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Title Color.
					color = colors[25];
					api( 'footer_title_color' ).set( color );
					api.control( 'footer_title_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Primary Text Color.
					color = colors[26];
					api( 'footer_text_primary_color' ).set( color );
					api.control( 'footer_text_primary_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Secondary Text Color.
					color = colors[27];
					api( 'footer_text_secondary_color' ).set( color );
					api.control( 'footer_text_secondary_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Links Color.
					color = colors[28];
					api( 'footer_link_color' ).set( color );
					api.control( 'footer_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Footer Links Hover Color.
					color = colors[29];
					api( 'footer_link_hover_color' ).set( color );
					api.control( 'footer_link_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(),
			css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		} );

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
