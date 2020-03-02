<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;


get_header( 'shop' );
// Closed list
$current_customer = get_user_meta(get_current_user_id(), 'user_customer', true);
if ( get_ordering_style($current_customer)=='closed_list' ) {

	/**
	 * Update mini cart on closed list shop page
	 */
    wp_enqueue_script( 'Closed_List_Shop_Page-js', plugins_url( '/unidress/front-end/js/Closed_List_Shop_Page.js' ), array( 'jquery' ) );

}

do_action( 'woocommerce_before_main_content' );

?>
    <header class="woocommerce-products-header">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        do_action( 'woocommerce_archive_description' );
        ?>
    </header>
<?php

if (woocommerce_product_loop()) {

    do_action('woocommerce_before_shop_loop');

    woocommerce_product_loop_start();

    if (wc_get_loop_prop('total')) {
        while (have_posts()) {

            the_post();

            do_action('woocommerce_shop_loop');

            if (get_ordering_style($current_customer) !='closed_list' ) {

                wc_get_template_part('content', 'product');

            } else {

                wc_get_template_part('content', 'product-closed-list' );

            }
        }
    }

    woocommerce_product_loop_end();

    do_action('woocommerce_after_shop_loop');

} else {

    do_action('woocommerce_no_products_found');

}

do_action( 'woocommerce_after_main_content' );

do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );

