<?php

class OneCoreCustomizer_Module_Infinity extends OneCoreCustomizer_Module_Base {
	function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 5 );
		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}
	}

	function config( $configs ) {

		$config = array(
			// Blog Posts Section.
			array(
				'name'     => 'blog_posts_infinity',
				'type'     => 'section',
				// 'panel'    => 'blog_panel',
				'panel'    => 'panel_blog_post',
				'title'    => __( 'Infinity Load', 'tophive-pro' ),
				'description'    => __( 'If this function enabled, the pagination will ignore.', 'tophive-pro' ),
				'priority' => 200,
			),

			array(
				'name'            => 'infinity_posts_show',
				'type'            => 'checkbox',
				'section'         => 'blog_posts_infinity',
				'default'         => 1,
				'checkbox_label'  => __( 'Enable', 'tophive-pro' ),
			),

			array(
				'name'            => 'infinity_posts_type',
				'type'            => 'select',
				'choices'            => array(
					'auto' => __( 'Auto load', 'tophive-pro' ),
					'click' => __( 'Click to load more items', 'tophive-pro' ),
				),
				'section'         => 'blog_posts_infinity',
				'default'         => 'auto',
				'label'  => __( 'Load Item Type', 'tophive-pro' ),
				'required'        => array( 'infinity_posts_show', '=', '1' ),
			),

			array(
				'name'            => 'infinity_posts_loading_text',
				'type'            => 'text',
				'section'         => 'blog_posts_infinity',
				'default'         => '',
				'label'  => __( 'Loading Label', 'tophive-pro' ),
				'required'        => array( 'infinity_posts_show', '=', '1' ),
			),

			array(
				'name'            => 'infinity_posts_load_more_text',
				'type'            => 'text',
				'section'         => 'blog_posts_infinity',
				'default'         => '',
				'label'           => __( 'Load More Label', 'tophive-pro' ),
				'required'        => array( 'infinity_posts_show', '=', '1' ),
			),

			// Product catalog Section.
			array(
				'name'            => 'infinity_products_heading',
				'type'            => 'heading',
				'section'         => 'woocommerce_product_catalog',
				'title'  => __( 'Infinity Load', 'tophive-pro' ),
				'priority' => 99,
			),

			array(
				'name'            => 'infinity_products_show',
				'type'            => 'checkbox',
				'section'         => 'woocommerce_product_catalog',
				'default'         => 1,
				'checkbox_label'  => __( 'Enable', 'tophive-pro' ),
				'priority' => 100,
			),

			array(
				'name'            => 'infinity_products_type',
				'type'            => 'select',
				'choices'            => array(
					'auto' => __( 'Auto load', 'tophive-pro' ),
					'click' => __( 'Click to load more items', 'tophive-pro' ),
				),
				'section'         => 'woocommerce_product_catalog',
				'default'         => 'auto',
				'label'  => __( 'Load Item Type', 'tophive-pro' ),
				'required'        => array( 'infinity_products_show', '=', '1' ),
				'priority' => 105,
			),

			array(
				'name'            => 'infinity_products_loading_text',
				'type'            => 'text',
				'section'         => 'woocommerce_product_catalog',
				'default'         => '',
				'label'  => __( 'Loading Label', 'tophive-pro' ),
				'required'        => array( 'infinity_products_show', '=', '1' ),
				'priority' => 110,
			),

			array(
				'name'            => 'infinity_products_load_more_text',
				'type'            => 'text',
				'section'         => 'woocommerce_product_catalog',
				'default'         => '',
				'label'           => __( 'Load More Label', 'tophive-pro' ),
				'required'        => array( 'infinity_products_show', '=', '1' ),
				'priority' => 115,
			),

		);

		return array_merge( $configs, $config );
	}

	function get_infinity_settings( $slug = 'posts' ) {
		$settings = array(
			'enable' => tophive_one()->get_setting( "infinity_{$slug}_show" ),
			'load_type' => tophive_one()->get_setting( "infinity_{$slug}_type" ),
			'loading_text' => tophive_one()->get_setting( "infinity_{$slug}_loading_text" ),
			'load_more_text' => tophive_one()->get_setting( "infinity_{$slug}_load_more_text" ),
		);

		if ( ! $settings['loading_text'] ) {
			$settings['loading_text'] = __( 'Loading', 'tophive-pro' );
		}

		if ( ! $settings['load_more_text'] ) {
			$settings['load_more_text'] = __( 'Load More', 'tophive-pro' );
		}

		return $settings;
	}

	function assets() {
		$this->is_assets = true;
		$this->add_css( 'infinity.css' );
		$this->add_js( 'infinity.js' );

		$supports = array( 'posts', 'products' );
		$settings = array();
		foreach ( $supports as $slug ) {
			$settings[ $slug ] = $this->get_infinity_settings( $slug );
		}

		$this->add_local_js_args( 'infinity_load', $settings );
	}
}
new OneCoreCustomizer_Module_Infinity();

