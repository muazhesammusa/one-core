<?php

class OneCoreCustomizer_Module_Header_Transparent extends OneCoreCustomizer_Module_Base {
	static $is_transparent = null;
	public $name = null;
	public $description = null;

	function __construct() {

		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 6 );
		if ( ! is_admin() ) {
			add_filter( 'tophive/builder/row-classes', array( $this, 'row_classes' ), 20, 3 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
			add_action( 'customizer/after-logo-img', array( $this, 'transparent_logo' ) );
			add_action( 'tophive/logo-classes', array( $this, 'logo_classes' ) );
		}
	}

	function assets() {
		if ( ! is_admin() ) {
			$this->add_css();
			$suffix = tophive_one()->get_asset_suffix();
			$file   = 'script' . $suffix . '.js';
			$this->add_js( OneCoreCustomizer()->get_url() . '/modules/header-sticky/js/' . $file, 'header-sticky', true );
		}
	}

	function logo_classes( $classes ) {
		$logo_id    = tophive_one()->get_setting( 'header_logo_tran' );
		$logo_image = tophive_one()->get_media( $logo_id, 'full' );
		if ( $logo_image ) {
			$classes[] = 'has-tran-logo';
		} else {
			$classes[] = 'no-tran-logo';
		}

		return $classes;
	}

