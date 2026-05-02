<?php
/**
 * This support plugin WooCommerce Wishlist Plugin
 *
 * @see https://wordpress.org/plugins/ti-woocommerce-wishlist/
 */

/**
 * Replace content inside with new content
 */
function tophive_tinvwl_wishlist_button_cb( $matches ) {
	if ( isset( $matches[1] ) ) {
		return str_replace( $matches[1], OneCoreCustomizerduct_Designer::icon_wishlist(), $matches[0] );
	}

	return $matches[0];
}



/**
 * Replace content inside with new content
 *
 * @param $content
 *
 * @return null|string|string[]
 */
function tophive_tinvwl_wishlist_button( $content ) {

	// Check if is product in the loop.
	if ( ! wc_get_loop_prop( 'tophive_cd' ) ) {
		return $content;
	}

	$pattern = '/<a[^>]*>(.*?)<\/a>/i';
	$content = preg_replace_callback(
		$pattern,
		'tophive_tinvwl_wishlist_button_cb',
		$content
	);

	return $content;
}
// add_filter( 'tinvwl_wishlist_button', 'tophive_tinvwl_wishlist_button' );

/**
 * Remove All all action for shop loop
 */

remove_action( 'tinvwl_after_shop_loop_item', 'tinvwl_view_addto_htmlloop' );
remove_action( 'woocommerce_after_shop_loop_item', 'tinvwl_view_addto_htmlloop', 9 );

remove_action( 'tinvwl_above_thumb_loop_item', 'tinvwl_view_addto_htmlloop' );
remove_action( 'woocommerce_before_shop_loop_item', 'tinvwl_view_addto_htmlloop', 9 );

remove_action( 'tinvwl_after_shop_loop_item', 'tinvwl_view_addto_htmlloop' );
remove_action( 'woocommerce_after_shop_loop_item', 'tinvwl_view_addto_htmlloop' );


/**
 * Shortcode Add To Wishlist
 *
 * @param array $atts Array parameter from shortcode.
 *
 * @return string
 */
function tophive_tinvwl_shortcode_addtowishlist( $atts = array() ) {
	$class = One_TI_Add_To_Whishlist::instance();
	return $class->shortcode( $atts );
}

remove_shortcode( 'ti_wishlists_addtowishlist' );
add_shortcode( 'ti_wishlists_addtowishlist', 'tophive_tinvwl_shortcode_addtowishlist' );
