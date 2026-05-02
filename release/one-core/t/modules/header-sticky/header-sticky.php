<?php

class OneCoreCustomizer_Module_Header_Sticky extends OneCoreCustomizer_Module_Base {

	public $rows;

	function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 5 );

		$this->rows = array(
			array(
				'id'   => 'top',
				'name' => __( 'Header top', 'tophive-pro' ),
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

		if ( ! is_admin() ) {
			add_filter( 'tophive/builder/row-classes', array( $this, 'row_classes' ), 20, 3 );
			// add_action('customizer/render_header/before', array($this, 'before_header'));
			// add_action('customizer/render_header/after', array($this, 'after_header'));
			add_action( 'customizer/after-logo-img', array( $this, 'sticky_logo' ) );
			add_action( 'tophive/logo-classes', array( $this, 'logo_classes' ) );
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}

	}

	function assets() {
		$this->add_css();
		$this->add_js();
		$this->add_local_js_args( 'header_sticky_up', tophive_one()->get_setting( 'header_sticky_adv_up' ) );
	}

	function logo_classes( $classes ) {
		$logo_id = tophive_one()->get_setting( 'header_logo_sticky' );
		$logo_image = tophive_one()->get_media( $logo_id, 'full' );
		if ( $logo_image ) {
			$classes[] = 'has-sticky-logo';
		} else {
			$classes[] = 'no-sticky-logo';
		}
		return $classes;
	}

	function sticky_logo() {
		$logo_id = tophive_one()->get_setting( 'header_logo_sticky' );
		$logo_image = tophive_one()->get_media( $logo_id, 'full' );
		$logo_retina = tophive_one()->get_setting( 'header_logo_sticky_retina' );
		$logo_retina_image = tophive_one()->get_media( $logo_retina );
		if ( $logo_image ) {
			?>
			<img class="site-img-logo-sticky" src="<?php echo esc_url( $logo_image ); ?>"
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

		$section = 'header_sticky';
		$selector = '#masthead';

		// {$selector}.sticky-active .site-header-inner
		$css_selector = ".sticky.sticky-active .header--row.header-{$args['id']}.header--sticky";
		$fn = 'tophive_customize_render_header';

		$config = array(
			array(
				'name'     => "header_{$args['id']}_sticky_h",
				'type'     => 'heading',
				'section'  => $section,
				'title'    => $args['name'],
				'selector' => $selector,
			),

			array(
				'name'            => "header_{$args['id']}_sticky",
				'type'            => 'checkbox',
				'section'         => $section,
				'checkbox_label'  => sprintf( __( 'Sticky %s', 'tophive-pro' ), $args['name'] ),
			   // 'selector'        => $selector,
				// 'render_callback' => $fn,
			),

			array(
				'name'            => "header_{$args['id']}_sticky_height",
				'type'            => 'slider',
				'section'         => $section,
				'theme_supports'  => '',
				'device_settings' => true,
				'max'             => 250,
				'selector'        => $css_selector . " .tophive-grid, $css_selector .style-full-height .primary-menu-ul > li > a",
				'css_format'      => 'min-height: {{value}};',
				'title'           => __( 'Sticky Height', 'tophive-pro' ),
				'required'        => array( "header_{$args['id']}_sticky", '=', 1 ),
			),

		);

		return $config;
	}


	function config( $configs ) {
		$section = 'header_sticky';
		$selector = '#masthead';
		$fn = 'tophive_customize_render_header';
		$config = array(
			// Global layout section.
			array(
				'name'  => $section,
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => __( 'Header Sticky', 'tophive-pro' ),
			),

			array(
				'name'     => 'header_sticky_adv_h',
				'type'     => 'heading',
				'section'  => $section,
				'priority' => 800,
				'title'    => __( 'Advanced Settings', 'tophive-pro' ),
				'selector' => $selector,
			),

			array(
				'name'            => 'header_sticky_adv_up',
				'type'            => 'checkbox',
				'section'         => $section,
				'priority'        => 810,
				'checkbox_label'  => __( 'Show header sticky when scroll up only', 'tophive-pro' ),
				'selector'        => $selector,
				'render_callback' => $fn,
			),

			array(
				'name'        => 'header_sticky_wrapper_pro',
				'type'        => 'modal',
				'section'     => $section,
				'priority'    => 815,
				'label'       => __( 'Sticky Wrapper Styling', 'tophive-pro' ),
				'selector'    => array(
					'normal' => "{$selector}.sticky-active .site-header-inner .header--sticky",
				),
				'default' => array(
					'normal' => array(
						'box_shadow'    => array(
							'color'  => 'rgba(50,50,50,0.06)',
							'x'      => '0',
							'y'      => 5,
							'blur'   => 10,
							'spread' => 0,
							'inset'  => '',
						),
					),
				),
				'css_format'  => 'styling', // styling
				'fields'      => array(
					'tabs'          => array(
						'normal' => __( 'Normal', 'tophive-pro' ),  // null or false to disable
					),
					'normal_fields' => array(

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
							'selector'   => "{$selector}.sticky-active .site-header-inner .header--sticky",
							'css_format' => 'border-style: {{value}};',
						),

						array(
							'name'       => 'border_width',
							'type'       => 'css_ruler',
							'label'      => __( 'Border Width', 'tophive-pro' ),
							'required'   => array(
								array( 'border_style', '!=', 'none' ),
								array( 'border_style', '!=', '' ),
							),
							'css_format' => array(
								'top'    => 'border-top-width: {{value}};',
								'right'  => 'border-right-width: {{value}};',
								'bottom' => 'border-bottom-width: {{value}};',
								'left'   => 'border-left-width: {{value}};',
							),
							'selector'   => "{$selector}.sticky-active .site-header-inner .header--sticky",
						),
						array(
							'name'       => 'border_color',
							'type'       => 'color',
							'label'      => __( 'Border Color', 'tophive-pro' ),
							'required'   => array(
								array( 'border_style', '!=', 'none' ),
								array( 'border_style', '!=', '' ),
							),
							'selector'   => "{$selector}.sticky-active .site-header-inner .header--sticky",
							'css_format' => 'border-color: {{value}};',
						),
						array(
							'name'       => 'background_color',
							'type'       => 'color',
							'label'      => __( 'Background Color', 'tophive-pro' ),
							'selector'   => "{$selector}.sticky-active .site-header-inner .header--sticky",
							'css_format' => 'background-color: {{value}};',
						),

						array(
							'name'       => 'box_shadow',
							'type'       => 'shadow',
							'label'      => __( 'Box Shadow', 'tophive-pro' ),
							'selector'   => "{$selector}.sticky-active .site-header-inner .header--sticky",
							'css_format' => 'box-shadow: {{value}};',
						),
					),
				),
			),

		);

		$_rows = array();

		foreach ( $this->rows as $arg ) {
			$_rows = array_merge( $_rows, $this->config_row( $arg ) );
		}

		$config = array_merge( $_rows, $config );

		$render_logo_cb_el = array( One_Customize_Layout_Builder()->get_builder_item( 'header', 'logo' ), 'render' );
		$selector = '.site-header .site-branding';
		$config[] = array(
			'name'            => 'header_logo_sticky',
			'type'            => 'image',
			'section'         => $section,
			'device_settings' => false,
			'selector'        => $selector,
			'render_callback' => $render_logo_cb_el,
			'priority'        => 820,
			'title'           => __( 'Sticky Logo', 'tophive-pro' ),
		);

		$config[] = array(
			'name'            => 'header_logo_sticky_retina',
			'type'            => 'image',
			'section'         => $section,
			'device_settings' => false,
			'selector'        => $selector,
			'render_callback' => $render_logo_cb_el,
			'priority'        => 825,
			'title'           => __( 'Sticky Logo Retina', 'tophive-pro' ),
		);

		$config[] = array(
			'name'            => 'logo_sticky_max_width',
			'type'            => 'slider',
			'section'         => $section,
			'default'         => array(),
			'max'             => 400,
			'priority'        => 830,
			'device_settings' => true,
			'title'           => __( 'Logo Max Width', 'tophive-pro' ),
			'selector'        => $selector . ' img.site-img-logo-sticky',
			'css_format'      => 'max-width: {{value}};',
		);

		return array_merge( $configs, $config );
	}

	function row_classes( $classes, $row_id, $builder ) {
		if ( $builder->get_id() == 'header' ) {
			if ( tophive_one()->get_setting( "header_{$row_id}_sticky" ) ) {
				$classes['sticky'] = 'header--sticky';
			}
		}
		return $classes;
	}

	function is_sticky() {
		$is_sticky = false;
		foreach ( $this->rows as $arg ) {
			$row_id = $arg['id'];
			if ( tophive_one()->get_setting( "header_{$row_id}_sticky" ) ) {
				$is_sticky = true;
			}
		}

		return $is_sticky;
	}

	function before_header() {
		if ( $this->is_sticky() ) {
			echo '<div id="masthead-wrapper">';
		}
	}

	function after_header() {
		if ( $this->is_sticky() ) {
			echo '</div><!-- /.masthead-wrapper -->';
		}
	}
}
new OneCoreCustomizer_Module_Header_Sticky();