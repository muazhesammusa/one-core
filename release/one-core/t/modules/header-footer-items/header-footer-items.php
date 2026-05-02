<?php

class OneCoreCustomizer_Module_Header_Footer_Items extends OneCoreCustomizer_Module_Base {

	function __construct() {
		require_once dirname( __FILE__ ) . '/inc/html.php';
		require_once dirname( __FILE__ ) . '/inc/secondary-menu.php';
		require_once dirname( __FILE__ ) . '/inc/languages-switcher.php';
		require_once dirname( __FILE__ ) . '/inc/contact.php';
		require_once dirname( __FILE__ ) . '/inc/icon-box.php';
		require_once dirname( __FILE__ ) . '/inc/footer-menu.php';

		add_action( 'after_setup_theme', array( $this, 'register_menu' ), 80 );

		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}

		add_filter( 'tophive/builder/footer/rows', array( $this, 'enable_footer_row_top' ) );
		add_filter( 'tophive/customize-menu-config-more', array( $this, 'sub_menu_config' ), 15, 3 );
	}

	function enable_footer_row_top( $rows ) {
		$rows['top'] = __( 'Footer Top', 'tophive-pro' );
		return $rows;
	}

	function assets() {
		$this->add_css();
	}
	function register_menu() {
		register_nav_menus(
			array(
				'menu-2' => esc_html__( 'Secondary', 'tophive-pro' ),
				'footer-menu' => esc_html__( 'Footer Horizontal Menu', 'tophive-pro' ),
			)
		);
	}


	function sub_menu_config( $config, $section = '', $class = null ) {
		$more_config = array(
			array(
				'name' => $class->prefix . '_submenu_heading',
				'type' => 'heading',
				'section' => $section,
				'title'  => __( 'Submenu', 'tophive-pro' ),
			),

			array(
				'name' => $class->prefix . '_submenu_width',
				'type' => 'slider',
				'section' => $section,
				'selector' => $class->selector . ' .sub-menu',
				'device_settings' => true,
				'css_format' => 'width: {{value}};',
				'title'  => __( 'Submenu Width', 'tophive-pro' ),
				'min' => 100,
				'max' => 500,
				'step' => 5,
			),

			array(
				'name' => $class->prefix . '_sub_styling',
				'type' => 'styling',
				'section' => $section,
				'title'  => __( 'Submenu Styling', 'tophive-pro' ),
				'description'  => __( 'Advanced styling for submenu', 'tophive-pro' ),
				'selector'  => array(
					'normal' => "{$class->selector} .sub-menu, .builder-item-sidebar .sub-menu",
				),
				'css_format'  => 'styling',
				'fields' => array(
					'normal_fields' => array(
						// 'margin' => true,
						'padding' => false, // disable for special field.
						'text_color' => false,
						'link_color' => false,
						'bg_cover' => false,
						'bg_image' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_position' => false,
					),
					'hover_fields' => false,
				),
			),

			array(
				'name' => $class->prefix . '_sub_item_styling',
				'type' => 'styling',
				'section' => $section,
				'title'  => __( 'Submenu Items Styling', 'tophive-pro' ),
				'description'  => __( 'Styling for submenu items', 'tophive-pro' ),
				'selector'  => array(
					'normal' => "{$class->selector} .sub-menu li a, .builder-item-sidebar .sub-menu li a",
					'hover' => "{$class->selector} .sub-menu li a:hover, {$class->selector} .sub-menu li a:focus, .builder-item-sidebar .sub-menu li a:hover, .builder-item-sidebar .sub-menu li a:focus",
				),
				'css_format'  => 'styling',
				'fields' => array(
					'tabs' => array(
						'normal' => __( 'Normal', 'tophive-pro' ),
						'hover'  => __( 'Hover/Active', 'tophive-pro' ),
					),
					'normal_fields' => array(
						// 'padding' => false, // disable for special field.
						'link_color' => false,
						'margin' => false,
						'bg_cover' => false,
						'bg_image' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_position' => false,
					),
					'hover_fields' => array(
						'padding' => false,
						'link_color' => false,
						'bg_cover' => false,
						'bg_image' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_position' => false,
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name' => $class->prefix . '_typography_submenu',
				'type' => 'typography',
				'section'  => $section,
				'title' => __( 'Submenu Items Typography', 'tophive-pro' ),
				'description' => __( 'Typography for submenu items', 'tophive-pro' ),
				'selector'  => "{$class->selector} .sub-menu li a, .builder-item-sidebar .sub-menu li a",
				'css_format' => 'typography',
			),
		);

		return array_merge( $config, $more_config );
	}

}
