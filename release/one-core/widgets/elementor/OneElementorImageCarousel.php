<?php

namespace ONECORE\widgets\elementor;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OneElementorImageCarousel extends \Elementor\Widget_Base {
	private $slide_prints_count = 0;


  	public function get_script_depends() {
     	return [ 'th-fe-script-handle' ];
  	}
	public function get_name() {
		return 'th-image-carousel';
	}

	public function get_title() {
		return esc_html__( 'Image Carousel', 'ONE_CORE_SLUG' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}
	public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
	public function get_keywords() {
		return [ 'picture', 'carousel', 'image' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'th_image_carousel_section_slides',
			[
				'label' => esc_html__( 'Slides', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$this->add_repeater_controls( $repeater );

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slides', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $this->get_repeater_defaults(),
				'separator' => 'after',
			]
		);

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides Per View', 'ONE_CORE_SLUG' ),
				'options' => [ '' => esc_html__( 'Default', 'ONE_CORE_SLUG' ) ] + $slides_per_view,
				'condition' => [
					'effect' => 'slide',
				],
				'default' => 3,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides to Scroll', 'ONE_CORE_SLUG' ),
				'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'ONE_CORE_SLUG' ),
				'options' => [ '' => esc_html__( 'Default', 'ONE_CORE_SLUG' ) ] + $slides_per_view,
				'condition' => [
					'effect' => 'slide',
				],
				'default' => 3,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'ONE_CORE_SLUG' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140,
					],
					'%' => [
						'min' => 50,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper' => 'width: calc({{SIZE}}{{UNIT}} + 30px)',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'ONE_CORE_SLUG' ),
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Arrows', 'ONE_CORE_SLUG' ),
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
				'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
				'prefix_class' => 'tophive-arrows-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'arrows_position',
			[
				'label' => esc_html__( 'Arrow Position', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside'  => esc_html__( 'Inside', 'ONE_CORE_SLUG' ),
					'outside'  => esc_html__( 'Outside', 'ONE_CORE_SLUG' ),
				],
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bullets',
				'options' => [
					'' => esc_html__( 'None', 'ONE_CORE_SLUG' ),
					'bullets' => esc_html__( 'Dots', 'ONE_CORE_SLUG' ),
					'fraction' => esc_html__( 'Fraction', 'ONE_CORE_SLUG' ),
					'progressbar' => esc_html__( 'Progress', 'ONE_CORE_SLUG' ),
				],
				'prefix_class' => 'tophive-pagination-type-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Transition Duration', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 500,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinite Loop', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => esc_html__( 'Pause on Interaction', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_style',
			[
				'label' => esc_html__( 'Slides', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between items', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px'
				]
			]
		);

		$this->add_control(
			'slide_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper .swiper-slide' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'testimonial_border',
				'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-main-swiper .swiper-slide',
			]
		);

		$this->add_control(
			'slide_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper .swiper-slide' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'slide_padding',
			[
				'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'th_tstml_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-main-swiper .swiper-slide',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label' => esc_html__( 'Arrows', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => esc_html__( 'Size', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tophive-swiper-button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'arrow_background',
				'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
				'types' => [ 'classic'],
				'selector' => '{{WRAPPER}} .tophive-swiper-button',
			]
		);
		$this->add_control(
			'arrow_width',
			[
				'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
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
					'{{WRAPPER}} .tophive-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrow_height',
			[
				'label' => esc_html__( 'Height', 'ONE_CORE_SLUG' ),
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
					'{{WRAPPER}} .tophive-swiper-button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrow_border_radius',
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
					'{{WRAPPER}} .tophive-swiper-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_arrows',
				'label' => __( 'Border', 'ONE_CORE_SLUG' ),
				'selector' => '{{WRAPPER}} .tophive-swiper-button',
			]
		);

		$this->add_control(
			'heading_pagination',
			[
				'label' => esc_html__( 'Pagination', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_position',
			[
				'label' => esc_html__( 'Position', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'outside' => esc_html__( 'Outside', 'ONE_CORE_SLUG' ),
					'inside' => esc_html__( 'Inside', 'ONE_CORE_SLUG' ),
				],
				'prefix_class' => 'tophive-pagination-position-',
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_size',
			[
				'label' => esc_html__( 'Size', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active, {{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_top_margin',
			[
				'label' => esc_html__( 'Pagination Margin Top', 'ONE_CORE_SLUG' ),
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
					'{{WRAPPER}} .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_injection( [
			'of' => 'slides',
		] );

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Skin', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'ONE_CORE_SLUG' ),
					'bubble' => esc_html__( 'Bubble', 'ONE_CORE_SLUG' ),
				],
				'prefix_class' => 'tophive-testimonial--skin-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'image_inline',
				'options' => [
					'image_inline' => esc_html__( 'Image Inline', 'ONE_CORE_SLUG' ),
					'image_stacked' => esc_html__( 'Image Stacked', 'ONE_CORE_SLUG' ),
					'image_above' => esc_html__( 'Image Above', 'ONE_CORE_SLUG' ),
					'image_left' => esc_html__( 'Image Left', 'ONE_CORE_SLUG' ),
					'image_right' => esc_html__( 'Image Right', 'ONE_CORE_SLUG' ),
				],
				'prefix_class' => 'tophive-testimonial--layout-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
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
				],
				'prefix_class' => 'tophive-testimonial--align-',
			]
		);

		$this->end_injection();

		$this->start_controls_section(
			'section_skin_style',
			[
				'label' => esc_html__( 'Bubble', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin' => 'bubble',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content, {{WRAPPER}} .tophive-testimonial__content:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'bottom' => '20',
					'left' => '20',
					'right' => '20',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_left .tophive-testimonial__footer,
					{{WRAPPER}}.tophive-testimonial--layout-image_right .tophive-testimonial__footer' => 'padding-top: {{TOP}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_above .tophive-testimonial__footer,
					{{WRAPPER}}.tophive-testimonial--layout-image_inline .tophive-testimonial__footer,
					{{WRAPPER}}.tophive-testimonial--layout-image_stacked .tophive-testimonial__footer' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border',
			[
				'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content, {{WRAPPER}} .tophive-testimonial__content:after' => 'border-style: solid',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .tophive-testimonial__content:after' => 'border-color: transparent {{VALUE}} {{VALUE}} transparent',
				],
				'condition' => [
					'border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__content, {{WRAPPER}} .tophive-testimonial__content:after' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_stacked .tophive-testimonial__content:after,
					{{WRAPPER}}.tophive-testimonial--layout-image_inline .tophive-testimonial__content:after' => 'margin-top: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_above .tophive-testimonial__content:after' => 'margin-bottom: -{{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'border' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_injection( [
			'at' => 'before',
			'of' => 'section_navigation',
		] );

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_gap',
			[
				'label' => esc_html__( 'Gap', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.tophive-testimonial--layout-image_inline .tophive-testimonial__footer,
					{{WRAPPER}}.tophive-testimonial--layout-image_stacked .tophive-testimonial__footer' => 'margin-top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_above .tophive-testimonial__footer' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_left .tophive-testimonial__footer' => 'padding-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_right .tophive-testimonial__footer' => 'padding-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__text' => 'color: {{VALUE}}',
				],
				
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .tophive-testimonial__text',
				
			]
		);

		$this->add_control(
			'name_title_style',
			[
				'label' => esc_html__( 'Name', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__name' => 'color: {{VALUE}}',
				],
				
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .tophive-testimonial__name',
				
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__title' => 'color: {{VALUE}}',
				],
				
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tophive-testimonial__title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'ONE_CORE_SLUG' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.tophive-testimonial--layout-image_left .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_right .tophive-testimonial__content:after' => 'top: calc( {{text_padding.TOP}}{{text_padding.UNIT}} + ({{SIZE}}{{UNIT}} / 2) - 8px );',

					'body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_stacked:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-right) .tophive-testimonial__content:after,
					 body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_inline:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-right) .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_stacked.tophive-testimonial--align-left .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_inline.tophive-testimonial--align-left .tophive-testimonial__content:after' => 'left: calc( {{text_padding.LEFT}}{{text_padding.UNIT}} + ({{SIZE}}{{UNIT}} / 2) - 8px ); right:auto;',

					'body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_stacked:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-left) .tophive-testimonial__content:after,
					 body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_inline:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-left) .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_stacked.tophive-testimonial--align-right .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_inline.tophive-testimonial--align-right .tophive-testimonial__content:after' => 'right: calc( {{text_padding.RIGHT}}{{text_padding.UNIT}} + ({{SIZE}}{{UNIT}} / 2) - 8px ); left:auto;',

					'body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_above:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-right) .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_above.tophive-testimonial--align-left .tophive-testimonial__content:after' => 'left: calc( {{text_padding.LEFT}}{{text_padding.UNIT}} + ({{SIZE}}{{UNIT}} / 2) - 8px ); right:auto;',

					'body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_above:not(.tophive-testimonial--align-center):not(.tophive-testimonial--align-left) .tophive-testimonial__content:after,
					 {{WRAPPER}}.tophive-testimonial--layout-image_above.tophive-testimonial--align-right .tophive-testimonial__content:after' => 'right: calc( {{text_padding.RIGHT}}{{text_padding.UNIT}} + ({{SIZE}}{{UNIT}} / 2) - 8px ); left:auto;',
				],
			]
		);

		$this->add_responsive_control(
			'image_gap',
			[
				'label' => esc_html__( 'Gap', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_inline.tophive-testimonial--align-left .tophive-testimonial__image + cite, 
					 body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_above.tophive-testimonial--align-left .tophive-testimonial__image + cite,
					 body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_inline .tophive-testimonial__image + cite, 
					 body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_above .tophive-testimonial__image + cite' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',

					'body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_inline.tophive-testimonial--align-right .tophive-testimonial__image + cite, 
					 body:not(.rtl) {{WRAPPER}}.tophive-testimonial--layout-image_above.tophive-testimonial--align-right .tophive-testimonial__image + cite,
					 body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_inline .tophive-testimonial__image + cite,
					 body.rtl {{WRAPPER}}.tophive-testimonial--layout-image_above .tophive-testimonial__image + cite' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left:0;',

					'{{WRAPPER}}.tophive-testimonial--layout-image_stacked .tophive-testimonial__image + cite, 
					 {{WRAPPER}}.tophive-testimonial--layout-image_left .tophive-testimonial__image + cite,
					 {{WRAPPER}}.tophive-testimonial--layout-image_right .tophive-testimonial__image + cite' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'image_border',
			[
				'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__image img' => 'border-style: solid',
				],
			]
		);

		$this->add_control(
			'image_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__image img' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'image_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__image img' => 'border-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'image_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tophive-testimonial__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->end_injection();

		$this->update_responsive_control(
			'width',
			[
				'selectors' => [
					'{{WRAPPER}} .tophive-main-swiper' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->update_responsive_control(
			'slides_per_view',
			[
				'condition' => null,
			]
		);

		$this->update_control(
			'slides_to_scroll',
			[
				'condition' => null,
			]
		);

		$this->remove_control( 'effect' );
		$this->remove_responsive_control( 'height' );
		$this->remove_control( 'pagination_position' );
	}

	protected function add_repeater_controls( $repeater ) {

		$repeater->add_control(
			'th_image_carousel_image',
			[
				'label' => esc_html__( 'Image', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'th_image_carousel_caption',
			[
				'label' => esc_html__( 'Caption', 'ONE_CORE_SLUG' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'ONE_CORE_SLUG' ),
			]
		);
	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = \Elementor\Utils::get_placeholder_image_src();

		return [
			[
				'th_image_carousel_caption' => esc_html__( 'I am image caption. Click edit button to change this text.', 'ONE_CORE_SLUG' ),
				'th_image_carousel_image' => [
					'url' => $placeholder_image_src,
				],
			],
			[
				'th_image_carousel_caption' => esc_html__( 'I am image caption. Click edit button to change this text.', 'ONE_CORE_SLUG' ),
				'th_image_carousel_image' => [
					'url' => $placeholder_image_src,
				],
			]
		];
	}

	protected function print_slider( ?array $settings = null ) {
		if ( null === $settings ) {
			$settings = $this->get_active_settings();
		}

		$default_settings = [
			'container_class' => 'tophive-image-carousel-main-swiper',
			'video_play_icon' => true,
		];

		$settings = array_merge( $default_settings, $settings );

		$slides_count = count( $settings['slides'] );

		$html = '<div class="tophive-swiper">';
			$html .= '<div class="'. $settings['container_class'] .' swiper-container">';
				$html .= '<div class="swiper-wrapper">';

					foreach ( $settings['slides'] as $index => $slide ){
						$this->slide_prints_count++;
						
						$html .= '<div class="swiper-slide" data-swiper-autoplay=" ' . $settings['autoplay_speed'] . '">';
							$html .= '<img src=" '. $slide['th_image_carousel_image']['url'] .'">';
						$html .= '</div>';
					}
				$html .= '</div>';
				if( 1 < $slides_count ){
					if( $settings['pagination'] ){
						$html .= '<div class="swiper-pagination"></div>';
					}
					if ( $settings['show_arrows'] ){
						$html .= '<div class="tophive-swiper-button tophive-swiper-button-prev ' . $settings['arrows_position'] . '">';
							$html .= '<i class="eicon-chevron-left" aria-hidden="true"></i>';
						$html .= '</div>';
						$html .= '<div class="tophive-swiper-button tophive-swiper-button-next ' . $settings['arrows_position'] .'">';
							$html .= '<i class="eicon-chevron-right" aria-hidden="true"></i>';
						$html .= '</div>';
					}
				}
			$html .= '</div>';
		$html .= '</div>';
		echo $html;

		?>
		<script>
			jQuery(document).ready(function(){
				var swiperslide = new Swiper ('.tophive-image-carousel-main-swiper', {
				    // Optional parameters
				    slidesPerView: <?php echo $settings['slides_per_view']; ?>,
				    slidesPerGroup: <?php echo $settings['slides_to_scroll']; ?>,
				    spaceBetween: <?php echo $settings['space_between']['size']; ?>,
				    loop: true,
				    loopFillGroupWithBlank: true,
				    autoplay:{
				    	delay: 2000
				    },

				    // If we need pagination
				    pagination: {
				      el: '.swiper-pagination',
				    },

				    // Navigation arrows
				    navigation: {
				      nextEl: '.tophive-swiper-button-next',
				      prevEl: '.tophive-swiper-button-prev',
				    },

				    // And if we need scrollbar
				    scrollbar: {
				      el: '.tophive-swiper-scrollbar',
				    },
			  	});
			})
		</script>
		<?php
	}

	protected function get_slide_image_url( $slide, array $settings ) {
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}

		return $image_url;
	}

	protected function render() {
		$this->print_slider();
	}
}
