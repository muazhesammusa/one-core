<?php

namespace ONECORE\widgets\elementor;

class OneElementorCoursesCarousel extends \Elementor\Widget_Base {
    public function get_name(){
        return 'thcoursescarousel';
    }
    public function get_title(){
        return esc_html__( 'LP Course Carousel', 'ONE_CORE_SLUG' );
    }
    public function get_icon(){
        return 'eicon-single-post';
    }
    public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
    public function get_script_depends() {
		return [ 'jquery-slick' ];
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
			'thcoursescarousel_content_section',
				[
					'label' => esc_html__( 'Course Carousel', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'thcoursescarousel_thumbnail_show_hide',
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
				'thcoursescarousel_posts_order',
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
				'thcoursescarousel_posts_layout',
				[
					'label' => esc_html__( 'Layout', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'' 	=> esc_html__( 'Full Width', 'ONE_CORE_SLUG' ),
						' ec-overflow-hidden' 	=> esc_html__( 'Fixed Width', 'ONE_CORE_SLUG' ),
					],
					'default' => '',
				]
			);
			$this->add_control(
				'thcoursescarousel_select_columns',
				[
					'label' => esc_html__( 'Select Columns', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'1' 	=> esc_html__( '1 Column', 'ONE_CORE_SLUG' ),
						'2' 	=> esc_html__( '2 Columns', 'ONE_CORE_SLUG' ),
						'3'  	=> esc_html__( '3 Columns', 'ONE_CORE_SLUG' ),
						'4' 	=> esc_html__( '4 Columns', 'ONE_CORE_SLUG' ),
						'5' 	=> esc_html__( '5 Columns', 'ONE_CORE_SLUG' ),
						'6' 	=> esc_html__( '6 Columns', 'ONE_CORE_SLUG' ),
						'7' 	=> esc_html__( '7 Columns', 'ONE_CORE_SLUG' ),
						'8' 	=> esc_html__( '8 Columns', 'ONE_CORE_SLUG' ),
					],
					'default' => '4',
				]
			);
			$this->add_control(
				'thcoursescarousel_courses_count',
				[
					'label' => esc_html__( 'Courses Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('-1 For showing all', 'ONE_CORE_SLUG'),
					'default' => 4,
				]
	        );
	        $this->add_control(
	        	'thcoursescarousel_word_count',
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
	        	'thcoursescarousel_cat_display',
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
	        	'thcoursescarousel_show_tags',
	        	[
	        		'label' => esc_html__( 'Show tags', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'no',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_show_desc',
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
	        	'thcoursescarousel_show_pricing',
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
	        	'thcoursescarousel_show_pricing_prev',
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
	        	'thcoursescarousel_show_author',
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
	        	'thcoursescarousel_show_lessons',
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
	        	'thcoursescarousel_show_level',
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
	        	'thcoursescarousel_show_rating',
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
		$this->start_controls_section(
			'thcoursescarousel_carousel_options',
				[
					'label' => esc_html__( 'Carousel Options', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'thcoursescarousel_autoplay',
				[
					'label' => esc_html__( 'Autoplay', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'No', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'thcoursescarousel_autoplay_delay',
				[
					'label' => esc_html__( 'Autoplay Delay', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 1000,
					'options' => [
						300  => esc_html__( '300ms', 'ONE_CORE_SLUG'),
						400  => esc_html__( '400ms', 'ONE_CORE_SLUG'),
						500  => esc_html__( '500ms', 'ONE_CORE_SLUG'),
						600  => esc_html__( '600ms', 'ONE_CORE_SLUG'),
						700  => esc_html__( '700ms', 'ONE_CORE_SLUG'),
						800  => esc_html__( '800ms', 'ONE_CORE_SLUG'),
						900  => esc_html__( '900ms', 'ONE_CORE_SLUG'),
						1000  => esc_html__( '1s', 'ONE_CORE_SLUG'),
						1500  => esc_html__( '1.5s', 'ONE_CORE_SLUG'),
						2000  => esc_html__( '2s', 'ONE_CORE_SLUG'),
						2500  => esc_html__( '2.5s', 'ONE_CORE_SLUG'),
						3000  => esc_html__( '3s', 'ONE_CORE_SLUG'),
					],
					'condition' => ['thcoursescarousel_autoplay' => 'yes']
				]
			);
			$this->add_control(
				'thcoursescarousel_play_speed',
				[
					'label' => esc_html__( 'Play Speed', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 500,
					'options' => [
						100  => esc_html__( '100ms', 'ONE_CORE_SLUG'),
						200  => esc_html__( '200ms', 'ONE_CORE_SLUG'),
						300  => esc_html__( '300ms', 'ONE_CORE_SLUG'),
						400  => esc_html__( '400ms', 'ONE_CORE_SLUG'),
						500  => esc_html__( '500ms', 'ONE_CORE_SLUG'),
						600  => esc_html__( '600ms', 'ONE_CORE_SLUG'),
						700  => esc_html__( '700ms', 'ONE_CORE_SLUG'),
						800  => esc_html__( '800ms', 'ONE_CORE_SLUG'),
						900  => esc_html__( '900ms', 'ONE_CORE_SLUG'),
						1000  => esc_html__( '1s', 'ONE_CORE_SLUG'),
						1500  => esc_html__( '1.5s', 'ONE_CORE_SLUG'),
						2000  => esc_html__( '2s', 'ONE_CORE_SLUG'),
						2500  => esc_html__( '2.5s', 'ONE_CORE_SLUG'),
						3000  => esc_html__( '3s', 'ONE_CORE_SLUG'),
					],
				]
			);
			$this->add_control(
				'thcoursescarousel_per_slide',
				[
					'label' => esc_html__( 'Course Per Slide', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 2,
					'options' => [
						1  => esc_html__( '1', 'ONE_CORE_SLUG'),
						2  => esc_html__( '2', 'ONE_CORE_SLUG'),
						3  => esc_html__( '3', 'ONE_CORE_SLUG'),
						4  => esc_html__( '4', 'ONE_CORE_SLUG'),
						5  => esc_html__( '5', 'ONE_CORE_SLUG'),
						6  => esc_html__( '6', 'ONE_CORE_SLUG'),
						7  => esc_html__( '7', 'ONE_CORE_SLUG'),
						8  => esc_html__( '8', 'ONE_CORE_SLUG'),
						9  => esc_html__( '9', 'ONE_CORE_SLUG'),
						10  => esc_html__( '10', 'ONE_CORE_SLUG'),
					],
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
			'thcoursescarousel_category_filter_section',
				[
					'label' => esc_html__( 'Course Category', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			// $this->add_control(
			// 	'thcoursescarousel_show_category_filter',
			// 	[
			// 		'label' => esc_html__( 'Show Category Filter', 'ONE_CORE_SLUG' ),
			// 		'type' => \Elementor\Controls_Manager::SWITCHER,
			// 		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
			// 		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
			// 		'return_value' => 'yes',
			// 		'default' => 'no',
			// 	]
			// );
			// $this->add_control(
			// 	'thcoursescarousel_filter_position',
			// 	[
			// 		'label' => esc_html__( 'Filter Position', 'ONE_CORE_SLUG' ),
			// 		'type' => \Elementor\Controls_Manager::SELECT,
			// 		'default' => 'solid',
			// 		'options' => [
			// 			'top'  => esc_html__( 'Top', 'ONE_CORE_SLUG' ),
			// 			'v-left'  => esc_html__( 'Left Side', 'ONE_CORE_SLUG' ),
			// 			'v-right'  => esc_html__( 'Right Side', 'ONE_CORE_SLUG' ),
			// 		],
			// 	]
			// );
			// $this->add_control(
			// 	'thcoursescarousel_filter_nav_width',
			// 	[
			// 		'label' => esc_html__( 'Width', 'ONE_CORE_SLUG' ),
			// 		'type' => \Elementor\Controls_Manager::SLIDER,
			// 		'size_units' => [ 'px', '%' ],
			// 		'range' => [
			// 			'px' => [
			// 				'min' => 50,
			// 				'max' => 400,
			// 				'step' => 1,
			// 			],
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .filter_sidebar_width' => 'width: {{SIZE}}{{UNIT}};',
			// 		]
			// 	]
			// );
			$this->add_control(
				'thcoursescarousel_select_categories',
				[
					'label' => esc_html__( 'Select Categories', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $this->parse_filter_categories(),
					'default' => [ '' ],
				]
			);
			// $this->add_control(
			// 	'thcoursescarousel_filter_text_align',
			// 	[
			// 		'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
			// 		'type' => \Elementor\Controls_Manager::CHOOSE,
			// 		'options' => [
			// 			'ec-text-left' => [
			// 				'title' => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
			// 				'icon' => 'fa fa-align-left',
			// 			],
			// 			'ec-text-center' => [
			// 				'title' => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
			// 				'icon' => 'fa fa-align-center',
			// 			],
			// 			'ec-text-right' => [
			// 				'title' => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
			// 				'icon' => 'fa fa-align-right',
			// 			],
			// 		],
			// 		'default' => 'ec-text-center',
			// 		'toggle' => true,
			// 	]
			// );

			// $this->start_controls_tabs(
			// 	'thcoursescarousel_filter_control_tabs'
			// );

			// $this->start_controls_tab(
			// 			'thcoursescarousel_filter_normal_tab',
			// 			[
			// 				'label' => esc_html__( 'Normal', 'plugin-name' ),
			// 			]
			// 		);

			// 		$this->add_control(
			// 			'thcoursescarousel_filter_border_section',
			// 			[
			// 				'label' => esc_html__( 'Filter Border', 'plugin-name' ),
			// 				'type' => \Elementor\Controls_Manager::HEADING,
			// 			]
			// 		);
			// 		$this->add_group_control(
			// 			\Elementor\Group_Control_Border::get_type(),
			// 			[
			// 				'name' => 'thcoursescarousel_filter_border',
			// 				'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
			// 				'selector' => '{{WRAPPER}} ul.th-course-categories-filter li',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_color_heading',
			// 			[
			// 				'label' => esc_html__( 'Colors', 'plugin-name' ),
			// 				'type' => \Elementor\Controls_Manager::HEADING,
			// 				'separator' => 'before',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_bg_color',
			// 			[
			// 				'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::COLOR,
			// 				
			// 				'selectors' => [
			// 					'{{WRAPPER}} ul.th-course-categories-filter' => 'background-color: {{VALUE}}',
			// 				],
			// 				'default' => 'transparent',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_text_color',
			// 			[
			// 				'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::COLOR,
			// 				
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li' => 'color: {{VALUE}}',
			// 				],
			// 				'default' => '#777777',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_text_bg_color',
			// 			[
			// 				'label' => esc_html__( 'Item Background', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::COLOR,
			// 				
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li' => 'background-color: {{VALUE}}',
			// 				],
			// 				'default' => 'transparent',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_category_filter_spacing_heading',
			// 			[
			// 				'label' => esc_html__( 'Spacing', 'plugin-name' ),
			// 				'type' => \Elementor\Controls_Manager::HEADING,
			// 				'separator' => 'before',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_box_margin',
			// 			[
			// 				'label' => esc_html__( 'Filter Box Margin', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::DIMENSIONS,
			// 				'size_units' => [ 'px', '%', 'em' ],
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			// 				],
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_items_padding',
			// 			[
			// 				'label' => esc_html__( 'Filter Items Padding', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::DIMENSIONS,
			// 				'size_units' => [ 'px', '%', 'em' ],
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			// 				],
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_gap_between',
			// 			[
			// 				'label' => esc_html__( 'Gap Between Items', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::SLIDER,
			// 				'size_units' => [ 'px' ],
			// 				'range' => [
			// 					'px' => [
			// 						'min' => 0,
			// 						'max' => 50,
			// 						'step' => 1,
			// 					],
			// 				],
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li' => 'margin-right: {{SIZE}}{{UNIT}};',
			// 				],
			// 			]
			// 		);

			// 		$this->add_group_control(
			// 			\Elementor\Group_Control_Typography::get_type(),
			// 			[
			// 				'name' => 'thcoursescarousel_filter_text_typo',
			// 				'label' => esc_html__( 'Text Typography', 'ONE_CORE_SLUG' ),
			// 				
			// 				'selector' => '{{WRAPPER}} .th-course-categories-filter li',
			// 			]
			// 		);


			// 		$this->add_control(
			// 			'thcoursescarousel_esecfsev_ksdvnksjdvkjsdvsdv',
			// 			[
			// 				'label' => esc_html__( 'Others', 'plugin-name' ),
			// 				'type' => \Elementor\Controls_Manager::HEADING,
			// 				'separator' => 'before',
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_border_rad',
			// 			[
			// 				'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::SLIDER,
			// 				'size_units' => [ 'px', '%' ],
			// 				'range' => [
			// 					'px' => [
			// 						'min' => 0,
			// 						'max' => 50,
			// 						'step' => 1,
			// 					],
			// 				],
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li' => 'border-radius: {{SIZE}}{{UNIT}};',
			// 				],
			// 			]
			// 		);
			// 		$this->add_group_control(
			// 			\Elementor\Group_Control_Box_Shadow::get_type(),
			// 			[
			// 				'name' => 'thcoursescarousel_filter_box_shadow',
			// 				'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
			// 				'selector' => '{{WRAPPER}} .th-course-categories-filter li',
			// 			]
			// 		);

			// $this->end_controls_tab();

			// $this->start_controls_tab(
			// 			'thcoursescarousel_filter_hover_tab',
			// 			[
			// 				'label' => esc_html__( 'Hover/Active', 'plugin-name' ),
			// 			]
			// 		);

			// 		$this->add_control(
			// 			'thcoursescarousel_filter_text_color_hover',
			// 			[
			// 				'label' => esc_html__( 'Hover Text Color', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::COLOR,
			// 				
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li:hover, 
			// 					{{WRAPPER}} .th-course-categories-filter li:focus, 
			// 					{{WRAPPER}} .th-course-categories-filter li.active' => 'color: {{VALUE}}'
			// 				],
			// 			]
			// 		);
			// 		$this->add_control(
			// 			'thcoursescarousel_filter_text_hover_bg',
			// 			[
			// 				'label' => esc_html__( 'Text Background Color on Hover', 'ONE_CORE_SLUG' ),
			// 				'type' => \Elementor\Controls_Manager::COLOR,
			// 				
			// 				'selectors' => [
			// 					'{{WRAPPER}} .th-course-categories-filter li:hover, 
			// 					{{WRAPPER}} .th-course-categories-filter li:focus, 
			// 					{{WRAPPER}} .th-course-categories-filter li.active' => 'background-color: {{VALUE}}'
			// 				],
			// 			]
			// 		);
			// 		$this->add_group_control(
			// 			\Elementor\Group_Control_Border::get_type(),
			// 			[
			// 				'name' => 'thcoursescarousel_filter_border_hover',
			// 				'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
			// 				'selector' => '{{WRAPPER}} ul.th-course-categories-filter li:hover, {{WRAPPER}} ul.th-course-categories-filter li:focus, {{WRAPPER}} ul.th-course-categories-filter li.active',
			// 			]
			// 		);

			// 		$this->add_group_control(
			// 			\Elementor\Group_Control_Box_Shadow::get_type(),
			// 			[
			// 				'name' => 'thcoursescarousel_filter_box_shadow_hover',
			// 				'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
			// 				'selector' => '{{WRAPPER}} .th-course-categories-filter li:hover, {{WRAPPER}} .th-course-categories-filter li:focus, {{WRAPPER}} .th-course-categories-filter li.active',
			// 			]
			// 		);

			// $this->end_controls_tab();

			// $this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'thcoursescarousel_treanding_filter_section',
				[
					'label' => esc_html__( 'Filter Tabs', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'thcoursescarousel_show_latest_filter_tabs',
				[
					'label' => esc_html__( 'Show Latest Filter tab', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'thcoursescarousel_show_treanding_filter_tabs',
				[
					'label' => esc_html__( 'Show Treanding Filter tab', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'thcoursescarousel_show_popular_filter_tabs',
				[
					'label' => esc_html__( 'Show Popular Filter tab', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
			'filter_text_align',
				[
					'label' => __( 'Alignment', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'ec-text-left' => [
							'title' => __( 'Left', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-left',
						],
						'ec-text-center' => [
							'title' => __( 'Center', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-center',
						],
						'ec-text-right' => [
							'title' => __( 'Right', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'ec-text-center',
					'toggle' => true,
				]
			);
			$this->add_control(
				'thcoursescarousel_show_popular_filter_margin',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} ul.th-course-trending-popular-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'thcoursescarousel_show_popular_filter_border',
					'label' => __( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} ul.th-course-trending-popular-filter',
				]
			);
			$this->start_controls_tabs(
				'thcoursescarousel_filter_control_tabs'
			);

			$this->start_controls_tab(
						'thcoursescarousel_filter_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'plugin-name' ),
						]
					);

					$this->add_control(
						'thcoursescarousel_filter_border_section',
						[
							'label' => esc_html__( 'Filter Border', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'thcoursescarousel_filter_border',
							'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} ul.th-course-trending-popular-filter li',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_color_heading',
						[
							'label' => esc_html__( 'Colors', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_bg_color',
						[
							'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} ul.th-course-trending-popular-filter' => 'background-color: {{VALUE}}',
							],
							'default' => 'transparent',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_text_color',
						[
							'label' => esc_html__( 'Text Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter li' => 'color: {{VALUE}}',
							],
							'default' => '#777777',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_text_bg_color',
						[
							'label' => esc_html__( 'Item Background', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter li' => 'background-color: {{VALUE}}',
							],
							'default' => 'transparent',
						]
					);
					$this->add_control(
						'thcoursescarousel_category_filter_spacing_heading',
						[
							'label' => esc_html__( 'Spacing', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_box_margin',
						[
							'label' => esc_html__( 'Filter Box Margin', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_items_padding',
						[
							'label' => esc_html__( 'Filter Items Padding', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_gap_between',
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
								'{{WRAPPER}} .th-course-trending-popular-filter li' => 'margin-right: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'thcoursescarousel_filter_text_typo',
							'label' => esc_html__( 'Text Typography', 'ONE_CORE_SLUG' ),
							
							'selector' => '{{WRAPPER}} .th-course-trending-popular-filter li',
						]
					);


					$this->add_control(
						'thcoursescarousel_esecfsev_ksdvnksjdvkjsdvsdv',
						[
							'label' => esc_html__( 'Others', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_border_rad',
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
								'{{WRAPPER}} .th-course-trending-popular-filter li' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'thcoursescarousel_filter_box_shadow',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-trending-popular-filter li',
						]
					);

			$this->end_controls_tab();

			$this->start_controls_tab(
						'thcoursescarousel_filter_hover_tab',
						[
							'label' => esc_html__( 'Hover/Active', 'plugin-name' ),
						]
					);

					$this->add_control(
						'thcoursescarousel_filter_text_color_hover',
						[
							'label' => esc_html__( 'Hover Text Color', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter li:hover, 
								{{WRAPPER}} .th-course-trending-popular-filter li:focus, 
								{{WRAPPER}} .th-course-trending-popular-filter li.active' => 'color: {{VALUE}}'
							],
						]
					);
					$this->add_control(
						'thcoursescarousel_filter_text_hover_bg',
						[
							'label' => esc_html__( 'Text Background Color on Hover', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .th-course-trending-popular-filter li:hover, 
								{{WRAPPER}} .th-course-trending-popular-filter li:focus, 
								{{WRAPPER}} .th-course-trending-popular-filter li.active' => 'background-color: {{VALUE}}'
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'thcoursescarousel_filter_border_hover',
							'label' => esc_html__( 'Filter Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} ul.th-course-trending-popular-filter li:hover, {{WRAPPER}} ul.th-course-trending-popular-filter li:focus, {{WRAPPER}} ul.th-course-trending-popular-filter li.active',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'thcoursescarousel_filter_box_shadow_hover',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-trending-popular-filter li:hover, {{WRAPPER}} .th-course-trending-popular-filter li:focus, {{WRAPPER}} .th-course-categories-filter li.active',
						]
					);

			$this->end_controls_tab();

			$this->end_controls_tabs();
		$this->end_controls_section();
		// /*
		// ** Course Hover Information settings
		// ** @package Masterclass
		// ** @subpackage Elementor
		// *
		// *
  //   	*/
		// $this->start_controls_section(
		// 	'thcoursescarousel_hover_info',
		// 		[
		// 			'label' => esc_html__( 'Hover Information', 'ONE_CORE_SLUG' ),
		// 			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hover_info',
		// 		[
		// 			'label' => esc_html__( 'Show Hover Info', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hover_info_top',
		// 		[
		// 			'label' => esc_html__( 'Top', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SLIDER,
		// 			'size_units' => [ 'px', '%' ],
		// 			'range' => [
		// 				'px' => [
		// 					'min' => -100,
		// 					'max' => 400,
		// 					'step' => 1,
		// 				],						
		// 				'%' => [
		// 					'min' => -100,
		// 					'max' => 300,
		// 					'step' => 1,
		// 				],
		// 			],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-section' => 'top: {{SIZE}}{{UNIT}};',
		// 			],
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hr_hi',
		// 		[
		// 			'type' => \Elementor\Controls_Manager::DIVIDER,
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hover_info_bg_color',
		// 		[
		// 			'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-section' => 'background-color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hover_info' => 'yes'],
		// 			'default' => '#ffffff'
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hover_info_border_rad',
		// 		[
		// 			'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SLIDER,
		// 			'size_units' => [ 'px' ],
		// 			'range' => [
		// 				'px' => [
		// 					'min' => 0,
		// 					'max' => 50,
		// 					'step' => 1,
		// 				],
		// 			],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-section' => 'border-radius: {{SIZE}}{{UNIT}};',
		// 			],
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hover_info_padding',
		// 		[
		// 			'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::DIMENSIONS,
		// 			'size_units' => [ 'px', '%', 'em' ],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 			],
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Box_Shadow::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_hover_info_box_shadow',
		// 			'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
		// 			'selector' => '{{WRAPPER}} .hover-section',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hr_hi_1',
		// 		[
		// 			'type' => \Elementor\Controls_Manager::DIVIDER,
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_title',
		// 		[
		// 			'label' => esc_html__( 'Show Title', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_cat',
		// 		[
		// 			'label' => esc_html__( 'Show category', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_lessons',
		// 		[
		// 			'label' => esc_html__( 'Show Number Of Chapters/lessons', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_course_duration',
		// 		[
		// 			'label' => esc_html__( 'Show Course Duration', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_course_details',
		// 		[
		// 			'label' => esc_html__( 'Show Details', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_add_to_cart',
		// 		[
		// 			'label' => esc_html__( 'Show Add To Cart', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_show_hi_wishlist',
		// 		[
		// 			'label' => esc_html__( 'Show Wishlist', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SWITCHER,
		// 			'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
		// 			'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
		// 			'return_value' => 'yes',
		// 			'default' => 'no',
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hr_hi_2',
		// 		[
		// 			'type' => \Elementor\Controls_Manager::DIVIDER,
		// 			'condition' => ['show_hover_info' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_title_opt',
		// 		[
		// 			'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::HEADING,
		// 			'separator' => 'none',
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Typography::get_type(),
		// 		[
		// 			'name' => 'hi_title_typography',
		// 			'label' => esc_html__( 'Title Typography', 'ONE_CORE_SLUG' ),
		// 			
		// 			'selector' => '{{WRAPPER}} .hover-info-title',
		// 			'condition' => ['show_hi_title' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_title_color',
		// 		[
		// 			'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-title' => 'color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hi_title' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hr_hi_3',
		// 		[
		// 			'type' => \Elementor\Controls_Manager::DIVIDER,
		// 			'condition' => ['show_hi_course_details' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_desc',
		// 		[
		// 			'label' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::HEADING,
		// 			'separator' => 'none',
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Typography::get_type(),
		// 		[
		// 			'name' => 'hi_desc_typo',
		// 			'label' => esc_html__( 'Description Typography', 'ONE_CORE_SLUG' ),
		// 			
		// 			'selector' => '{{WRAPPER}} .hover-info-desc',
		// 			'condition' => ['show_hi_course_details' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_desc_excerpt',
		// 		[
		// 			'label' => esc_html__( 'Description Word Count', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::NUMBER,
		// 			'min' => 5,
		// 			'max' => 30,
		// 			'step' => 1,
		// 			'default' => 10,
		// 			'condition' => ['show_hi_course_details' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_desc_padding',
		// 		[
		// 			'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::DIMENSIONS,
		// 			'size_units' => [ 'px', '%', 'em' ],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 			],
		// 			'condition' => ['show_hi_course_details' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hr_hi_4',
		// 		[
		// 			'type' => \Elementor\Controls_Manager::DIVIDER,
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);

		// 	/*--------------- Cart Button ------------------*/
			
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_button',
		// 		[
		// 			'label' => esc_html__( 'Cart Button', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::HEADING,
		// 			'separator' => 'none',
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->start_controls_tabs('hover_info_cart_wl');
		// 	$this->start_controls_tab('hover_info_cart', ['label' => esc_html__( 'Normal', 'tophive' )]);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Typography::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_hi_cart_button',
		// 			'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
		// 			
		// 			'selector' => '{{WRAPPER}} .hover-info-add-cart',
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_btn_color',
		// 		[
		// 			'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'default' => '#666',
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart' => 'color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_btn_color_bg',
		// 		[
		// 			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'default' => '#f1f1f1',
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart' => 'background-color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_btn_br',
		// 		[
		// 			'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SLIDER,
		// 			'size_units' => [ 'px', '%' ],
		// 			'range' => [
		// 				'px' => [
		// 					'min' => 0,
		// 					'max' => 100,
		// 					'step' => 1,
		// 				],
		// 			],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart' => 'border-radius: {{SIZE}}{{UNIT}};',
		// 			],
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Border::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_cart_buttonborder',
		// 			'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
		// 			'selector' => '{{WRAPPER}} .hover-info-add-cart',
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_padding_hi',
		// 		[
		// 			'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::DIMENSIONS,
		// 			'size_units' => [ 'px', '%', 'em' ],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 			],
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->end_controls_tab();
		// 	$this->start_controls_tab('hover_info_cart_hover', ['label' => esc_html__( 'Hover', 'tophive' )]);
		
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_btn_color_hover',
		// 		[
		// 			'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'default' => '#888',
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart:hover' => 'color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_cart_btn_color_bg_hover',
		// 		[
		// 			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'default' => '#666',
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-add-cart:hover' => 'background-color: {{VALUE}}',
		// 			],
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Border::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_cart_buttonborder_hover',
		// 			'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
		// 			'selector' => '{{WRAPPER}} .hover-info-add-cart:hover',
		// 			'condition' => ['show_hi_add_to_cart' => 'yes']
		// 		]
		// 	);
		// 	$this->end_controls_tab();
		// 	$this->end_controls_tabs();

		// 	/*--------- Wishlist ----------*/
			
		// 	$this->add_control(
		// 		'thcoursescarousel_wishl_header',
		// 		[
		// 			'label' => esc_html__( 'Wishlist', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::HEADING,
		// 			'separator' => 'before',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_wishlist_icon',
		// 		[
		// 			'label' => esc_html__( 'Wishlist Icon', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::ICON,
		// 			'default' => 'fa fa-heart-o',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_wishlist_icon_br',
		// 		[
		// 			'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::SLIDER,
		// 			'size_units' => [ 'px', '%' ],
		// 			'range' => [
		// 				'px' => [
		// 					'min' => 0,
		// 					'max' => 100,
		// 					'step' => 1,
		// 				],
		// 			],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a' => 'border-radius: {{SIZE}}{{UNIT}};',
		// 			],
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Typography::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_hi_wish_list_button',
		// 			'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
		// 			
		// 			'selector' => '{{WRAPPER}} .hover-info-wishlist a',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_wish_list_btn_color',
		// 		[
		// 			'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a' => 'color: {{VALUE}}',
		// 			],
		// 			'default' => '#555',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_wish_list_btn_color_bg',
		// 		[
		// 			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a' => 'background-color: {{VALUE}}',
		// 			],
		// 			'default' => 'transparent',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Border::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_wishlist_buttonborder',
		// 			'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
		// 			'selector' => '{{WRAPPER}} .hover-info-wishlist a',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_padding_hi_wl',
		// 		[
		// 			'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::DIMENSIONS,
		// 			'size_units' => [ 'px', '%', 'em' ],
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 			],
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_wish_list_hover',
		// 		[
		// 			'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::HEADING,
		// 			'separator' => 'none',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_wishlist_btn_color_hover',
		// 		[
		// 			'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on' => 'color: {{VALUE}}',
		// 			],
		// 			'default' => '#ffffff',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_control(
		// 		'thcoursescarousel_hi_wishlist_color_bg_hover',
		// 		[
		// 			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
		// 			'type' => \Elementor\Controls_Manager::COLOR,
		// 			
		// 			'selectors' => [
		// 				'{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on' => 'background-color: {{VALUE}}',
		// 			],
		// 			'default' => '#d91e18',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// 	$this->add_group_control(
		// 		\Elementor\Group_Control_Border::get_type(),
		// 		[
		// 			'name' => 'thcoursescarousel_wishlist_border_hover',
		// 			'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
		// 			'selector' => '{{WRAPPER}} .hover-info-wishlist a:hover, {{WRAPPER}} .hover-info-wishlist a.on',
		// 			'condition' => ['show_hi_wishlist' => 'yes']
		// 		]
		// 	);
		// $this->end_controls_section();
		

		/*
  		** Carousel Navigation section
		*/
	    $this->start_controls_section(
            'thcoursescarousel_carousel_navigation',
	            [
	                'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
	            ]
	        );
    		$this->add_control(
				'thcoursescarousel_carousel_arrow_section',
				[
					'label' => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
		    $this->add_control(
		    	'thcoursescarousel_hide_arrow',
		    	[
		    		'label' 		=> esc_html__( 'Hide Arrow', 'ONE_CORE_SLUG' ),
		    		'type' 			=> \Elementor\Controls_Manager::SWITCHER,
		    		'label_on' 		=> __( 'Show', 'ONE_CORE_SLUG' ),
		    		'label_off' 	=> __( 'Hide', 'ONE_CORE_SLUG' ),
		    		'return_value' 	=> 'yes',
		    		'default' 		=> 'no',
		    	]
		    );
    		
			$this->add_control(
				'thcoursescarousel_arrow_position',
				[
					'label' => esc_html__( 'Select arrow position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 4,
					'options' => [
						'ec-text-center'  => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
						'ec-text-right'  => esc_html__( 'Top Right', 'ONE_CORE_SLUG' ),
						'ec-text-left'  => esc_html__( 'Top Left', 'ONE_CORE_SLUG' ),
					],
					'default' => 'ec-text-center'
				]
			);
			$this->start_controls_tabs(
				'thcoursescarousel_arrow_style_tabs'
			);

			$this->start_controls_tab(
				'thcoursescarousel_arrow_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

				]
			);
			$this->add_control(
				'thcoursescarousel_more_btn_background_color',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next' => 'background-color: {{VALUE}}',
					],
					'default' => '#ff5166'
				]
			);
			$this->add_control(
				'thcoursescarousel_more_btn_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next' => 'color: {{VALUE}}',
					],
					'default' => '#fff'
				]
			);
			$this->add_control(
				'thcoursescarousel_arrow_width',
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
						'{{WRAPPER}} .ec-swiper-arrow > span' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thcoursescarousel_arrow_height',
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
						'{{WRAPPER}} .ec-swiper-arrow > span' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thcoursescarousel_arrow_size',
				[
					'label' => esc_html__( 'Arrow Size', 'ONE_CORE_SLUG' ),
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
						'{{WRAPPER}} .ec-swiper-arrow > span > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thcoursescarousel_more_btn_margin',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'thcoursescarousel_more_btn_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'thcoursescarousel_more_btn_border',
					'label' => __( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next',
				]
			);
			
			$this->add_control(
				'thcoursescarousel_more_btn_border_rad',
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
						'{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next' => 'border-radius: {{SIZE}}{{UNIT}};',
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
				'thcoursescarousel_more_btn_background_color_hover',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#00214D'
				]
			);
			$this->add_control(
				'thcoursescarousel_more_btn_color_hover',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover' => 'color: {{VALUE}}',
					],
					'default' => '#fff'
				]
			);
			
			$this->add_control(
				'thcoursescarousel_more_btn_margin_hover',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'thcoursescarousel_more_btn_box_shadow_hover',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover',
				]
			);
			$this->add_control(
				'thcoursescarousel_more_btn_border_rad_hover',
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
						'{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
					]
				]
			);
			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'thcoursescarousel_carousel_dot_nav_section',
				[
					'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$this->add_control(
		    	'thcoursescarousel_hide_navigation',
		    	[
		    		'label' 		=> esc_html__( 'Hide Dot Navigation', 'ONE_CORE_SLUG' ),
		    		'type' 			=> \Elementor\Controls_Manager::SWITCHER,
		    		'label_on' 		=> __( 'Show', 'ONE_CORE_SLUG' ),
		    		'label_off' 	=> __( 'Hide', 'ONE_CORE_SLUG' ),
		    		'return_value' 	=> 'yes',
		    		'default' 		=> 'no',
		    	]
		    );
		    $this->start_controls_tabs(
				'thcoursescarousel_dot_nav_style_tabs'
			);

				$this->start_controls_tab(
					'thcoursescarousel_dot_nav_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_background_color',
					[
						'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
						],
						'default' => '#ff5166'
					]
				);
				$this->add_control(
					'widthcoursescarousel_dot_nav_background_opacity',
					[
						'label' => esc_html__( 'Opacity', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
								'step' => 1,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}}%;',
						],
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_width',
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
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_height',
					[
						'label' => esc_html__( 'Height', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 50,
								'step' => 1,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_margin',
					[
						'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				
				$this->add_control(
					'thcoursescarousel_dot_nav_border_rad',
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
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{SIZE}}{{UNIT}};',
						]
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'thcoursescarousel_dot_nav_hover_tab',
					[
						'label' => esc_html__( 'Active', 'ONE_CORE_SLUG' ),
					]
				);

				$this->add_control(
					'widthcoursescarousel_dot_nav_background_opacity_active',
					[
						'label' => esc_html__( 'Opacity', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
								'step' => 1,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet-active' => 'opacity: {{SIZE}}%;',
						],
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_background_color_hover',
					[
						'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						
						'selectors' => [
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
						],
						'default' => '#00214D'
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_width_hover',
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
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'thcoursescarousel_dot_nav_height_hover',
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
							'{{WRAPPER}} .ec-swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);
				
				$this->add_control(
					'thcoursescarousel_dot_nav_rad_hover',
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
							'{{WRAPPER}} .swiper-pagination-bullet-active' => 'border-radius: {{SIZE}}{{UNIT}};',
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
            'thcoursescarousel_box_style_section',
	            [
	                'label' => esc_html__( 'Box Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_group_control(
        		\Elementor\Group_Control_Border::get_type(),
        		[
        			'name' => 'thcoursescarousel_border',
        			'label' => esc_html__( 'Box Border', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block',
        		]
        	);
        	$this->add_control(
        		'thcoursescarousel_hr_box_border',
        		[
        			'type' => \Elementor\Controls_Manager::DIVIDER,
        		]
        	);
        	$this->add_control(
				'thcoursescarousel_select_layout',
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
				'thcoursescarousel_thumb_width',
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
					'condition' => [ 'thcoursescarousel_select_layout' => 
						array(
							'thumb-left', 
							'thumb-right'
						) ]
				]
			);
        	$this->add_responsive_control(
        		'thcoursescarousel_thumb_height',
        		[
        			'label' => esc_html__( 'Thumbnail Height', 'ONE_CORE_SLUG' ),
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
        				'size' => 190,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-course-thumb' => 'height: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'thcoursescarousel_thumb_top_spacing',
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
        		'thcoursescarousel_box_margin',
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
        		'thcoursescarousel_box_padding',
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
        		'thcoursescarousel_content_padding',
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
        		'thcoursescarousel_image_border_radius',
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
        		'thcoursescarousel_box_border_radius',
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
        			'name' => 'thcoursescarousel_course_box_shadow',
        			'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block',
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'thcoursescarousel_course_box_shadow_hover',
        			'label' => esc_html__( 'Box Shadow on hover', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-course-block:hover',
        		]
        	);
        	$this->add_control(
        		'thcoursescarousel_course_block_bg',
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
            'thcoursescarousel_cat_style_section',
	            [
	                'label' => esc_html__( 'Content', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_control(
	        	'thcoursescarousel_category_heading',
	        	[
	        		'label' => esc_html__('Catogory', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING
	        	]
	        );
	        $this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'thcoursescarousel_category_typography',
					'selector' => '{{WRAPPER}} .course-category',
				]
	        );
	        $this->add_control(
	        	'thcoursescarousel_show_cat_bg',
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
	        	'thcoursescarousel_cat_padding',
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
	        	'thcoursescarousel_cat_margin',
	        	[
	        		'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px', '%', 'em' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .course-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        		'default' => [
	        			'top' => 10,
	        			'right' => 0,
	        			'bottom' => 0,
	        			'left' => 0,
	        			'unit' => 'px'
	        		]
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_cat_br',
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
	        			'size' => 3
	        		]
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_hr_title',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_title_header',
	        	[
	        		'label' => esc_html__('Title', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_title_typo',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-block-title',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_title_color',
	        	[
	        		'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-block-title' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_title_hover_color',
	        	[
	        		'label' => esc_html__( 'Title Hover Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-block-title:hover' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_title_margin',
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
	        	'thcoursescarousel_hr_tag',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_tag_header',
	        	[
	        		'label' => esc_html__('Course tag', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_tag_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		
	        		'selector' => '{{WRAPPER}} .course-tags',
	        	]
	        );
	        $this->add_responsive_control(
	        	'thcoursescarousel_tags_vertical_position',
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
	        	]
	        );
	        $this->add_responsive_control(
	        	'thcoursescarousel_tags_horizontal_position',
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
	        	]
	        );
	        
	        $this->add_responsive_control(
	        	'thcoursescarousel_course_tag_padding',
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
	        	'thcoursescarousel_hr_price',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_desc_header',
	        	[
	        		'label' => esc_html__('Description', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_desc_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-description',
	        	]
	        );
	        $this->add_control(
				'thcoursescarousel_th_course_item_desc_color',
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
	        	'thcoursescarousel_desc_margin',
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
	        	'thcoursescarousel_hr_desc',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_pricing_header',
	        	[
	        		'label' => esc_html__('Pricing', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_pricing_typo',
	        		'label' => esc_html__( 'Pricing Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-sale-price',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_price_color',
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
	        	'thcoursescarousel_price_color_bg',
	        	[
	        		'label' => esc_html__( 'Price Color Background', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .price-section' => 'background-color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
				'thcoursescarousel_price_border_rad',
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
				'thcoursescarousel_price_section_padding',
				[
					'label' => esc_html__( 'Price Section Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .price-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => 10,
						'right' => 10,
						'bottom' => 10,
						'left' => 10,
						'unit' => 'px'
					]
				]
			);
			$this->add_responsive_control(
				'thcoursescarousel_price_pos_top',
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
						'size' => -30
					]
				]
			);
			$this->add_responsive_control(
				'thcoursescarousel_price_pos_rt',
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
						'size' => 260
					]
				]
			);
			$this->add_responsive_control(
				'thcoursescarousel_price_section_width',
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
	        		'name' => 'thcoursescarousel_prev_pricing_typo',
	        		'label' => esc_html__( 'Previous Pricing Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-original-price',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_prev_price_color',
	        	[
	        		'label' => esc_html__( 'Original Pricing Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .th-original-price' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_hr_author',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
        $this->end_controls_section();
        $this->start_controls_section(
			'thcoursescarousel_footer_section',
				[
					'label' => esc_html__( 'Footer', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
        	$this->add_control(
	        	'thcoursescarousel_footer_header',
	        	[
	        		'label' => esc_html__('Footer', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'thcoursescarousel_footer_border',
					'label' => esc_html__( 'Footer Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-course-footer'
				]
			);

			$this->add_control(
				'thcoursescarousel_footer_padding',
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
	        	'thcoursescarousel_author_header',
	        	[
	        		'label' => esc_html__('Author', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_author_typography',
	        		'label' => esc_html__( 'Author Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-author a',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_author_color',
	        	[
	        		'label' => esc_html__( 'Author Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-author a' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_hr_lessons',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_level_header',
	        	[
	        		'label' => esc_html__('Course Level', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_course_level_typography',
	        		'label' => esc_html__( 'Course Level Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-level',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_Course_Level_color',
	        	[
	        		'label' => esc_html__( 'Course Level Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-level' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_Course_Level_img_width',
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
	        	'thcoursescarousel_hr_lessons_2',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_lessons_header',
	        	[
	        		'label' => esc_html__('Lessons', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'thcoursescarousel_lessons_typography',
	        		'label' => esc_html__( 'Lessons Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .course-lessons',
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_lessons_color',
	        	[
	        		'label' => esc_html__( 'Lessons color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .course-lessons' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
			'thcoursescarousel_lessons_align',
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
					'default' => 'ec-text-left',
					'toggle' => true,
				]
			);
	        $this->add_control(
	        	'thcoursescarousel_hr_rating',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_rating_header',
	        	[
	        		'label' => esc_html__('Ratings', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_control(
	        	'thcoursescarousel_rating_font_size',
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
	        	'thcoursescarousel_rating_position',
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
			'thcoursescarousel_star_color',
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

		$settings = $this->get_settings_for_display();
		
		
		$json_settings = array(
			'arrow_position' 			=> $settings['thcoursescarousel_arrow_position'],
			'courses_count' 			=> $settings['thcoursescarousel_courses_count'],
			'cat_display' 				=> $settings['thcoursescarousel_cat_display'],
			'select_columns' 			=> $settings['thcoursescarousel_select_columns'],
			'select_layout' 			=> $settings['thcoursescarousel_select_layout'],
			'show_author' 				=> $settings['thcoursescarousel_show_author'],
			'show_tags' 				=> $settings['thcoursescarousel_show_tags'],
			'show_lessons' 				=> $settings['thcoursescarousel_show_lessons'],
			'show_level' 				=> $settings['thcoursescarousel_show_level'],
			'lessons_align' 			=> $settings['thcoursescarousel_lessons_align'],
			'show_cat_bg' 				=> $settings['thcoursescarousel_show_cat_bg'],
			'show_desc' 				=> $settings['thcoursescarousel_show_desc'],
			'show_hover_info'			=> 'no',
			'show_pricing' 				=> $settings['thcoursescarousel_show_pricing'],
			'show_pricing_prev' 		=> $settings['thcoursescarousel_show_pricing_prev'],
			'show_rating' 				=> $settings['thcoursescarousel_show_rating'],
			'word_count' 				=> $settings['thcoursescarousel_word_count'],
			'thumbnail_show_hide' 		=> $settings['thcoursescarousel_thumbnail_show_hide'],
			// 'hi_desc_excerpt'			=> $settings['thcoursescarousel_hi_desc_excerpt'],
			// 'show_hi_title'				=> $settings['thcoursescarousel_show_hi_title'],
			// 'show_hi_lessons'			=> $settings['thcoursescarousel_show_hi_lessons'],
			// 'show_hi_course_duration'	=> $settings['thcoursescarousel_show_hi_course_duration'],
			// 'show_hi_course_details'	=> $settings['thcoursescarousel_show_hi_course_details'],
			// 'show_hi_add_to_cart'		=> $settings['thcoursescarousel_show_hi_add_to_cart'],
			// 'show_hi_wishlist'			=> $settings['thcoursescarousel_show_hi_wishlist'],
			// 'wishlist_icon'				=> $settings['thcoursescarousel_wishlist_icon']
		);
		$slider_sl = rand();
		$args = array(
			'post_type' => 'lp_course',
			'post_status' => 'publish',
			'posts_per_page' => $settings['thcoursescarousel_courses_count'],
		);
		if( !empty($settings['thcoursescarousel_select_categories']) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'slug',
		            'terms'    => $settings['thcoursescarousel_select_categories'],
				)
			);
		}
		if( !empty($settings['thcoursescarousel_posts_order']) ){
			$args['order'] = $settings['thcoursescarousel_posts_order'];
		}
		?>
		<div class="ec-filtering-section">
			<ul class="th-course-trending-popular-filter <?php echo $settings['filter_text_align'] ?>" data-settings="<?php echo htmlspecialchars(json_encode($json_settings)) ?>">
				<?php if( $settings['thcoursescarousel_show_latest_filter_tabs'] ): ?>
					<li data-id="ec-swiper-container-<?php echo $slider_sl?>" data-cat="<?php echo htmlspecialchars(json_encode($settings['thcoursescarousel_select_categories'])); ?>" data-sort="latest"><?php echo esc_html__('Latest', 'ONE_CORE_SLUG'); ?></li>
				<?php endif; ?>
				<?php if( $settings['thcoursescarousel_show_popular_filter_tabs'] ): ?>
					<li data-id="ec-swiper-container-<?php echo $slider_sl?>" data-cat="<?php echo htmlspecialchars(json_encode($settings['thcoursescarousel_select_categories'])); ?>" data-sort="popular"><?php echo esc_html__('Most Popular', 'ONE_CORE_SLUG'); ?></li>
				<?php endif; ?>
				<?php if( $settings['thcoursescarousel_show_treanding_filter_tabs'] ): ?>
					<li data-id="ec-swiper-container-<?php echo $slider_sl?>" data-cat="<?php echo htmlspecialchars(json_encode($settings['thcoursescarousel_select_categories'])); ?>" data-sort="treanding"><?php echo esc_html__('Treanding', 'ONE_CORE_SLUG'); ?></li>
				<?php endif; ?>
			</ul>
		</div>	


		<div class="ec-swiper-fixed-width">
			<div class="ec-swiper-container ec-swiper-container-<?php echo $slider_sl . ' ' . $settings['thcoursescarousel_posts_layout']; ?>" id="ec-swiper-container-<?php echo $slider_sl ?>">

			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper ec-dynamic-slides">
			        <!-- Slides -->
			        <?php
			        	$displayflex = $settings['thcoursescarousel_select_layout'] === 'thumb-left' || $settings['thcoursescarousel_select_layout'] === 'thumb-right' ? 'ec-d-md-flex' : ''; 
			        	$html = '';
			        	$json_settings['use_slider'] = true;
			        	$json_settings['autoplay_delay'] = $settings['thcoursescarousel_autoplay_delay'];

						$posts = new \WP_Query($args);
							if($posts->have_posts()){
								while ($posts->have_posts()) {
									$posts->the_post();
									$course = \LP_Global::course();	
										$html .= apply_filters( 'tophive/learnpress/default/single/course/grid-two', $course, $json_settings );
								}
							}
						echo $html;
					?>
			    </div>

			    

			</div>	
			<?php if( $settings['thcoursescarousel_hide_arrow'] !== 'yes' ){ ?>
				<div class="ec-swiper-arrow">
					<span class="ec-swiper-button-prev ec-swiper-button-prev-<?php echo $slider_sl?>">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" preserveAspectRatio="xMidYMin" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
						</svg>
					</span>
					<span class="ec-swiper-button-next ec-swiper-button-next-<?php echo $slider_sl?>">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
						</svg>
					</span>
				</div>
			<?php } ?>
			<?php if( $settings['thcoursescarousel_hide_navigation'] !== 'yes' ){ ?>
				<div class="ec-swiper-pagination ec-swiper-pagination-<?php echo $slider_sl?>"></div>
			<?php } ?>
		</div>
		<script>
			jQuery(document).ready(function(){
				var THslider = new Swiper ('#ec-swiper-container-<?php echo $slider_sl; ?>', {
			    // Optional parameters
				    slidesPerView: <?php echo $settings['thcoursescarousel_select_columns'] ?>,
				    spaceBetween: 20,
				    slidesPerGroup: <?php echo $settings['thcoursescarousel_per_slide'] ?>,
				    loop: false,
				    autoplay : <?php echo $settings['thcoursescarousel_autoplay'] == 'yes' ? var_export(true) : var_export(false) ?>,
				    speed: <?php echo $settings['thcoursescarousel_play_speed'] ?>,
				    loopFillGroupWithBlank: true,
				    breakpoints: {
					    300: {
					      	slidesPerView: 1,
					      	spaceBetween: 10
					    },
					    700: {
					      	slidesPerView: 2,
					      	spaceBetween: 10
					    },
					    1000: {
					      	slidesPerView: <?php echo $settings['thcoursescarousel_select_columns'] ?>,
					      	spaceBetween: 20
					    }
					},
				    // If we need pagination
				    pagination: {
				      el: '.ec-swiper-pagination-<?php echo $slider_sl?>',
				    },

				    // Navigation arrows
				    navigation: {
				      nextEl: '.ec-swiper-button-next-<?php echo $slider_sl?>',
				      prevEl: '.ec-swiper-button-prev-<?php echo $slider_sl?>',
				    },

				    // And if we need scrollbar
				    scrollbar: {
				      el: '.ec-swiper-scrollbar',
				    },
			  	});
			})
		</script>
		<?php
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
	    		$html .= '<li data-id="'. $id .'" data-cat="'. $value .'">'. $value .'</li>';
	    	}
    	}else{
	    	$html = '<div></div>';
    	}
    	return $html;
    }
}
