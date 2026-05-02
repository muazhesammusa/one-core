<?php

class OneCoreCustomizer_Module_WC_Gallery_Slider extends OneCoreCustomizer_Module_Base {
	function __construct() {
		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 25 );

		/**
		 * @see woocommerce_photoswipe
		 */
		add_action( 'wp_footer', array( $this, 'woocommerce_photoswipe' ), 15 );

		/**
		 * @see woocommerce_gallery_image_size
		 */
		add_filter( 'woocommerce_gallery_image_size', array( $this, 'woocommerce_gallery_image_size' ) );

		/**
		 * Disable flex slider, zoom photoswipe
		 */
		apply_filters( 'woocommerce_single_product_flexslider_enabled', '__return_false', 99 );
		apply_filters( 'woocommerce_single_product_zoom_enabled', '__return_false', 99 );
		apply_filters( 'woocommerce_single_product_photoswipe_enabled', '__return_false', 99 );

		/**
		 * Add Slider Settings
		 */
		add_filter( 'tophive/customizer/config', array( $this, 'configs' ), 50 );

	}

	/**
	 * Add slider config
	 *
	 * @param array $configs List configs.
	 *
	 * @return array
	 */
	function configs( $configs ) {

		$section = 'wc_single_product';

		$required = apply_filters( 'wc_gallery_slider_required', null );

		$configs[] = array(
			'name'     => 'wc_single_gallery_slider_h',
			'type'     => 'heading',
			'section'  => $section,
			'label'    => __( 'Product Gallery Slider', 'tophive-pro' ),
			'priority' => 30,
			'required' => $required,
		);

		$configs[] = array(
			'name'     => 'wc_single_gallery_slider',
			'type'     => 'select',
			'section'  => $section,
			'default'  => 'thumbnails_horizontal',
			'label'    => __( 'Slider Display', 'tophive-pro' ),
			'choices'  => array(
				'thumbnails_horizontal' => __( 'Thumbnails Horizontal', 'tophive-pro' ),
				'thumbnails_vertical'   => __( 'Thumbnails Vertical', 'tophive-pro' ),
				'hide_thumbnails'       => __( 'Hide Thumbnails', 'tophive-pro' ),
			),
			'priority' => 30,
			'required' => $required,
		);

		$configs[] = array(
			'name'           => 'wc_single_gallery_enable_zoom',
			'type'           => 'checkbox',
			'section'        => $section,
			'default'        => '1',
			'checkbox_label' => __( 'Enable Zoom', 'tophive-pro' ),
			'priority'       => 35,
			'required'       => $required,
		);

		$configs[] = array(
			'name'           => 'wc_single_gallery_enable_lightbox',
			'type'           => 'checkbox',
			'section'        => $section,
			'default'        => '1',
			'checkbox_label' => __( 'Enable Lightbox', 'tophive-pro' ),
			'priority'       => 35,
			'required'       => $required,
		);

		return $configs;
	}


	/**
	 * All product gallery image have same size
	 *
	 * @param string $size Image size.
	 *
	 * @return string
	 */
	public function woocommerce_gallery_image_size( $size ) {
		$size = 'woocommerce_single';
		return $size;
	}

	/**
	 * Load photo photoswipe
	 */
	function woocommerce_photoswipe() {
		wc_get_template( 'single-product/photoswipe.php' );
	}

	/**
	 * Remove theme support for gallery
	 */
	function theme_setup() {
		remove_theme_support( 'wc-product-gallery-slider' );
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
	}

	/**
	 * Add assets to front end
	 */
	function assets() {

		wp_enqueue_script( 'zoom' );
		wp_enqueue_script( 'photoswipe' );
		wp_enqueue_script( 'photoswipe-ui-default' );
		wp_enqueue_style( 'photoswipe-default-skin' );

		$slick_url = OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->get_url();
		$suffix    = tophive_one()->get_asset_suffix();

		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( $slick_url . '/assets/slick/slick' . $suffix . '.js', false, true );

		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_css( 'product-gallery-slider' . $suffix . '.css' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( 'product-gallery-slider' . $suffix . '.js' );
		$vertical_mod = tophive_one()->get_setting( 'wc_single_gallery_slider' ) == 'thumbnails_vertical' ? true : false;
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_local_js_args(
			'wc_product_gallery',
			array(
				'vertical'        => $vertical_mod,
				'auto_resize'     => apply_filters( 'wc_single_gallery_slider_auto_resize_nav', false ),
				'enable_slider'   => apply_filters( 'wc_single_gallery_enable_slider', true ),
				'show_thumbs'     => tophive_one()->get_setting( 'wc_single_gallery_slider' ) == 'hide_thumbnails' ? false : true,
				'enable_zoom'     => apply_filters( 'wc_single_gallery_enable_zoom', tophive_one()->get_setting( 'wc_single_gallery_enable_zoom' ) == 1 ? true : false ),
				'enable_lightbox' => tophive_one()->get_setting( 'wc_single_gallery_enable_lightbox' ) == 1 ? true : false,
				'auto_width'      => apply_filters( 'wc_single_gallery_slider_auto_width', false ),
				'slider'          => array(
					'slidesToShow'   => 1,
					'slidesToScroll' => 1,
					'infinite'       => false,
					'isSyn'          => false,
					'accessibility'  => false, // prevent scroll to top
					'speed'          => 300,
					'centerMode'     => false,
					'focusOnSelect'  => true,
					'adaptiveHeight' => true,
					'mobileFirst'    => true,
					'variableWidth'  => false,
					'dots'           => false,
					'swipe'          => false,
					'lazyLoad'       => 'progressive',
					'rtl'            => is_rtl(),
					'draggable'      => true,

					'prevArrow' => '<button type="button" class="slick-prev nav-btn x2 nav-prev slick-arrow">' . apply_filters( 'tophive_nav_prev_icon', '' ) . '</button>',
					'nextArrow' => '<button type="button" class="slick-next nav-btn x2 nav-next slick-arrow">' . apply_filters( 'tophive_nav_next_icon', '' ) . '</button>',
				),
				'thumbs'          => apply_filters(
					'wc_single_gallery_thumbs_args',
					array(
						'slidesToShow'    => 4,
						'vertical'        => $vertical_mod,
						'infinite'        => true,
						'isSyn'           => false,
						'accessibility'   => false, // prevent scroll to top
						'verticalSwiping' => $vertical_mod,
						'speed'           => 300,
						'centerMode'      => false,
						'slidesToScroll'  => 1,
						'focusOnSelect'   => true,
						'mobileFirst'     => true,
						'variableWidth'   => false,
						'dots'            => false,
						'lazyLoad'        => 'progressive',
						'rtl'             => is_rtl(),
						'draggable'       => true,
						'prevArrow'       => '<button type="button" class="slick-prev nav-btn nav-prev slick-arrow">' . apply_filters( 'tophive_nav_prev_icon', '' ) . '</button>',
						'nextArrow'       => '<button type="button" class="slick-next nav-btn nav-next slick-arrow">' . apply_filters( 'tophive_nav_next_icon', '' ) . '</button>',

					)
				),
			)
		);
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_local_js_args(
			'wc_product_gallery_quick_view',
			array(
				'vertical'        => false,
				'enable_slider'   => true,
				'auto_width'      => true,
				'show_thumbs'     => false,
				'enable_zoom'     => true,
				'enable_lightbox' => true,
				'slider'          => array(
					'dots' => true,
				),
			)
		);

	}
}

