<?php

namespace ONECORE\widgets\elementor;

class OneElementorCoursesGrid extends \Elementor\Widget_Base {

    public function get_name(){
        return 'thcoursesgrid';
    }
    public function get_title(){
        return esc_html__( 'LP Course Grid', 'ONE_CORE_SLUG' );
    }
    public function get_icon(){
        return 'eicon-single-post';
    }
    public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
    protected function register_controls() {

    	/*
    	*
    	* ----------- Content Tab Starts ----------
    	*
		** Course Grid basic settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'content_section',
				[
					'label' => esc_html__( 'Course Grid', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'thumbnail_show_hide',
				[
					'label' => esc_html__( 'Show Image', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'use_advanced_filter',
				[
					'label' => esc_html__( 'Use As Advanced Filter Layout', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'No', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'posts_order',
				[
					'label' => esc_html__( 'Order by', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'ASC' 	=> esc_html__( 'Ascending', 'ONE_CORE_SLUG' ),
						'DESC' 	=> esc_html__( 'Descending', 'ONE_CORE_SLUG' ),
					],
					'default' => 'ASC',
				]
			);
			$this->add_control(
				'select_columns',
				[
					'label' => esc_html__( 'Select Columns', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'ec-col-md-12' 	=> esc_html__( '1 Column', 'ONE_CORE_SLUG' ),
						'ec-col-md-6' 	=> esc_html__( '2 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-lg-4 ec-col-md-6 ec-col-12'  	=> esc_html__( '3 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-lg-3 ec-col-md-6 ec-col-12' 	=> esc_html__( '4 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-lg-2 ec-col-md-6 ec-col-12' 	=> esc_html__( '5 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-lg-2 ec-col-md-6 ec-col-12' 	=> esc_html__( '6 Columns', 'ONE_CORE_SLUG' ),
					],
					'default' => 'ec-col-lg-4 ec-col-md-6 ec-col-12',
				]
			);
			$this->add_control(
				'courses_count',
				[
					'label' => esc_html__( 'Courses Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('-1 For showing all', 'ONE_CORE_SLUG'),
					'default' => 4,
				]
	        );
	        $this->add_control(
	        	'word_count',
	        	[
	        		'label' => esc_html__( 'Word Count for description', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::NUMBER,
	        		'min' => 2,
	        		'max' => 30,
	        		'step' => 1,
	        		'default' => 10,
	        	]
	        );
	        $this->add_control(
	        	'cat_display',
	        	[
	        		'label' => esc_html__('Show Category', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'show_desc',
	        	[
	        		'label' => esc_html__( 'Show Description', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'show_pricing',
	        	[
	        		'label' => esc_html__( 'Show Price', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'show_pricing_prev',
	        	[
	        		'label' => esc_html__( 'Show Previous Pricing', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'show_author',
	        	[
	        		'label' => esc_html__( 'Show Author', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'show_lessons',
	        	[
	        		'label' => esc_html__( 'Show Lessons', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'no',
	        	]
	        );
	        $this->add_control(
	        	'show_level',
	        	[
	        		'label' => esc_html__( 'Show Level', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'no',
	        	]
	        );
	        
       		$this->add_control(
	        	'show_rating',
	        	[
	        		'label' => esc_html__( 'Show Rating', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
		$this->end_controls_section();

		/*
		** Course Category Filter settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'category_filter_section',
				[
					'label' => esc_html__( 'Course Category Filter', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'show_category_filter',
				[
					'label' => esc_html__( 'Show Category Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_position',
				[
					'label' => esc_html__( 'Filter Position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'solid',
					'options' => [
						'top'  => esc_html__( 'Top', 'ONE_CORE_SLUG' ),
						'v-left'  => esc_html__( 'Left Side', 'ONE_CORE_SLUG' ),
						'v-right'  => esc_html__( 'Right Side', 'ONE_CORE_SLUG' ),
					],
					'condition' => ['show_category_filter' => 'yes']
				]
			);
			$this->add_control(
				'filter_nav_width',
				[
					'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 50,
							'max' => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .filter_sidebar_width' => 'width: {{SIZE}}{{UNIT}};',
					]
				]
			);
			$this->add_control(
				'select_categories',
				[
					'label' => esc_html__( 'Select Categories', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $this->parse_filter_categories(),
					'default' => [ '' ],
					'condition' => ['show_category_filter' => 'yes']
				]
			);
			$this->add_control(
				'filter_text_align',
				[
					'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'ec-text-left' => [
							'title' => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-left',
						],
						'ec-text-center' => [
							'title' => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-center',
						],
						'ec-text-right' => [
							'title' => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'ec-text-center',
					'toggle' => true,
					'condition' => ['show_category_filter' => 'yes']
				]
			);

			$this->start_controls_tabs(
				'filter_control_tabs'
			);

			$this->start_controls_tab(
						'filter_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'plugin-name' ),
						]
					);

					$this->add_control(
						'edd_asytcgasc',
						[
							'label' => esc_html__( 'Filter Border', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'filter_border',
							'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} ul.th-course-categories-filter li',
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'edd_kasjbcnkjasc',
						[
							'label' => esc_html__( 'Colors', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'filter_bg_color',
						[
							'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} ul.th-course-categories-filter' => 'background-color: {{VALUE}}',
							],
							'default' => 'transparent',
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'filter_text_color',
						[
							'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li' => 'color: {{VALUE}}',
							],
							'default' => '#777777',
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'filter_text_bg_color',
						[
							'label' => esc_html__( 'Item Background', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li' => 'background-color: {{VALUE}}',
							],
							'default' => 'transparent',
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'edd_jtyauisc',
						[
							'label' => esc_html__( 'Spacing', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'filter_box_margin',
						[
							'label' => esc_html__( 'Filter Box Margin', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'filter_items_padding',
						[
							'label' => esc_html__( 'Filter Items Padding', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'filter_gap_between',
						[
							'label' => esc_html__( 'Gap Between Items', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 50,
									'step' => 1,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li' => 'margin-right: {{SIZE}}{{UNIT}};',
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'filter_text_typo',
							'label' => esc_html__( 'Text Typography', 'ONE_CORE_SLUG' ),
							
							'selector' => '{{WRAPPER}} .th-course-categories-filter li',
							'condition' => ['show_category_filter' => 'yes']
						]
					);


					$this->add_control(
						'esecfsev_ksdvnksjdvkjsdvsdv',
						[
							'label' => esc_html__( 'Others', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'filter_border_rad',
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
								'{{WRAPPER}} .th-course-categories-filter li' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'filter_box_shadow',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-categories-filter li',
							'condition' => ['show_category_filter' => 'yes']
						]
					);

			$this->end_controls_tab();

			$this->start_controls_tab(
						'filter_hover_tab',
						[
							'label' => esc_html__( 'Hover/Active', 'plugin-name' ),
						]
					);

					$this->add_control(
						'filter_text_color_hover',
						[
							'label' => esc_html__( 'Hover Text Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li:hover, 
								{{WRAPPER}} .th-course-categories-filter li:focus, 
								{{WRAPPER}} .th-course-categories-filter li.active' => 'color: {{VALUE}}'
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_control(
						'filter_text_hover_bg',
						[
							'label' => esc_html__( 'Text Background Color on Hover', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-categories-filter li:hover, 
								{{WRAPPER}} .th-course-categories-filter li:focus, 
								{{WRAPPER}} .th-course-categories-filter li.active' => 'background-color: {{VALUE}}'
							],
							'condition' => ['show_category_filter' => 'yes']
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'filter_border_hover',
							'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} ul.th-course-categories-filter li:hover, {{WRAPPER}} ul.th-course-categories-filter li:focus, {{WRAPPER}} ul.th-course-categories-filter li.active',
							'condition' => ['show_category_filter' => 'yes']
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'filter_box_shadow_hover',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-categories-filter li:hover, {{WRAPPER}} .th-course-categories-filter li:focus, {{WRAPPER}} .th-course-categories-filter li.active',
							'condition' => ['show_category_filter' => 'yes']
						]
					);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
		
		/*
		** Course Hover Information settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'hover_info',
				[
					'label' => esc_html__( 'Hover Information', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'show_hover_info',
				[
					'label' => esc_html__( 'Show Hover Info', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'hover_info_width',
				[
					'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 290,
							'max' => 700,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .hover-section' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'hover_info_top',
				[
					'label' => esc_html__( 'Top', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 400,
							'step' => 1,
						],						
						'%' => [
							'min' => -100,
							'max' => 300,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .hover-section' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'hr_hi',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'hover_info_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-section' => 'background-color: {{VALUE}}',
					],
					'condition' => ['show_hover_info' => 'yes'],
					'default' => '#ffffff'
				]
			);
			$this->add_control(
				'hover_info_border_rad',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .hover-section' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'hover_info_padding',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .hover-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'hover_info_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .hover-section',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'hr_hi_1',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_title',
				[
					'label' => esc_html__( 'Show Title', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_level',
				[
					'label' => esc_html__( 'Show Level', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			// $this->add_control(
	        // 	'show_learning_points',
	        // 	[
	        // 		'label' => esc_html__( 'Show learning points', 'ONE_CORE_SLUG' ),
	        // 		'type' => \Elementor\Controls_Manager::SWITCHER,
	        // 		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        // 		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        // 		'return_value' => 'yes',
	        // 		'default' => 'yes',
	        // 	]
	        // );
			$this->add_control(
				'show_hi_lessons',
				[
					'label' => esc_html__( 'Show Number Of Chapters/lessons', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_course_duration',
				[
					'label' => esc_html__( 'Show Course Duration', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_course_details',
				[
					'label' => esc_html__( 'Show Details', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_add_to_cart',
				[
					'label' => esc_html__( 'Show Add To Cart', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'show_hi_wishlist',
				[
					'label' => esc_html__( 'Show Wishlist', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'hr_hi_2',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'condition' => ['show_hover_info' => 'yes']
				]
			);
			$this->add_control(
				'hi_title_opt',
				[
					'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_title_typography',
					'label' => esc_html__( 'Title Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-info-title',
					'condition' => ['show_hi_title' => 'yes']
				]
			);
			$this->add_control(
				'hi_title_color',
				[
					'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-info-title' => 'color: {{VALUE}}',
					],
					'condition' => ['show_hi_title' => 'yes']
				]
			);
			$this->add_control(
				'hr_hi_3',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'condition' => ['show_hi_course_details' => 'yes']
				]
			);
			$this->add_control(
				'hi_desc',
				[
					'label' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_desc_typo',
					'label' => esc_html__( 'Description Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-info-desc',
					'condition' => ['show_hi_course_details' => 'yes']
				]
			);
			
			$this->add_control(
				'hi_desc_excerpt',
				[
					'label' => esc_html__( 'Description Word Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 5,
					'max' => 30,
					'step' => 1,
					'default' => 10,
					'condition' => ['show_hi_course_details' => 'yes']
				]
			);
			$this->add_control(
				'hi_desc_padding',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .hover-info-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => ['show_hi_course_details' => 'yes']
				]
			);
			$this->add_control(
				'hr_hi_4',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'hi_learning_points',
				[
					'label' => esc_html__( 'Learning Points', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
					'condition' => ['show_learning_points' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_learning_points_typo',
					'label' => esc_html__( 'Learning points typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-section .learning-points',
					'condition' => ['show_learning_points' => 'yes']
				]
			);
			$this->add_control(
				'hi_learning_points_margin',
				[
					'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .hover-section .learning-points' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			/*--------------- Date ------------------*/

			$this->add_control(
				'hi_date',
				[
					'label' => esc_html__( 'Date', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
				]
			);
			$this->add_control(
				'hi_date_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-section .hover-info-date' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_date_typography',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-section .hover-info-date',
				]
			);
			/*--------------- Cart Button ------------------*/
			
			$this->add_control(
				'hi_cart_button',
				[
					'label' => esc_html__( 'Cart Button', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->start_controls_tabs('hover_info_cart_wl');
			$this->start_controls_tab('hover_info_cart', ['label' => esc_html__( 'Normal', 'tophive' )]);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_cart_button',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-info-add-cart',
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'hi_cart_btn_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'default' => '#666',
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart' => 'color: {{VALUE}}',
					],
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'hi_cart_btn_color_bg',
				[
					'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'default' => '#f1f1f1',
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart' => 'background-color: {{VALUE}}',
					],
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'hi_cart_btn_br',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'cart_buttonborder',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .hover-info-add-cart',
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'padding_hi',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab('hover_info_cart_hover', ['label' => esc_html__( 'Hover', 'tophive' )]);
		
			$this->add_control(
				'hi_cart_btn_color_hover',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'default' => '#888',
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart:hover' => 'color: {{VALUE}}',
					],
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_control(
				'hi_cart_btn_color_bg_hover',
				[
					'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'default' => '#666',
					'selectors' => [
						'{{WRAPPER}} .hover-info-add-cart:hover' => 'background-color: {{VALUE}}',
					],
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'cart_buttonborder_hover',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .hover-info-add-cart:hover',
					'condition' => ['show_hi_add_to_cart' => 'yes']
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			/*--------- Wishlist ----------*/
			
			$this->add_control(
				'wishl_header',
				[
					'label' => esc_html__( 'Wishlist', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'wishlist_icon',
				[
					'label' => esc_html__( 'Wishlist Icon', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::ICON,
					'default' => 'fa fa-heart-o',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'wishlist_icon_br',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'hi_wish_list_button',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .hover-info-wishlist a',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'hi_wish_list_btn_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a' => 'color: {{VALUE}}',
					],
					'default' => '#555',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'hi_wish_list_btn_color_bg',
				[
					'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a' => 'background-color: {{VALUE}}',
					],
					'default' => 'transparent',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'wishlist_buttonborder',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .hover-info-wishlist a',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'padding_hi_wl',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'hi_wish_list_hover',
				[
					'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'none',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'hi_wishlist_btn_color_hover',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on' => 'color: {{VALUE}}',
					],
					'default' => '#ffffff',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'hi_wishlist_color_bg_hover',
				[
					'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on' => 'background-color: {{VALUE}}',
					],
					'default' => '#d91e18',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'wishlist_border_hover',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
		$this->end_controls_section();
		

		/*
  		** Carousel Navigation section
		*/
	    $this->start_controls_section(
            'carousel_navigation',
	            [
	                'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
	            ]
	        );
		    $this->add_control(
		    	'thcoursegrid_select_nav_type',
		    	[
		    		'label' => esc_html__( 'Select Navigation Type', 'ONE_CORE_SLUG' ),
		    		'type' => \Elementor\Controls_Manager::SELECT,
		    		'default' => 'load_more',
		    		'options' => [
		    			''  => esc_html__( 'Hide Navigation', 'ONE_CORE_SLUG' ),
		    			'load_more'  => esc_html__( 'Load More', 'ONE_CORE_SLUG' ),
		    			'arrow'  => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
		    		],
		    	]
		    );
    		$this->add_control(
				'carousel_arrow_section',
				[
					'label' => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'condition' => ['thcoursegrid_select_nav_type' => 'arrow']
				]
			);
    		$this->add_control(
				'carousel_load_more_section',
				[
					'label' => esc_html__( 'Load More', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'condition' => ['thcoursegrid_select_nav_type' => 'load_more']
				]
			);
			$this->add_control(
				'load_more_text',
				[
					'label' => esc_html__( 'Load More Text', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Show More', 'ONE_CORE_SLUG' ),
					'placeholder' => esc_html__( 'Load More', 'ONE_CORE_SLUG' ),
					'condition' => ['thcoursegrid_select_nav_type' => 'load_more']
				]
			);
			$this->add_control(
				'Load_more_btn_position',
				[
					'label' => esc_html__( 'Load More Button position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 4,
					'options' => [
						'ec-text-center'  => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
						'ec-text-right'  => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
						'ec-text-left'  => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
					],
					'default' => 'ec-text-center',
					'condition' => ['thcoursegrid_select_nav_type' => 'load_more']
				]
			);
			$this->add_control(
				'arrow_position',
				[
					'label' => esc_html__( 'Select arrow position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 4,
					'options' => [
						''  => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
						'top-right'  => esc_html__( 'Top Right', 'ONE_CORE_SLUG' ),
						'top-left'  => esc_html__( 'Top Left', 'ONE_CORE_SLUG' ),
					],
					'default' => '',
					'condition' => ['thcoursegrid_select_nav_type' => 'arrow']
				]
			);
			$this->start_controls_tabs(
				'arrow_style_tabs'
			);

			$this->start_controls_tab(
				'arrow_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'more_btn_content_typography',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev',
				]
			);
			$this->add_control(
				'more_btn_background_color',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev' => 'background-color: {{VALUE}}',
					],
					'default' => '#ff5166'
				]
			);
			$this->add_control(
				'more_btn_color',
				[
					'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev' => 'color: {{VALUE}}',
					],
					'default' => '#fff'
				]
			);
			$this->add_control(
				'more_btn_padding',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'more_btn_margin',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'more_btn_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'more_btn_border',
					'label' => __( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev',
				]
			);
			
			$this->add_control(
				'more_btn_border_rad',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next, {{WRAPPER}} button.ec-switch-button-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
					]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'arrow_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
				]
			);

			$this->add_control(
				'more_btn_background_color_hover',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next:hover, {{WRAPPER}} button.ec-switch-button-prev:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#ff5166'
				]
			);
			$this->add_control(
				'more_btn_color_hover',
				[
					'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next:hover, {{WRAPPER}} button.ec-switch-button-prev:hover' => 'color: {{VALUE}}',
					],
					'default' => '#fff'
				]
			);
			
			$this->add_control(
				'more_btn_margin_hover',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next:hover, {{WRAPPER}} button.ec-switch-button-prev:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'more_btn_box_shadow_hover',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} button.ec-switch-button-next:hover, {{WRAPPER}} button.ec-switch-button-prev:hover',
				]
			);
			$this->add_control(
				'more_btn_border_rad_hover',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} button.ec-switch-button-next:hover, {{WRAPPER}} button.ec-switch-button-prev:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();
        /*
			*** --------------------- Content Tab ends ---------------------***
        */
        /*
    	*
    	* ----------- Style Tab Starts ----------
    	*
		** Course Grid Box Style settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
	    $this->start_controls_section(
            'box_style_section',
	            [
	                'label' => esc_html__( 'Box Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_group_control(
        		\Elementor\Group_Control_Border::get_type(),
        		[
        			'name' => 'border',
        			'label' => esc_html__( 'Box Border', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block',
        		]
        	);
        	$this->add_control(
        		'hr_box_border',
        		[
        			'type' => \Elementor\Controls_Manager::DIVIDER,
        		]
        	);
        	$this->add_control(
				'select_layout',
				[
					'label' => esc_html__( 'Select Layout', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => [
						'top'  		=> esc_html__( 'Image Top', 'ONE_CORE_SLUG' ),
						'thumb-left'  	=> esc_html__( 'Image Left', 'ONE_CORE_SLUG' ),
						'thumb-right'  	=> esc_html__( 'Image Right', 'ONE_CORE_SLUG' ),
					],
				]
			);
			$this->add_responsive_control(
				'thumb_width',
				[
					'label' => esc_html__( 'Thumbnail Width', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 400,
							'step' => 1,
						],
						'%' => [
							'min' => 20,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .th-course-thumb' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [ 'select_layout' => 
						array(
							'thumb-left', 
							'thumb-right'
						) ]
				]
			);
        	$this->add_responsive_control(
        		'thumb_height',
        		[
        			'label' => esc_html__( 'Thumbnail Height', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SLIDER,
        			'size_units' => [ 'px' ],
        			'range' => [
        				'px' => [
        					'min' => 0,
        					'max' => 700,
        					'step' => 1,
        				]
        			],
        			'default' => [
        				'unit' => 'px',
        				'size' => 130,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-thumb' => 'height: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'thumb_top_spacing',
        		[
        			'label' => esc_html__( 'Thumbnail Top Spacing', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SLIDER,
        			'size_units' => [ 'px' ],
        			'range' => [
        				'px' => [
        					'min' => 0,
        					'max' => 250,
        					'step' => 1,
        				]
        			],
        			'default' => [
        				'unit' => 'px',
        				'size' => 0,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-thumb' => 'margin-top: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	
        	$this->add_responsive_control(
        		'box_margin',
        		[
        			'label' => esc_html__( 'Box margin', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        			'default' => [
        				'top' => 0,
        				'right' => 0,
        				'bottom' => 20,
        				'left' => 0,
        				'unit' => 'px',
						'isLinked' => true,
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'box_padding',
        		[
        			'label' => esc_html__( 'Box Padding', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'content_padding',
        		[
        			'label' => esc_html__( 'Content Padding', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        			'default' => [
        				'top' => 30,
        				'right' => 30,
        				'bottom' => 30,
        				'left' => 30,
        				'unit' => 'px'
        			]
        		]
        	);
        	$this->add_responsive_control(
        		'image_border_radius',
        		[
        			'label' => esc_html__( 'Image Border Radius', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			
        			'selectors' => [
        				'{{WRAPPER}} .th-course-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_control(
        		'box_border_radius',
        		[
        			'label' => esc_html__( 'Box Border Radius', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SLIDER,
        			'size_units' => [ 'px', '%' ],
        			'range' => [
        				'px' => [
        					'min' => 0,
        					'max' => 50,
        					'step' => 1,
        				],
        				'%' => [
        					'min' => 0,
        					'max' => 100,
        				],
        			],
        			'default' => [
        				'unit' => 'px',
        				'size' => 0,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-block' => 'border-radius: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'course_box_shadow',
        			'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block',
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'course_box_shadow_hover',
        			'label' => esc_html__( 'Box Shadow on hover', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block:hover',
        		]
        	);
        	$this->add_control(
        		'course_block_bg',
        		[
        			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::COLOR,
        			
        			'selectors' => [
        				'{{WRAPPER}} .th-course-block' => 'background-color: {{VALUE}}',
        			],
        			'default' => '#2E2E2E08',
        		]
        	);
        $this->end_controls_section();
		/*
    	**
		** Course Grid Box Content Style settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
        $this->start_controls_section(
            'cat_style_section',
	            [
	                'label' => esc_html__( 'Content', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_control(
	        	'category_heading',
	        	[
	        		'label' => esc_html__('Catogory', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING
	        	]
	        );
	        $this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'category_typography',
					'selector' => '{{WRAPPER}} .course-category',
				]
	        );
	        $this->add_control(
	        	'show_cat_bg',
	        	[
	        		'label' => esc_html__( 'Show Category Background', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Yes', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'No', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_control(
	        	'cat_padding',
	        	[
	        		'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px', '%', 'em' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        		'default' => [
	        			'top' => 0,
	        			'right' => 13,
	        			'bottom' => 0,
	        			'left' => 16,
	        			'unit' => 'px'
	        		]
	        	]
	        );
	        $this->add_control(
	        	'cat_margin',
	        	[
	        		'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px', '%', 'em' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'cat_br',
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
	        			'{{WRAPPER}} .course-category' => 'border-radius: {{SIZE}}{{UNIT}};',
	        		],
	        		'default' => [
	        			'unit' => 'px',
	        			'size' => 22
	        		]
	        	]
	        );
	        $this->add_control(
	        	'hr_title',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'title_header',
	        	[
	        		'label' => esc_html__('Title', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'title_typo',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-block-title',
	        	]
	        );
	        $this->add_control(
	        	'title_color',
	        	[
	        		'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-block-title' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'title_hover_color',
	        	[
	        		'label' => esc_html__( 'Title Hover Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-block-title:hover' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'title_margin',
	        	[
	        		'label' => esc_html__( 'Title Margin', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-block-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        	]
	        );
	        
	        $this->add_control(
	        	'hr_tag',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'tag_header',
	        	[
	        		'label' => esc_html__('Course tag', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'tag_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		
	        		'selector' => '{{WRAPPER}} .course-tags',
	        	]
	        );
	        $this->add_responsive_control(
	        	'tags_vertical_position',
	        	[
	        		'label' => esc_html__( 'Vertical Position', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SLIDER,
	        		'size_units' => [ 'px', '%' ],
	        		'range' => [
	        			'px' => [
	        				'min' => -300,
	        				'max' => 200,
	        				'step' => 1,
	        			],
	        		],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-tags' => 'top: {{SIZE}}{{UNIT}};',
	        		],
	        		'default' => array(
	        			'unit' => 'px',
	        			'size' => 35
	        		)
	        	]
	        );
	        $this->add_responsive_control(
	        	'tags_horizontal_position',
	        	[
	        		'label' => esc_html__( 'Horizontal Position', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SLIDER,
	        		'size_units' => [ 'px', '%' ],
	        		'range' => [
	        			'px' => [
	        				'min' => -200,
	        				'max' => 200,
	        				'step' => 1,
	        			],
	        		],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-tags' => 'left: {{SIZE}}{{UNIT}};',
	        		],
	        		'default' => array(
	        			'unit' => '%',
	        			'size' => 70
	        		)
	        	]
	        );
	        $this->add_control(
	        	'show_tags',
	        	[
	        		'label' => esc_html__( 'Show tags', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
	        $this->add_responsive_control(
	        	'course_tag_padding',
	        	[
	        		'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px', '%', 'em' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-tags' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'hr_price',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'desc_header',
	        	[
	        		'label' => esc_html__('Description', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'desc_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-description',
	        	]
	        );
	        $this->add_control(
				'th_course_item_desc_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-description' => 'color: {{VALUE}}',
					],
					'default' => '#777'
				]
			);
	        $this->add_control(
	        	'desc_margin',
	        	[
	        		'label' => esc_html__( 'Description Margin', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px'],
	        		'selectors' => [
	        			'{{WRAPPER}} .th-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        	]
	        );
	        
	        $this->add_control(
	        	'hr_desc',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'pricing_header',
	        	[
	        		'label' => esc_html__('Pricing', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'pricing_typo',
	        		'label' => esc_html__( 'Pricing Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-sale-price',
	        	]
	        );
	        $this->add_control(
	        	'price_color',
	        	[
	        		'label' => esc_html__( 'Price Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'default' => '#ffffff',
	        		'selectors' => [
	        			'{{WRAPPER}} .th-sale-price' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'price_color_bg',
	        	[
	        		'label' => esc_html__( 'Price Color Background', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .price-section' => 'background-color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
				'price_border_rad',
				[
					'label' => esc_html__( 'Pricing Border Radius', 'ONE_CORE_SLUG' ),
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
						'{{WRAPPER}} .price-section' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'size' => 0,
						'unit' => 'px'
					]
				]
			);
			$this->add_control(
				'price_section_padding',
				[
					'label' => esc_html__( 'Price Section Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .price-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => 10,
						'right' => 20,
						'bottom' => 10,
						'left' => 20,
						'unit' => 'px'
					]
				]
			);
			$this->add_responsive_control(
				'price_pos_top',
				[
					'label' => esc_html__( 'Position Top', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => 1,
							'max' => 200,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .price-section' => 'top: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'unit' => 'px',
						'size' => -35
					]
				]
			);
			$this->add_responsive_control(
				'price_pos_rt',
				[
					'label' => esc_html__( 'Position Right', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => 1,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .price-section' => 'right: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'unit' => 'px',
						'size' => 281
					]
				]
			);
			$this->add_responsive_control(
				'price_section_width',
				[
					'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 200,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .price-section' => 'width: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'unit' => 'px',
						'size' => 70
					]
				]
			);
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'prev_pricing_typo',
	        		'label' => esc_html__( 'Previous Pricing Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-original-price',
	        	]
	        );
	        $this->add_control(
	        	'prev_price_color',
	        	[
	        		'label' => esc_html__( 'Original Pricing Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .th-original-price' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'hr_author',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
        $this->end_controls_section();
        $this->start_controls_section(
			'footer_section',
				[
					'label' => esc_html__( 'Footer', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
        	$this->add_control(
	        	'footer_header',
	        	[
	        		'label' => esc_html__('Footer', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'footer_border',
					'label' => esc_html__( 'Footer Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-course-footer'
				]
			);

			$this->add_control(
				'footer_padding',
				[
					'label' => esc_html__( 'Footer Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
        			'default' => [
        				'top' => 0,
        				'right' => 20,
        				'bottom' => 25,
        				'left' => 30,
        				'unit' => 'px'
        			]
				]
			);

	        $this->add_control(
	        	'author_header',
	        	[
	        		'label' => esc_html__('Author', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'author_typography',
	        		'label' => esc_html__( 'Author Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-author a',
	        	]
	        );
	        $this->add_control(
	        	'author_color',
	        	[
	        		'label' => esc_html__( 'Author Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-author a' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'hr_lessons',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'level_header',
	        	[
	        		'label' => esc_html__('Course Level', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'course_level_typography',
	        		'label' => esc_html__( 'Course Level Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-level',
	        	]
	        );
	        $this->add_control(
	        	'Course_Level_color',
	        	[
	        		'label' => esc_html__( 'Course Level Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-level' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'Course_Level_img_width',
	        	[
	        		'label' => esc_html__( 'Level Icon size', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SLIDER,
	        		'size_units' => [ 'px', '%' ],
	        		'range' => [
	        			'px' => [
	        				'min' => 10,
	        				'max' => 100,
	        				'step' => 1,
	        			],
	        		],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-level img' => 'width: {{SIZE}}{{UNIT}};',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'hr_lessons_2',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'lessons_header',
	        	[
	        		'label' => esc_html__('Lessons', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'lessons_typography',
	        		'label' => esc_html__( 'Lessons Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-lessons',
	        	]
	        );
	        $this->add_control(
	        	'lessons_color',
	        	[
	        		'label' => esc_html__( 'Lessons color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-lessons' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'hr_rating',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'rating_header',
	        	[
	        		'label' => esc_html__('Ratings', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_control(
	        	'rating_font_size',
	        	[
	        		'label' => esc_html__( 'Size', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SLIDER,
	        		'size_units' => [ 'px' ],
	        		'range' => [
	        			'px' => [
	        				'min' => 10,
	        				'max' => 40,
	        				'step' => 1,
	        			]
	        		],
	        		'default' => [
	        			'unit' => 'px',
	        			'size' => 14,
	        		],
	        		'selectors' => [
	        			'{{WRAPPER}} .review-count, 
	        			{{WRAPPER}} .review-stars-rated .review-stars.empty, {{WRAPPER}} .review-stars-rated .review-stars.filled' => 'font-size: {{SIZE}}{{UNIT}};',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'rating_position',
	        	[
	        		'label' => esc_html__( 'Vertical Position', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SLIDER,
	        		'size_units' => [ 'px' ],
	        		'range' => [
	        			'px' => [
	        				'min' => -20,
	        				'max' => 20,
	        				'step' => 1,
	        			]
	        		],
	        		'default' => [
	        			'unit' => 'px',
	        			'size' => 7,
	        		],
	        		'selectors' => [
	        			'{{WRAPPER}} .review-stars-rated' => 'margin-top: {{SIZE}}{{UNIT}};',
	        		],
	        	]
	        );
	        $this->add_control(
			'star_color',
				[
					'label' => esc_html__( 'Rating Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .review-stars-rated .review-stars.empty,{{WRAPPER}}  .review-stars-rated .review-stars.filled' => 'color: {{VALUE}}',
					],
					'default' => '#f4c150',
				]
			);
        $this->end_controls_section();
        /*
			*** --------------------- Content Tab ends ---------------------***
        */
	}
    protected function render() {

    	$uniqID = 'ec_mc_' . rand();

		$settings = $this->get_settings_for_display();

		$json_settings = array(
			'arrow_position' 			=> $settings['arrow_position'],
			'Load_more_btn_position' 	=> $settings['Load_more_btn_position'],
			'load_more_text' 			=> $settings['load_more_text'],
			'courses_count' 			=> $settings['courses_count'],
			'cat_display' 				=> $settings['cat_display'],
			'hi_desc_excerpt'			=> $settings['hi_desc_excerpt'],
			'select_columns' 			=> $settings['select_columns'],
			'select_layout' 			=> $settings['select_layout'],
			'show_author' 				=> $settings['show_author'],
			'show_tags' 				=> $settings['show_tags'],
			'show_lessons' 				=> $settings['show_lessons'],
			'show_level' 				=> $settings['show_level'],
			// 'lessons_align' 			=> $settings['lessons_align'],
			'show_cat_bg' 				=> $settings['show_cat_bg'],
			'show_desc' 				=> $settings['show_desc'],
			'show_hover_info'			=> $settings['show_hover_info'],
			'show_hi_title'				=> $settings['show_hi_title'],
			'show_hi_lessons'			=> $settings['show_hi_lessons'],
			'show_hi_level'				=> $settings['show_hi_level'],
			// 'show_learning_points'		=> $settings['show_learning_points'],
			'show_hi_course_duration'	=> $settings['show_hi_course_duration'],
			'show_hi_course_details'	=> $settings['show_hi_course_details'],
			'show_hi_add_to_cart'		=> $settings['show_hi_add_to_cart'],
			'show_hi_wishlist'			=> $settings['show_hi_wishlist'],
			'show_pricing' 				=> $settings['show_pricing'],
			'show_pricing_prev' 		=> $settings['show_pricing_prev'],
			'show_rating' 				=> $settings['show_rating'],
			'word_count' 				=> $settings['word_count'],
			'thumbnail_show_hide' 		=> $settings['thumbnail_show_hide'],
			'wishlist_icon'				=> $settings['wishlist_icon'],
			'nav_type'					=> $settings['thcoursegrid_select_nav_type']
		);
		$args = array(
			'post_type' => 'lp_course',
			'post_status' => 'publish',
			'posts_per_page' => $settings['courses_count'],
		);

		if( !empty($settings['select_categories']) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'slug',
		            'terms'    => $settings['select_categories'],
				)
			);
		}
		if( !empty($settings['posts_order']) ){
			$args['order'] = $settings['posts_order'];
		}

		$advanced_filter = 'yes' == $settings['use_advanced_filter'] ? ' tophive-advanced-filter-wrapper' : '';
		
		$html = '';
		if( $settings['filter_position'] === 'top' ){
			$html .= '<div>';
			if(!empty($settings['select_categories']) && (count($settings['select_categories']) > 1) ){
					$html .= '<ul data-settings="'. htmlspecialchars(json_encode($json_settings)) .'" class="ec-row th-course-categories-filter ' . $settings['filter_text_align'] . '">';
						$html .= $this->parse_filter_selected_categories( $settings['select_categories'], $uniqID );
					$html .= '</ul>';
				}
			$html .= '</div>';
		}
		$html .= '<div class="ec-mc-falexiblewidth ec-d-lg-flex ec-flex-row">';
			if( $settings['filter_position'] === 'v-left' ){
				$html .= '<div class="filter_sidebar_width">';
					if(!empty($settings['select_categories']) && (count($settings['select_categories']) > 1) ){
						$html .= '<ul data-settings="'. htmlspecialchars(json_encode($json_settings)) .'" class="filter-vertical ec-row th-course-categories-filter ' . $settings['filter_text_align'] . '">';
							$html .= $this->parse_filter_selected_categories( $settings['select_categories'], $uniqID );
						$html .= '</ul>';
					}
				$html .= '</div>';
			}
			
			$html .= '<div class="ec-mc-main-content">';
				$html .= '<div id="'. $uniqID .'" class="ec-row ajax-replace ec-position-relative'. $advanced_filter .'" data-settings="'. htmlspecialchars(json_encode($json_settings)) .'" data-grid="two">';
					$html .= OneElementorBase::prepareCourses($args, $json_settings);
				$html .= '</div>';
				$html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="137px" height="137px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
					<path d="M35 50A15 15 0 0 0 65 50A15 16.3 0 0 1 35 50" fill="#292664" stroke="none" transform="rotate(177.696 50 50.65)">
					  <animateTransform attributeName="transform" type="rotate" dur="0.5025125628140703s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50.65;360 50 50.65"></animateTransform>
					</path></svg>';
			$html .= '</div>';
			if( $settings['filter_position'] === 'v-right' ){
				$html .= '<div class="filter_sidebar_width">';
					if(!empty($settings['select_categories']) && (count($settings['select_categories']) > 1) ){
						$html .= '<ul data-settings="'. htmlspecialchars(json_encode($json_settings)) .'" class="filter-vertical ec-row th-course-categories-filter ' . $settings['filter_text_align'] . '">';
							$html .= $this->parse_filter_selected_categories( $settings['select_categories'], $uniqID );
						$html .= '</ul>';
					}
				$html .= '</div>';
			}
		$html .= '</div>';
		echo $html;		
    }
    public function ihover_position( $cols, $k ){
    	$var = '';
    	switch ($cols) {
    		case 'ec-col-md-12':
    			$var = ($k%1 == 0) ? 'right ' : '';
    			break;
    		
    		case 'ec-col-md-6':
    			$var = ($k%2 == 0) ? 'right ' : '';
    			break;

    		case 'ec-col-md-4':
    			$var = ($k%3 == 0) ? 'right ' : '';
    			break;

    		case 'ec-col-md-3':
    			$var = ($k%4 == 0) ? 'right ' : '';
    			break;

    		case 'ec-col-md-2':
    			$var = ($k%6 == 0) ? 'right ' : '';
    			break;
    		
    		default:
    			$var = '';
    			break;
    	}
    	return $var;
    }
    public function parse_filter_categories(){
    	$allcoursecategories =  get_categories('taxonomy=course_category&type=lp_course');
		$catarray = array();
    	foreach ($allcoursecategories as $category) {
			$catarray[$category->slug] = $category->name;
    	}
    	return $catarray;
    }
    public function parse_filter_selected_categories( $categories, $id = '' ){
    	$categories_count = count($categories);
    	$html = '';
    	if( $categories_count > 1 ){
	    	$html .= '<li data-id="'. $id .'" data-cat="all">'. esc_html__('All', 'ONE_CORE_SLUG') .'</li>';
	    	foreach ($categories as $key => $value) {
	    		$value = urldecode($value);
	    		$html .= '<li data-id="'. $id .'" data-cat="'. $value .'">'. str_replace('-', ' ', $value) .'</li>';
	    	}
    	}else{
	    	$html = '<div></div>';
    	}
    	return $html;
    }
    
}
