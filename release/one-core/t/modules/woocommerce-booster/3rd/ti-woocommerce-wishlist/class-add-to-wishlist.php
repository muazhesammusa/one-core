<?php

if ( ! class_exists( 'TInvWL_Public_AddToWishlist' ) ) {
	return;
}

/**
 * Add to wishlists shortcode and hooks
 *
 * @see TInvWL_Public_AddToWishlist
 */
class One_TI_Add_To_Whishlist extends TInvWL_Public_AddToWishlist {

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	private $_name;

	/**
	 * Global product
	 *
	 * @var object
	 */
	private $product;
	/**
	 * This user wishlists
	 *
	 * @var array
	 */
	private $user_wishlist;

	/**
	 * This wishlists and product
	 *
	 * @var array
	 */
	private $wishlist;

	/**
	 * Check is loop button
	 *
	 * @var bolean
	 */
	private $is_loop;

	/**
	 * This class
	 *
	 * @var \One_TI_Add_To_Whishlist
	 */
	protected static $_instance = null;

	/**
	 * Get this class object
	 *
	 * @param string $plugin_name Plugin name.
	 *
	 * @return \One_TI_Add_To_Whishlist
	 */
	public static function instance( $plugin_name = TINVWL_PREFIX ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $plugin_name );
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @param string $plugin_name Plugin name.
	 */
	function __construct( $plugin_name ) {
		$this->_name   = $plugin_name;
		$this->is_loop = false;
		$this->define_hooks();
	}

	/**
	 * Defined shortcode and hooks
	 */
	public function define_hooks() {
		// We do not need this method.
	}


	/**
	 * Get user wishlist
	 *
	 * @return array
	 */
	function user_wishlists() {
		if ( ! empty( $this->user_wishlist ) ) {
			return $this->user_wishlist;
		}
		$wishlists = array();
		$wl        = new TInvWL_Wishlist( $this->_name );
		if ( is_user_logged_in() ) {
			$wishlists = $wl->get_by_user_default();
		} else {
			$wishlists = $wl->get_by_sharekey_default();
		}
		$wishlists = array_filter( $wishlists );
		if ( ! empty( $wishlists ) ) {
			$_wishlists = array();
			foreach ( $wishlists as $key => $wishlist ) {
				if ( is_array( $wishlist ) && array_key_exists( 'ID', $wishlist ) ) {
					$_wishlists[ $key ] = array(
						'ID'    => $wishlist['ID'],
						'title' => $wishlist['title'],
						'url'   => tinv_url_wishlist_by_key( $wishlist['share_key'] ),
					);
				}
			}
			$wishlists = $_wishlists;
		}
		$this->user_wishlist = $wishlists;

		return $wishlists;
	}

	/**
	 * Check exists product in user wishlists
	 *
	 * @param object $product Product object.
	 * @param object $wlp     Product class, used for local products.
	 *
	 * @return array
	 */
	function user_wishlist( $product, $wlp = null ) {
		$wishlists = $this->wishlist = array();
		$vproduct  = in_array(
			( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->product_type : $product->get_type() ),
			array(
				'variable',
				'variation',
				'variable-subscription',
			)
		);
		$wlp       = new TInvWL_Product();
		$wishlists = $this->user_wishlists();
		$ids       = array();
		foreach ( $wishlists as $key => $wishlist ) {
			$ids[] = $wishlist['ID'];
		}
		$ids = array_filter( $ids );

		if ( empty( $ids ) ) {
			return $wishlists;
		}
		$products = $wlp->get(
			array(
				'product_id'  => ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->id : ( $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() ) ),
				'wishlist_id' => $ids,
				'external'    => false,
			)
		);
		$in       = array();
		if ( ! empty( $products ) ) {
			foreach ( $products as $product ) {
				$in[ $product['wishlist_id'] ][] = $product['variation_id'];
			}
			foreach ( $in as $wishlist_id => $products ) {
				sort( $in[ $wishlist_id ], SORT_NUMERIC );
				if ( empty( $in[ $wishlist_id ] ) && ( $this->is_loop || ! $vproduct ) ) {
					$in[ $wishlist_id ] = true;
				}
			}
		}
		foreach ( $wishlists as $key => $wishlist ) {
			$wishlists[ $key ]['in'] = array_key_exists( $wishlist['ID'], $in ) ? $in[ $wishlist['ID'] ] : false;
		}
		$wishlists      = apply_filters( 'tinvwl_addtowishlist_preparewishlists', $wishlists, $product );
		$this->wishlist = $wishlists;

