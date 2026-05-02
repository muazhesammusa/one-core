<?php
namespace ONECORE\widgets\elementor;

class OneElementorAdvanceSearch extends \Elementor\Widget_Base {


	public function get_name() {
		return 'advenced_search';
	}

	public function get_title() {
		return esc_html__( 'Advanced Course Search', 'ONE_CORE_SLUG' );
	}

	public function get_icon() {
		return 'eicon-site-search';
	}

	public function get_categories() {
		return [ 'ONE_CORE_SLUG' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'advanced_search_fields',
			[
				'label' => esc_html__( 'Fields', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'advanced_search_fields_text',
			[
				'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'advanced_search_fields_desc',
			[
				'label' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => esc_html__( 'Search Description', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_responsive_control(
			'advanced_search_fields_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'ec-text-left'    => [
						'title' => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-left',
					],
					'ec-text-center' => [
						'title' => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-center',
					],
					'ec-text-right' => [
						'title' => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-right',
					],
					'ec-text-justify' => [
						'title' => esc_html__( 'Justified', 'ONE_CORE_SLUG' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_search_fields_container_styling',
			[
				'label' => esc_html__( 'Container', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'advanced_search_fields_br',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'advanced_search_fields_container_padding',
			[
				'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'advanced_search_fields_container_margin',
			[
				'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'advanced_search_fields_container_bg',
			[
				'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields' => 'background-color: {{VALUE}}',
				],
				'default' => 'transparent'
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'advanced_search_fields_container_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_search_fields_title_styling',
			[
				'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'advanced_search_fields_title_typography',
				
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-title',
			]
		);
		$this->add_control(
			'advanced_search_fields_title_color',
			[
				'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-title' => 'color: {{VALUE}}',
				],
			]
		);	
		$this->add_control(
			'advanced_search_fields_title_padding',
			[
				'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_search_fields_desc_styling',
			[
				'label' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'advanced_search_fields_desc_typography',
				
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-desc',
			]
		);
		$this->add_control(
			'advanced_search_fields_desc_color',
			[
				'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-desc' => 'color: {{VALUE}}',
				],
				'default' => '#666'
			]
		);	
		$this->add_control(
			'advanced_search_fields_desc_padding',
			[
				'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_search_fields_input_styling',
			[
				'label' => esc_html__( 'Input', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'advanced_search_fields_input_placeholder',
			[
				'label' => esc_html__( 'Placeholder', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Search any course...', 'ONE_CORE_SLUG' ),
				'placeholder' => esc_html__( 'Search a course...', 'ONE_CORE_SLUG' ),
			]
		);
		$this->add_control(
			'advanced_search_fields_input_color',
			[
				'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-input' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'advanced_search_fields_input_content_typography',
				'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
				
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-input',
			]
		);
		$this->add_control(
			'advanced_search_fields_input_padding',
			[
				'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'advanced_search_fields_input_margin',
			[
				'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'advanced_search_fields_input_height',
			[
				'label' => esc_html__( 'Height', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'advanced_search_fields_input_background',
				'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
				'types' => [ 'classic'],
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-input',
			]
		);
		$this->add_control(
			'advanced_search_fields_input_br',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-input' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'advanced_search_fields_input_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-input',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'advanced_search_fields_input_border',
				'label' => __( 'Border', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-input',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'advanced_search_fields_icon_styling',
			[
				'label' => esc_html__( 'Search Icon', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'advanced_search_fields_icon_color',
			[
				'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-submit' => 'color: {{VALUE}}',
				],
				'default' => '#666'
			]
		);
		$this->add_control(
			'advanced_search_fields_icon_color_bg',
			[
				'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-submit' => 'background-color: {{VALUE}}',
				],
				'default' => '#666'
			]
		);	
		$this->add_control(
			'advanced_search_fields_icon_padding',
			[
				'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'advanced_search_fields_icon_border',
				'label' => __( 'Border', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-advanced-search-fields .search-submit',
			]
		);
		$this->add_control(
			'advanced_search_fields_icon_br',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-advanced-search-fields .search-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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

		?>
			<div class="tophive-advanced-search-fields <?php echo $settings['advanced_search_fields_alignment'] ?>">
				<?php if( !empty($settings['advanced_search_fields_text']) ): ?>
					<h3 class="search-title"><?php echo $settings['advanced_search_fields_text']; ?></h3>
				<?php endif;  ?>
				<?php if( !empty($settings['advanced_search_fields_desc']) ): ?>
					<p class="search-desc"><?php echo $settings['advanced_search_fields_desc']; ?></p>
				<?php endif;  ?>
				<form class="tophive-advanced-search-form">
					<input type="search" class="search-input" placeholder="<?php echo $settings['advanced_search_fields_input_placeholder']; ?>" />
					<a href="" class="search-submit" target="_blank">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
						  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
						</svg>
					</a>
					<div class="search-result-wrapper">
						<span class="ec-pl-3 ec-py-3 ec-d-inline-block">Searching :</span><span class="search-text"></span>
					</div>
				</form>
			</div>
		<?php
	}

}
