<?php

namespace ONECORE\widgets\elementor;

class OneElementorBlog extends \Elementor\Widget_Base {

    public function get_name(){
        return 'thelemblog';
    }
    public function get_title(){
        return esc_html__( 'Blog', 'ONE_CORE_SLUG' );
    }
    public function get_icon(){
        return 'eicon-post-content';
    }
    public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
    protected function register_controls() {

    	/*
    	*
    	* ----------- Content Tab Starts ----------
    	*
		** Course Blog basic settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'blog_content_section',
				[
					'label' => esc_html__( 'Blog', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'blog_post_order',
				[
					'label' => esc_html__( 'Order Posts by', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'recent',
					'options' => [
						'recent'  		=> esc_html__( 'Recently Published', 'ONE_CORE_SLUG' ),
						'popularity'  	=> esc_html__( 'Popular', 'ONE_CORE_SLUG' ),
					],
				]
			);
			$this->add_control(
				'select_blog_columns',
				[
					'label' => esc_html__( 'Select Columns', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'ec-col-md-12' 	=> esc_html__( '1 Column', 'ONE_CORE_SLUG' ),
						'ec-col-md-6' 	=> esc_html__( '2 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-md-4'  	=> esc_html__( '3 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-md-3' 	=> esc_html__( '4 Columns', 'ONE_CORE_SLUG' ),
						'ec-col-md-2' 	=> esc_html__( '6 Columns', 'ONE_CORE_SLUG' ),
					],
					'default' => 'ec-col-md-6',
				]
			);
			$this->add_control(
				'blog_post_count',
				[
					'label' => esc_html__( 'Post Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('-1 For showing all', 'ONE_CORE_SLUG'),
					'default' => 4,
				]
	        );
			$this->add_control(
				'blog_post_offset',
				[
					'label' => esc_html__( 'Post Offset', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('This number of posts will be excluded from first', 'ONE_CORE_SLUG'),
					'default' => 0,
				]
	        );
	        $this->add_control(
	        	'blog_word_count',
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
	        	'blog_show_desc',
	        	[
	        		'label' => esc_html__( 'Show Description', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'no',
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
			'blog_filter_category',
				[
					'label' => esc_html__( 'Blog Category', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
	
			$this->add_control(
				'select_blog_categories',
				[
					'label' => esc_html__( 'Select Categories', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $this->parse_filter_categories(),
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'blog_meta_section',
				[
					'label' => esc_html__( 'Meta Data', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'meta_position',
				[
					'label' => esc_html__( 'Select Meta Data Position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'before-title',
					'options' => [
						'before-title'  => esc_html__( 'Before Title', 'ONE_CORE_SLUG' ),
						'after-title'  => esc_html__( 'After Title', 'ONE_CORE_SLUG' ),
					],
				]
			);
			$this->add_control(
	        	'display_category',
	        	[
	        		'label' => esc_html__('Show category', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
	        	]
	        );
			$this->add_control(
	        	'display_comments',
	        	[
	        		'label' => esc_html__('Show comments', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
	        	]
	        );
			$this->add_control(
	        	'display_author',
	        	[
	        		'label' => esc_html__('Show author', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
	        	]
	        );
			$this->add_control(
	        	'display_views',
	        	[
	        		'label' => esc_html__('Show views', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
	        	]
	        );
			$this->add_control(
	        	'display_date_meta',
	        	[
	        		'label' => esc_html__('Show date', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
	        	]
	        );

		$this->end_controls_section();
		/*
  		** Carousel Navigation section
		*/
	    $this->start_controls_section(
            'blog_carousel_navigation',
	            [
	                'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
	            ]
	        );
    		$this->add_control(
				'blog_carousel_arrow_section',
				[
					'label' => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
    		$this->add_control(
				'blog_carousel_arrow',
				[
					'label' => esc_html__( 'Show Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'blog_arrow_button',
				[
					'label' => esc_html__( 'Arrow Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-blog-pagination-arrow .ec-switch-button i' => 'color: {{VALUE}}',
					],
					'default' => '#888'
				]
			);
			$this->add_control(
				'blog_arrow_button_bg',
				[
					'label' => esc_html__( 'Arrow Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-blog-pagination-arrow .ec-switch-button i, {{WRAPPER}} .th-blog-pagination-arrow .ec-switch-button' => 'background-color: {{VALUE}}',
					],
					'default' => '#f1f1f1'
				]
			);
			$this->add_control(
				'blog_arrow_slider',
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
						'{{WRAPPER}} .th-blog-pagination-arrow .ec-switch-button i' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'blog_arrow_position',
				[
					'label' => esc_html__( 'Select arrow position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 4,
					'options' => [
						'default'  => esc_html__( 'Default', 'ONE_CORE_SLUG' ),
						'top-right'  => esc_html__( 'Top right', 'ONE_CORE_SLUG' ),
						'top-left'  => esc_html__( 'Top left', 'ONE_CORE_SLUG' ),
						'top-center'  => esc_html__( 'Top center', 'ONE_CORE_SLUG' ),

						'bottom-right'  => esc_html__( 'bottom right', 'ONE_CORE_SLUG' ),
						'bottom-left'  => esc_html__( 'bottom left', 'ONE_CORE_SLUG' ),
						'bottom-center'  => esc_html__( 'bottom center', 'ONE_CORE_SLUG' ),
					],
					'default' => 'bottom-center'
				]
			);
			$this->start_controls_tabs(
				'blog_arrow_style_tabs'
			);

			$this->start_controls_tab(
				'blog_arrow_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

				]
			);

			$this->add_control(
				'blog_arrow_background_color',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button-next i, {{WRAPPER}} .ec-switch-button-prev i' => 'background-color: {{VALUE}}',
					],
					'default' => '#F3F3F3',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'blog_arrow_icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button-next i, {{WRAPPER}} .ec-switch-button-prev i' => 'color: {{VALUE}}',
					],
					'default' => '#d91e18',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'blog_arrow_border_control',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-switch-button-next i, {{WRAPPER}} .ec-switch-button-prev i'
				]
			);
			$this->add_control(
				'blog_arrow_border_rad',
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
						'{{WRAPPER}} .ec-switch-button-next i, {{WRAPPER}} .ec-switch-button-prev i' => 'border-radius: {{SIZE}}{{UNIT}};',
					]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'blog_arrow_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
				]
			);

