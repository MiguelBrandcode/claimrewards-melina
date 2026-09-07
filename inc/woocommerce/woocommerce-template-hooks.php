<?php
/**
 * WooCommerce Template Hooks
 *
 * @package Melina
 */

/**
 * Layout
 *
 * @see melina_before_content()
 * @see melina_after_content()
 * @see melina_sorting_wrapper()
 * @see melina_sorting_wrapper_close()
 */

add_action( 'melina_menu_secondary_search_before',        'melina_header_cart',                            20 );
add_action( 'melina_menu_secondary_search_before',        'melina_header_account',                         10 );

remove_action( 'woocommerce_before_main_content',         'woocommerce_output_content_wrapper',            10 );
remove_action( 'woocommerce_after_main_content',          'woocommerce_output_content_wrapper_end',        10 );
add_action( 'woocommerce_before_main_content',            'melina_before_content',                         10 );
add_action( 'woocommerce_after_main_content',             'melina_after_content',                          10 );
add_action( 'melina_woocommerce_sidebar',                 'woocommerce_get_sidebar',                       10 );

add_action( 'woocommerce_before_shop_loop',               'melina_sorting_wrapper',                        19 );
add_action( 'woocommerce_before_shop_loop',               'melina_sorting_wrapper_close',                  31 );

/**
 * Loop Product
 *
 * @see melina_loop_item_thumbnail_before()
 * @see melina_show_product_badges_open()
 * @see melina_show_product_featured_flash()
 * @see melina_show_product_badges_close()
 * @see melina_template_loop_add_to_cart_before()
 * @see melina_template_loop_add_to_cart_after()
 * @see melina_loop_item_thumbnail_after()
 * @see melina_loop_item_body_before()
 * @see melina_loop_item_title()
 * @see melina_loop_item_info_open()
 * @see melina_loop_item_info_close()
 * @see melina_loop_item_body_after()
 */
remove_action( 'woocommerce_before_shop_loop_item',       'woocommerce_template_loop_product_link_open',   10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash',      10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',   10 );
remove_action( 'woocommerce_shop_loop_item_title',        'woocommerce_template_loop_product_title',       10 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_rating',              5 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_price',               10 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_product_link_close',  5 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_add_to_cart',         10 );
add_action( 'woocommerce_before_shop_loop_item',          'melina_loop_item_thumbnail_before',             10 );
add_action( 'woocommerce_before_shop_loop_item',          'melina_show_product_badges_open',               15 );
add_action( 'woocommerce_before_shop_loop_item',          'melina_show_product_featured_flash',            20 );
add_action( 'woocommerce_before_shop_loop_item',          'woocommerce_show_product_loop_sale_flash',      25 );
add_action( 'woocommerce_before_shop_loop_item',          'melina_show_product_badges_close',              30 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_open',   10 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_thumbnail',   20 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_close',  30 );
add_action( 'woocommerce_before_shop_loop_item_title',    'melina_template_loop_add_to_cart_before',       35 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_add_to_cart',         40 );
add_action( 'woocommerce_before_shop_loop_item_title',    'melina_template_loop_add_to_cart_after',        45 );
add_action( 'woocommerce_before_shop_loop_item_title',    'melina_loop_item_thumbnail_after',              50 );
add_action( 'woocommerce_shop_loop_item_title',           'melina_loop_item_body_before',                  5 );
add_action( 'woocommerce_shop_loop_item_title',           'melina_loop_item_title',                        10 );
add_action( 'woocommerce_after_shop_loop_item_title',     'melina_loop_item_info_open',                    5 );
add_action( 'woocommerce_after_shop_loop_item_title',     'woocommerce_template_loop_price',               10 );
add_action( 'woocommerce_after_shop_loop_item_title',     'woocommerce_template_loop_rating',              15 );
add_action( 'woocommerce_after_shop_loop_item_title',     'melina_loop_item_info_close',                   20 );
add_action( 'woocommerce_after_shop_loop_item',           'melina_loop_item_body_after',                   10 );

/**
 * Loop Category
 *
 * @see melina_loop_category_thumbnail_before()
 * @see melina_loop_category_thumbnail_after()
 * @see melina_loop_category_body_before()
 * @see melina_loop_category_title()
 * @see melina_loop_category_body_after()
 */
remove_action( 'woocommerce_before_subcategory',          'woocommerce_template_loop_category_link_open',  10 );
remove_action( 'woocommerce_before_subcategory_title',    'woocommerce_subcategory_thumbnail',             10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title',      10 );
remove_action( 'woocommerce_after_subcategory',           'woocommerce_template_loop_category_link_close', 10 );
add_action( 'woocommerce_before_subcategory',             'melina_loop_category_thumbnail_before',         10 );
add_action( 'woocommerce_before_subcategory',             'woocommerce_template_loop_category_link_open',  20 );
add_action( 'woocommerce_before_subcategory',             'woocommerce_subcategory_thumbnail',             30 );
add_action( 'woocommerce_before_subcategory',             'woocommerce_template_loop_category_link_close', 40 );
add_action( 'woocommerce_before_subcategory',             'melina_loop_category_thumbnail_after',          50 );
add_action( 'woocommerce_before_subcategory_title',       'melina_loop_category_body_before',              10 );
add_action( 'woocommerce_shop_loop_subcategory_title',    'melina_loop_category_title',                    10 );
add_action( 'woocommerce_after_subcategory_title',        'melina_loop_category_body_after',               10 );

/**
 * Single Product
 *
 * @see melina_product_summary_wrapper_open()
 * @see melina_show_product_badges_open()
 * @see melina_show_product_featured_flash()
 * @see melina_show_product_badges_close()
 * @see melina_product_summary_wrapper_close()
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',      10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images',          20 );
add_action( 'woocommerce_before_single_product_summary',    'melina_product_summary_wrapper_open',      10 );
add_action( 'woocommerce_before_single_product_summary',    'melina_show_product_badges_open',          20 );
add_action( 'woocommerce_before_single_product_summary',    'melina_show_product_featured_flash',       22 );
add_action( 'woocommerce_before_single_product_summary',    'woocommerce_show_product_sale_flash',      23 );
add_action( 'woocommerce_before_single_product_summary',    'melina_show_product_badges_close',         25 );
add_action( 'woocommerce_before_single_product_summary',    'woocommerce_show_product_images',          30 );
add_action( 'woocommerce_after_single_product_summary',     'melina_product_summary_wrapper_close',     5 );
