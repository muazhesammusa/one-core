<?php
class One_Builder_Item_Languages_Switcher {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;

	/**
	 * Optional construct
	 */
	function __construct() {
		$this->id = 'lang_switcher';
		$this->label = __( 'Languages Switcher', 'tophive-pro' );
		$this->prefix = 'lang_switcher';
		$this->selector = '.header--row:not(.header--transparent) #lang_switcher';
		$this->section = 'lang_switcher';
	}

	function item() {
		return array(
			'name' => $this->label,
			'id' => $this->id,
			'width' => '2',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	function is_lang_active() {
		return function_exists( 'icl_get_languages' );
	}

	function customize() {
		$section = $this->section;
		$fn = array( $this, 'render' );

		if ( $this->is_lang_active() ) {

			$config = array(
				array(
					'name'           => $section,
					'type'           => 'section',
					'panel'          => 'header_settings',
					'theme_supports' => '',
					'title'          => $this->label,
				),

				array(
					'name'            => $this->prefix . '_show_name',
					'type'            => 'select',
					'section'         => $section,
					'default'         => 'name',
					'label'           => __( 'Display Names', 'tophive-pro' ),
					'selector'        => $this->selector,
					'render_callback' => $fn,
					'choices'         => array(
						'name' => __( 'Language Names', 'tophive-pro' ),
						'code' => __( 'Language Codes', 'tophive-pro' ),
						'hide' => __( 'Hide Names', 'tophive-pro' ),
					),
				),

				array(
					'name'            => $this->prefix . '_show_flag',
					'type'            => 'checkbox',
					'section'         => $section,
					'default'         => 1,
					'checkbox_label'  => __( 'Show Flags', 'tophive-pro' ),
					'selector'        => $this->selector,
					'render_callback' => $fn,
				),

				array(
					'name'            => $this->prefix . '_skip_missing',
					'type'            => 'checkbox',
					'section'         => $section,
					'default'         => 1,
					'checkbox_label'  => __( 'Skip Missing Languages', 'tophive-pro' ),
					'selector'        => $this->selector,
					'render_callback' => $fn,
				),
				array(
					'name'            => $this->prefix . '_orderby',
					'type'            => 'select',
					'section'         => $section,
					'default'         => 'id',
					'label'           => __( 'Order Languages By', 'tophive-pro' ),
					'selector'        => $this->selector,
					'render_callback' => $fn,
					'choices'         => array(
						'slug' => __( 'Language Code', 'tophive-pro' ),
						'name' => __( 'Language Name', 'tophive-pro' ),
						'id'   => __( 'Language ID', 'tophive-pro' ),
					),
				),
				array(
					'name'            => $this->prefix . '_order',
					'type'            => 'select',
					'section'         => $section,
					'default'         => 'ASC',
					'label'           => __( 'Order Languages', 'tophive-pro' ),
					'selector'        => $this->selector,
					'render_callback' => $fn,
					'choices'         => array(
						'ASC'  => __( 'ASC', 'tophive-pro' ),
						'DESC' => __( 'DESC', 'tophive-pro' ),
					),
				),

				array(
					'name'       => $this->prefix . '_styling',
					'type'       => 'styling',
					'section'    => $section,
					'title'      => __( 'Current Language Styling', 'tophive-pro' ),
					'selector'   => array(
						'normal'            => "{$this->selector} .lang-switcher-top",
						'normal_margin'     => "{$this->selector}",
						'normal_text_color' => "{$this->selector} .lang-switcher-top",
						'hover'             => "{$this->selector} .lang-switcher-top:hover, {$this->selector} .lang-switcher-top.focus",
						'hover_text_color'  => "{$this->selector} .lang-switcher-top:hover, {$this->selector} .lang-switcher-top.focus",
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
					'name'            => $this->prefix . '_sub_align',
					'type'            => 'radio_group',
					'device_settings' => true,
					'section'         => $section,
					'selector'        => $this->section,
					'render_callback' => $fn,
					'default'         => 'left',
					'title'           => __( 'Dropdown Align', 'tophive-pro' ),
					'choices'         => array(
						'left'  => __( 'Left', 'tophive-pro' ),
						'right' => __( 'Right', 'tophive-pro' ),
					),
				),

				array(
					'name'            => $this->prefix . '_sub_width',
					'type'            => 'slider',
					'device_settings' => true,
					'section'         => $section,
					'selector'        => "{$this->selector} .lang-switcher-list",
					'css_format'      => 'width: {{value}};',
					'default'         => 'left',
					'title'           => __( 'Dropdown Width', 'tophive-pro' ),
					'max'             => 250,
					'min'             => 20,
				),

				array(
					'name'       => $this->prefix . '_sub_styling',
					'type'       => 'styling',
					'section'    => $section,
					'title'      => __( 'Dropdown Styling', 'tophive-pro' ),
					'selector'   => array(
						'normal' => "{$this->selector} .lang-switcher-list",
					),
					'css_format' => 'styling',
					'fields'     => array(
						'tabs'          => array(
							'normal' => __( 'Normal', 'tophive-pro' ),
						),
						'normal_fields' => array(
							// 'padding' => false // disable for special field.
							'text_color'    => false,
							'link_color'    => false,
							'bg_cover'      => false,
							'bg_image'      => false,
							'bg_repeat'     => false,
							'bg_attachment' => false,
							'bg_position'   => false,
						),
						'hover_fields'  => false,
					),
				),

				array(
					'name'       => $this->prefix . '_sub-item_styling',
					'type'       => 'styling',
					'section'    => $section,
					'title'      => __( 'Dropdown Item Styling', 'tophive-pro' ),
					'selector'   => array(
						'normal'            => "{$this->selector} .lang-switcher-list a",
						'normal_text_color' => "{$this->selector} .lang-switcher-list a, {$this->selector} .lang-switcher-list a",
						'hover'             => "{$this->selector} .lang-switcher-list a:hover",
						'hover_text_color'  => "{$this->selector} .lang-switcher-list a:hover, {$this->selector} .lang-switcher-list a.focus",
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

			);

			// Item Layout
			return array_merge( $config, tophive_header_layout_settings( $this->id, $section ) );

		} else {

			$html = sprintf( __( 'Please install and active plugin <a target="_blank" href="%1$s">Polylang</a> or <a target="_blank" href="%2$s">WPML</a> to use this item.', 'tophive-pro' ), 'https://wordpress.org/plugins/polylang/', 'https://wpml.org/' );

			$config = array(
				array(
					'name'           => $section,
					'type'           => 'section',
					'panel'          => 'header_settings',
					'theme_supports' => '',
					'title'          => $this->label,
				),

				array(
					'name'            => $this->prefix . '_info',
					'type'            => 'custom_html',
					'section'         => $section,
					'description'     => $html,
				),
			);
			return $config;
		}

		// Item Layout
		// return array_merge( $config, tophive_header_layout_settings( $this->id, $section ) );
	}

	/**
	 * @see https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
	 */
	function render() {

		if ( ! $this->is_lang_active() ) {
			return null;
		}

		$classes = array();
		$classes[] = 'lang-switcher';

		$show_name = tophive_one()->get_setting( $this->prefix . '_show_name' );
		$show_flag = tophive_one()->get_setting( $this->prefix . '_show_flag' );
		$skip_missing = tophive_one()->get_setting( $this->prefix . '_skip_missing' );
		$orderby = tophive_one()->get_setting( $this->prefix . '_orderby' );
		$order = tophive_one()->get_setting( $this->prefix . '_oderby' );
		$aligns = tophive_one()->get_setting( $this->prefix . '_sub_align', 'all' );

		$args = array();
		if ( $skip_missing ) {
			$args['skip_missing'] = 1;
		} else {
			$args['skip_missing'] = 0;
		}
		$args['orderby'] = $orderby;
		$args['order'] = $order;

		$languages = apply_filters( 'wpml_active_languages', array() );

		if ( $show_name == 'hide' ) {
			$classes[] = 'hide-lang-name';
		} else {
			$classes[] = 'show-lang-' . $show_name;
		}
		$url = '';
		$html = '';
		$name = '';
		$list = array();

		foreach ( (array) $aligns as $d => $a ) {
			if ( $d && $a ) {
				$classes[] = "align-{$d}-{$a}";
			}
		}

		foreach ( $languages as $l ) {
			if ( ! $l['active'] ) {
				$_html = '';
				if ( $show_flag ) {
					$_html .= '<img alt="" src="' . esc_url( $l['country_flag_url'] ) . '"/>';
				}

				if ( $show_name == 'code' ) {
					$_html .= '<span>' . $l['language_code'] . '</span>';
				} elseif ( $show_name != 'hide' ) {
					$_html .= '<span>' . $l['native_name'] . '</span>';
				}
				$list[] = sprintf( '<li><a href="%1$s" title="%3$s">%2$s</a></li>', $l['url'], $_html, esc_attr( $l['native_name'] ) );
			} else {
				$name = $l['native_name'];
				$html = '';
				if ( $show_flag ) {
					$html .= '<img alt="" src="' . esc_url( $l['country_flag_url'] ) . '"/>';
				}

				if ( $show_name == 'code' ) {
					$html .= '<span>' . $l['language_code'] . '</span>';
				} elseif ( $show_name != 'hide' ) {
					$html .= '<span>' . $l['native_name'] . '</span>';
				}
			}
		}

		echo '<div id="' . esc_attr( $this->id ) . '" class="' . esc_attr( join( ' ', $classes ) ) . '">';
			printf( '<span title="%3$s" class="lang-switcher-top">%2$s</span>', $url, $html, $name );

		if ( ! empty( $list ) ) {
			echo '<ul class="lang-switcher-list">';
			echo join( "\n", $list );
			echo '</ul>';
		}
		echo '</div>';

	}

}

One_Customize_Layout_Builder()->register_item( 'header', new One_Builder_Item_Languages_Switcher() );