			$this->add_control(
				'blog_arrow_background_color_hover',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button-next i:hover, {{WRAPPER}} .ec-switch-button-prev i:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#d91e18',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_control(
				'blog_arrow_icon_color_hover',
				[
					'label' => esc_html__( 'Icon Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button-next i:hover, {{WRAPPER}} .ec-switch-button-prev i:hover' => 'color: {{VALUE}}',
					],
					'default' => '#d91e18',
					'condition' => ['show_hi_wishlist' => 'yes']
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'blog_arrow_border_control_hover',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-switch-button-next i:hover, {{WRAPPER}} .ec-switch-button-prev i:hover'
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'arrow_inactive_tab',
				[
					'label' => esc_html__( 'Inactive', 'ONE_CORE_SLUG' ),

				]
			);
			$this->add_control(
				'blog_arrow_background_color_inactive',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button.disabled i, {{WRAPPER}} .ec-switch-button.disabled i:hover' => 'background-color: {{VALUE}}',
					],
					'default' => '#f8f8f8',
				]
			);
			$this->add_control(
				'blog_arrow_icon_color_inactive',
				[
					'label' => esc_html__( 'Icon Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .ec-switch-button.disabled i, {{WRAPPER}} .ec-switch-button.disabled i:hover' => 'color: {{VALUE}}',
					],
					'default' => '#e3e3e3',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'blog_arrow_border_control_inactive',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-switch-button.disabled i, 
					{{WRAPPER}} .ec-switch-button.disabled i:hover'
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
            'blog_box_style_section',
	            [
	                'label' => esc_html__( 'Box Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_group_control(
        		\Elementor\Group_Control_Border::get_type(),
        		[
        			'name' => 'blog_border',
        			'label' => esc_html__( 'Box Border', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block',
        		]
        	);
        	$this->add_control(
        		'blog_hr_box_border',
        		[
        			'type' => \Elementor\Controls_Manager::DIVIDER,
        		]
        	);
        	$this->add_control(
				'select_blog_layout',
				[
					'label' => esc_html__( 'Select Blog Layout', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => [
						'top'  		=> esc_html__( 'Image Top', 'ONE_CORE_SLUG' ),
						'thumb-left'  	=> esc_html__( 'Image Left', 'ONE_CORE_SLUG' ),
						'thumb-right'  	=> esc_html__( 'Image Right', 'ONE_CORE_SLUG' ),
					],
					'default' => 'thumb-right'
				]
			);
        	$this->add_responsive_control(
        		'blog_box_margin',
        		[
        			'label' => esc_html__( 'Box margin', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        		'blog_box_padding',
        		[
        			'label' => esc_html__( 'Box Padding', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'blog_content_padding',
        		[
        			'label' => esc_html__( 'Content Padding', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        			'default' => [
        				'top' => 20,
        				'right' => 25,
        				'bottom' => 20,
        				'left' => 25,
        				'unit' => 'px'
        			]
        		]
        	);
        	$this->add_responsive_control(
        		'blog_box_border_radius',
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
        				'size' => 10,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-block' => 'border-radius: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'blog_course_box_shadow',
        			'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block',
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'blog_course_box_shadow_hover',
        			'label' => esc_html__( 'Box Shadow on hover', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block:hover',
        		]
        	);
        	$this->add_control(
        		'blog_block_bg',
        		[
        			'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::COLOR,
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-block' => 'background-color: {{VALUE}}',
        			],
        			'default' => '#f1f1f1',
        		]
        	);
        $this->end_controls_section();
        /*
		** Course Grid Thumbnail Style settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
	    $this->start_controls_section(
            'blog_thumb_style_section',
	            [
	                'label' => esc_html__( 'Thumbnail', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	
			$this->add_control(
				'show_blog_thumb',
				[
					'label' => esc_html__( 'Show thumbnail', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
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
						'{{WRAPPER}} .th-blog-thumb, {{WRAPPER}} .th-course-thumb' => 'width: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'size' => 265,
						'unit' => 'px'
					],
					'condition' => [ 'select_blog_layout' => 
						array(
							'thumb-left', 
							'thumb-right'
						) ]
				]
			);
        	$this->add_responsive_control(
        		'blog_thumb_height',
        		[
        			'label' => esc_html__( 'Thumbnail Height', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SLIDER,
        			'size_units' => [ 'px' ],
        			'range' => [
        				'px' => [
        					'min' => 0,
        					'max' => 450,
        					'step' => 1,
        				]
        			],
        			'default' => [
        				'unit' => 'px',
        				'size' => 285,
        			],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-thumb, {{WRAPPER}} .th-course-thumb' => 'height: {{SIZE}}{{UNIT}};',
        			],
        		]
        	);
        	$this->add_responsive_control(
        		'blog_image_border_radius',
        		[
        			'label' => esc_html__( 'Image Border Radius', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px' ],
        			
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-thumb, {{WRAPPER}} .th-course-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        			'default' => array(
        				'top' 	 => 0,
        				'right'  => 10,
        				'left' 	 => 0,
        				'bottom' => 10,
        				'unit' 	 => 'px'
        			)
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
            'blog_desc_style_section',
	            [
	                'label' => esc_html__( 'Content style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        
	        $this->add_control(
	        	'title_header_blog',
	        	[
	        		'label' => esc_html__('Title', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'blog_title_typo',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-block-title',
	        	]
	        );
	        $this->add_control(
	        	'blog_title_color',
	        	[
	        		'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-block-title' => 'color: {{VALUE}}',
	        		],
	        		'default' => '#555'
	        	]
	        );
	        $this->add_control(
	        	'blog_title_hover_color',
	        	[
	        		'label' => esc_html__( 'Title Hover Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-block-title:hover' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'blog_title_margin',
	        	[
	        		'label' => esc_html__( 'Title Margin', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::DIMENSIONS,
	        		'size_units' => [ 'px' ],
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-block-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        		],
	        	]
	        );
	        
	        $this->add_control(
	        	'hr_desc_blog',
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
	        		'name' => 'blog_desc_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-description',
	        	]
	        );
	        $this->add_control(
	        	'blog_desc_typography_color',
	        	[
	        		'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .th-description' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'blog_desc_margin',
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
	        	'hr_desc_blog_2',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
        $this->end_controls_section();/*
    	**
		** Course Grid Meta Style settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
        $this->start_controls_section(
            'blog_meta_style_section',
	            [
	                'label' => esc_html__( 'Meta Data', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_control(
        		'blog_meta_spacing',
        		[
        			'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px', '%', 'em' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-details .th-elem-blog-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        		]
        	);
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'blog_meta_content_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		// 'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
	        		'selector' => '{{WRAPPER}} .th-blog-details .th-elem-blog-meta i,{{WRAPPER}} .th-blog-details .th-elem-blog-meta a, {{WRAPPER}} .th-blog-details .th-elem-blog-meta span',
	        	]
	        );
	        $this->add_control(
	        	'blog_meta_content_colors',
	        	[
	        		'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .th-blog-details .th-elem-blog-meta i,{{WRAPPER}} .th-blog-details .th-elem-blog-meta a, {{WRAPPER}} .th-blog-details .th-elem-blog-meta span' => 'color: {{VALUE}}',
	        		],
	        		'default' => '#A8A8A8'
	        	]
	        );
	        $this->add_control(
	        	'blog_meta_spacing_between',
	        	[
	        		'label' => esc_html__( 'Space between items', 'ONE_CORE_SLUG' ),
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
	        			'{{WRAPPER}} .th-blog-details .th-elem-blog-meta span' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
	        			'{{WRAPPER}} .th-blog-details .th-elem-blog-meta' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}',
	        		],
	        	]
	        );

	        $this->add_control(
	        	'blog_date_meta',
	        	[
	        		'label' => esc_html__( 'Date', 'plugin-name' ),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'separator' => 'before',
	        	]
	        );
	        $this->add_control(
	        	'blog_date_format',
	        	[
	        		'label' => esc_html__( 'Select Date Format', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SELECT,
	        		'default' => 'solid',
	        		'options' => [
	        			'FjY'  => esc_html__( 'i.e: January 11,2020', 'ONE_CORE_SLUG' ),
	        			'DMj'  => esc_html__( 'i.e: Wed Jan 9', 'ONE_CORE_SLUG' ),
	        			'dSMY'  => esc_html__( 'i.e: 15th Jan 2020', 'ONE_CORE_SLUG' ),
	        			'FY'  => esc_html__( 'i.e: January 2020', 'ONE_CORE_SLUG' ),
	        		],
	        	]
	        );
        $this->end_controls_section();
        $this->start_controls_section(
            'blog_footer_style_section',
	            [
	                'label' => esc_html__( 'Footer', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_responsive_control(
        		'footerpadding',
        		[
        			'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::DIMENSIONS,
        			'size_units' => [ 'px', '%', 'em' ],
        			'selectors' => [
        				'{{WRAPPER}} .th-blog-block .th-blog-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			],
        			'default' => array(
        				'top' => 0,
        				'right' => 30,
        				'left' => 7,
        				'bottom' => 20,
        				'unit' => 'px'
        			)
        		]
        	);
        	$this->add_control(
        		'display_footer_view',
        		[
        			'label' => esc_html__( 'Show views', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SWITCHER,
        			'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
        			'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
        			'return_value' => 'yes',
        			'default' => 'no',
        		]
        	);
        	$this->add_control(
        		'display_footer_author',
        		[
        			'label' => esc_html__( 'Show author', 'ONE_CORE_SLUG' ),
        			'type' => \Elementor\Controls_Manager::SWITCHER,
        			'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
        			'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
        			'return_value' => 'yes',
        			'default' => 'yes',
        		]
        	);
	        $this->add_control(
	        	'read_more_header',
	        	[
	        		'label' => esc_html__('Read more', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_control(
	        	'blog_read_more_text',
	        	[
	        		'label' => esc_html__( 'Read more text', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::TEXT,
	        		'default' => '',
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'blog_read_more_typo',
	        		'label' => esc_html__( 'Read More Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-read-more',
	        	]
	        );
	        $this->add_control(
	        	'blog_read_more',
	        	[
	        		'label' => esc_html__( 'Readmore Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'default' => '#20AD96',
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-read-more a' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'blog_read_more_hover',
	        	[
	        		'label' => esc_html__( 'Readmore Color hover', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'default' => '#20AD96',
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-read-more a:hover' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'footer_auther_header',
	        	[
	        		'label' => esc_html__('Author', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'blog_author_typography',
	        		'label' => esc_html__( 'Author Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-author a',
	        	]
	        );
	        $this->add_control(
	        	'author_color',
	        	[
	        		'label' => esc_html__( 'Author Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-author a' => 'color: {{VALUE}}',
	        		],
	        		'default' => '#666'
	        	]
	        );
	        $this->add_control(
	        	'view_count_header',
	        	[
	        		'label' => esc_html__('View Count', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'blog_footer_view_typo',
	        		'label' => esc_html__( 'View Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-view',
	        	]
	        );
	        $this->add_control(
	        	'blog_view_color',
	        	[
	        		'label' => esc_html__( 'View Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-view' => 'color: {{VALUE}}',
	        		],
	        		'default' => '#666'
	        	]
	        );
        $this->end_controls_section();
        /*
			*** --------------------- Content Tab ends ---------------------***
        */
	}
	function randColors(){
		$colors = array(
			array(
				'rgba(90, 90, 204, 0.2)',
				'rgba(90, 90, 204, 1)'
			), 
			array(
				'rgba(140, 103, 198, 0.2)',
				'rgba(140, 103, 198, 1)',
			), 
			array(
				'rgba(216, 99, 216, 0.2)',
				'rgba(216, 99, 216, 1)',
			), 
			array(
				'rgba(108, 40, 161, 0.2)',
				'rgba(108, 40, 161, 1)',
			), 
			array(
				'rgba(248, 129, 45, 0.2)',
				'rgba(248, 129, 45, 1)',
			), 
			array(
				'rgba(150, 229, 16, 0.2)',
				'rgba(150, 229, 16, 1)',
			), 
			array(
				'rgba(36, 85, 206, 0.2)',
				'rgba(36, 85, 206, 1)',
			), 
			array(
				'rgba(248, 51, 78, 0.2)',
				'rgba(248, 51, 78, 1)',
			), 
			array(
				'rgba(244, 180, 93, 0.2)',
				'rgba(244, 180, 93, 1)',
			), 
			array(
				'rgba(242, 176, 164, 0.2)',
				'rgba(242, 176, 164, 1)',
			),
		);
		return $colors[array_rand($colors)];
	}
    protected function render() {

    	$uniqID = 'ec_mc_' . rand();

		$settings = $this->get_settings_for_display();

		$json_settings = array(
			'blog_post_order' 		=> $settings['blog_post_order'],
			'blog_arrow_position' 	=> $settings['blog_arrow_position'],
			'blog_carousel_arrow' 	=> $settings['blog_carousel_arrow'],
			'blog_post_count' 		=> $settings['blog_post_count'],
			'blog_date_format' 		=> $settings['blog_date_format'],
			'blog_read_more_text'	=> $settings['blog_read_more_text'],
			'select_blog_columns' 	=> $settings['select_blog_columns'],
			'select_blog_layout' 	=> $settings['select_blog_layout'],
			'display_category' 		=> $settings['display_category'],
			'meta_position' 		=> $settings['meta_position'],
			'display_comments' 		=> $settings['display_comments'],
			'display_author' 		=> $settings['display_author'],
			'display_views' 		=> $settings['display_views'],
			'display_date_meta' 	=> $settings['display_date_meta'],
			'blog_show_desc' 		=> $settings['blog_show_desc'],
			'blog_word_count' 		=> $settings['blog_word_count'],
			// 'blog_show_views' 		=> $settings['blog_show_views'],
			'show_blog_thumb' 		=> $settings['show_blog_thumb'],
			// 'show_blog_views' 		=> $settings['show_blog_views'],
			'display_footer_view' 	=> $settings['display_footer_view'],
			'display_footer_author' => $settings['display_footer_author'],
		);
		$args = array(
			'posts_per_page' => $settings['blog_post_count'],
			'post_type' => 'post'
		);
		if( 'popularity' == $settings['blog_post_order'] ){
			$args['meta_key'] = 'tophive_get_post_view';
			$args['orderby'] = 'meta_value_num';
		}

		if( $settings['blog_post_offset'] > 0 ){
			$args['offset'] = $settings['blog_post_offset'];
		}

		// if( !empty($settings['select_blog_categories']) ){
		// 	$args['category__in'] = $settings['select_blog_categories'];
		// }

		$html = '';
		
		$html .= '<div class="ec-d-flex ec-flex-row">';
			
			$html .= '<div class="ec-mc-main-content">';
				$html .= '<div id="'. $uniqID .'" class="ec-row ajax-replace ec-position-relative">';
					$html .= OneElementorBase::prepareBlogs($args, $json_settings);
				$html .= '</div>';
				$html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="137px" height="137px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
					<path d="M35 50A15 15 0 0 0 65 50A15 16.3 0 0 1 35 50" fill="#292664" stroke="none" transform="rotate(177.696 50 50.65)">
					  <animateTransform attributeName="transform" type="rotate" dur="0.5025125628140703s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50.65;360 50 50.65"></animateTransform>
					</path></svg>';
			$html .= '</div>';
			
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
    	$allcategories =  get_categories();
		$catarray = array();
    	foreach ($allcategories as $category) {
			$catarray[$category->term_id] = $category->name;
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
