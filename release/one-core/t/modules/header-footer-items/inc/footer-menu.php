<?php

class One_Builder_Item_Footer_Horizontal_Menu extends One_Builder_Item_Primary_Menu {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $theme_location;

	/**
	 * Optional construct
	 */
	function __construct() {
		$this->id = 'footer-horizontal-menu';
		$this->label = __( 'Footer Horizontal Menu', 'tophive-pro' );
		$this->prefix = 'footer_horizontal_menu';
		$this->selector = '.builder-item--' . $this->id . ' .footer-horizontal-menu-ul';
		$this->section = 'footer_horizontal_menu';
		$this->theme_location = 'footer-menu';
	}

	function customize() {
		$section = $this->section;
		$fn      = array( $this, 'render' );
		$config  = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'footer_settings',
				'theme_supports' => '',
				'title'          => $this->label,
				'description'    => sprintf( __( 'Assign <a href="#menu_locations"  class="focus-section">Menu Location</a> for %1$s', 'tophive-pro' ), $this->label ),
			),

			array(
				'name'        => $this->prefix . '_item_styling',
				'type'        => 'styling',
				'section'     => $section,
				'title'       => __( 'Menu Items Styling', 'tophive-pro' ),
				'description' => __( 'Styling for menu items', 'tophive-pro' ),
				'selector'    => array(
					'normal'           => ".footer--row-inner {$this->selector} > li > a",
					'normal_margin'    => "{$this->selector} > li",
					'hover'            => ".footer--row {$this->selector} > li > a:hover,
					.footer--row {$this->selector} > li.current-menu-item > a, 
					.footer--row {$this->selector} > li.current-menu-ancestor > a, 
					.footer--row {$this->selector} > li.current-menu-parent > a",
				),
				'css_format'  => 'styling',
				'fields'      => array(
					'tabs'          => array(
						'normal' => __( 'Normal', 'tophive-pro' ),
						'hover'  => __( 'Hover/Active', 'tophive-pro' ),
					),
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
				),
			),

			array(
				'name'        => $this->prefix . '_typography',
				'type'        => 'typography',
				'section'     => $section,
				'title'       => __( 'Menu Items Typography', 'tophive-pro' ),
				'description' => __( 'Typography for menu', 'tophive-pro' ),
				'selector'    => "{$this->selector} > li > a",
				'css_format'  => 'typography',
			),

		);

		return array_merge( $config, tophive_footer_layout_settings( $this->id, $this->section ) );

	}


}

One_Customize_Layout_Builder()->register_item( 'footer', new One_Builder_Item_Footer_Horizontal_Menu() );