	function transparent_logo() {
		$logo_id           = tophive_one()->get_setting( 'header_logo_tran' );
		$logo_image        = tophive_one()->get_media( $logo_id, 'full' );
		$logo_retina       = tophive_one()->get_setting( 'header_logo_tran_retina' );
		$logo_retina_image = tophive_one()->get_media( $logo_retina );
		if ( $logo_image ) {
			?>
			<img class="site-img-logo-tran" src="<?php echo esc_url( $logo_image ); ?>"
				 alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>"<?php if ( $logo_retina_image ) {
						?> srcset="<?php echo esc_url( $logo_retina_image ); ?> 2x"<?php } ?>>
			<?php
		}
	}

	function config_row( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'name'     => '',
				'id'       => '',
				'selector' => '',
			)
		);

		$section      = 'header_transparent';
		$fn           = 'tophive_customize_render_header';
		$selector     = '#masthead';
		$row_selector = ".header--row.header-{$args['id']}.header--transparent";

		$config = array(

			array(
				'name'    => 'header_' . $args['id'] . '_transparent_h',
				'type'    => 'heading',
				'section' => $section,
				'title'   => $args['name'],
			),

			array(
				'name'            => 'header_' . $args['id'] . '_transparent',
				'type'            => 'checkbox',
				'section'         => $section,
				'checkbox_label'  => sprintf( __( 'Transparent %s', 'tophive-pro' ), $args['name'] ),
			   // 'selector'        => $selector,
				// 'render_callback' => $fn,
			),

			array(
				'name'             => 'header_' . $args['id'] . '_transparent_styling',
				'type'             => 'styling',
				'section'          => $section,
				'title'            => __( 'Styling', 'tophive-pro' ),
				'description'      => sprintf( __( 'Transparent styling for %s', 'tophive-pro' ), $args['name'] ),
				'live_title_field' => 'title',
				'selector'         => array(
					'normal'            => "{$row_selector} .tophive-container, {$row_selector}.layout-full-contained, {$row_selector}.layout-fullwidth",
				),
				'css_format'       => 'styling', // styling
				'fields'           => array(
					'normal_fields' => array(
						'padding'       => false,  // disable for special field.
						'margin'        => false,
						'text_color'    => false,
						'link_color'    => false,
						'bg_heading'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'border_radius' => false,
						'box_shadow'    => false,
					),
					'hover_fields'  => false,
				),
			),
		);

		return $config;
	}

	function config( $configs ) {
		$section  = 'header_transparent';
		$fn       = 'tophive_customize_render_header';
		$selector = '#masthead';

		$display_fields = array(
			array(
				'name'           => 'index',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on index', 'tophive-pro' ),
			),
			array(
				'name'           => 'category',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on categories', 'tophive-pro' ),
			),
			array(
				'name'           => 'search',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on search', 'tophive-pro' ),
			),
			array(
				'name'           => 'archive',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on archive', 'tophive-pro' ),
			),
			array(
				'name'           => 'page',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on single page', 'tophive-pro' ),
			),
			array(
				'name'           => 'post',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on single post', 'tophive-pro' ),
			),
			array(
				'name'           => 'singular',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on singular', 'tophive-pro' ),
			),
			array(
				'name'           => 'page_404',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on 404 page', 'tophive-pro' ),
			),

		);

		if ( tophive_one()->is_woocommerce_active() ) {
			$display_fields[] = array(
				'name'           => 'product',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on product page', 'tophive-pro' ),
			);
			$display_fields[] = array(
				'name'           => 'product_cat',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on product category', 'tophive-pro' ),
			);
			$display_fields[] = array(
				'name'           => 'product_tag',
				'type'           => 'checkbox',
				'checkbox_label' => __( 'Disable on product tag', 'tophive-pro' ),
			);

		}

		$config = array(

			array(
				'name'  => $section,
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => __( 'Header Transparent', 'tophive-pro' ),
			),

			array(
				'name'    => "{$section}_display_h",
				'type'    => 'heading',
				'section' => $section,
				'title'   => __( 'Advanced Settings', 'tophive-pro' ),
			),

			array(
				'name'        => "{$section}_display_pages",
				'type'        => 'modal',
				'section'     => $section,
				'label'       => __( 'Display', 'tophive-pro' ),
				'description' => __( 'Settings display for special pages.', 'tophive-pro' ),
				'default'     => array(),
				'fields'      => array(
					'tabs'           => array(
						'display' => __( 'Display', 'tophive-pro' ),
					),
					'display_fields' => $display_fields,
				),
			),

		);

		$rows = array(
			array(
				'id'   => 'top',
				'name' => __( 'Header Top', 'tophive-pro' ),
			),
			array(
				'id'   => 'main',
				'name' => __( 'Header Main', 'tophive-pro' ),
			),
			array(
				'id'   => 'bottom',
				'name' => __( 'Header Bottom', 'tophive-pro' ),
			),
		);

		$_rows = array();
		foreach ( $rows as $arg ) {
			$_rows = array_merge( $_rows, $this->config_row( $arg ) );
		}
		$config = array_merge( $_rows, $config );
		// return array_merge( $configs, $config );
		$render_logo_cb_el = array(
			One_Customize_Layout_Builder()->get_builder_item( 'header', 'logo' ),
			'render',
		);
		$selector          = '.site-header .site-branding';
		$config[]          = array(
			'name'            => 'header_logo_tran',
			'type'            => 'image',
			'section'         => $section,
			'device_settings' => false,
			'selector'        => $selector,
			'render_callback' => $render_logo_cb_el,
			'priority'        => 820,
			'title'           => __( 'Transparent Logo', 'tophive-pro' ),
		);

		$config[] = array(
			'name'            => 'header_logo_tran_retina',
			'type'            => 'image',
			'section'         => $section,
			'device_settings' => false,
			'selector'        => $selector,
			'render_callback' => $render_logo_cb_el,
			'priority'        => 825,
			'title'           => __( 'Transparent Logo Retina', 'tophive-pro' ),
		);

		$config[] = array(
			'name'            => 'logo_tran_max_width',
			'type'            => 'slider',
			'section'         => $section,
			'default'         => array(),
			'max'             => 400,
			'priority'        => 830,
			'device_settings' => true,
			'title'           => __( 'Transparent Logo Max Width', 'tophive-pro' ),
			'selector'        => $selector . ' img.site-img-logo-tran',
			'css_format'      => 'max-width: {{value}};',
		);

		return array_merge( $configs, $config );
	}

	function row_classes( $classes, $row_id, $builder ) {
		if ( $builder->get_id() == 'header' ) {
			if ( $this->is_transparent() ) {
				if ( tophive_one()->get_setting( "header_{$row_id}_transparent" ) ) {
					$classes['transparent'] = 'header--transparent';
				}
			}
		}
		return $classes;
	}

	function is_transparent( $force = false ) {
		if ( self::$is_transparent === null || $force ) {
			$is_tran = false;
			foreach ( array( 'top', 'main', 'bottom' ) as $row_id ) {
				if ( tophive_one()->get_setting( "header_{$row_id}_transparent" ) ) {
					$is_tran = true;
				}
			}

			if ( $is_tran ) {

				$display = tophive_one()->get_setting_tab( 'header_transparent_display_pages', 'display' );
				$display = wp_parse_args(
					$display,
					array(
						'index'       => '',
						'category'    => '',
						'search'      => '',
						'archive'     => '',
						'page'        => '',
						'post'        => '',
						'singular'    => '',
						'product'     => '',
						'product_cat' => '',
						'product_tag' => '',
						'page_404'    => '',
					)
				);

				$hide = false;

				if ( is_front_page() && is_home() ) { // index page
					// Default homepage
					$hide = $display['index'];
				} elseif ( is_front_page() ) {
					// static homepage
					$hide = $display['page'];
				} elseif ( is_home() ) {
					// blog page
					$hide = $display['page'];
				} elseif ( is_category() ) {
					// category
					$hide = $display['category'];
				} elseif ( is_page() ) {
					// single page
					$hide = $display['page'];
				} elseif ( is_single() ) {
					// single post
					$hide = $display['post'];
				} elseif ( is_singular() ) {
					// single custom post type
					$hide = $display['singular'];
				} elseif ( is_404() ) {
					// page not found
					$hide = $display['page_404'];
				} elseif ( is_search() ) {
					// Search result
					$hide = $display['search'];
				} elseif ( is_archive() ) {
					$hide = $display['archive'];
				}

				// WooCommerce Settings
				if ( tophive_one()->is_woocommerce_active() ) {
					if ( is_product() ) {
						$hide = $display['product'];
					} elseif ( is_product_category() ) {
						$hide = $display['product_cat'];
					} elseif ( is_product_tag() ) {
						$hide = $display['product_tag'];
					} elseif ( is_shop() ) {
						$hide = $display['page'];
					}
				}

				if ( $hide ) {
					$is_tran = false;
				} else {
					$cover_settings = One_Page_Header::get_instance()->get_settings();
					if ( $cover_settings['display'] == 'cover' || $cover_settings['display'] == 'shortcode' ) {
						$is_tran = true;
					} else {
						$is_tran = false;
					}
				}

				if ( tophive_one()->is_using_post() ) {
					$id = tophive_one()->get_current_post_id();
					if ( $id ) {
						$page_header_display = get_post_meta( $id, '_tophive_header_transparent_display', true );
						if ( $page_header_display == 'hide' ) {
							$is_tran = false;
						} elseif ( $page_header_display == 'show' ) {
							$is_tran = true;
						}
					}
				}
			} // $is_tran

			self::$is_transparent = apply_filters( 'tophive/render_header/is-transparent', $is_tran );
		}

		return self::$is_transparent;
	}

	function body_classes( $classes ) {
		if ( $this->is_transparent() ) {
			$classes['header_transparent'] = 'is-header-transparent';
		}

		return $classes;
	}
}
new OneCoreCustomizer_Module_Header_Transparent();