<?php
class One_Builder_Item_Icon_Box {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $panel;
	public $sidebar = true;
	public $vertical_default = false;

	/**
	 * Optional construct
	 */
	function __construct() {
		$this->id = 'icon-box';
		$this->label = __( 'Icon Box', 'tophive-pro' );
		$this->prefix = 'icon-box';
		$this->selector = '.header--row .icon-box';
		$this->section = 'icon-box';
		$this->panel = 'header_settings';
		add_filter( 'tophive/icon_used', array( $this, 'used_icon' ) );
	}

	function used_icon( $list = array() ) {
		$list[ $this->id ] = 1;
		return $list;
	}

	function item() {
		return array(
			'name' => $this->label,
			'id' => $this->id,
			'width' => '2',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	function customize() {
		$section = $this->section;
		$fn = array( $this, 'render' );
		$config = array(
			array(
				'name' => $section,
				'type' => 'section',
				'panel' => $this->panel,
				'title' => $this->label,
			),

			array(
				'name'             => $this->prefix . '_items',
				'type'             => 'repeater',
				'section'          => $section,
				'selector'         => $this->selector,
				'render_callback'  => $fn,
				'title'            => __( 'Icon Box Items', 'tophive-pro' ),
				'live_title_field' => 'title',
				'default'          => array(
					array(
						'title' => _x( "We're on call 24/7", 'Default iconbox', 'tophive-pro' ),
						'sub_title' => _x( '1.800.123.4567', 'Default iconbox', 'tophive-pro' ),
						'icon' => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-phone',
						),
						'url' => 'tel://18001234567',
					),
					array(
						'title' => _x( 'Operating Hours', 'Default iconbox', 'tophive-pro' ),
						'sub_title' => _x( 'Mon-Fri 08:00-20:00', 'Default iconbox', 'tophive-pro' ),
						'icon' => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-clock-o',
						),
						'url' => '',
					),
					array(
						'title' => _x( 'Get in touch', 'Default iconbox', 'tophive-pro' ),
						'sub_title' => _x( 'info@yoursite.com', 'Default iconbox', 'tophive-pro' ),
						'icon' => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-envelope-o',
						),
						'url' => 'mailto:support@yoursite.com',
					),
				),
				'fields'           => array(
					array(
						'name'  => 'title',
						'type'  => 'text',
						'label' => __( 'Title', 'tophive-pro' ),
					),
					array(
						'name'  => 'sub_title',
						'type'  => 'text',
						'label' => __( 'Sub Title', 'tophive-pro' ),
					),
					array(
						'name'  => 'icon',
						'type'  => 'icon',
						'label' => __( 'Icon', 'tophive-pro' ),
					),
					array(
						'name'  => 'url',
						'type'  => 'text',
						'label' => __( 'Link', 'tophive-pro' ),
					),
				),
			),

			array(
				'name'            => $this->prefix . '_typo',
				'type'            => 'typography',
				'section'         => $section,
				'label'           => __( 'Item Typography', 'tophive-pro' ),
				'selector'        => "{$this->selector} li",
				'css_format'      => 'typography',
			),

			array(
				'name'       => $this->prefix . '_styling',
				'type'       => 'styling',
				'section'    => $section,
				'title'      => __( 'Item Styling', 'tophive-pro' ),
				'selector'   => array(
					'normal'            => "{$this->selector} li",
					'normal_margin'     => "{$this->selector} li",
					'normal_text_color' => "{$this->selector} li, .header-menu-sidebar .icon-box li, {$this->selector} li a, .header-menu-sidebar .icon-box li a",
					'hover'             => "{$this->selector} li:hover, .header-menu-sidebar .icon-box li:hover, {$this->selector} li a:hover, .header-menu-sidebar .icon-box li a:hover",
					'hover_text_color'  => "{$this->selector} {$this->selector} li:hover, {$this->selector} li a:hover",
				),
				'css_format' => 'styling',
				'fields'     => array(
					'tabs'          => array(
						'normal' => __( 'Normal', 'tophive-pro' ),
						'hover'  => __( 'Hover', 'tophive-pro' ),
					),
					'normal_fields' => array(
						// 'padding' => false // disable for special field.
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
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'            => $this->prefix . '_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $section,
				'min'             => 10,
				'step'            => 1,
				'max'             => 100,
				// 'selector'        => "$selector li a",
				'selector'        => 'format',
				'css_format'      => "{$this->selector} li .c-icon { font-size: {{value}}; }",
				'label'           => __( 'Icon Size', 'tophive-pro' ),
			),

			array(
				'name'            => $this->prefix . '_padding',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $section,
				'min'             => 0,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "{$this->selector} li .c-icon",
				'css_format'      => 'padding: {{value}};',
				'label'           => __( 'Icon Padding', 'tophive-pro' ),
			),

			array(
				'name'       => $this->prefix . '_icon_styling',
				'type'       => 'styling',
				'section'    => $section,
				'title'      => __( 'Item Icon Styling', 'tophive-pro' ),
				'selector'   => array(
					'normal'            => "{$this->selector} li .c-icon",
					'normal_padding'            => "{$this->selector} li .icon-box-label",
					'hover'             => "{$this->selector} li:hover .c-icon, {$this->selector} li a:hover .c-icon",
				),
				'css_format' => 'styling',
				'fields'     => array(
					'tabs'          => array(
						'normal' => __( 'Normal', 'tophive-pro' ),
						'hover'  => __( 'Hover', 'tophive-pro' ),
					),
					'normal_fields' => array(
						// 'padding' => false // disable for special field.
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
						'box_shadow'   => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
						'box_shadow'   => false,
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'            => $this->prefix . '_display_align',
				'type'            => 'select',
				'device_settings' => true,
				'section'         => $section,
				'devices'         => array( 'desktop', 'mobile' ),
				'selector'        => "{$this->selector}",
				'render_callback'  => $fn,
				'label'           => __( 'Display Align', 'tophive-pro' ),
				'default' => ( $this->vertical_default ) ? array(
					'desktop' => 'vertical',
					'tablet' => 'vertical',
					'mobile' => 'vertical',
				) : null,
				'choices'           => array(
					'horizontal' => __( 'Horizontal', 'tophive-pro' ),
					'vertical' => __( 'Vertical', 'tophive-pro' ),
				),
			),

		);

		if ( $this->sidebar ) {
			$config[] = array(
				'name'            => $this->prefix . '_vertical_on_sidebar',
				'type'            => 'checkbox',
				'section'         => $section,
				'selector'        => "{$this->selector}",
				'render_callback'  => $fn,
				'checkbox_label'           => __( 'Display as vertical in menu sidebar', 'tophive-pro' ),
			);
		}

		// Item Layout
		return array_merge( $config, tophive_header_layout_settings( $this->id, $section ) );
	}

	/**
	 * @see https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
	 */
	function render() {
		$classes = array();
		$classes[] = 'icon-box';

		$items = tophive_one()->get_setting( $this->prefix . '_items' );
		$algin_desktop = tophive_one()->get_setting( $this->prefix . '_display_align', 'desktop' );
		$algin_mobile = tophive_one()->get_setting( $this->prefix . '_display_align', 'mobile' );
		$v_in_sidebar = tophive_one()->get_setting( $this->prefix . '_vertical_on_sidebar' );
		if ( $v_in_sidebar ) {
			$classes[] = 'hca-sidebar-vertical';
		}
		$classes[] = 'cont-desktop-' . $algin_desktop;
		$classes[] = 'cont-mobile-' . $algin_mobile;
		echo '<ul id="' . esc_attr( $this->id ) . '" class="' . esc_attr( join( ' ', $classes ) ) . '">';
		foreach ( (array) $items as $item ) {
			$item = wp_parse_args(
				$item,
				array(
					'title' => '',
					'sub_title' => '',
					'icon' => '',
					'url' => '',
					'_visibility' => '',
				)
			);

			$item['icon'] = wp_parse_args(
				$item['icon'],
				array(
					'icon' => '',
				)
			);

			if ( $item['_visibility'] != 'hidden' ) {
				$icon_html = '';
				if ( $item['icon']['icon'] ) {
					$icon_html = '<span class="icon-box-flex icon-box-icon"><i class="c-icon ' . esc_attr( $item['icon']['icon'] ) . '"></i></span>';
				}

				$label = '';
				if ( $item['title'] ) {
					$label .= '<span class="icon-box-title">' . wp_kses_post( $item['title'] ) . '</span>';
				}
				if ( $item['sub_title'] ) {
					$label .= '<span class="icon-box-sub-title">' . wp_kses_post( $item['sub_title'] ) . '</span>';
				}

				if ( $label ) {
					$label = '<span class="icon-box-flex icon-box-label">' . $label . '</span>';
				}

				if ( is_rtl() ) {
					$text = $label . $icon_html;
				} else {
					$text = $icon_html . $label;
				}

				echo '<li class="icon-box-item">';
				if ( $item['url'] ) {
					printf( '<a class="icon-box-inner" title="%3$s" href="%1$s">%2$s</a>', esc_url( $item['url'] ), $text, $item['title'] );
				} else {
					printf( '<span class="icon-box-inner">%1$s</span>', $text );
				}
				echo '</li>';
			}
		}
		echo '</ul>';

	}

}

class One_Builder_Footer_Item_Icon_Box extends One_Builder_Item_Icon_Box {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $panel;
	public $sidebar;
	public $vertical_default;
	/**
	 * Optional construct
	 */
	function __construct() {
		$this->id = 'footer-icon-box';
		$this->label = __( 'Icon Box', 'tophive-pro' );
		$this->prefix = 'footer-icon-box';
		$this->selector = '#footer-icon-box';
		$this->section = 'footer-icon-box';
		$this->panel = 'footer_settings';
		$this->sidebar = false;
		$this->vertical_default = true;
	}
}

One_Customize_Layout_Builder()->register_item( 'header', new One_Builder_Item_Icon_Box() );
One_Customize_Layout_Builder()->register_item( 'footer', new One_Builder_Footer_Item_Icon_Box() );
