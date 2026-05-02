<?php
namespace ONECORE\widgets\elementor;

class OneElementorInstructorFormPopup extends \Elementor\Widget_Base {


	public function get_name() {
		return 'instructor_button';
	}

	public function get_title() {
		return esc_html__( 'Instructor Form Popup', 'ONE_CORE_SLUG' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'ONE_CORE_SLUG' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => esc_html__( 'Extra Small', 'ONE_CORE_SLUG' ),
			'sm' => esc_html__( 'Small', 'ONE_CORE_SLUG' ),
			'md' => esc_html__( 'Medium', 'ONE_CORE_SLUG' ),
			'lg' => esc_html__( 'Large', 'ONE_CORE_SLUG' ),
			'xl' => esc_html__( 'Extra Large', 'ONE_CORE_SLUG' ),
		];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'instructor_btn_section_button',
			[
				'label' => esc_html__( 'Button', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'instructor_btn_button_type',
			[
				'label' => esc_html__( 'Type', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'Default', 'ONE_CORE_SLUG' ),
					'info' => esc_html__( 'Info', 'ONE_CORE_SLUG' ),
					'success' => esc_html__( 'Success', 'ONE_CORE_SLUG' ),
					'warning' => esc_html__( 'Warning', 'ONE_CORE_SLUG' ),
					'danger' => esc_html__( 'Danger', 'ONE_CORE_SLUG' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'instructor_btn_text',
			[
				'label' => esc_html__( 'Text', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Click here', 'ONE_CORE_SLUG' ),
				'placeholder' => esc_html__( 'Click here', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'instructor_btn_link',
			[
				'label' => esc_html__( 'Link', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ONE_CORE_SLUG' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'instructor_btn_align',
			[
				'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'instructor_btn_size',
			[
				'label' => esc_html__( 'Size', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'instructor_btn_selected_icon',
			[
				'label' => esc_html__( 'Icon', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'instructor_btn_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'ONE_CORE_SLUG' ),
					'right' => esc_html__( 'After', 'ONE_CORE_SLUG' ),
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'instructor_btn_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'instructor_btn_view',
			[
				'label' => esc_html__( 'View', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'instructor_btn_button_css_id',
			[
				'label' => esc_html__( 'Button ID', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'ONE_CORE_SLUG' ),
				'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'ONE_CORE_SLUG' ),
				'separator' => 'before',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'instructor_btn_section_style',
			[
				'label' => esc_html__( 'Button', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'instructor_btn_typography',
				
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'instructor_btn_text_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'instructor_btn_tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'instructor_btn_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'instructor_btn_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'instructor_btn_tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'instructor_btn_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'instructor_btn_button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'instructor_btn_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'instructor_btn_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'instructor_btn_border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'instructor_btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'instructor_btn_button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'instructor_btn_text_padding',
			[
				'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['instructor_btn_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['instructor_btn_link'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['instructor_btn_button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['instructor_btn_button_css_id'] );
		}

		if ( ! empty( $settings['instructor_btn_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['instructor_btn_size'] );
		}

		if ( $settings['instructor_btn_hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['instructor_btn_hover_animation'] );
		}
		$this->add_render_attribute( 'button', 'class', 'tophive-popup-window-button' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<div class="tophive-popup-modal tophive-instructor-request-form-popup">
			<div class="learn-press-become-teacher-form become-teacher-form learn-press-form tophive-popup-content-wrapper">
			<span class="ec-float-right tophive-popup-modal-close"><a href="">
				<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
				  <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
				</svg>
			</a></span>
				
				<?php echo do_shortcode( '[learn_press_become_teacher_form]' ); ?>

			</div>
		</div>
		<?php
	}

	/**
	 * Render button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
		view.addInlineEditingAttributes( 'text', 'none' );
		var iconHTML = elementor.helpers.renderIcon( view, settings.instructor_btn_selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
			migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );
		#>
		<div class="elementor-button-wrapper">
			<a id="{{ settings.instructor_btn_button_css_id }}" class="elementor-button elementor-size-{{ settings.instructor_btn_size }} elementor-animation-{{ settings.instructor_btn_hover_animation }}" href="{{ settings.instructor_btn_link.url }}" role="button">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.instructor_btn_icon || settings.instructor_btn_selected_icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.instructor_btn_icon_align }}">
						<# if ( ( migrated || ! settings.instructor_btn_icon ) && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# } else { #>
							<i class="{{ settings.instructor_btn_icon }}" aria-hidden="true"></i>
						<# } #>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.instructor_btn_text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$migrated = isset( $settings['__fa4_migrated']['instructor_btn_selected_icon'] );
		$is_new = empty( $settings['instructor_btn_icon'] ) && \Elementor\Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['instructor_btn_icon_align'] ) ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			//old default
			$settings['instructor_btn_icon_align'] = $this->get_settings( 'icon_align' );
		}

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['instructor_btn_icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['instructor_btn_icon'] ) || ! empty( $settings['instructor_btn_selected_icon']['value'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php if ( $is_new || $migrated ) :
					\Elementor\Icons_Manager::render_icon( $settings['instructor_btn_selected_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['instructor_btn_icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['instructor_btn_text']; ?></span>
		</span>
		<?php
	}

	public function on_import( $element ) {
		return \Elementor\Icons_Manager::on_import_migration( $element, 'icon', 'instructor_btn_selected_icon' );
	}
}
