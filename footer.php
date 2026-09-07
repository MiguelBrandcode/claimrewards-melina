<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Melina
 */

?>

		<?php
		/**
		 * Functions hooked in to melina_footer action:
		 *
		 * @hooked melina_post_navigation         - 10
		 * @hooked melina_related_posts           - 20
		 * @hooked melina_footer_instagram_widget - 30
		 */
		do_action( 'melina_content_bottom' ); ?>

	</div><!-- #content -->

	<footer id="colophon" class="footer">
		<div class="container">

			<?php
			/**
			 * Functions hooked in to melina_footer action:
			 *
			 * @hooked melina_footer_widgets - 10
			 * @hooked arkona_site_info      - 20 
			 */
			do_action( 'melina_footer' ); ?>

		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
/**
 * Functions hooked in to melina_site_after action:
 *
 * @hooked melina_scroll_to_top  - 10
 * @hooked melina_search_overlay - 20
 */
do_action( 'melina_site_after' );

wp_footer(); ?>

</body>
</html>
