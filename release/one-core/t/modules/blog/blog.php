<?php

class OneCoreCustomizer_Module_Blog extends OneCoreCustomizer_Module_Base {


	public $post_type = 'post';
	function __construct() {
		require_once dirname( __FILE__ ) . '/class-blog-layout.php';
		remove_filter( 'tophive/customizer/config', 'tophive_customizer_blog_posts_config' );
		add_filter( 'tophive/customizer/config', array( $this, 'blog_posts_config' ), 85 );

		add_filter( 'tophive/blog/render_callback', array( $this, 'change_render_class' ) );

		// add_filter( 'tophive/auto-css', array( $this, 'add_blog_inline_style' ) );
		// add_filter( 'tophive/blog/before-render', array( $this, 'blog_inline_style' ) );
		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
		}
	}

	function get_masonry_css() {
		$blog_sections = array(
			array(
				'id' => 'blog_post',
				'selector' => '#blog-posts',
			),
		);

		$css_prefix = '';
		if ( is_customize_preview() ) {
			$css_prefix = '#page ';
		}
		$css = '';
		foreach ( $blog_sections as $section ) {
			$layout = tophive_one()->get_setting( $section['id'] . '_layout' );
			$columns = tophive_one()->get_setting( $section['id'] . '_columns', 'all' );
			if ( $layout == 'blog_masonry' ) {
				if ( is_numeric( $columns ) && $columns > 1 ) {
					$css = "{$css_prefix}{$section['selector']} .layout--blog_masonry{-webkit-column-count: {$columns};  column-count: {$columns};}";
				} elseif ( is_array( $columns ) ) {
					foreach ( $columns as $d => $v ) {
						$v = absint( $v );
						if ( $v < 1 ) {
							$v = 1;
						} elseif ( $v > 12 ) {
							$v = 12;
						}
						$columns[ $d ] = $v;
					}

					foreach ( One_Customizer_Auto_CSS::get_instance()->media_queries as $d => $s ) {
						if ( isset( $columns[ $d ] ) ) {
							$n = $columns[ $d ];
							$css .= sprintf( $s, "{$css_prefix}{$section['selector']} .layout--blog_masonry{-webkit-column-count: {$n};  column-count: {$n};}" );
						}
					}
				}
			}
		}

		return $css;
	}

	function blog_inline_style() {
		$css = $this->get_masonry_css();
		if ( $css ) {
			echo '<style>' . $css . '</style>';
		}
	}

	function add_blog_inline_style( $code ) {
		$code .= $this->get_masonry_css();
		return $code;
	}

	function assets() {
		$this->add_css();
		// $layout = tophive_one()->get_setting( 'blog_post_layout' );
		// if ( $layout == 'blog_masonry'  ) {
		// }
		$suffix = tophive_one()->get_asset_suffix();

		$this->add_js( OneCoreCustomizer()->get_url() . '/assets/js/shuffle' . $suffix . '.js', 'shuffle.js', true );
		$this->add_js();
	}

	function get_taxs() {
		$list = array();
		$taxonomy_objects = get_object_taxonomies( $this->post_type, 'objects' );
		if ( ! empty( $taxonomy_objects ) ) {
			foreach ( $taxonomy_objects as $t ) {
				$list[ $t->name ] = $t->labels->name;
			}
		}
		return $list;
	}

	function change_render_class() {
		return 'OneCoreCustomizer_Blog_Posts_Layout';
	}

	function get_available_items( $show = array(), $remove = array() ) {
		$_show = $show;
		if ( ! is_array( $_show ) ) {
			$_show = array();
		}

		if ( ! is_array( $remove ) ) {
			$remove = array();
		}

		$_show = array_flip( $_show );
		$_remove = array_flip( $remove );
		$items = array(
			array(
				'_visibility' => '',
				'_key' => 'title',
				'title' => __( 'Title', 'tophive-pro' ),
			),
			array(
				'_key' => 'meta',
				'_visibility' => '',
				'title' => __( 'Meta', 'tophive-pro' ),
			),
			array(
				'_key' => 'excerpt',
				'_visibility' => '',
				'title' => __( 'Excerpt', 'tophive-pro' ),
			),
			array(
				'_key' => 'category',
				'_visibility' => '',
				'title' => __( 'Category', 'tophive-pro' ),
			),
			array(
				'_key' => 'readmore',
				'_visibility' => '',
				'title' => __( 'Read more', 'tophive-pro' ),
			),
		);

		foreach ( $items as $k => $i ) {
			if ( isset( $_show[ $i['_key'] ] ) || $show == 'all' ) {
				$items[ $k ]['_visibility'] = 'visible';
			} else {
				$items[ $k ]['_visibility'] = 'hidden';
			}

			if ( isset( $_remove[ $i['_key'] ] ) ) {
				unset( $items[ $k ] );
			}
		}

		return $items;

	}

	function blog_config( $args = array() ) {
		$item_fields = array(
			array(
				'name' => '_key',
				'type' => 'hidden',
			),
			array(
				'name' => 'title',
				'type' => 'hidden',
				'label' => __( 'Title', 'tophive-pro' ),
			),
		);

		$args = wp_parse_args(
			$args,
			array(
				'name' => __( 'Blog Posts', 'tophive-pro' ),
				'id' => 'blog_post',
				'selector' => '#blog-posts',
				'cb' => 'tophive_blog_posts',
				'active_callback' => '',
				'desc' => '',
			)
		);
		$top_panel = 'blog_panel';
		$level_2_panel = 'panel_' . $args['id'];

		$config = array(
			array(
				'name' => $level_2_panel,
				'type' => 'panel',
				'panel' => $top_panel,
				'title' => $args['name'],
				'auto_expand_sole_section' => true,
				'description' => $args['desc'],
			),

			// Article Layout ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_layout',
				'type' => 'section',
				'panel' => $level_2_panel,
				'title' => __( 'Layout', 'tophive-pro' ),
				'active_callback' => $args['active_callback'],
			),

			array(
				'name' => $args['id'] . '_layout',
				'type'    => 'image_select',
				'section' => $level_2_panel . '_layout',
				'label'   => __( 'Layout', 'tophive-pro' ),
				'default' => 'blog_classic',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'choices' => array(
					'blog_classic' => array(
						'img' => OneCoreCustomizer()->get_url() . '/assets/images/blog_classic.svg',
					),
					'blog_column' => array(
						'img' => OneCoreCustomizer()->get_url() . '/assets/images/blog_column.svg',
					),
					'blog_masonry' => array(
						'img' => OneCoreCustomizer()->get_url() . '/assets/images/blog_masonry.svg',
					),
					'blog_lateral' => array(
						'img' => OneCoreCustomizer()->get_url() . '/assets/images/blog_lateral.svg',
					),
				),
				'reset_controls' => array(
					$args['id'] . '_media_ratio',
					$args['id'] . '_media_width',
				),
			),

			array(
				'name' => $args['id'] . '_columns',
				'type' => 'select',
				'section' => $level_2_panel . '_layout',
				'default' => 0,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'device_settings' => true,
				'label' => __( 'Layout Columns', 'tophive-pro' ),
				'required' => array(
					array( $args['id'] . '_layout', '!=', 'blog_timeline' ),
					array( $args['id'] . '_layout', '!=', 'blog_lateral' ),
				),
				'choices' => array(
					0 => __( 'Default', 'tophive-pro' ),
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				),
			),

			array(
				'name' => $level_2_panel . '_layout_h1',
				'type' => 'heading',
				'section' => $level_2_panel . '_layout',
				'title' => __( 'Article Styling', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_a_item',
				'type' => 'styling',
				'section' => $level_2_panel . '_layout',
				'selector'    => array(
					'normal' => "{$args['selector'] } .entry-inner",
					'hover' => "{$args['selector'] } .entry-inner:hover",
					'normal_margin' => "{$args['selector'] } .entry-inner",
				),
				'css_format'  => 'styling',
				'label' => __( 'Article Wrapper', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				// 'required' => array($args['id'].'_more_display', '==', '1')
			),

			array(
				'name' => $args['id'] . '_a_header',
				'type' => 'styling',
				'section' => $level_2_panel . '_layout',
				'selector'    => array(
					'normal' => "{$args['selector'] } .entry-article-header",
					'hover' => "{$args['selector'] } .entry-article-header",
					'normal_margin' => "{$args['selector'] } .entry-article-header",
				),
				'css_format'  => 'styling',
				'label' => __( 'Article Header', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				// 'required' => array($args['id'].'_more_display', '==', '1')
			),

			array(
				'name' => $args['id'] . '_a_body',
				'type' => 'styling',
				'section' => $level_2_panel . '_layout',
				'selector'    => array(
					'normal' => "{$args['selector'] } .entry-article-body",
					'hover' => "{$args['selector'] } .entry-article-body",
					'normal_margin' => "{$args['selector'] } .entry-article-body",
				),
				'css_format'  => 'styling',
				'label' => __( 'Article Body', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				// 'required' => array($args['id'].'_more_display', '==', '1')
			),

			array(
				'name' => $args['id'] . '_a_footer',
				'type' => 'styling',
				'section' => $level_2_panel . '_layout',
				'selector'    => array(
					'normal' => "{$args['selector'] } .entry-article-footer",
					'hover' => "{$args['selector'] } .entry-article-footer",
					'normal_margin' => "{$args['selector'] } .entry-article-footer",
				),
				'css_format'  => 'styling',
				'label' => __( 'Article Footer', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				// 'required' => array($args['id'].'_more_display', '==', '1')
			),

			array(
				'name' => $args['id'] . '_a_mgb',
				'type' => 'slider',
				'section' => $level_2_panel . '_layout',
				'selector'    => "{$args['selector'] } .entry-article-header .entry--item, {$args['selector'] } .entry-article-body .entry--item, {$args['selector'] } .entry-article-media .entry--item",
				'css_format'  => 'margin-bottom: {{value}};',
				'label' => __( 'Article Part Spacing', 'tophive-pro' ),
				'description' => __( 'Spacing between items (Title, Meta, Excerpt, Category) inside article parts: Media, Header, Body, Footer', 'tophive-pro' ),
				'max' => 100,
				// 'required' => array($args['id'].'_more_display', '==', '1')
			),

			// Article Display & Position ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_dnp',
				'type' => 'section',
				'active_callback' => $args['active_callback'],
				'panel' => $level_2_panel,
				'title' => __( 'Display & Positions', 'tophive-pro' ),
				'description' => __( 'Each entry post have 4 parts: Media, Header, Body, Footer. You can show/hide entry items in this parts by clicking to eye icon.', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_dnp_media',
				'section' => $level_2_panel . '_dnp',
				'type' => 'repeater',
				'title' => __( 'Media', 'tophive-pro' ),
				'description' => sprintf( __( 'Show/hide items in media area, <a href="#%1$s" class="focus-section">Custom Styling</a>', 'tophive-pro' ), $level_2_panel . '_media' ),
				'live_title_field' => 'title',
				'limit' => 4,
				'addable' => false,
				'title_only' => true,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => $this->get_available_items(),
				'fields' => $item_fields,
			),
			array(
				'name' => $args['id'] . '_dnp_header',
				'section' => $level_2_panel . '_dnp',
				'type' => 'repeater',
				'title' => __( 'Header', 'tophive-pro' ),
				'description' => sprintf( __( 'Show/hide items in header area, <a href="#%1$s" class="focus-control">Custom Styling</a>', 'tophive-pro' ), $args['id'] . '_a_header' ),
				'live_title_field' => 'title',
				'limit' => 4,
				'addable' => false,
				'title_only' => true,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => $this->get_available_items( array( 'title' ) ),
				'fields' => $item_fields,
			),
			array(
				'name' => $args['id'] . '_dnp_body',
				'section' => $level_2_panel . '_dnp',
				'type' => 'repeater',
				'title' => __( 'Body', 'tophive-pro' ),
				'description' => sprintf( __( 'Show/hide items in body area, <a href="#%1$s" class="focus-control">Custom Styling</a>', 'tophive-pro' ), $args['id'] . '_a_body' ),
				'live_title_field' => 'title',
				'limit' => 4,
				'addable' => false,
				'title_only' => true,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => $this->get_available_items( array( 'meta', 'excerpt' ) ),
				'fields' => $item_fields,
			),
			array(
				'name' => $args['id'] . '_dnp_footer',
				'section' => $level_2_panel . '_dnp',
				'type' => 'repeater',
				'title' => __( 'Footer', 'tophive-pro' ),
				'description' => sprintf( __( 'Show/hide items in footer area, <a href="#%1$s" class="focus-control">Custom Styling</a>', 'tophive-pro' ), $args['id'] . '_a_footer' ),
				'live_title_field' => 'title',
				'limit' => 4,
				'addable' => false,
				'title_only' => true,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => $this->get_available_items( array( 'readmore' ), array( 'excerpt', 'title', 'category' ) ),
				'fields' => $item_fields,
			),

			// Article Media ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_media',
				'type' => 'section',
				'panel' => $level_2_panel,
				'title' => __( 'Media', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_media_hide',
				'type' => 'checkbox',
				'section' => $level_2_panel . '_media',
				'checkbox_label' => __( 'Hide Media', 'tophive-pro' ),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name' => $args['id'] . '_media_ratio',
				'type' => 'slider',
				'section' => $level_2_panel . '_media',
				'label' => __( 'Media Ratio', 'tophive-pro' ),
				'selector' => "{$args['selector']} .posts-layout .entry .entry-media",
				'css_format' => 'padding-top: {{value_no_unit}}%;',
				'device_settings' => true,
				'max' => 200,
				'unit' => '%',
				'min' => 0,
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),
			array(
				'name' => $args['id'] . '_media_width',
				'type' => 'slider',
				'section' => $level_2_panel . '_media',
				'label' => __( 'Media Width', 'tophive-pro' ),
				'device_settings' => true,
				'devices'         => array( 'desktop', 'tablet' ),
				'max' => 100,
				'min' => 20,
				'unit' => '%',
				'selector' => "{$args['selector']} .posts-layout .entry-media, {$args['selector']} .posts-layout.layout--blog_classic .entry-media",
				'css_format' => 'flex-basis: {{value_no_unit}}%; width: {{value_no_unit}}%;',
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name' => $args['id'] . '_media_radius',
				'type' => 'slider',
				'section' => $level_2_panel . '_media',
				'label' => __( 'Media Radius', 'tophive-pro' ),
				'max' => 300,
				'min' => 0,
				'selector' => "{$args['selector']} .posts-layout .entry-media",
				'css_format' => 'border-radius: {{value}};',
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name' => $args['id'] . '_thumbnail_size',
				'type' => 'select',
				'section' => $level_2_panel . '_media',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => 'medium',
				'label' => __( 'Thumbnail Size', 'tophive-pro' ),
				'choices' => tophive_get_all_image_sizes(),
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),
			array(
				'name' => $args['id'] . '_hide_thumb_if_empty',
				'type' => 'checkbox',
				'section' => $level_2_panel . '_media',
				'default' => '1',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label' => __( 'Hide featured image if empty.', 'tophive-pro' ),
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name' => $level_2_panel . '_media_styling',
				'type' => 'modal',
				'section' => $level_2_panel . '_media',
				'default'    => 1,
				'title'      => __( 'Styling', 'tophive-pro' ),
				'selector'   => "{$args['selector']} .posts-layout .entry-media",
				'css_format' => 'styling',
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
							'selector'   => "{$args['selector']} .posts-layout .entry-media",
						),

						array(
							'name'       => 'bg_scale',
							'type'       => 'slider',
							'min'       => 0,
							'max'       => 3,
							'step'       => .1,
							'default'       => 1,
							'unit'       => '%',
							'label'      => __( 'Image Scale', 'tophive-pro' ),
							'css_format' => 'transform: scale({{value_no_unit}});',
							'selector'   => "{$args['selector']} .posts-layout .entry-thumbnail img",
						),

						array(
							'name'       => 'bg_color',
							'type'       => 'color',
							'label'      => __( 'Overlay Color', 'tophive-pro' ),
							'css_format' => 'background-color: {{value}};',
							'selector'   => "{$args['selector']} .posts-layout .entry-thumbnail::before",
						),

						array(
							'name'       => 'margin',
							'type'       => 'css_ruler',
							'label'      => __( 'Margin', 'tophive-pro' ),
							'device_settings' => true,
							'css_format' => array(
								'top' => 'margin-top: {{value}};',
								'right' => 'margin-right: {{value}};',
								'bottom' => 'margin-bottom: {{value}};',
								'left' => 'margin-left: {{value}};',
							),
							'selector'   => "{$args['selector']} .posts-layout .entry-media",
						),
					),

					'hover_fields' => array(
						array(
							'name'       => 'text_color',
							'type'       => 'color',
							'label'      => __( 'Color', 'tophive-pro' ),
							'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
							'selector'   => "{$args['selector']} .posts-layout .entry-media",
						),

						array(
							'name'       => 'bg_scale',
							'type'       => 'slider',
							'min'       => 0,
							'max'       => 3,
							'step'       => .1,
							'default'       => 1,
							'unit'       => '%',
							'label'      => __( 'Image Scale', 'tophive-pro' ),
							'css_format' => 'transform: scale({{value_no_unit}});',
							'selector'   => "{$args['selector']} .posts-layout .entry-media:hover .entry-thumbnail img",
						),

						array(
							'name'       => 'bg_color',
							'type'       => 'color',
							'label'      => __( 'Overlay Color', 'tophive-pro' ),
							'css_format' => 'background-color: {{value}};',
							'selector'   => "{$args['selector']} .posts-layout .entry-media:hover .entry-thumbnail::before",
						),

					),
				),
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name' => $level_2_panel . '_media_h1',
				'type' => 'heading',
				'section' => $level_2_panel . '_media',
				'title' => __( 'Media Content', 'tophive-pro' ),
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name' => $args['id'] . '_media_ca',
				'section' => $level_2_panel . '_media',
				'type' => 'radio_group',
				'default' => 'mc-bottom',
				'label' => __( 'Vertical Align', 'tophive-pro' ),
				'choices' => array(
					'mc-top' => __( 'Top', 'tophive-pro' ),
					'mc-center' => __( 'Center', 'tophive-pro' ),
					'mc-bottom' => __( 'Bottom', 'tophive-pro' ),
				),
				'selector' => "{$args['selector']} .entry",
				'css_format' => 'html_class',
				'required' => array( $args['id'] . '_media_hide', '!=', '1' ),
			   // 'render_callback' => $args['cb'],
			),

			// Article Title ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_title',
				'type' => 'section',
				'active_callback' => $args['active_callback'],
				'panel' => $level_2_panel,
				'title' => __( 'Title', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_title_tag',
				'section' => $level_2_panel . '_title',
				'type' => 'select',
				'default' => 'h2',
				'label' => __( 'HTML Element', 'tophive-pro' ),
				'choices' => array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
					'span' => 'span',
				),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name' => $args['id'] . '_title_link',
				'section' => $level_2_panel . '_title',
				'type' => 'checkbox',
				'default' => 1,
				'checkbox_label' => __( 'Link to post', 'tophive-pro' ),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name' => $args['id'] . '_title_h',
				'section' => $level_2_panel . '_title',
				'type' => 'slider',
				'default' => '',
				'max' => 200,
				'label' => __( 'Min Height', 'tophive-pro' ),
				'selector' => "{$args['selector']} .entry-title",
				'css_format'  => 'min-height: {{value}}',
				'device_settings'  => true,
			),

			array(
				'name' => $args['id'] . '_title_style',
				'type' => 'styling',
				'section' => $level_2_panel . '_title',
				'selector'    => array(
					'normal' => "{$args['selector']} .entry-title",
					'hover' => "{$args['selector']} .entry:hover .entry-title",
					'hover_text_color' => "{$args['selector']} .entry:hover .entry-title, {$args['selector']} .entry:hover .entry-title a",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name' => $args['id'] . '_title_typo',
				'type' => 'typography',
				'section' => $level_2_panel . '_title',
				'selector'    => "{$args['selector']} .entry-title",
				'css_format'  => 'typography',
				'label' => __( 'Typography', 'tophive-pro' ),
			),

			array(
				'name'            => $args['id'] . '_title_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_title',
				'device_settings' => true,
				'selector' => "{$args['selector']} .entry .entry-title",
				'css_format'      => 'text-align: {{value}};',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

			// Article Excerpt ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_excerpt',
				'type' => 'section',
				'panel' => $level_2_panel,
				'title' => __( 'Excerpt', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_excerpt_type',
				'type' => 'select',
				'section' => $level_2_panel . '_excerpt',
				'default' => 'custom',
				'choices' => array(
					'custom' => __( 'Custom', 'tophive-pro' ),
					'excerpt' => __( 'Use excerpt metabox', 'tophive-pro' ),
					'more_tag' => __( 'Strip excerpt by more tag', 'tophive-pro' ),
					'content' => __( 'Full content', 'tophive-pro' ),
				),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Excerpt Type', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_excerpt_length',
				'type' => 'number',
				'section' => $level_2_panel . '_excerpt',
				'default' => 25,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Excerpt Length', 'tophive-pro' ),
				'required' => array( $args['id'] . '_excerpt_type', '=', 'custom' ),
			),
			array(
				'name' => $args['id'] . '_excerpt_more',
				'type' => 'text',
				'section' => $level_2_panel . '_excerpt',
				'default' => '',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Excerpt More', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_excerpt_style',
				'type' => 'styling',
				'section' => $level_2_panel . '_excerpt',
				'selector'    => array(
					'normal' => "{$args['selector']} .entry-excerpt",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => false,
				),
			),

			array(
				'name' => $args['id'] . '_excerpt_typo',
				'type' => 'typography',
				'section' => $level_2_panel . '_excerpt',
				'selector'    => "{$args['selector']} .entry-excerpt",
				'css_format'  => 'typography',
				'label' => __( 'Typography', 'tophive-pro' ),
			),

			array(
				'name'            => $args['id'] . '_excerpt_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_excerpt',
				'device_settings' => true,
				'selector' => "{$args['selector']} .entry .entry-excerpt",
				'css_format'      => 'text-align: {{value}};',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

			// Article Category ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_taxonomy',
				'type' => 'section',
				'active_callback' => $args['active_callback'],
				'panel' => $level_2_panel,
				'title' => __( 'Category', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_taxonomy',
				'type' => 'select',
				'section' => $level_2_panel . '_taxonomy',
				'default' => 'category',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Taxonomy', 'tophive-pro' ),
				'choices' => $this->get_taxs(),
			),
			array(
				'name' => $args['id'] . '_term_count',
				'type' => 'number',
				'section' => $level_2_panel . '_taxonomy',
				'default' => 1,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Count', 'tophive-pro' ),
				'description' => __( 'How many terms to show (enter 0 or leave empty to show all terms)', 'tophive-pro' ),
			),
			array(
				'name' => $args['id'] . '_term_sep',
				'type' => 'number',
				'section' => $level_2_panel . '_taxonomy',
				'default' => ',',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Separator', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_cat_absolute',
				'type' => 'checkbox',
				'section' => $level_2_panel . '_taxonomy',
				'selector'    => "{$args['selector']} .entry-cat",
				'css_format'  => 'position: absolute;',
				'checkbox_label' => __( 'Display absolute position', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_cat_pos',
				'type' => 'css_ruler',
				'section' => $level_2_panel . '_taxonomy',
				'selector'    => "{$args['selector']} .entry-cat",
				'default' => array(
					'link' => 0,
				),
				'css_format'  => array(
					'top' => 'top: {{value}};',
					'right' => 'right: {{value}};',
					'bottom' => 'bottom: {{value}};',
					'left' => 'left: {{value}};',
				),
				'label' => __( 'Position', 'tophive-pro' ),
				'required' => array( $args['id'] . '_cat_absolute', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_tax_style',
				'type' => 'styling',
				'section' => $level_2_panel . '_taxonomy',
				'selector'    => array(
					'normal' => "{$args['selector']} .entry-cat",
					'hover' => "{$args['selector']} .entry-cat:hover",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(),
				),
			),

			array(
				'name' => $args['id'] . '_tax_typo',
				'type' => 'typography',
				'section' => $level_2_panel . '_taxonomy',
				'selector'    => "{$args['selector']} .entry-cat",
				'css_format'  => 'typography',
				'label' => __( 'Typography', 'tophive-pro' ),
			),

			array(
				'name'            => $args['id'] . '_tax_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_taxonomy',
				'device_settings' => true,
				'selector' => "{$args['selector']} .entry .entry-cat",
				'css_format'      => 'text-align: {{value}};',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

			// Article Meta ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_meta',
				'type' => 'section',
				'active_callback' => $args['active_callback'],
				'panel' => $level_2_panel,
				'title' => __( 'Metas', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_meta_sep',
				'section' => $level_2_panel . '_meta',
				'type' => 'text',
				'default' => '',
				'label' => __( 'Separator', 'tophive-pro' ),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name' => $args['id'] . '_meta_sep_width',
				'section' => $level_2_panel . '_meta',
				'type' => 'slider',
				'max' => 20,
				'label' => __( 'Separator Width', 'tophive-pro' ),
				'selector' => $args['selector'] . ' .entry-meta .sep',
				'css_format' => 'margin-left: calc( {{value}} / 2 ); margin-right: calc( {{value}} / 2 );',
			),

			array(
				'name' => $args['id'] . '_meta_config',
				'section' => $level_2_panel . '_meta',
				'type' => 'repeater',
				'label' => __( 'Meta Display', 'tophive-pro' ),
				'live_title_field' => 'title',
				'limit' => 4,
				'addable' => false,
				'title_only' => true,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => array(
					array(
						'_key' => 'author',
						'title' => __( 'Author', 'tophive-pro' ),
					),
					array(
						'_key' => 'date',
						'title' => __( 'Date', 'tophive-pro' ),
					),
					array(
						'_key' => 'categories',
						'title' => __( 'Categories', 'tophive-pro' ),
					),
					array(
						'_key' => 'comment',
						'title' => __( 'Comment', 'tophive-pro' ),
					),

				),
				'fields' => array(
					array(
						'name' => '_key',
						'type' => 'hidden',
					),
					array(
						'name' => 'title',
						'type' => 'hidden',
						'label' => __( 'Title', 'tophive-pro' ),
					),
				),
			),

			array(
				'name' => $args['id'] . '_author_avatar',
				'type' => 'checkbox',
				'section' => $level_2_panel . '_meta',
				'default' => 0,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label' => __( 'Show author avatar', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_avatar_size',
				'type' => 'slider',
				'section' => $level_2_panel . '_meta',
				'default' => 32,
				'max' => 150,
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Avatar Size', 'tophive-pro' ),
				'required' => array( $args['id'] . '_author_avatar', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_meta_style',
				'type' => 'styling',
				'section' => $level_2_panel . '_meta',
				'selector'    => array(
					'normal' => "{$args['selector']} .entry-meta",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'text_color' => false,
						'link_color' => false,
						'bg_color' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_heading' => false,
						'border_heading' => false,
						'border_style' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => false,
						'box_shadow' => false,
					),
					'hover_fields' => false,
				),
			),
			array(
				'name' => $args['id'] . '_meta_item_style',
				'type' => 'styling',
				'section' => $level_2_panel . '_meta',
				'selector'    => array(
					'normal' => "{$args['selector']} .entry-meta .meta-item, {$args['selector']} .entry-meta a",
					'hover' => "{$args['selector']} .entry-meta a:hover",
				),
				'css_format'  => 'styling',
				'label' => __( 'Meta Item Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						// 'link_color' => false, // disable for special field.
						'link_color' => false,
						'padding' => false,
						'bg_color' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_heading' => false,
						'border_heading' => false,
						'border_style' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => false,
						'box_shadow' => false,
					),
					'hover_fields' => array(
						'link_color' => false,
						'bg_color' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_heading' => false,
						'border_heading' => false,
						'border_style' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => false,
						'box_shadow' => false,
					),
				),
			),

			array(
				'name' => $args['id'] . '_meta_typo',
				'type' => 'typography',
				'section' => $level_2_panel . '_meta',
				'selector'    => "{$args['selector']} .entry-meta",
				'css_format'  => 'typography',
				'label' => __( 'Typography', 'tophive-pro' ),
			),

			array(
				'name'            => $args['id'] . '_meta_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_meta',
				'device_settings' => true,
				'selector' => "{$args['selector']} .entry .entry-meta",
				'css_format'      => 'text-align: {{value}};',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

			// Article Readmore ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_readmore',
				'type' => 'section',
				'panel' => $level_2_panel,
				'title' => __( 'Read More', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_more_display',
				'type' => 'checkbox',
				'default' => 1,
				'section' => $level_2_panel . '_readmore',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label' => __( 'Show Read More Button', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_more_text',
				'type' => 'text',
				'section' => $level_2_panel . '_readmore',
				'default' => ! is_rtl() ? _x( 'Read More &rarr;', 'readmore LTR', 'tophive-pro' ) : _x( 'Read More &larr;', 'readmore RTL', 'tophive-pro' ),
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'label' => __( 'Read More Text', 'tophive-pro' ),
				'required' => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_more_typography',
				'type' => 'typography',
				'css_format' => 'typography',
				'section' => $level_2_panel . '_readmore',
				'selector' => "{$args['selector'] } .entry-readmore a",
				'label' => __( 'Typography', 'tophive-pro' ),
				'required' => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_more_styling',
				'type' => 'styling',
				'section' => $level_2_panel . '_readmore',
				'selector'    => array(
					'normal' => "{$args['selector'] } .entry-readmore a",
					'hover' => "{$args['selector'] } .entry-readmore a:hover",
					'normal_margin' => "{$args['selector'] } .entry-readmore",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				'required' => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name'            => $args['id'] . '_readmore_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_readmore',
				'device_settings' => true,
				'selector' => "{$args['selector']} .entry-readmore",
				'css_format' => 'text-align: {{value}}',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

			// Article Paging ---------------------------------------------------------------------------------
			array(
				'name' => $level_2_panel . '_pagination',
				'type' => 'section',
				'panel' => $level_2_panel,
				'title' => __( 'Pagination', 'tophive-pro' ),
			),

			array(
				'name' => $args['id'] . '_pg_show_paging',
				'section' => $level_2_panel . '_pagination',
				'type' => 'checkbox',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'default' => 1,
				'checkbox_label' => __( 'Show Pagination', 'tophive-pro' ),
			),
			array(
				'name' => $args['id'] . '_pg_show_nav',
				'section' => $level_2_panel . '_pagination',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'type' => 'checkbox',
				'default' => 1,
				'checkbox_label' => __( 'Show Next, Previous Label', 'tophive-pro' ),
				'required' => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),
			array(
				'name' => $args['id'] . '_pg_prev_text',
				'section' => $level_2_panel . '_pagination',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'type' => 'text',
				'label' => __( 'Previous Label', 'tophive-pro' ),
				'required' => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),
			array(
				'name' => $args['id'] . '_pg_next_text',
				'section' => $level_2_panel . '_pagination',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'type' => 'text',
				'label' => __( 'Next Label', 'tophive-pro' ),
				'required' => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_pg_mid_size',
				'section' => $level_2_panel . '_pagination',
				'selector' => $args['selector'],
				'render_callback' => $args['cb'],
				'type' => 'text',
				'default' => 3,
				'label' => __( 'How many numbers to either side of the current pages', 'tophive-pro' ),
				'required' => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_pg_styling',
				'type' => 'styling',
				'section' => $level_2_panel . '_pagination',
				'selector'    => array(
					'normal' => "{$args['selector'] } .nav-links a",
					'hover' => "{$args['selector'] } .nav-links a:hover, {$args['selector'] } .nav-links span:hover, {$args['selector'] } .nav-links span.current ",
				),
				'css_format'  => 'styling',
				'label' => __( 'Styling', 'tophive-pro' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color' => false, // disable for special field.
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false, // disable for special field.
					),
				),
				'required' => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name' => $args['id'] . '_pg_typography',
				'type' => 'typography',
				'css_format' => 'typography',
				'section' => $level_2_panel . '_pagination',
				'selector' => "{$args['selector'] } .nav-links a, {$args['selector'] } .nav-links span",
				'label' => __( 'Typography', 'tophive-pro' ),
				'required' => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name'            => $args['id'] . '_pg_align',
				'type'            => 'text_align_no_justify',
				'section'         => $level_2_panel . '_pagination',
				'device_settings' => true,
				'selector' => "{$args['selector']} .pagination",
				'css_format'      => 'text-align: {{value}};',
				'title'           => __( 'Align', 'tophive-pro' ),
			),

		);

		return $config;
	}

	function blog_posts_config( $configs ) {
		$config = array(
			array(
				'name' => 'blog_panel',
				'type' => 'panel',
				'priority' => 20,
				'title' => __( 'Blog', 'tophive-pro' ),
			),
		);

		$blog_sections = array(
			array(
				'name' => __( 'Blog Posts', 'tophive-pro' ),
				'id' => 'blog_post',
				'selector' => '#blog-posts',
				'cb' => 'tophive_blog_posts',
			),
		);

		foreach ( $blog_sections as $c ) {
			$config = array_merge( $config, $this->blog_config( $c ) );
		}

		return array_merge( $configs, $config );
	}

	/**
	 * Display blog posts layout
	 *
	 * @param array $args
	 */
	function render( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'el_id'  => 'blog-posts',
				'prefix' => 'blog_post',
			)
		);

		echo '<div id="' . esc_attr( $args['el_id'] ) . '">';
		if ( have_posts() ) :
			$l = new OneCoreCustomizer_Blog_Posts_Layout();
			$l->render( $args );

		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		echo '</div>';
	}





}
