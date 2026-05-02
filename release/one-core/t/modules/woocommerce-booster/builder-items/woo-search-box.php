<?php

class One_Advance_Search_Box {
	public $id = 'search_box';
	public $section = 'search_box';
	public $name = 'search_box';


	/**
	 * Optional construct
	 *
	 * One_Builder_Item_HTML constructor.
	 */
	public function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 100 );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'tophive/builder_item/search-box/form_extra_class', array( $this, 'form_extra_class' ), 10 );
		add_action( 'tophive/builder_item/search-box/html_content/before_input', array( $this, 'post_type_field' ) );
		add_action( 'tophive/builder_item/search-box/html_content/before_input', array( $this, 'select_cats_field' ) );
	}

	public function body_class( $classes ) {
		$classes[] = 'woo_bootster_search';
		return $classes;
	}

	/**
	 * Filter to exists configs
	 *
	 * @return array
	 */
	public function config( $configs ) {
		$selector = ".header-{$this->id}-item";
		$fn       = array( $this, 'render' );

		$configs[] = array(
			'name'        => $this->section . '_search_only_product',
			'type'        => 'checkbox',
			'section'     => $this->section,
			'default'     => false,
			'label'       => __( 'Search products only', 'tophive-pro' ),
			'description' => __( 'Search WooCommerce products only', 'tophive-pro' ),
			'priority'    => 11,
		);

		$configs[] = array(
			'name'        => $this->section . '_show_cats',
			'type'        => 'checkbox',
			'section'     => $this->section,
			'default'     => false,
			'label'       => __( 'Enable product categories', 'tophive-pro' ),
			'description' => __( 'Enable search products with category', 'tophive-pro' ),
			'priority'    => 12,
			'required'    => array( $this->section . '_search_only_product', '=', '1' ),
		);

		$configs[] = array(
			'name'            => $this->section . '_all_cat_text',
			'type'            => 'text',
			'section'         => $this->section,
			'label'           => __( 'All categories text', 'tophive-pro' ),
			'default'         => __( 'All Categories', 'tophive-pro' ),
			'required'        => array(
				array( "{$this->section}_show_cats", '=', '1' ),
				array( "{$this->section}_search_only_product", '=', '1' ),
			),
			'priority'        => 13,
		);

		foreach ( $configs as $key => $config ) {
			if ( $this->section . '_height' === $config['name'] ) {
				$configs[ $key ]['selector'] = "{$selector} .header-search-form, {$selector} .header-search-form .search-field, {$selector} .header-search-form .search_product_cats";
				$configs[ $key ]['css_format'] = 'height: {{value}};line-height: {{value}};min-height: {{value}};';
			}

			if ( $this->section . '_font_size' === $config['name'] ) {
				$configs[ $key ]['selector'] = "$selector .header-search-form .search-form-fields, {$selector} .header-search-form .search-field, {$selector} .header-search-form .search-field::placeholder, {$selector} .header-search-form .search_product_cats";
			}

			if ( $this->section . '_input_styling' === $config['name'] ) {
				$configs[ $key ]['selector'] = array(
					'normal'                  => ".woo_bootster_search {$selector} .header-search-form .search-form-fields, .woo_bootster_search {$selector} .header-search-form .search-field, .woo_bootster_search {$selector} .header-search-form .search_product_cats",
					'hover'                   => ".woo_bootster_search {$selector} .header-search-form .search-field:focus, .woo_bootster_search {$selector} .header-search-form .search_product_cats:focus",
					'normal_text_color'       => ".woo_bootster_search {$selector} .search-form-fields,
												  .woo_bootster_search {$selector} .search-form-fields input.search-field::placeholder,
												  .woo_bootster_search {$selector} .search-form-fields select.search_product_cats,
												  .dark-mode {$selector} .search-form-fields .search-field,
												  .dark-mode {$selector} .search-form-fields .search-field::placeholder,
												  .woo_bootster_search .dark-mode {$selector} .header-search-form .search-form-fields input.search-field,
												  .woo_bootster_search .dark-mode {$selector} .header-search-form .search-form-fields input.search-field::placeholder,
												  .woo_bootster_search .dark-mode {$selector} .search-form-fields .search_product_cats 
												  ",
					'normal_style'            => "{$selector} .header-search-form .search-field, {$selector} .header-search-form .search-field::placeholder, {$selector} .header-search-form .search_product_cats",
					'normal_text_decoration'  => "{$selector} .header-search-form .search-field, {$selector} .header-search-form .search-field::placeholder, {$selector} .header-search-form .search_product_cats",
					'normal_text_transform'   => "{$selector} .header-search-form .search-field, {$selector} .header-search-form .search-field::placeholder, {$selector} .header-search-form .search_product_cats",
					'normal_border_style'     => ".woo_bootster_search {$selector} .header-search-form,.woo_bootster_search {$selector} .header-search-form .search_product_cats, .dark-mode {$selector} .search-form-fields, .woo_bootster_search .dark-mode {$selector} .header-search-form .search_product_cats",
					'normal_border_width'     => ".woo_bootster_search {$selector} .header-search-form,.woo_bootster_search {$selector} .header-search-form .search_product_cats, .dark-mode {$selector} .search-form-fields, .woo_bootster_search .dark-mode {$selector} .header-search-form .search_product_cats",
					'normal_border_color'     => ".woo_bootster_search {$selector} .header-search-form,.woo_bootster_search {$selector} .header-search-form .search_product_cats, .dark-mode {$selector} .search-form-fields, .woo_bootster_search .dark-mode {$selector} .header-search-form .search_product_cats",
					'normal_border_radius'    => ".woo_bootster_search {$selector} .header-search-form, .dark-mode {$selector} .search-form-fields",
					'normal_box_shadow'       => ".woo_bootster_search {$selector} .header-search-form, .dark-mode {$selector} .search-form-fields",
					'normal_bg_color'         => "{$selector} .header-search-form, .dark-mode {$selector} .search-form-fields",
				);
			}
		}

		return $configs;
	}

	/**
	 * Add post type product to search form
	 */
	public function post_type_field() {
		$search_only_product = tophive_one()->get_setting( $this->section . '_search_only_product' );
		if ( $search_only_product ) {
			?>
			<input type="hidden" name="post_type" value="product" />
			<?php
		}
	}

	/**
	 * Add select categories to search form
	 */
	public function select_cats_field() {
		$search_only_product = tophive_one()->get_setting( $this->section . '_search_only_product' );
		$show_cats = tophive_one()->get_setting( $this->section . '_show_cats' );
		if ( $search_only_product && $show_cats ) {
			$all_cats_text = tophive_one()->get_setting( $this->section . '_all_cat_text' );
			$all_cats_text = ( ! empty( $all_cats_text ) ) ? $all_cats_text : esc_html__( 'All Categories', 'tophive-pro' );
			$selected_cat = 0;
			if ( isset( $_GET['product_cat'] ) && sanitize_text_field( wp_unslash( $_GET['product_cat'] ) ) ) {
				$selected_cat = sanitize_text_field( wp_unslash( $_GET['product_cat'] ) );
			}
			$args = array(
				'show_option_all' => esc_html( $all_cats_text ),
				'taxonomy'     => 'product_cat',
				'orderby'      => 'ID',
				'order'        => 'ASC',
				'hierarchical' => true,
				'hide_empty'   => true,
				'value_field'  => 'slug',
				'selected'     => $selected_cat,
				'name'         => 'product_cat',
				'id'           => 'product_cat_' . uniqid(),
				'class'        => 'search_product_cats',
			);
			wp_dropdown_categories( $args );
		}
	}

	public function form_extra_class( $classes ) {
		$search_only_product = tophive_one()->get_setting( $this->section . '_search_only_product' );
		$show_cats = tophive_one()->get_setting( $this->section . '_show_cats' );

		if ( $search_only_product && $show_cats ) {
			$classes[] = 'has_select_cats';
		} else {
			$classes[] = 'no_select_cats';
		}

		return $classes;
	}
}

new One_Advance_Search_Box();
