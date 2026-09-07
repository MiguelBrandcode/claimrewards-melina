<?php
/**
 * The template part for displaying search overlay.
 *
 * @package Melina
 */

?>

<!-- Search -->
<div id="search-overlay" class="search-overlay">
	<button type="button" class="button--close" aria-label="<?php esc_attr_e( 'Close', 'melina' ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Close', 'melina' ); ?></span>
	</button>

	<?php get_template_part( 'searchform' ); ?>
</div>
