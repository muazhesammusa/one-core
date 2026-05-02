<?php


class OneCoreCustomizer_Module_WC_Off_Canvas_Filter extends OneCoreCustomizer_Module_Base {
	function __construct() {
		add_action( 'widgets_init', array( $this, 'add_off_canvas_sidebar' ) );
		add_action( 'wp_footer', array( $this, 'display_sidebar' ) );

		add_action( 'widgets_init', array( $this, 'register_widgets' ), 15 );
		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}

		add_action( 'woocommerce_product_query', array( $this, 'pre_get_products' ), 9999, 2 );
		remove_action( 'woocommerce_before_shop_loop', 'tophive_wc_catalog_header', 15 );

		add_action( 'woocommerce_before_shop_loop', array( $this, 'tophive_wc_catalog_header' ), 20 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'active_filters' ), 25 );

		add_filter( 'woocommerce_layered_nav_count', array( $this, 'woocommerce_layered_nav_count' ), 15, 2 );

		// Customize config.
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 5 );
	}

	function config( $configs = array() ) {

		$configs[] = array(
			'name'     => 'wc_products_filter_h',
			'type'     => 'heading',
			'section'  => 'woocommerce_product_catalog',
			'title'    => __( 'Products Filter', 'tophive-pro' ),
			'priority' => 160,
		);

		$configs[] = array(
			'name'     => 'wc_products_filter_notice',
			'type'     => 'custom_html',
			'section'  => 'woocommerce_product_catalog',
			'description'    => __( 'Off-Canvas Sidebar  only show if the sidebar <code>Woocommerce Off-Canvas Sidebar</code> has widget items. Click <a href="https://tophive.local/wp-admin/widgets.php" target="_blank">here</a> to add widgets', 'tophive-pro' ),
			'priority' => 160,
		);

		$configs[] = array(
			'name'     => 'wc_products_filter_sidebar',
			'type'     => 'radio_group',
			'title'    => __( 'Off-Canvas Sidebar Position', 'tophive-pro' ),
			'default'  => 'right',
			'section'  => 'woocommerce_product_catalog',
			'choices'  => array(
				'left'  => __( 'Left', 'tophive-pro' ),
				'right' => __( 'Right', 'tophive-pro' ),
			),
			'priority' => 162,
		);

		return $configs;
	}

	/**
	 * Check conditional to show sidebar
	 *
	 * @return bool
	 */
	function is_show_sidebar() {
		$is_show = ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) ? true : false;

		if ( ! is_active_sidebar( 'off-canvas-sidebar' ) ) {
			$is_show = false;
		}

		return $is_show;
	}

	/**
	 * Change WC count product text.
	 *
	 * @param $count
	 *
	 * @return string
	 */
	function woocommerce_layered_nav_count( $html, $count ) {
		return '<span class="count">' . absint( $count ) . '</span>';
	}

	/**
	 * Display filter button
	 */
	function filter_button() {
		?>
		<span class="tophive-filter-btn wc-svg-btn btn-mg-md">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				 viewBox="0 0 247.46 247.46" xml:space="preserve">
				<path d="M246.744,13.984c-1.238-2.626-3.881-4.301-6.784-4.301H7.5c-2.903,0-5.545,1.675-6.784,4.301
					c-1.238,2.626-0.85,5.73,0.997,7.97l89.361,108.384v99.94c0,2.595,1.341,5.005,3.545,6.373c1.208,0.749,2.579,1.127,3.955,1.127
					c1.137,0,2.278-0.259,3.33-0.78l50.208-24.885c2.551-1.264,4.165-3.863,4.169-6.71l0.098-75.062l89.366-108.388
					C247.593,19.714,247.982,16.609,246.744,13.984z M143.097,122.873c-1.105,1.34-1.711,3.023-1.713,4.761l-0.096,73.103
					l-35.213,17.453v-90.546c0-1.741-0.605-3.428-1.713-4.771L23.404,24.682h200.651L143.097,122.873z" />
			</svg>
			<span>
				<?php _e( 'Filter', 'tophive-pro' ); ?>
			</span>
		</span>
		<?php
	}

	/**
	 * Custom shop header
	 * Add Filter button to shop header
	 *
	 * @see tophive_wc_catalog_header
	 */
	function tophive_wc_catalog_header() {
		// do not show shop header when display subcategories.
		if ( is_product_category() || is_product_tag() || is_product_taxonomy() ) {
			$d = get_option( 'woocommerce_category_archive_display' );
		} else {
			$d = get_option( 'woocommerce_shop_page_display' );
		}

		if ( $d && $d == 'subcategories' ) {
			return;
		}

		if ( ! tophive_one()->get_setting( 'wc_cd_show_catalog_header' ) ) {
			return false;
		}
		echo '<div class="wc-catalog-header">';
		if ( $this->is_show_sidebar() ) {
			$this->filter_button();
		}

		woocommerce_result_count();
		tophive_wc_catalog_view_mod();
		woocommerce_catalog_ordering();
		echo '</div>';
	}

	/**
	 * Display active filters
	 */
	function active_filters() {
		the_widget(
			'WC_Widget_Layered_Nav_Filters',
			array( 'title' => __( 'Active filters', 'tophive-pro' ) ),
			array(
				'before_widget' => '<div class="widget tophive-active-filters %s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);
	}

	/**
	 * Add Filter to query page
	 *
	 * @see WC_Query::product_query
	 *
	 * @param $query
	 * @param $wc_query
	 *
	 * @return bool
	 */
	function pre_get_products( $query, $wc_query ) {
		if ( ! $query->is_main_query() ) {
			return false;
		}

		$post_type = $query->get( 'post_type' );

		$product_taxs    = get_object_taxonomies( $post_type );
		$list_tax_adding = array();

		// Layered nav filters on terms.
		$current_tax_query = $query->get( 'tax_query' );

		if ( ! is_array( $current_tax_query ) ) {
			$current_tax_query = array(
				'relation' => 'AND',
			);
		}

		foreach ( $current_tax_query as $k => $array ) {
			if ( is_array( $array ) ) {
				$list_tax_adding[ $array['taxonomy'] ] = true;
			}
		}

		foreach ( $product_taxs as $tax ) {
			if ( isset( $_GET[ 'filter_' . $tax ] ) && ! isset( $list_tax_adding[ $tax ] ) ) {

				$terms      = wp_unslash( $_GET[ 'filter_' . $tax ] );
				$terms      = explode( ',', $terms );
				$query_type = ( isset( $_GET[ 'query_type_' . $tax ] ) && $_GET[ 'query_type_' . $tax ] == 'and' ) ? 'and' : 'or'; // WPCS: sanitization ok.
				if ( ! empty( $terms ) ) {
					$current_tax_query[ $tax ] = array(
						'taxonomy'         => $tax,
						'field'            => 'slug',
						'terms'            => $terms,
						'operator'         => 'and' === $query_type ? 'AND' : 'IN',
						'include_children' => false,
					);
				}
			}
		}

		$query->set( 'tax_query', $current_tax_query );

	}

	/**
	 * Register widgets
	 */
	function register_widgets() {

	}

	/**
	 * Add assets to front end
	 */
	function assets() {
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_css( 'off-canvas-filter.css' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( 'off-canvas-filter.js' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_local_js_args( 'wc_filter', array( 'shop' => get_permalink( wc_get_page_id( 'shop' ) ) ) );
	}

	/**
	 * Display Of Canvas Sidebar
	 */
	function display_sidebar() {

		if ( $this->is_show_sidebar() ) {
			if ( is_active_sidebar( 'off-canvas-sidebar' ) ) {
				$position = tophive_one()->get_setting( 'wc_products_filter_sidebar' );
				if ( $position != 'left' ) {
					$position = 'right';
				}
				echo '<div class="off-canvas-sidebar-overlay"></div>';
				echo '<div class="off-canvas-sidebar widget-area slider-from-' . esc_attr( $position ) . '">';
				echo '<div class="off-canvas-actions"><a href="#" class="remove2x off-canvas-close">×</a></div>';
				dynamic_sidebar( 'off-canvas-sidebar' );
				echo '</div>';
			}
		}
	}

	/**
	 * Add Off Canvas Sidebar
	 */
	function add_off_canvas_sidebar() {
		register_sidebar(
			array(
				'name'          => __( 'WooCommerce Off Canvas Filter', 'tophive-pro' ),
				'id'            => 'off-canvas-sidebar',
				'description'   => __( 'Widgets in this area will be shown on product catalog and product archives pages.', 'tophive-pro' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

}


