<?php
/**
 * Template for displaying search forms.
 *
 * @package Melina
 */

$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="search-form__label">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'melina' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-form__input" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'melina' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-form__button"><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'melina' ); ?></span></button>
	<input type="hidden" name="post_type" value="post" />
</form>
