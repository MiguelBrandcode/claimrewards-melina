<?php

/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Melina
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<?php
$langcode_short = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en';

$valid_languages = ['en', 'es', 'fr', 'de', 'it', 'pt', 'nl', 'da', 'sv', 'no', 'fi', 'pl'];

if (!in_array($langcode_short, $valid_languages)) {
	$langcode_short = 'en';
}
?>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-culture="<?php echo esc_attr($langcode_short); ?>"
		data-cbid="b8a6d98c-4a95-4775-8ccd-36d12edf7028" type="text/javascript" async></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php
	/**
	 * Functions hooked in to melina_site_before action:
	 *
	 * @hooked melina_skip_link - 0
	 */
	do_action('melina_site_before'); ?>

	<div id="page" class="site">
		<header id="masthead" class="header <?php do_action('melina_header_classes'); ?>">
			<div class="container">

				<?php
				/**
				 * Functions hooked into melina_header action:
				 *
				 * @hooked melina_site_branding  - 10
				 * @hooked melina_header_menu    - 20
				 */
				do_action('melina_header'); ?>

			</div><!-- .container -->
		</header><!-- #masthead -->

		<div id="content" class="content">

			<?php
			/**
			 * Functions hooked into melina_content_top action:
			 *
			 * @hooked melina_featured_content - 10
			 */
			do_action('melina_content_top'); ?>