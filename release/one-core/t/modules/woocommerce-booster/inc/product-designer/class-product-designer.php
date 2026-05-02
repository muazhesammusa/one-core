<?php

class OneCoreCustomizerduct_Designer {

	private $in_media = false;

	public function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 155 );

		add_filter( 'tophive/product-designer/part', array( $this, 'item_part_filter' ), 35, 3 );
		add_filter( 'tophive/product-designer/body-items', array( $this, 'body_items' ), 35 );
		add_filter( 'tophive/product-designer/body-field-config', array( $this, 'body_field_config' ), 35 );
		add_filter( 'tophive/product-designer/render_html', array( $this, 'body_render' ), 35, 3 );
	}

	public function is_qv_enable() {
		return OneCoreCustomizer()->is_enabled_module( 'OneCoreCustomizer_Module_WC_Quick_View' );
	}

	/**
	 * Check if wishlist plugin installed & activated.
	 *
	 * @see https://vi.wordpress.org/plugins/ti-woocommerce-wishlist/
	 *
	 * @return bool
	 */
	public function is_wishlist_enable() {
		return defined( 'TINVWL_PATH' );
	}

	/**
	 * Check if compare plugin installed and activated.
	 *
	 * @see https://wordpress.org/support/plugin/woo-smart-compare/
	 *
	 * @return bool
	 */
	public function is_compare_enable() {
		return function_exists( 'wooscp_init' );
	}

	public static function icon_quick_view() {
		return '<i class="fa fa-eye" aria-hidden="true"></i>';
	}

	public static function icon_compare() {
		return '<i class="fa fa-line-chart" aria-hidden="true"></i>';
	}

	public static function icon_wishlist() {
		return '<i class="fa fa-heart-o" aria-hidden="true"></i>';
	}

	public static function icon_cart() {
		return '<i class="fa fa-shopping-basket" aria-hidden="true"></i>';
	}

	/**
	 * Render outer product media items.
	 *
	 * @param string|bool                   $html HTML code render by other filter.
	 * @param array                         $items
	 * @param One_WC_Catalog_Designer $pd
	 * @return stringœ
	 */
	public function body_render( $html, $items, $pd ) {

		$layout = array();

		wc_set_loop_prop( 'tophive_cd', 1 );

		foreach ( (array) $items as $item ) {
			$item = wp_parse_args(
				$item,
				array(
					'_key' => '',
					'_visibility' => '',
					'show_in_grid' => 1,
					'show_in_list' => 1,
					'position' => 'left',
					'display' => '',
					'visibility' => '',
				)
			);
			if ( $item['_visibility'] !== 'hidden' ) {

				$cb = $pd->callback( $item['_key'] );

				if ( is_callable( $cb ) ) {
					$classes = array();
					$classes[] = 'wc-product__part';
					$classes[] = 'wc-product__' . $item['_key'];

					if ( $item['show_in_grid'] ) {
						$classes[] = 'show-in-grid';
					} else {
						$classes[] = 'hide-in-grid';
					}
					if ( $item['show_in_list'] ) {
						$classes[] = 'show-in-list';
					} else {
						$classes[] = 'hide-in-list';
					}

					if ( $item['visibility'] && $item['visibility'] != 'default' ) {
						$classes[] = $item['visibility'];
					}

					$item_html = '';
					ob_start();
					call_user_func( $cb, array( $item, $this ) );
					$item_html = ob_get_contents();
					ob_end_clean();

					if ( trim( $item_html ) != '' ) {
						$item_html = '<div class="' . esc_attr( join( ' ', $classes ) ) . '">' . $item_html . '</div>';
						if ( ! isset( $layout[ $item['position'] ] ) ) {
							$layout[ $item['position'] ] = '';
						}

						$layout[ $item['position'] ] .= $item_html;

					}
				}
			}
		}

		wc_set_loop_prop( 'tophive_cd', 0 );

		$html = '';
		$bottom = '';
		if ( isset( $layout['bottom'] ) ) {
			$bottom = $layout['bottom'];
			unset( $layout['bottom'] );

		}
		if ( count( $layout ) ) {
			$html .= '<div class="b-row-main">';
			foreach ( $layout as $pos => $string ) {
				if ( $string ) {
					$classes = array(
						'b-col',
						'col-' . $pos,
					);

					$h_mod = tophive_one()->get_setting( 'wc_cd_ph_body_' . $pos );
					if ( $h_mod == 1 || $h_mod === true ) {
						$classes[] = 'col-horizontal';
					} else {
						$col_classes[] = 'col-vertical';
					}
					$html .= '<div class="' . esc_attr( join( ' ', $classes ) ) . '">' . $string . '</div>';
				}
			}
			$html .= '</div>';
		}

		if ( $bottom ) {
			$classes = array(
				'b-col',
				'col-bottom',
			);
			$h_mod = tophive_one()->get_setting( 'wc_cd_ph_body_bottom' );
			if ( $h_mod == 1 || $h_mod === true ) {
				$classes[] = 'col-horizontal';
			} else {
				$col_classes[] = 'col-vertical';
			}
			$html .= '<div class="b-row-end">';
			$html .= '<div class="' . esc_attr( join( ' ', $classes ) ) . '">' . $bottom . '</div>';
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Filter item part render
	 *
	 * @param bool $cb
	 * @param bool $item_id
	 * @param bool $pd
	 *
	 * @return array|bool
	 */
	public function item_part_filter( $cb = false, $item_id = false, $pd = false ) {
		if ( method_exists( $this, 'product__' . $item_id ) ) {
			$cb = array( $this, 'product__' . $item_id );
		}

		return $cb;
	}

	/**
	 * Get media item callback.
	 *
	 * @param string $item_id Id of item.
	 *
	 * @return array|bool
	 */
	private function media_item_cb( $item_id ) {
		$cb = false;
		if ( method_exists( $this, 'product__media_' . $item_id ) ) {
			$cb = array( $this, 'product__media_' . $item_id );
		}

		return $cb;
	}

	private function render_media() {

		$items = tophive_one()->get_setting( 'wc_cd_media_positions' );
		$media_positions = array();
		$this->in_media  = true;

		$rows = array(
			'top'    => array(),
			'center' => array(),
			'bottom' => array(),
		);

		wc_set_loop_prop( 'tophive_cd', 1 );

		foreach ( (array) $items as $item ) {
			$item = wp_parse_args(
				$item,
				array(
					'_key'        => '',
					'_visibility' => '',
					'position'    => '',
					'show_when'   => 'always',
				)
			);
			$cb = $this->media_item_cb( $item['_key'] );

			if ( $item['_visibility'] !== 'hidden' && is_callable( $cb ) ) {

				$item_html = '';
				$classes = array( 'pm-item', 'media-item-' . $item['_key'], 'show-' . $item['show_when'] );
				ob_start();
				call_user_func( $cb, array( $item, $this ) );
				$item_html = ob_get_contents();
				ob_end_clean();

				if ( trim( $item_html ) != '' ) {

					if ( ! isset( $media_positions[ $item['position'] ] ) || ! is_array( $media_positions[ $item['position'] ] ) ) {
						$media_positions[ $item['position'] ] = array();
					}

					$item_html = '<div class="' . esc_attr( join( ' ', $classes ) ) . '">' . $item_html . '</div>';

					$media_positions[ $item['position'] ][] = $item_html;

					$_p = explode( '-', $item['position'] );

					if ( ! isset( $_p[1] ) ) {
						$_p[1] = 'center';
					}

					if ( ! isset( $rows[ $_p[0] ][ $_p[1] ] ) ) {
						$rows[ $_p[0] ][ $_p[1] ] = array();
					}

					$rows[ $_p[0] ][ $_p[1] ][] = $item_html;

				}
			}
		} // end the loop

		wc_set_loop_prop( 'tophive_cd', 0 );

		foreach ( $rows as $row_id => $row ) {
			if ( ! empty( $row ) ) {
				$classes = array(
					'p-media-row',
					'p-media-' . $row_id,
					'p-col-' . count( $row ),
				);
				echo '<div class="' . esc_attr( join( ' ', $classes ) ) . '">';

				foreach ( $row as $col_id => $array_html ) {
					$col_classes = array(
						'pm-col',
						'col-' . $col_id,
						'p-media-' . $row_id . '-' . $col_id,
					);

					$h_mod = tophive_one()->get_setting( "wc_cd_ph_media_{$row_id}_$col_id" );
					if ( $h_mod == 1 || $h_mod === true ) {
						$col_classes[] = 'col-horizontal';
					} else {
						$col_classes[] = 'col-vertical';
					}

					echo '<div class="' . esc_attr( join( ' ', $col_classes ) ) . '">';
					echo join( "\r\n", $array_html );
					echo '</div>';

				}

				echo '</div>';

			}
		}

		$this->in_media = false;

	}

	public function product__media_onsale() {
		woocommerce_show_product_loop_sale_flash();
	}

	public function product__media_quickview() {
		$this->product__quickview();
	}

	public function product__media_add_to_cart() {
		$this->in_media = true;
		$this->product__add_to_cart();
		$this->in_media = false;
	}

	/**
	 * Get tooltip text
	 *
	 * @param WC_Product $product
	 * @return string
	 */
	public function get_add_to_cart_tooltip( $product ) {
		$text = __( 'Add to cart', 'tophive-pro' );
		switch ( $product->get_type() ) {
			case 'variable':
				$text = __( 'Select options', 'tophive-pro' );
				break;
			case 'grouped':
				$text = __( 'View products', 'tophive-pro' );
				break;
		}

		return $text;
	}

	public function product__add_to_cart() {

		global $product;
		$args    = array();
		$display = tophive_one()->get_setting( 'wc_cd_add_to_cart_type' );
		$title   = $this->get_add_to_cart_tooltip( $product );

		$defaults = array(
			'quantity' => 1,
			'class' => implode(
				' ',
				array_filter(
					array(
						'button',
						'c-pro',
						'product_type_' . $product->get_type(),
						'display-' . $display,
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
					)
				)
			),
			'attributes' => array(
				'data-product_id'  => $product->get_id(),
				'data-product_sku' => $product->get_sku(),
				'aria-label'       => $product->add_to_cart_description(),
				'title'            => $title,
				'rel'              => 'nofollow',
			),
		);

		if ( 'icon' == $display ) {
			$defaults['class'] .= ' cd-btn';
		}

		if ( $this->in_media ) {
			$defaults['class'] .= ' in-media';
		} else {
			$defaults['class'] .= ' out-media';
		}

		$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

		if ( isset( $args['attributes']['aria-label'] ) ) {
			$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
		}

		if ( 'icon' == $display ) {
			$text = self::icon_cart();
		} elseif ( 'both' == $display ) {
			$text = $product->add_to_cart_text();
			$text = self::icon_cart() . '<span class="icon-label">' . $text . '</span>';
		} else {
			$text = $product->add_to_cart_text();
		}

		if ( ! isset( $args['class'] ) ) {
			$args['class'] = 'button';
		}

		if ( strpos( $args['class'], 'add_to_cart_button' ) === false ) {
			$args['class'] .= ' add_to_cart_button';
		}

		echo apply_filters(
			'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
			sprintf(
				'<a href="%1$s" data-quantity="%2$s" class="%3$s" %4$s>%5$s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
				esc_attr( $args['class'] ),
				isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
				$text
			),
			$product,
			$args
		);

	}

	public function product__media_wishlist() {
		$this->product__wishlist();
	}

	public function product__media_compare() {
		$this->product__compare();
	}

	public function product__quickview() {
		if ( ! $this->is_qv_enable() ) {
			return false;
		}

		$display = tophive_one()->get_setting( 'wc_cd_qv_type' );
		$classes = array(
			'button',
			'cd-btn',
			'cd-quick-view',
			'quick-view-btn',
			'display-' . $display,
		);

		if ( $this->in_media ) {
			$classes[] = 'in-media';
			if ( 'both' == $display || 'text' == $display ) {
				$classes[] = 'cd-not-apply';
			}
		} else {
			$classes[] = 'out-media';
		}

		?>
		<a title="<?php esc_attr_e( 'Quick View', 'tophive-pro' ); ?>" class="<?php echo esc_attr( join( ' ', $classes ) ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" href="#"><?php
		echo self::icon_quick_view();
		echo '<span class="icon-label">' . __( 'Quick View', 'tophive-pro' ) . '</span>';
		?></a>
		<?php
	}

	public function product__compare() {
		if ( ! $this->is_compare_enable() ) {
			return;
		}

		$display = tophive_one()->get_setting( 'wc_cd_compare_type' );
		$classes = array(
			'cd-btn',
			'tophive-wc-compare',
			'display-' . $display,
			'button',
			'wooscp-btn',
		);
		?>
		<a class="<?php echo esc_attr( join( ' ', $classes ) ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" title="<?php esc_attr_e( 'Compare', 'tophive-pro' ); ?>" href="#">
			<?php
			echo self::icon_compare();
			echo '<span class="icon-label">' . __( 'Compare', 'tophive-pro' ) . '</span>';
			?>
		</a>
		<?php

	}

	/**
	 * Display wishlits item
	 *
	 * @return bool|string
	 */
	public function product__wishlist() {
		if ( ! $this->is_wishlist_enable() ) {
			return false;
		}

		if ( $this->is_wishlist_enable() ) {
			remove_shortcode( 'ti_wishlists_addtowishlist' );
			add_shortcode( 'ti_wishlists_addtowishlist', 'tophive_tinvwl_shortcode_addtowishlist' );
			echo do_shortcode( '[ti_wishlists_addtowishlist]' );

			return false;
		}

	}

	/**
	 * Add product media
	 *
	 * @param null                       $item_config Item Config.
	 * @param OneCoreCustomizerduct_Designer $pd          Product catalog designer.
	 */
	public function product__media( $item_config = null, $pd = null ) {
		echo '<div class="wc-product-media">';
		woocommerce_template_loop_product_link_open();

		woocommerce_template_loop_product_thumbnail();
		tophive_wc_secondary_product_thumbnail();

		woocommerce_template_loop_product_link_close();

		$this->render_media();
		echo '</div>';
	}

	/**
	 * Add more settings for body items
	 *
	 * @param array $items
	 *
	 * @return array
	 */
	public function body_items( $items = array() ) {

		if ( $this->is_wishlist_enable() ) {
			$items[] = array(
				'_key'         => 'wishlist',
				'_visibility'  => 'hidden',
				'show_in_grid' => 1,
				'show_in_list' => 1,
				'title'        => __( 'Wishlist', 'tophive-pro' ),
			);
		}

		return $items;
	}

	/**
	 * Add more config field for body items
	 *
	 * @param array $fields Configs fields.
	 *
	 * @return array
	 */
	public function body_field_config( $fields ) {
		$fields[] = array(
			'name'    => 'position',
			'type'    => 'select',
			'label'   => __( 'Position', 'tophive-pro' ),
			'choices' => array(
				'left'   => __( 'Left', 'tophive-pro' ),
				'right'  => __( 'Right', 'tophive-pro' ),
				'bottom' => __( 'Bottom', 'tophive-pro' ),
			),
		);

		$fields[] = array(
			'name'             => 'visibility',
			'type'             => 'select',
			'label'            => __( 'Visibility', 'tophive-pro' ),
			'choices'          => array(
				'default'         => __( 'default', 'tophive-pro' ),
				'show_when_hover' => __( 'Show when hover', 'tophive-pro' ),
				'hide_when_hover' => __( 'Hide when hover', 'tophive-pro' ),
			),
		);

		return $fields;
	}

	public function get_media_items() {
		$items = array();

		$items[] = array(
			'_key'        => 'onsale',
			'_visibility' => '',
			'position'    => 'top-left',
			'title'       => __( 'Onsale Bubble', 'tophive-pro' ),
		);

		if ( $this->is_wishlist_enable() ) {
			$items[] = array(
				'_key'        => 'wishlist',
				'_visibility' => '',
				'position'    => 'top-right',
				'title'       => __( 'Wishlist', 'tophive-pro' ),
			);
		}

		if ( $this->is_compare_enable() ) {
			$items[] = array(
				'_visibility' => '',
				'_key'        => 'compare',
				'title'       => __( 'Compare', 'tophive-pro' ),
				'position'    => 'top-right',
			);
		}

		$items[] = array(
			'_key'        => 'add_to_cart',
			'_visibility' => 'hidden',
			'position'    => 'bottom-center',
			'title'       => __( 'Add To Cart', 'tophive-pro' ),
		);

		if ( $this->is_qv_enable() ) {
			$items[] = array(
				'_key'        => 'quickview',
				'_visibility' => '',
				'position'    => 'bottom-center',
				'show_when'   => 'when_hover',
				'title'       => __( 'Quickview', 'tophive-pro' ),
			);
		}

		return apply_filters( 'tophive/product-designer/get_media_items', $items );
	}

	/**
	 * Add quick view config
	 *
	 * @param array $configs Config fields.
	 *
	 * @return array
	 */
	public function config( $configs ) {
		$section = 'wc_catalog_designer';

		// Display type for quick view.
		if ( $this->is_qv_enable() ) {
			$configs[] = array(
				'name'            => 'wc_cd_qv_type',
				'type'            => 'select',
				'default'         => 'both',
				'priority'        => 46,
				'choices'         => array(
					'icon'           => __( 'Icon', 'tophive-pro' ),
					'text'           => __( 'Text', 'tophive-pro' ),
					'both'           => __( 'Icon & text', 'tophive-pro' ),
				),
				'selector'        => '.wc-product-listing',
				'render_callback' => 'woocommerce_content',
				'section'         => $section,
				'label'           => __( 'Display Type', 'tophive-pro' ),
			);
		}

		$configs[] = array(
			'name'             => 'wc_cd_media_positions',
			'section'          => $section,
			'label'            => __( 'Media Items & Positions', 'tophive-pro' ),
			'type'             => 'repeater',
			'title'            => __( 'Body', 'tophive-pro' ),
			'live_title_field' => 'title',
			'limit'            => 4,
			'addable'          => false,
			'priority'         => 14,
			'selector'         => '.wc-product-listing',
			'render_callback'  => 'woocommerce_content',
			'default'          => $this->get_media_items(),
			'fields' => array(
				array(
					'name' => '_key',
					'type' => 'hidden',
				),
				array(
					'name'  => 'title',
					'type'  => 'hidden',
					'label' => __( 'Title', 'tophive-pro' ),
				),
				array(
					'name'           => 'position',
					'type'           => 'select',
					'label'          => __( 'Position', 'tophive-pro' ),
					'choices'        => array(
						'top-left'      => __( 'Top left', 'tophive-pro' ),
						'top-right'     => __( 'Top right', 'tophive-pro' ),
						'center'        => __( 'Center', 'tophive-pro' ),
						'bottom-center' => __( 'Bottom center', 'tophive-pro' ),
					),
				),

				array(
					'name'        => 'show_when',
					'type'        => 'select',
					'label'       => __( 'Visibility', 'tophive-pro' ),
					'description' => __( 'If on touch screen, this item will always show.', 'tophive-pro' ),
					'choices'     => array(
						'always'     => __( 'Default', 'tophive-pro' ),
						'when_hover' => __( 'Show when hover', 'tophive-pro' ),
					),
				),

			),
		);

		if ( ! $this->is_wishlist_enable() ) {
			$configs[] = array(
				'name'        => 'wc_cd_wishlist_help',
				'type'        => 'custom_html',
				'priority'    => 14,
				'section'     => $section,
				'description' => __( 'Please install the <a href = "https: //wordpress.org/plugins/ti-woocommerce-wishlist/" target = "_blank">WooCommerce Wishlist</a> plugin to enable the Wishlist feature.', 'tophive-pro' ),
			);
		}

		if ( ! $this->is_compare_enable() ) {
			$configs[] = array(
				'name'        => 'wc_cd_compare_help',
				'type'        => 'custom_html',
				'priority'    => 14,
				'section'     => $section,
				'description' => __( 'Please install the <a href = "https: //wordpress.org/plugins/woo-smart-compare/" target = "_blank">WooCommerce Smart Compare</a> plugin to enable the Compare feature.', 'tophive-pro' ),
			);
		}

		// Add to cart.
		$configs[] = array(
			'name'     => 'wc_cd_add_to_cart_h',
			'type'     => 'heading',
			'section'  => $section,
			'priority' => 29,
			'label'    => __( 'Product Add to cart', 'tophive-pro' ),
		);

		$configs[] = array(
			'name'            => 'wc_cd_add_to_cart_type',
			'type'            => 'select',
			'default'         => 'both',
			'priority'        => 29,
			'choices'         => array(
				'icon'           => __( 'Icon', 'tophive-pro' ),
				'text'           => __( 'Text', 'tophive-pro' ),
				'both'           => __( 'Icon & text', 'tophive-pro' ),
			),
			'selector'        => '.wc-product-listing',
			'render_callback' => 'woocommerce_content',
			'section'         => $section,
			'label'           => __( 'Display Type', 'tophive-pro' ),
		);

		$configs[] = array(
			'name'            => 'wc_cd_add_to_cart_styling',
			'type'            => 'styling',
			'section'         => $section,
			'title'           => __( 'Styling', 'tophive-pro' ),
			'description'     => __( 'Advanced styling for add to cart button', 'tophive-pro' ),
			'priority'        => 29,
			'selector'        => array(
				'normal'         => '.products .product .wc-product-inner .button.add_to_cart_button, .products .product .wc-product-inner .button.added_to_cart',
				'hover'          => '.products .product .wc-product-inner .button.add_to_cart_button:hover, .products .product .wc-product-inner .button.added_to_cart:hover',
			),
			'css_format'      => 'styling',
			'default'         => array(),
			'fields'          => array(
				'normal_fields'  => array(
					'link_color'    => false, // disable for special field.
					'bg_image'      => false,
					'bg_cover'      => false,
					'bg_position'   => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
				),
				'hover_fields'   => array(
					'link_color'    => false, // disable for special field.
				),
			),
		);
		$configs[] = array(
			'name'     => 'wc_cd_load_more_styling',
			'type'     => 'heading',
			'section'  => $section,
			'priority' => 29,
			'label'    => __( 'Load more button', 'tophive-pro' ),
		);
		$configs[] = array(
			'name'            => 'wc_cd_load_more_btn_styling',
			'type'            => 'styling',
			'section'         => $section,
			'title'           => __( 'Styling', 'tophive-pro' ),
			'description'     => __( 'Advanced styling for load more button', 'tophive-pro' ),
			'priority'        => 29,
			'selector'        => array(
				'normal'         => 'body .woocommerce-pagination .tophive-infinity-button.button',
				'hover'          => 'body .woocommerce-pagination .tophive-infinity-button.button:hover, body .woocommerce-pagination .tophive-infinity-button.button.loading',
			),
			'css_format'      => 'styling',
			'default'         => array(),
			'fields'          => array(
				'normal_fields'  => array(
					'link_color'    => false, // disable for special field.
					'bg_image'      => false,
					'bg_cover'      => false,
					'bg_position'   => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
				),
				'hover_fields'   => array(
					'link_color'    => false, // disable for special field.
				),
			),
		);
		// Positions & Display Type.
		$configs[] = array(
			'name'     => 'wc_cd_pa_h',
			'type'     => 'heading',
			'section'  => $section,
			'priority' => 18,
			'label'    => __( 'Positions & Display Type', 'tophive-pro' ),
		);

		$positions = array(
			'media_top_left'      => __( 'Media top left', 'tophive-pro' ),
			'media_top_right'     => __( 'Media top right', 'tophive-pro' ),
			'media_center_center' => __( 'Media center', 'tophive-pro' ),
			'media_bottom_center' => __( 'Media bottom center', 'tophive-pro' ),
			'body_left'           => __( 'Body left', 'tophive-pro' ),
			'body_right'          => __( 'Body right', 'tophive-pro' ),
			'body_bottom'         => __( 'Body bottom', 'tophive-pro' ),
		);

		foreach ( $positions as $k => $l ) {
			$configs[] = array(
				'name'            => 'wc_cd_ph_' . $k,
				'type'            => 'checkbox',
				'default'         => 'default',
				'priority'        => 18,
				'selector'        => '.wc-product-listing',
				'render_callback' => 'woocommerce_content',
				'section'         => $section,
				'checkbox_label'  => sprintf( __( '%s horizontal', 'tophive-pro' ), $l ),
			);
		}

		if ( $this->is_wishlist_enable() ) {
			// Wishlist.
			$configs[] = array(
				'name'     => 'wc_cd_wishlist_h',
				'type'     => 'heading',
				'section'  => $section,
				'priority' => 50,
				'label'    => __( 'Product Wishlist', 'tophive-pro' ),
			);

			$configs[] = array(
				'name'            => 'wc_cd_wishlist_type',
				'type'            => 'select',
				'default'         => 'icon',
				'priority'        => 50,
				'choices'         => array(
					'icon'           => __( 'Icon', 'tophive-pro' ),
					'text'           => __( 'Text', 'tophive-pro' ),
					'both'           => __( 'Icon & text', 'tophive-pro' ),
				),
				'selector'        => '.wc-product-listing',
				'render_callback' => 'woocommerce_content',
				'section'         => $section,
				'label'           => __( 'Display Type', 'tophive-pro' ),
			);

			$configs[] = array(
				'name'            => 'wc_cd_wishlist_styling',
				'type'            => 'styling',
				'section'         => $section,
				'title'           => __( 'Styling', 'tophive-pro' ),
				'description'     => __( 'Advanced styling for wishlist button', 'tophive-pro' ),
				'priority'        => 50,
				'selector'        => array(
					'normal'         => '.products .product .cd-btn.wishlist-btn',
					'hover'          => '.products .product .cd-btn.wishlist-btn:hover',
				),
				'css_format'      => 'styling',
				'default'         => array(),
				'fields'          => array(
					'normal_fields'  => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'   => array(
						'link_color'    => false, // disable for special field.
					),
				),
			);

		}

		if ( $this->is_compare_enable() ) {
			// Compare.
			$configs[] = array(
				'name'     => 'wc_cd_compare_h',
				'type'     => 'heading',
				'section'  => $section,
				'priority' => 52,
				'label'    => __( 'Product Compare', 'tophive-pro' ),
			);

			$configs[] = array(
				'name'            => 'wc_cd_compare_type',
				'type'            => 'select',
				'default'         => 'icon',
				'priority'        => 52,
				'choices'         => array(
					'icon'           => __( 'Icon', 'tophive-pro' ),
					'text'           => __( 'Text', 'tophive-pro' ),
					'both'           => __( 'Icon & text', 'tophive-pro' ),
				),
				'selector'        => '.wc-product-listing',
				'render_callback' => 'woocommerce_content',
				'section'         => $section,
				'label'           => __( 'Display Type', 'tophive-pro' ),
			);

			$configs[] = array(
				'name'            => 'wc_cd_compare_styling',
				'type'            => 'styling',
				'section'         => $section,
				'title'           => __( 'Styling', 'tophive-pro' ),
				'description'     => __( 'Advanced styling for compare button', 'tophive-pro' ),
				'priority'        => 52,
				'selector'        => array(
					'normal'         => '.products .product .wc-product-inner .cd-btn.tophive-wc-compare',
					'hover'          => '.products .product .wc-product-inner .cd-btn.tophive-wc-compare: hover',
				),
				'css_format'      => 'styling',
				'default'         => array(),
				'fields'          => array(
					'normal_fields'  => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'   => array(
						'link_color'    => false, // disable for special field.
					),
				),
			);

		}

		// Advanced styling.
		$configs[] = array(
			'name'     => 'wc_cd_advanced_styling_h',
			'type'     => 'heading',
			'section'  => $section,
			'priority' => 200,
			'label'    => __( 'Advanced Styling', 'tophive-pro' ),
		);

		$configs[] = array(
			'name'            => 'wc_cd_list_media_gap',
			'type'            => 'slider',
			'section'         => $section,
			'unit'            => 'px',
			'max'             => 100,
			'device_settings' => true,
			'priority'        => 200,
			'selector'        => 'format',
			'css_format'      => '.woocommerce-listing.wc-list-view .product.tophive-col:not(.product-category) .wc-product-inner .wc-product-media { margin-right: {{value}}; } ',
			'title'           => __( 'List View Media Gap', 'tophive-pro' ),
		);

		$configs[] = array(
			'name'            => 'wc_cd_row_gap',
			'type'            => 'slider',
			'device_settings' => true,
			'min'             => 0,
			'step'            => 1,
			'max'             => 100,
			'priority'        => 200,
			'section'         => $section,
			'title'           => __( 'Row Gap', 'tophive-pro' ),
			'selector'        => '.woocommerce ul.products li.product, .woocommerce ul.products > li',
			'css_format'      => 'margin-top: calc( {{value}}/ 2 ); margin-bottom: calc( {{value}}/ 2 );',
		);

		$configs[] = array(
			'name'            => 'wc_cd_col_gap',
			'type'            => 'slider',
			'device_settings' => true,
			'min'             => 0,
			'step'            => 1,
			'max'             => 100,
			'priority'        => 200,
			'section'         => $section,
			'title'           => __( 'Column Gap', 'tophive-pro' ),
			'selector'        => 'format',
			'css_format'      => '.woocommerce ul.products li.product, .woocommerce ul.products > li { padding-left: calc( {{value}}/ 2 ); padding-right: calc( {{value}}/ 2 ); } .woocommerce ul.products { margin-left: calc( -{{value}}/ 2 ) ; margin-right: calc( -{{value}}/ 2 ); }',
		);

		$configs[] = array(
			'name'            => 'wc_cd_product_styling',
			'type'            => 'styling',
			'section'         => $section,
			'title'           => __( 'Product Wrapper Styling', 'tophive-pro' ),
			'description'     => __( 'Advanced styling for product wrapper', 'tophive-pro' ),
			'priority'        => 200,
			'selector'        => array(
				'normal'         => '.products .product .wc-product-inner',
				'hover'          => '.products .product .wc-product-inner: hover',
			),
			'css_format'      => 'styling',
			'default'         => array(),
			'fields'          => array(
				'normal_fields'  => array(
					'color'         => false, // disable for special field.
					'link_color'    => false, // disable for special field.
					'bg_image'      => false,
					'bg_cover'      => false,
					'bg_position'   => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
				),
				'hover_fields'   => array(
					'color'         => false, // disable for special field.
					'link_color'    => false, // disable for special field.
				),
			),
		);

		$configs[] = array(
			'name' => 'wc_cd_product_body_styling',
			'type' => 'styling',
			'section' => $section,
			'title' => __( 'Product Outside Media Styling', 'tophive-pro' ),
			'description' => __( 'Advanced styling for product outside media', 'tophive-pro' ),
			'priority' => 200,
			'selector' => array(
				'normal' => '.products .product .wc-product-contents',
				'hover'  => '.products .wc-product-inner:hover .wc-product-contents',
			),
			'css_format' => 'styling',
			'default' => array(),
			'fields' => array(
				'normal_fields' => array(
					'text_color'    => false, // disable for special field.
					'link_color'    => false, // disable for special field.
					'bg_image'      => false,
					'bg_cover'      => false,
					'bg_position'   => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
				),
				'hover_fields' => array(
					'text_color' => false, // disable for special field.
					'link_color' => false, // disable for special field.
				),
			),
		);

		$position_parts = array(
			'p-media-top'    => __( 'Product Media Top Styling', 'tophive-pro' ),
			'p-media-center' => __( 'Product Media Center Styling', 'tophive-pro' ),
			'p-media-bottom' => __( 'Product Media Bottom Styling', 'tophive-pro' ),
		);
		foreach ( $position_parts as $k => $label ) {
			$configs[] = array(
				'name' => "wc_cd_position_{$k}_styling",
				'type' => 'styling',
				'section' => $section,
				'title' => $label,
				'priority' => 210,
				'selector' => array(
					'normal' => ".product .{$k}",
				),
				'css_format' => 'styling',
				'default' => array(),
				'fields' => array(
					'normal_fields' => array(
						'text_color'     => false, // disable for special field.
						'link_color'     => false, // disable for special field.
						'bg_heading'     => false,
						'bg_color'       => false,
						'bg_image'       => false,
						'bg_cover'       => false,
						'bg_position'    => false,
						'bg_repeat'      => false,
						'bg_attachment'  => false,
						'border_heading' => false,
						'border_style'   => false,
						'border_width'   => false,
						'border_color'   => false,
						'border_radius'  => false,
						'box_shadow'     => false,
					),
					'hover_fields' => false,
				),
			);
		}

		$configs[] = array(
			'name'            => 'wc_cd_disable_tooltip',
			'type'            => 'checkbox',
			'priority'        => 250,
			'section'         => $section,
			'default'         => false,
			'title'           => __( 'Disable Tooltip', 'tophive-pro' ),
			'description'     => __( 'Tooltip only show for product items and the item display as icon.', 'tophive-pro' ),
		);

		return $configs;
	}

}

new OneCoreCustomizerduct_Designer();
