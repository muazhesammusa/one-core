<?php

/**
 * Wishlit header builder item
 *
 * Class One_Builder_Item_WC_Wishlist
 */
class One_Builder_Item_WC_Wishlist {

	public $id = 'wc_wishlist'; // Required
	public $section = 'wc_wishlist'; // Optional
	public $name = 'wc_wishlist'; // Optional
	public $label = ''; // Optional
	public $priority = 200;
	public $panel = 'header_settings';

	/**
	 * Optional construct
	 *
	 * One_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = __( 'Wishlist', 'tophive-pro' );
	}

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => $this->label,
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn = array( $this, 'render' );
		$config = array(
			array(
				'name'     => $this->section,
				'type'     => 'section',
				'panel'    => $this->panel,
				'priority' => $this->priority,
				'title'    => $this->label,
			),

			array(
				'name'            => "{$this->name}_text",
				'type'            => 'text',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'title'           => __( 'Label', 'tophive-pro' ),
				'default'         => __( 'Wishlist', 'tophive-pro' ),
			),

			array(
				'name'            => "{$this->name}_icon",
				'type'            => 'icon',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => array(
					'icon' => 'fa fa-heart-o',
					'type' => 'font-awesome',
				),
				'title'           => __( 'Icon', 'tophive-pro' ),
			),

			array(
				'name'            => "{$this->name}_icon_position",
				'type'            => 'select',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => 'after',
				'choices'         => array(
					'before' => __( 'Before', 'tophive-pro' ),
					'after'  => __( 'After', 'tophive-pro' ),
				),
				'title'           => __( 'Icon Position', 'tophive-pro' ),
			),

			array(
				'name'            => "{$this->name}_show_label",
				'type'            => 'checkbox',
				'default'         => array(
					'desktop' => 1,
					'tablet' => 1,
					'mobile' => 0,
				),
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'label'  => __( 'Show Label', 'tophive-pro' ),
				'checkbox_label'  => __( 'Show Label', 'tophive-pro' ),
				'device_settings' => true,
			),

			array(
				'name'            => "{$this->name}_show_qty",
				'type'            => 'checkbox',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'  => 1,
				'label'  => __( 'Counter', 'tophive-pro' ),
				'checkbox_label'  => __( 'Show counter', 'tophive-pro' ),
			),

			array(
				'name'        => "{$this->name}_label_styling",
				'type'        => 'styling',
				'section'     => $this->section,
				'title'       => __( 'Styling', 'tophive-pro' ),
				'selector'    => array(
					'normal' => '.builder-header-' . $this->id . '-item .wishlist_products_counter',
					'hover'  => '.builder-header-' . $this->id . '-item:hover .wishlist_products_counter',
				),
				'css_format'  => 'styling',
				'default'     => array(),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'margin'        => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name'       => "{$this->name}_typography",
				'type'       => 'typography',
				'section'    => $this->section,
				'title'      => __( 'Typography', 'tophive-pro' ),
				'selector'   => '.builder-header-' . $this->id . '-item',
				'css_format' => 'typography',
				'default'    => array(),
			),

			array(
				'name'    => "{$this->name}_icon_h",
				'type'    => 'heading',
				'section' => $this->section,
				'title'   => __( 'Icon Settings', 'tophive-pro' ),
			),

			array(
				'name'            => "{$this->name}_icon_size",
				'type'            => 'slider',
				'section'         => $this->section,
				'device_settings' => true,
				'max'             => 150,
				'title'           => __( 'Icon Size', 'tophive-pro' ),
				'selector'        => '.builder-header-' . $this->id . '-item .wishlist-icon i:before',
				'css_format'      => 'font-size: {{value}};',
				'default'         => array(),
			),

			array(
				'name'        => "{$this->name}_icon_styling",
				'type'        => 'styling',
				'section'     => $this->section,
				'title'       => __( 'Styling', 'tophive-pro' ),
				'description' => __( 'Advanced styling for wishlist icon', 'tophive-pro' ),
				'selector'    => array(
					'normal' => '.builder-header-' . $this->id . '-item .wishlist_products_counter .wishlist-icon i',
					'hover'  => '.builder-header-' . $this->id . '-item:hover .wishlist_products_counter .wishlist-icon i',
				),
				'css_format'  => 'styling',
				'default'     => array(),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						// 'margin' => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name'        => "{$this->name}_qty_styling",
				'type'        => 'styling',
				'section'     => $this->section,
				'title'       => __( 'Counter', 'tophive-pro' ),
				'description' => __( 'Advanced styling for counter bubble', 'tophive-pro' ),
				'selector'    => array(
					'normal' => '.builder-header-' . $this->id . '-item  .wishlist-icon .wishlist_products_counter_number',
					'hover'  => '.builder-header-' . $this->id . '-item:hover .wishlist-icon .wishlist_products_counter_number',
				),
				'css_format'  => 'styling',
				'default'     => array(),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						// 'margin' => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

		);

		// Item Layout
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}

	function array_to_class( $array, $prefix ) {
		if ( ! is_array( $array ) ) {
			return $prefix . '-' . $array;
		}
		$classes = array();
		$array = array_reverse( $array );
		foreach ( $array as $k => $v ) {
			if ( $v == 1 ) {
				$v = 'show';
			} elseif ( $v == 0 ) {
				$v = 'hide';
			}
			$classes[] = "{$prefix}-{$k}-{$v}";
		}

		return join( ' ', $classes );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		if ( ! class_exists( 'TInvWL_Public_WishlistCounter' ) ) {
			return;
		}

		$icon = tophive_one()->get_setting( "{$this->name}_icon" );
		$icon_position = tophive_one()->get_setting( "{$this->name}_icon_position" );
		$text = tophive_one()->get_setting( "{$this->name}_text" );

		$show_label = tophive_one()->get_setting( "{$this->name}_show_label", 'all' );
		$show_qty = tophive_one()->get_setting( "{$this->name}_show_qty" );

		$classes = array();

		$align = tophive_one()->get_setting( "{$this->name}_d_align" );
		if ( ! $align ) {
			$align = 'right';
		}
		$classes[] = $this->array_to_class( $align, 'd-align' );

		$label_classes = $this->array_to_class( $show_label, 'wc_wishlist' );

		$icon = wp_parse_args(
			$icon,
			array(
				'type' => '',
				'icon' => '',
			)
		);

		$icon_html = '';
		if ( $icon['icon'] ) {
			$icon_html = '<i class="' . esc_attr( $icon['icon'] ) . '"></i> ';
		}
		// $classes[] = 'is-icon-' . $icon_position;
		if ( $text ) {
			$text = '<span class="wishlit-text wishlit-label ' . esc_attr( $label_classes ) . '">' . sanitize_text_field( $text ) . '</span>';
		}

		$number = TInvWL_Public_WishlistCounter::counter();
		$html = $text;

		if ( $number <= 0 ) {
			$classes[] = ' qty-0';
		}

		if ( $icon_html ) {
			$icon_html = '<span class="wishlist-icon">' . $icon_html;
			if ( $show_qty ) {
				$icon_html .= '<span class="wishlist_products_counter_number">' . $number . '</span>';
			}
			$icon_html .= '</span>';
		}

		if ( $icon_position == 'before' ) {
			$html = $icon_html . $html;
		} else {
			$html = $html . $icon_html;
		}

		$classes[] = 'builder-header-' . $this->id . '-item';
		$classes[] = 'item--' . $this->id;
		if ( $show_qty ) {
			$classes[] = 'show-counter';
		} else {
			$classes[] = 'hide-counter';
		}

		wp_enqueue_script( 'tinvwl' );

		echo '<div class="' . esc_attr( join( ' ', $classes ) ) . '">';

		$number = TInvWL_Public_WishlistCounter::counter();

		?>
		<a href="<?php echo esc_url( tinv_url_wishlist_default() ); ?>" title="<?php esc_attr_e( 'View your wishlist', 'tophive-pro' ); ?>" rel="nofollow" class="wishlist_products_counter text-small link-meta <?php echo ( 0 < $number ? ' wishlist-counter-with-products' : '' ); // WPCS: xss ok. ?>">
			<?php echo $html; ?>
		</a>
		<?php
		echo '</div>';
	}
}

One_Customize_Layout_Builder()->register_item( 'header', new One_Builder_Item_WC_Wishlist() );
