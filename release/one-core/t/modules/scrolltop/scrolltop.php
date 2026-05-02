<?php

class OneCoreCustomizer_Module_Scrolltop extends OneCoreCustomizer_Module_Base {

	private $section = 'scrolltop';

	function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 5 );
		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
			add_action( 'wp_footer', array( $this, 'render' ) );
		}
	}

	function assets() {
		 $show = tophive_one()->get_setting( "{$this->section}_show" );
		if ( ! is_customize_preview() ) {
			if ( ! $show ) {
				return;
			}
		}
		$this->add_css();
		$this->add_js();
		$this->add_local_js_args( 'scrolltop_duration', tophive_one()->get_setting( "{$this->section}_duration" ) );
		$this->add_local_js_args( 'scrolltop_offset', tophive_one()->get_setting( "{$this->section}_offset" ) );
	}

	function config( $configs = array() ) {
		$section = $this->section;
		$selector = '#scrolltop';
		$fn = array( $this, 'render' );
		$config = array(
			// Global layout section.
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'footer_settings',
				'title'    => __( 'Scroll To Top', 'tophive-pro' ),
				'priority' => 200,
			),

			array(
				'name'            => "{$section}_show",
				'type'            => 'checkbox',
				'section'         => $section,
				'default'         => 1,
				'checkbox_label'  => __( 'Show Scroll To Top Button', 'tophive-pro' ),
				'selector'        => $selector,
				'render_callback' => $fn,
			),

			array(
				'name'            => "{$section}_icon",
				'type'            => 'icon',
				'section'         => $section,
				'default'         => array(
					'type' => 'font-awesome',
					'icon' => 'fa fa-angle-double-up',
				),
				'label'  => __( 'Icon', 'tophive-pro' ),
				'selector'        => $selector,
				'render_callback' => $fn,
				'required'        => array( "{$section}_show", '=', '1' ),
			),

			array(
				'name'            => "{$section}_position",
				'type'            => 'radio_group',
				'section'         => $section,
				'label'           => __( 'Position', 'tophive-pro' ),
				'choices'         => array(
					'left'  => __( 'Left', 'tophive-pro' ),
					'right' => __( 'Right', 'tophive-pro' ),
				),
				'default'         => 'right',
				'selector'        => $selector,
				'render_callback' => $fn,
				'required'        => array( "{$section}_show", '=', '1' ),
			),

			array(
				'name'            => "{$section}_mgb",
				'type'            => 'slider',
				'max'             => 150,
				'section'         => $section,
				'device_settings' => true,
				'css_format'      => 'bottom: {{value}};',
				'label'           => __( 'Margin bottom', 'tophive-pro' ),
				'selector'        => "{$selector}",
				'required'        => array( "{$section}_show", '=', '1' ),
			),
			array(
				'name'            => "{$section}_mgr",
				'type'            => 'slider',
				'max'             => 150,
				'device_settings' => true,
				'section'         => $section,
				'css_format'      => 'right: {{value}};',
				'label'           => __( 'Margin Right', 'tophive-pro' ),
				'selector'        => "{$selector}.right",
				'required'        => array(
					array( "{$section}_position", '!=', 'left' ),
					array( "{$section}_show", '=', '1' ),
				),
			),

			array(
				'name'            => "{$section}_mgl",
				'type'            => 'slider',
				'max'             => 150,
				'device_settings' => true,
				'section'         => $section,
				'css_format'      => 'left: {{value}};',
				'label'           => __( 'Margin Left', 'tophive-pro' ),
				'selector'        => "{$selector}.left",
				'required'        => array(
					array( "{$section}_position", '=', 'left' ),
					array( "{$section}_show", '=', '1' ),
				),
			),

			array(
				'name'            => "{$section}_duration",
				'type'            => 'text',
				'section'         => $section,
				'default'         => 500,
				'title'  => __( 'Scroll Duration (milliseconds)', 'tophive-pro' ),
				'transport' => 'postMessage',
				'required'        => array( "{$section}_show", '=', '1' ),
			),

			array(
				'name'            => "{$section}_offset",
				'type'            => 'text',
				'section'         => $section,
				'default'         => 100,
				'title'           => __( 'Offset', 'tophive-pro' ),
				'description'     => __( 'Show button when page scrolled top x pixels.', 'tophive-pro' ),
				'transport'       => 'postMessage',
				'required'        => array( "{$section}_show", '=', '1' ),
			),

			array(
				'name'       => "{$section}_styling",
				'type'       => 'modal',
				'section'    => $section,
				'default'    => 1,
				'title'      => __( 'Styling', 'tophive-pro' ),
				'selector'   => $selector,
				'css_format' => 'styling',
				'required'   => array( "{$section}_show", '=', '1' ),
				'fields'     => array(
					'tabs'          => array(
						'normal' => __( 'Normal', 'tophive-pro' ),
						'hover'  => __( 'Hover', 'tophive-pro' ),
					),
					'normal_fields' => array(
						array(
							'name'       => 'text_color',
							'type'       => 'color',
							'label'      => __( 'Color', 'tophive-pro' ),
							'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
							'selector'   => "{$selector} i",
						),

						array(
							'name'            => 'padding',
							'type'            => 'slider',
							'max'             => 150,
							'device_settings' => true,
							'css_format'      => 'height: {{value}}; width: {{value}};',
							'label'           => __( 'Padding', 'tophive-pro' ),
							'selector'        => "{$selector} i",
						),

						array(
							'name'            => 'icon_size',
							'type'            => 'slider',
							'device_settings' => true,
							'css_format'      => 'font-size: {{value}};',
							'max'             => 100,
							'label'           => __( 'Icon Size', 'tophive-pro' ),
							'selector'        => "{$selector} i:before",
						),

						array(
							'name'  => 'bg_heading',
							'type'  => 'heading',
							'label' => __( 'Background', 'tophive-pro' ),
						),

						array(
							'name'       => 'bg_color',
							'type'       => 'color',
							'label'      => __( 'Background Color', 'tophive-pro' ),
							'css_format' => 'background-color: {{value}};',
							'selector'   => "{$selector} i",
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
							'css_format' => 'border-style: {{value}};',
							'selector'   => "{$selector} i",
						),

						array(
							'name'       => 'border_width',
							'type'       => 'css_ruler',
							'label'      => __( 'Border Width', 'tophive-pro' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'css_format' => array(
								'top'    => 'border-top-width: {{value}};',
								'right'  => 'border-right-width: {{value}};',
								'bottom' => 'border-bottom-width: {{value}};',
								'left'   => 'border-left-width: {{value}};',
							),
							'selector'   => "{$selector} i",
						),
						array(
							'name'       => 'border_color',
							'type'       => 'color',
							'label'      => __( 'Border Color', 'tophive-pro' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'css_format' => 'border-color: {{value}};',
							'selector'   => "{$selector} i",
						),

						array(
							'name'       => 'border_radius',
							'type'       => 'css_ruler',
							'label'      => __( 'Border Radius', 'tophive-pro' ),
							'css_format' => array(
								'top'    => 'border-top-left-radius: {{value}};',
								'right'  => 'border-top-right-radius: {{value}};',
								'bottom' => 'border-bottom-right-radius: {{value}};',
								'left'   => 'border-bottom-left-radius: {{value}};',
							),
							'selector'   => "{$selector} i",
						),

						array(
							'name'       => 'box_shadow',
							'type'       => 'shadow',
							'label'      => __( 'Box Shadow', 'tophive-pro' ),
							'css_format' => 'box-shadow: {{value}};',
							'selector'   => "{$selector} i",
						),

					),

					'hover_fields' => array(
						array(
							'name'       => 'text_color',
							'type'       => 'color',
							'label'      => __( 'Color', 'tophive-pro' ),
							'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'  => 'bg_heading',
							'type'  => 'heading',
							'label' => __( 'Background', 'tophive-pro' ),
						),
						array(
							'name'       => 'bg_color',
							'type'       => 'color',
							'label'      => __( 'Background Color', 'tophive-pro' ),
							'css_format' => 'background-color: {{value}};',
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'  => 'border_heading',
							'type'  => 'heading',
							'label' => __( 'Border', 'tophive-pro' ),
						),
						array(
							'name'       => 'border_style',
							'type'       => 'select',
							'label'      => __( 'Border Style', 'tophive-pro' ),
							'default'    => '',
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
							'css_format' => 'border-style: {{value}};',
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'       => 'border_width',
							'type'       => 'css_ruler',
							'label'      => __( 'Border Width', 'tophive-pro' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'css_format' => array(
								'top'    => 'border-top-width: {{value}};',
								'right'  => 'border-right-width: {{value}};',
								'bottom' => 'border-bottom-width: {{value}};',
								'left'   => 'border-left-width: {{value}};',
							),
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'       => 'border_color',
							'type'       => 'color',
							'label'      => __( 'Border Color', 'tophive-pro' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'css_format' => 'border-color: {{value}};',
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'       => 'border_radius',
							'type'       => 'css_ruler',
							'label'      => __( 'Border Radius', 'tophive-pro' ),
							'css_format' => array(
								'top'    => 'border-top-left-radius: {{value}};',
								'right'  => 'border-top-right-radius: {{value}};',
								'bottom' => 'border-bottom-right-radius: {{value}};',
								'left'   => 'border-bottom-left-radius: {{value}};',
							),
							'selector'   => "{$selector}:hover i",
						),
						array(
							'name'       => 'box_shadow',
							'type'       => 'shadow',
							'label'      => __( 'Box Shadow', 'tophive-pro' ),
							'css_format' => 'box-shadow: {{value}};',
							'selector'   => "{$selector}:hover i",
						),

					),
				),
			),

		);

		return array_merge( $configs, $config );
	}

	function render() {
		 $section = 'scrolltop';
		$show = tophive_one()->get_setting( "{$section}_show" );
		if ( ! is_customize_preview() ) {
			if ( ! $show ) {
				return;
			}
		}
		$icon = tophive_one()->get_setting( "{$section}_icon" );
		$position = tophive_one()->get_setting( "{$section}_position" );
		$icon = wp_parse_args(
			$icon,
			array(
				'type' => '',
				'icon' => '',
			)
		);
		if ( $position != 'left' ) {
			$position = 'right';
		}

		$classes = array( 'scrolltop' );
		$classes[] = $position;
		if ( ! $show ) {
			$classes[] = 'hide';
		}

		?>
		<div id="scrolltop" class="<?php echo esc_attr( join( ' ', $classes ) ); ?>"><?php
		if ( $icon['icon'] ) {
			echo '<i class="' . esc_attr( $icon['icon'] ) . '"></i>';
		}
		?></div>
		<?php
	}


}
new OneCoreCustomizer_Module_Scrolltop();