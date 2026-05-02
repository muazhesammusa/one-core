<?php

class OneCoreCustomizer_Module_WC_Quick_View extends OneCoreCustomizer_Module_Base {

	private $backup_post = null;

	function __construct() {

		if ( ! OneCoreCustomizer()->is_enabled_module( 'OneCoreCustomizer_Module_WooCommerce_Booster' ) ) {
			return false; // do nothing if parent module not activated.
		}

		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 155 );
		add_action( 'wp_loaded', array( $this, 'init' ) );

		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}

	}

	/**
	 * Load css and js on front-end
	 */
	function assets() {
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_css( 'quick-view.css' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( 'quick-view.js' );
		$this->add_local_js_args(
			'quick_view',
			array(
				'loading_text' => __( 'Loading...', 'tophive-pro' ),
			)
		);
	}

	/**
	 * Initial
	 */
	function init() {
		add_action( 'wp_ajax_tophive/wc/quick-view', array( $this, 'load_product_quick_view_ajax' ) );
		add_action( 'wp_ajax_nopriv_tophive/wc/quick-view', array( $this, 'load_product_quick_view_ajax' ) );
		add_action( 'tophive_after_loop_product_media', array( $this, 'button' ) );

		if ( ! is_search() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_single_scripts' ), 0 );
			add_action( 'wp_head', array( $this, 'restore_load_single_scripts' ), 999 );
		}
	}

	/**
	 * Add quick view config
	 *
	 * @param array $configs List configs.
	 *
	 * @return array
	 */
	function config( $configs ) {
		$section = 'wc_catalog_designer';

		$configs[] = array(
			'name'    => 'wc_cd_qv_h',
			'type'    => 'heading',
			'section' => $section,
			'priority'   => 40,
			'label'   => __( 'Product Quick View', 'tophive-pro' ),
		);

		$configs[] = array(
			'name'       => 'wc_cd_qv_styling',
			'type'       => 'modal',
			'section'    => $section,
			'css_format' => 'styling',
			'priority'   => 46,
			'selector'   => '.wc-product__part.wc-product__price',
			'label'      => __( 'Styling', 'tophive-pro' ),
			'description' => __( 'Advanced styling for quick view button', 'tophive-pro' ),
			'fields'     => array(
				'tabs'           => array(
					'default' => __( 'Normal', 'tophive-pro' ),
					'hover' => __( 'Hover', 'tophive-pro' ),
				),
				'default_fields' => array(
					array(
						'name'       => 'opacity',
						'type'       => 'slider',
						'label'      => __( 'Opacity', 'tophive-pro' ),
						'max'        => 1,
						'min'        => 0,
						'step'       => 0.1,
						'css_format' => 'opacity: {{value_no_unit}};',
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),
					array(
						'name'       => 'color',
						'type'       => 'color',
						'label'      => __( 'Color', 'tophive-pro' ),
						'css_format' => 'color: {{value}};',
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),
					array(
						'name'       => 'bg_color',
						'type'       => 'color',
						'label'      => __( 'Background Color', 'tophive-pro' ),
						'css_format' => 'background-color: {{value}};',
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),
					array(
						'name'            => 'padding',
						'type'            => 'css_ruler',
						'device_settings' => true,
						'label'           => __( 'Padding', 'tophive-pro' ),
						'css_format'      => array(
							'top'    => 'padding-top: {{value}};',
							'bottom' => 'padding-bottom: {{value}};',
							'left'   => 'padding-left: {{value}};',
							'right'  => 'padding-right: {{value}};',
						),
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),
					array(
						'name'            => 'margin',
						'type'            => 'css_ruler',
						'device_settings' => true,
						'label'           => __( 'Margin', 'tophive-pro' ),
						'css_format'      => array(
							'top'    => 'margin-top: {{value}};',
							'bottom' => 'margin-bottom: {{value}};',
							'left'   => 'margin-left: {{value}};',
							'right'  => 'margin-right: {{value}};',
						),
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),
					array(
						'name'  => 'border_heading',
						'type'  => 'heading',
						'label' => __( 'Border', 'tophive-pro' ),
					),
					array(
						'name'       => 'border_style',
						'type'       => 'select',
						'class'      => 'clear',
						'label'      => __( 'Border Style', 'tophive-pro' ),
						'default'    => '',
						'css_format' => 'border-style: {{value}};',
						'choices'    => array(
							''       => __( 'Default', 'tophive-pro' ),
							'none'   => __( 'None', 'tophive-pro' ),
							'solid'  => __( 'Solid', 'tophive-pro' ),
							'dotted' => __( 'Dotted', 'tophive-pro' ),
							'dashed' => __( 'Dashed', 'tophive-pro' ),
							'double' => __( 'Double', 'tophive-pro' ),
							'ridge'  => __( 'Ridge', 'tophive-pro' ),
							'inset'  => __( 'Inset', 'tophive-pro' ),
							'outset' => __( 'Outset', 'tophive-pro' ),
						),
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),

					array(
						'name'       => 'border_width',
						'type'       => 'css_ruler',
						'label'      => __( 'Border Width', 'tophive-pro' ),
						'required'   => array(
							array( 'border_style', '!=', 'none' ),
							array( 'border_style', '!=', '' ),
						),
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
						'css_format' => array(
							'top'    => 'border-top-width: {{value}};',
							'bottom' => 'border-bottom-width: {{value}};',
							'left'   => 'border-left-width: {{value}};',
							'right'  => 'border-right-width: {{value}};',
						),
					),
					array(
						'name'       => 'border_color',
						'type'       => 'color',
						'label'      => __( 'Border Color', 'tophive-pro' ),
						'css_format' => 'border-color: {{value}};',
						'required'   => array(
							array( 'border_style', '!=', 'none' ),
							array( 'border_style', '!=', '' ),
						),
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),

					array(
						'name'       => 'border_radius',
						'type'       => 'slider',
						'max'        => 100,
						'label'      => __( 'Border Radius', 'tophive-pro' ),
						'css_format' => 'border-radius: {{value}};',
						'selector'   => '.woocommerce .wc-product-inner .tophive-wc-quick-view, .woocommerce .wc-product-inner .button.quick-view-btn',
					),

				),
				'hover_fields' => array(
					array(
						'name'       => 'opacity',
						'type'       => 'slider',
						'label'      => __( 'Opacity', 'tophive-pro' ),
						'max' => 1,
						'min' => 0,
						'step' => 0.1,
						'css_format' => 'opacity: {{value_no_unit}};',
						'selector'   => '.woocommerce .wc-product-inner:hover .tophive-wc-quick-view,  .woocommerce .wc-product-inner:hover .button.quick-view-btn',
					),
					array(
						'name'       => 'color',
						'type'       => 'color',
						'label'      => __( 'Color', 'tophive-pro' ),
						'css_format' => 'color: {{value}};',
						'selector'   => '.woocommerce .wc-product-inner:hover .tophive-wc-quick-view,  .woocommerce .wc-product-inner:hover .button.quick-view-btn',
					),
					array(
						'name'       => 'bg_color',
						'type'       => 'color',
						'label'      => __( 'Background Color', 'tophive-pro' ),
						'css_format' => 'background-color: {{value}};',
						'selector'   => '.woocommerce .wc-product-inner:hover .tophive-wc-quick-view,  .woocommerce .wc-product-inner:hover .button.quick-view-btn',
					),
				),
			),
		);

		return $configs;
	}

	/**
	 * Hack to load single product scripts
	 */
	function load_single_scripts() {
		global $post;
		if ( is_object( $post ) && property_exists( $post, 'post_content' ) ) {
			$this->backup_post = $post;
			if ( ! is_object( $post ) ) {
				$post = (object) array(
					'post_content' => '',
				);
			}
			if ( ! strpos( $post->post_content, '[product_page' ) ) {
				$post->post_content .= '|__[product_page';
			}
		}

	}

	/**
	 * Restore single scripts
	 */
	function restore_load_single_scripts() {
		global $post;
		if ( is_object( $post ) && property_exists( $post, 'post_content' ) ) {
			$post = $this->backup_post;
			$post->post_content = str_replace( '|__[product_page', '', $post->post_content );
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}

	}

	/**
	 * Add quick view button
	 */
	function button() {
		?>
		<a class="tophive-wc-quick-view" data-id="<?php echo esc_attr( get_the_ID() ); ?>" href="#"><?php _e( 'Quick View', 'tophive-pro' ); ?></a>
		<?php
	}

	/**
	 *  Add link to quick view product title
	 */
	function product_quick_view_title() {
		the_title( '<h2 class="product_title entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
	}

	/**
	 * Ajax action to load product in quick view
	 *
	 * @access public
	 * @return void
	 * @since 1.0.0
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	public function load_product_quick_view_ajax() {

		if ( ! isset( $_REQUEST['product_id'] ) ) {
			die();
		}

		global $sitepress;

		$product_id = intval( $_REQUEST['product_id'] );

		/**
		 * WPML Support:  Localize Ajax Call
		 */
		$lang = isset( $_REQUEST['lang'] ) ? $_REQUEST['lang'] : '';
		if ( defined( 'ICL_LANGUAGE_CODE' ) && $lang && isset( $sitepress ) ) {
			$sitepress->switch_lang( $lang, true );
		}

		// set the main wp query for the product.
		wp( 'p=' . $product_id . '&post_type=product' );
		global $post;

		/**
		 * @see WC_Frontend_Scripts::get_script_data();
		 */
		$params = array(
			'review_rating_required' => get_option( 'woocommerce_review_rating_required' ),
			'flexslider'             => apply_filters(
				'woocommerce_single_product_carousel_options',
				array(
					'rtl'            => is_rtl(),
					'animation'      => 'slide',
					'smoothHeight'   => true,
					'directionNav'   => false,
					'controlNav'     => false, // Default thumbnails.
					'slideshow'      => false,
					'animationSpeed' => 500,
					'animationLoop'  => false, // Breaks photoswipe pagination if true.
					'allowOneSlide'  => false,
				)
			),
			'zoom_enabled'           => apply_filters( 'woocommerce_single_product_zoom_enabled', get_theme_support( 'wc-product-gallery-zoom' ) ),
			'zoom_options'           => apply_filters( 'woocommerce_single_product_zoom_options', array() ),
			'photoswipe_enabled'     => apply_filters( 'woocommerce_single_product_photoswipe_enabled', get_theme_support( 'wc-product-gallery-lightbox' ) ),
			'photoswipe_options'     => apply_filters(
				'woocommerce_single_product_photoswipe_options',
				array(
					'shareEl'               => false,
					'closeOnScroll'         => false,
					'history'               => false,
					'hideAnimationDuration' => 0,
					'showAnimationDuration' => 0,
				)
			),
			'flexslider_enabled'     => apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) ),
		);

		$params['flexslider']['controlNav'] = true;
		$params['flexslider']['directionNav'] = true;

		$params['flexslider']['prevText'] = '<button type="button" class="slick-prev nav-btn x2 nav-prev slick-arrow">' . apply_filters( 'tophive_nav_prev_icon', '' ) . '</button>';
		$params['flexslider']['nextText'] = '<button type="button" class="slick-next nav-btn x2 nav-next slick-arrow">' . apply_filters( 'tophive_nav_next_icon', '' ) . '</button>';

		$GLOBALS['tophive_wc_quick_view'] = 1;
		wc_setup_product_data( $post );
		global $product;

		remove_all_actions( 'woocommerce_single_product_summary_before' );
		remove_all_actions( 'woocommerce_after_single_product_summary' );
		remove_all_actions( 'woocommerce_after_single_product' );

		remove_all_actions( 'woocommerce_before_single_product' );
		remove_all_actions( 'woocommerce_after_single_product' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
		// Remove default title.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		// Add link to quick view product title.
		add_action( 'woocommerce_single_product_summary', array( $this, 'product_quick_view_title' ), 5 );

		do_action( 'customif/wc/before/quick-view' );
		ob_start();
		// load content template.
		wc_get_template( 'content-single-product.php' );

		$content = ob_get_clean();

		$variation_params = array(
			'wc_ajax_url'                      => WC_AJAX::get_endpoint( '%%endpoint%%' ),
			'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'tophive-pro' ),
			'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'tophive-pro' ),
			'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'tophive-pro' ),
		);

		/*
		$content = '<div id="tophive-wc-modal-product-'. $product_id .'" class="tophive-wc-modal hide">'.
				   '<div class="tophive-wc-modal-overlay"></div>'.
				   '<div class="tophive-wc-modal-cont  woocommerce woocommerce-page single single-product">'.
				   '<div class="tophive-wc-modal-inner">'.
				   '<a href="#" class="remove2x tophive-wc-modal-close">×</a> '.
				   '<div class="tophive-container">'.
				   '<div class="tophive-grid"><div class="tophive-col-12">' .$content . '</div></div>' .
				   '</div>' .
				   '</div>' .
				   '</div>' ;
		*/

		/**
		 * @TODO tell WC this is single product
		 */
		wp_send_json(
			array(
				'params'           => $params,
				'variation_params' => $variation_params,
				'type'             => $product->product_type,
				'content'          => $content,
			)
		);

		die();
	}
}
