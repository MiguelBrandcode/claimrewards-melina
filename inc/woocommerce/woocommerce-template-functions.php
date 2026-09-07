<?php
/**
 * WooCommerce Template Functions
 *
 * @package Melina
 */

if ( ! function_exists( 'melina_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function melina_cart_link_fragment( $fragments ) {
		ob_start();
		melina_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'melina_cart_link_fragment' );

if ( ! function_exists( 'melina_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function melina_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'melina' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				esc_html( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'melina' ) ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
				<span class="count" title="<?php echo esc_html( $item_count_text ); ?>"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
			<?php endif; ?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'melina_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function melina_header_cart() {
		if ( is_cart() ) {
			$class = ' current-menu-item';
		} else {
			$class = '';
		} ?>

		<li id="site-header-cart" class="menu-item menu-item--cart menu-item-has-children<?php echo esc_attr( $class ); ?>">
			<?php melina_cart_link(); ?>

			<ul class="sub-menu">
				<li class="menu-item">
					<?php
					$instance = array(
						'title' => '',
					);

					the_widget( 'WC_Widget_Cart', $instance );
					?>
				</li>
			</ul>
		</li>

	<?php
	}
}

if ( ! function_exists( 'melina_header_account' ) ) {
	/**
	 * Display Header Account Link.
	 *
	 * @return void
	 */
	function melina_header_account() {
		if ( is_account_page() ) {
			$class = ' current-menu-item';
		} else {
			$class = '';
		} ?>

		<li id="site-header-account" class="menu-item menu-item--account<?php echo esc_attr( $class ); ?>">
			<?php
			if ( is_user_logged_in() ) : ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('My Account','melina'); ?>">
					<span><?php esc_html_e('My Account','melina'); ?></span>
				</a>
			<?php
			else : ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('Login / Register','melina'); ?>">
					<span><?php esc_html_e('Login / Register','melina'); ?></span>
				</a>
			<?php
			endif; ?>
		</li>

	<?php
	}
}

if ( ! function_exists( 'melina_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return void
	 */
	function melina_before_content() {
		?>
    <div id="content-area" class="content-area">
    	<div class="container">
    		<main id="primary" class="main-content">
		<?php
	}
}

if ( ! function_exists( 'melina_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return void
	 */
	function melina_after_content() {
		?>
        </main><!-- #primary -->

				<?php do_action( 'melina_woocommerce_sidebar' ); ?>
      </div><!-- .container -->
    </div><!-- #content-area -->
		<?php
	}
}

if ( ! function_exists( 'melina_sorting_wrapper' ) ) {
	/**
	 * Before woocommerce_result_count
	 *
	 * Sorting wrapper
	 *
	 * @return void
	 */
	function melina_sorting_wrapper() {
		echo '<div class="woocommerce-sorting">';
	}
}

if ( ! function_exists( 'melina_sorting_wrapper_close' ) ) {
	/**
	 * After woocommerce_catalog_ordering
	 *
	 * Sorting wrapper close
	 *
	 * @return void
	 */
	function melina_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'melina_loop_item_thumbnail_before' ) ) {
	/**
	 * Before melina_show_product_loop_badges_open
	 *
	 * Wraps product thumbnail, onsale and add to card buton
	 *
	 * @return void
	 */
	function melina_loop_item_thumbnail_before() {
		echo '<div class="woocommerce-loop-product__thumbnail">';
	}
}

if ( ! function_exists( 'melina_show_product_badges_open' ) ) {
	/**
	 * Before woocommerce_show_product_loop_sale_flash
	 *
	 * Wraps product badges
	 *
	 * @return void
	 */
	function melina_show_product_badges_open() {
		echo '<div class="woocommerce-product__badges">';
	}
}

if ( ! function_exists( 'melina_show_product_featured_flash' ) ) {
	/**
	 * Output the product featured flash
	 */
	function melina_show_product_featured_flash() {
		global $product;

		if ( $product->is_featured() && ! is_front_page() ) {
			echo '<span class="badge--featured">' . esc_html__( 'Hot', 'melina' ) . '</span>';
		}
	}
}

if ( ! function_exists( 'melina_show_product_badges_close' ) ) {
	/**
	 * After melina_show_product_loop_featured_flash
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_show_product_badges_close() {
		echo '</div><!-- .woocommerce-loop-product__badges -->';
	}
}

if ( ! function_exists( 'melina_template_loop_add_to_cart_before' ) ) {
	/**
	 * Before woocommerce_template_loop_add_to_cart
	 *
	 * Wraps product buttons
	 *
	 * @return void
	 */
	function melina_template_loop_add_to_cart_before() {
		echo '<div class="woocommerce-loop-product__buttons">';
	}
}

if ( ! function_exists( 'melina_template_loop_add_to_cart_after' ) ) {
	/**
	 * After woocommerce_template_loop_add_to_cart
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_template_loop_add_to_cart_after() {
		echo '</div><!-- .woocommerce-loop-product__buttons -->';
	}
}

if ( ! function_exists( 'melina_loop_item_thumbnail_after' ) ) {
	/**
	 * After woocommerce_template_loop_add_to_cart
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_loop_item_thumbnail_after() {
		echo '</div><!-- .woocommerce-loop-product__thumbnail -->';
	}
}

if ( ! function_exists( 'melina_loop_item_body_before' ) ) {
	/**
	 * Before melina_loop_item_title
	 *
	 * Wraps product info
	 *
	 * @return void
	 */
	function melina_loop_item_body_before() {
		echo '<div class="woocommerce-loop-product__body">';
	}
}

if ( ! function_exists( 'melina_loop_item_title' ) ) {
	/**
	 * Instead woocommerce_template_loop_product_title
	 *
	 * Display product title whith link
	 *
	 * @return void
	 */
	function melina_loop_item_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<h2 class="woocommerce-loop-product__title">';
		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
		echo get_the_title();
		echo '</a>';
		echo '</h2>';
	}
}

if ( ! function_exists( 'melina_loop_item_info_open' ) ) {
	/**
	 * Before woocommerce_template_loop_price
	 *
	 * Wraps product price and rating
	 *
	 * @return void
	 */
	function melina_loop_item_info_open() {
		echo '<div class="woocommerce-loop-product__info">';
	}
}

if ( ! function_exists( 'melina_loop_item_info_close' ) ) {
	/**
	 * After woocommerce_template_loop_rating
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_loop_item_info_close() {
		echo '</div><!-- .woocommerce-loop-product__info -->';
	}
}

if ( ! function_exists( 'melina_loop_item_body_after' ) ) {
	/**
	 * After woocommerce_template_loop_rating
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_loop_item_body_after() {
		echo '</div><!-- .woocommerce-loop-product__body -->';
	}
}

if ( ! function_exists( 'melina_loop_category_thumbnail_before' ) ) {
	/**
	 * Before woocommerce_template_loop_category_link_open
	 *
	 * Wraps product category thumbnail
	 *
	 * @return void
	 */
	function melina_loop_category_thumbnail_before() {
		echo '<div class="woocommerce-loop-category__thumbnail">';
	}
}

if ( ! function_exists( 'melina_loop_category_thumbnail_after' ) ) {
	/**
	 * After woocommerce_template_loop_category_link_close
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_loop_category_thumbnail_after() {
		echo '</div><!-- .woocommerce-loop-category__thumbnail -->';
	}
}

if ( ! function_exists( 'melina_loop_category_body_before' ) ) {
	/**
	 * Before melina_loop_category_title
	 *
	 * Wraps product category title
	 *
	 * @return void
	 */
	function melina_loop_category_body_before() {
		echo '<div class="woocommerce-loop-category__body">';
	}
}

if ( ! function_exists( 'melina_loop_category_title' ) ) {
	/**
	 * Instead woocommerce_template_loop_category_title
	 *
	 * Display product category title whith link
	 *
	 * @return void
	 */
	function melina_loop_category_title( $category ) {
		echo '<h2 class="woocommerce-loop-category__title">';
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">';
		echo esc_html( $category->name );
		echo '</a>';
		echo '</h2>';
	}
}

if ( ! function_exists( 'melina_loop_category_body_after' ) ) {
	/**
	 * After melina_loop_category_title
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_loop_category_body_after() {
		echo '</div><!-- ."woocommerce-loop-category__body -->';
	}
}

if ( ! function_exists( 'melina_product_summary_wrapper_open' ) ) {
	/**
	 * Before woocommerce_show_product_sale_flash
	 *
	 * Wraps sinle product gallery and summary
	 *
	 * @return void
	 */
	function melina_product_summary_wrapper_open() {
		echo '<div class="woocommerce-product-summary__wrapper">';
	}
}

if ( ! function_exists( 'melina_product_summary_wrapper_close' ) ) {
	/**
	 * Before woocommerce_output_product_data_tabs
	 *
	 * Closes the wrapping div
	 *
	 * @return void
	 */
	function melina_product_summary_wrapper_close() {
		?>
		</div><!-- .woocommerce-product-summary__wrapper -->
		<?php
	}
}
