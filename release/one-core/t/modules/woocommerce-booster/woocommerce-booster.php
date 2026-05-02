<?php
/**
 * Register module
 */
OneCoreCustomizer()->register_module(
	'OneCoreCustomizer_Module_WooCommerce_Booster',
	array()
);

/**
 * Load sub modules
 */
require_once dirname( __FILE__ ) . '/single-product-layouts.php';
require_once dirname( __FILE__ ) . '/off-canvas-filter.php';
require_once dirname( __FILE__ ) . '/product-gallery-slider.php';
require_once dirname( __FILE__ ) . '/quick-view.php';

/**
 * Main module class
 *
 * Class OneCoreCustomizer_Module_WooCommerce_Booster
 */
class OneCoreCustomizer_Module_WooCommerce_Booster extends OneCoreCustomizer_Module_Base {

	static $_instance = null;

	/**
	 * Instance
	 *
	 * @return OneCoreCustomizer_Module_WooCommerce_Booster
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance            = new self();
			self::$_instance->is_assets = true;
			require_once dirname( __FILE__ ) . '/builder-items/currency-switcher.php';
			require_once dirname( __FILE__ ) . '/builder-items/payment-methods.php';
			require_once dirname( __FILE__ ) . '/builder-items/wishlist.php';
			require_once dirname( __FILE__ ) . '/builder-items/woo-search-box.php';

			require_once dirname( __FILE__ ) . '/3rd/ti-woocommerce-wishlist/class-add-to-wishlist.php';
			require_once dirname( __FILE__ ) . '/3rd/ti-woocommerce-wishlist/init.php';
			require_once dirname( __FILE__ ) . '/3rd/woo-smart-compare/init.php';

			require_once dirname( __FILE__ ) . '/inc/product-designer/class-product-designer.php';

			if ( ! is_admin() ) {
				add_action( 'tophive-pro/scripts', array( self::$_instance, 'assets' ) );
			}

			// Load Plugin template first.
			add_filter(
				'woocommerce_locate_template',
				array(
					self::$_instance,
					'woocommerce_locate_template',
				),
				35,
				2
			);
		}

		return self::$_instance;
	}

	public function assets() {
		$this->is_assets = true;
		$this->add_css();
		if ( ! tophive_one()->get_setting( 'wc_cd_disable_tooltip' ) ) {
			$this->add_js( 'tippy.js', 'tippy', false );
			$this->add_js();
		}
	}

	/**
	 * Load WC template from plugin first
	 *
	 * @see \woocommerce_locate_template
	 *
	 * @param string $located       File path.
	 * @param string $template_name Template name.
	 *
	 * @return string File path.
	 */
	public function woocommerce_locate_template( $located, $template_name = '' ) {

		$plugin_located = dirname( __FILE__ ) . '/templates/' . $template_name;
		if ( file_exists( $plugin_located ) ) {
			return $plugin_located;
		}

		return $located;
	}

}