		return $wishlists;
	}


	/**
	 * Output page
	 *
	 * @global object $product
	 *
	 * @param array   $attr         Array parameter for shortcode.
	 * @param boolean $is_shortcode Shortcode or action.
	 *
	 * @return boolean
	 */
	function htmloutput( $attr = array(), $is_shortcode = false ) {
		global $product;

		$attr          = apply_filters( 'tinvwl_addtowishlist_out_prepare_attr', $attr );
		$this->product = apply_filters( 'tinvwl_addtowishlist_out_prepare_product', $product );
		$position      = tinv_get_option( 'add_to_wishlist', 'position' );
		if ( $is_shortcode ) {
			$position     = 'shortcode';
			$product_id   = absint( $attr['product_id'] );
			$variation_id = absint( $attr['variation_id'] );

			if ( 'product_variation' == get_post_type( $product_id ) ) { // WPCS: loose comparison ok.
				$variation_id = $product_id;
				$product_id   = wp_get_post_parent_id( $variation_id );
			}

			$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );

			if ( $product_data && 'trash' !== ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->post->post_status : get_post( $product_data->get_id() )->post_status ) ) {
				$this->product = $product_data;
			} else {
				return '';
			}
		}
		if ( empty( $this->product ) || ! apply_filters( 'tinvwl_allow_addtowishlist_single_product', true, $this->product ) ) {
			return;
		}

		$wishlists = $this->user_wishlist( $this->product );

		$this->button();
	}

	/**
	 * Create button
	 *
	 * @param boolean $echo Return or output.
	 */
	public function button( $echo = true ) {
		$content    = apply_filters( 'tinvwl_wishlist_button_before', '' );
		$label      = ( tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'show_text' ) ) ? apply_filters( 'tinvwl-add_to_wishlist_catalog-text', tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'text' ) ) : '';
		$icon       = tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'icon' );
		$icon_color = tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'icon_style' );
		$icon_class = '';
		$action     = 'addto';

		$icon_class = ' cd-btn button wishlist-btn display-'.tophive_one()->get_setting( 'wc_cd_wishlist_type' );

		$text = OneCoreCustomizerduct_Designer::icon_wishlist();
		if ( $label ) {
			$text .= '<span class="icon-label">' . $label . '</span>';
		}

		/*
		if ( ! empty( $icon ) ) {
			$icon_upload = tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'icon_upload' );
			if ( 'custom' === $icon && ! empty( $icon_upload ) ) {
				$text = sprintf( '<img src="%s" alt="%s" /> %s', esc_url( $icon_upload ), esc_attr( apply_filters( 'tinvwl-add_to_wishlist_catalog-text', tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'text' ) ) ), $text );
			}
			$icon = 'tinvwl-icon-' . $icon;
			if ( 'custom' !== $icon && $icon_color ) {
				$icon .= ' icon-' . $icon_color;
			}
		}
		*/

		$icon         .= $icon_class;
		$variation_id = ( ( $this->is_loop && in_array(
				( version_compare( WC_VERSION, '3.0.0', '<' ) ? $this->product->product_type : $this->product->get_type() ),
				array(
					'variable',
					'variable-subscription',
				)
			) ) ? $this->variation_id : ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $this->product->variation_id : ( $this->product->is_type( 'variation' ) ? $this->product->get_id() : 0 ) ) );

		foreach ( $this->wishlist as $value ) {
			if ( $value['in'] && in_array( $variation_id, $value['in'] ) ) {
				$icon .= ' tinvwl-product-in-list';
				if ( tinv_get_option( 'general', 'simple_flow' ) ) {
					if ( $this->is_loop ) {
						if ( ! is_array( $value['in'] ) || in_array( $variation_id, $value['in'] ) ) {
							$icon   .= ' tinvwl-product-make-remove';
							$action = 'remove';
						}
					} else {
						$icon   .= ' tinvwl-product-make-remove';
						$action = 'remove';
					}
				}
				break;
			}
		}

		$icon .= ' ' . tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'class' );

		$icon .= ' tinvwl-position-' . tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'position' );

		$icon .= ( tinv_get_option( 'add_to_wishlist' . ( $this->is_loop ? '_catalog' : '' ), 'show_preloader' ) ) ? ' ftinvwl-animated' : '';

		$product_id        = version_compare( WC_VERSION, '3.0.0', '<' ) ? $this->product->id : ( $this->product->is_type( 'variation' ) ? $this->product->get_parent_id() : $this->product->get_id() );
		$product_variation = ( $this->is_loop && in_array(
				( version_compare( WC_VERSION, '3.0.0', '<' ) ? $this->product->product_type : $this->product->get_type() ),
				array(
					'variable',
					'variable-subscription',
				)
			) ) ? $this->variation_id : ( version_compare(
			WC_VERSION,
			'3.0.0',
			'<'
		) ? $this->product->variation_id : ( $this->product->is_type( 'variation' ) ? $this->product->get_id() : 0 ) );

		$product_type = version_compare( WC_VERSION, '3.0.0', '<' ) ? $this->product->product_type : $this->product->get_type();

		$content .= sprintf(
			'<a class="tinvwl_add_to_wishlist_button %1$s" data-tinv-wl-list="%2$s" data-tinv-wl-product="%3$s" data-tinv-wl-productvariation="%4$s" data-tinv-wl-producttype="%5$s" data-tinv-wl-action="%6$s" title="%8$s"  rel="nofollow">%7$s</a>',
			$icon,
			esc_attr( wp_json_encode( $this->wishlist ) ),
			$product_id,
			$product_variation,
			$product_type,
			$action,
			$text,
			esc_attr( $label )
		);

		$content .= apply_filters( 'tinvwl_wishlist_button_after', '' );

		if ( ! empty( $text ) ) {
			$content .= '<div class="tinv-wishlist-clear"></div>';
		}

		echo $content; // WPCS: xss ok.
	}

	/**
	 * Shortcode basic function
	 *
	 * @global object $product
	 *
	 * @param array   $atts Array parameter from shortcode.
	 *
	 * @return string
	 */
	function shortcode( $atts = array() ) {
		global $product;

		$default = array(
			'product_id'   => 0,
			'variation_id' => 0,
			'loop'         => 'no',
		);
		if ( $product && is_a( $product, 'WC_Product' ) ) {
			$default['product_id']   = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->get_id() : ( $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() ) );
			$default['variation_id'] = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->variation_id : ( $product->is_type( 'variation' ) ? $product->get_id() : 0 ) );
		}
		$atts = shortcode_atts( $default, $atts );

		ob_start();
		if ( 'yes' === $atts['loop'] ) {
			$this->is_loop = true;
			$this->htmloutput( $atts, true );
			$this->is_loop = false;
		} else {
			$this->htmloutput( $atts, true );
		}

		return ob_get_clean();
	}

}
