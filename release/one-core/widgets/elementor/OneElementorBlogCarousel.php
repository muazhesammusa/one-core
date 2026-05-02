<?php

namespace ONECORE\widgets\elementor;

class OneElementorBlogCarousel extends \Elementor\Widget_Base {

    public function get_name(){
        return 'thelemblog-carousel';
    }
    public function get_title(){
        return esc_html__( 'Blog Carousel', 'ONE_CORE_SLUG' );
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
			'th_blog_carousel_blog_content_section',
				[
					'label' => esc_html__( 'Blog Carousel', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'th_blog_carousel_blog_post_order',
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
				'th_blog_carousel_posts_layout',
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
				'th_blog_carousel_select_blog_columns',
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
					],
					'default' => '3',
				]
			);
			$this->add_control(
				'th_blog_carousel_blog_post_count',
				[
					'label' => esc_html__( 'Post Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('-1 For showing all', 'ONE_CORE_SLUG'),
					'default' => 4,
				]
	        );
			$this->add_control(
				'th_blog_carousel_blog_post_offset',
				[
					'label' => esc_html__( 'Post Offset', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('This number of posts will be excluded from first', 'ONE_CORE_SLUG'),
					'default' => 0,
				]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_word_count',
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
	        	'th_blog_carousel_blog_show_desc',
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
		$this->start_controls_section(
			'th_blog_carousel_carousel_options',
				[
					'label' => esc_html__( 'Carousel Options', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'th_blog_carousel_autoplay',
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
				'th_blog_carousel_autoplay_delay',
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
					'condition' => ['th_blog_carousel_autoplay' => 'yes']
				]
			);
			$this->add_control(
				'th_blog_carousel_play_speed',
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
				'th_blog_carousel_per_slide',
				[
					'label' => esc_html__( 'Posts Per Slide', 'ONE_CORE_SLUG' ),
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
  		** Carousel Navigation section
		*/
	    $this->start_controls_section(
            'th_blog_carousel_carousel_navigation',
	            [
	                'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
	            ]
	        );
    		$this->add_control(
				'th_blog_carousel_carousel_arrow_section',
				[
					'label' => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
		    $this->add_control(
		    	'th_blog_carousel_hide_arrow',
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
				'th_blog_carousel_arrow_position',
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
				'th_blog_carousel_arrow_style_tabs'
			);

			$this->start_controls_tab(
				'th_blog_carousel_arrow_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

				]
			);
			$this->add_control(
				'th_blog_carousel_more_btn_background_color',
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
				'th_blog_carousel_more_btn_color',
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
				'th_blog_carousel_arrow_width',
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
				'th_blog_carousel_arrow_height',
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
				'th_blog_carousel_arrow_size',
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
				'th_blog_carousel_more_btn_margin',
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
					'name' => 'th_blog_carousel_more_btn_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'th_blog_carousel_more_btn_border',
					'label' => __( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev, {{WRAPPER}} .ec-swiper-button-next',
				]
			);
			
			$this->add_control(
				'th_blog_carousel_more_btn_border_rad',
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
				'th_blog_carousel_more_btn_background_color_hover',
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
				'th_blog_carousel_more_btn_color_hover',
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
				'th_blog_carousel_more_btn_margin_hover',
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
					'name' => 'th_blog_carousel_more_btn_box_shadow_hover',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-swiper-button-prev:hover, {{WRAPPER}} .ec-swiper-button-next:hover',
				]
			);
			$this->add_control(
				'th_blog_carousel_more_btn_border_rad_hover',
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
				'th_blog_carousel_carousel_dot_nav_section',
					[
						'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$this->add_control(
			    	'th_blog_carousel_hide_navigation',
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
					'th_blog_carousel_dot_nav_style_tabs'
				);

					$this->start_controls_tab(
						'th_blog_carousel_dot_nav_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

						]
					);
					$this->add_control(
						'th_blog_carousel_dot_nav_background_color',
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
						'width_blog_carousel_dot_nav_background_opacity',
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
						'th_blog_carousel_dot_nav_width',
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
						'th_blog_carousel_dot_nav_height',
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
						'th_blog_carousel_dot_nav_margin',
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
						'th_blog_carousel_dot_nav_border_rad',
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
						'th_blog_carousel_dot_nav_hover_tab',
						[
							'label' => esc_html__( 'Active', 'ONE_CORE_SLUG' ),
						]
					);

					$this->add_control(
						'width_blog_carousel_dot_nav_background_opacity_active',
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
						'th_blog_carousel_dot_nav_background_color_hover',
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
						'th_blog_carousel_dot_nav_width_hover',
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
						'th_blog_carousel_dot_nav_height_hover',
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
						'th_blog_carousel_dot_nav_rad_hover',
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
		** Course Category Filter settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'th_blog_carousel_blog_filter_category',
				[
					'label' => esc_html__( 'Blog Category', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
	
			$this->add_control(
				'th_blog_carousel_select_blog_categories',
				[
					'label' => esc_html__( 'Select Categories', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $this->parse_filter_categories(),
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'th_blog_carousel_blog_meta_section',
				[
					'label' => esc_html__( 'Meta Data', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'th_blog_carousel_meta_position',
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
	        	'th_blog_carousel_display_category',
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
	        	'th_blog_carousel_display_comments',
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
	        	'th_blog_carousel_display_author',
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
	        	'th_blog_carousel_display_views',
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
	        	'th_blog_carousel_display_date_meta',
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
            'th_blog_carousel_blog_carousel_navigation',
	            [
	                'label' => esc_html__( 'Navigation', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
	            ]
	        );
    		$this->add_control(
				'th_blog_carousel_blog_carousel_arrow_section',
				[
					'label' => esc_html__( 'Arrow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
    		$this->add_control(
				'th_blog_carousel_blog_carousel_arrow',
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
				'th_blog_carousel_blog_arrow_button',
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
				'th_blog_carousel_blog_arrow_button_bg',
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
				'th_blog_carousel_blog_arrow_slider',
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
				'th_blog_carousel_blog_arrow_position',
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
				'th_blog_carousel_blog_arrow_style_tabs'
			);

			$this->start_controls_tab(
				'th_blog_carousel_blog_arrow_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),

				]
			);

			$this->add_control(
				'th_blog_carousel_blog_arrow_background_color',
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
				'th_blog_carousel_blog_arrow_icon_color',
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
					'name' => 'th_blog_carousel_blog_arrow_border_control',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .ec-switch-button-next i, {{WRAPPER}} .ec-switch-button-prev i'
				]
			);
			$this->add_control(
				'th_blog_carousel_blog_arrow_border_rad',
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
				'th_blog_carousel_blog_arrow_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
				]
			);

			$this->add_control(
				'th_blog_carousel_blog_arrow_background_color_hover',
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
				'th_blog_carousel_blog_arrow_icon_color_hover',
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
				'th_blog_carousel_arrow_inactive_tab',
				[
					'label' => esc_html__( 'Inactive', 'ONE_CORE_SLUG' ),

				]
			);
			$this->add_control(
				'th_blog_carousel_blog_arrow_background_color_inactive',
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
				'th_blog_carousel_blog_arrow_icon_color_inactive',
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
            'th_blog_carousel_blog_box_style_section',
	            [
	                'label' => esc_html__( 'Box Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_group_control(
        		\Elementor\Group_Control_Border::get_type(),
        		[
        			'name' => 'th_blog_carousel_blog_border',
        			'label' => esc_html__( 'Box Border', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block',
        		]
        	);
        	$this->add_control(
        		'th_blog_carousel_blog_hr_box_border',
        		[
        			'type' => \Elementor\Controls_Manager::DIVIDER,
        		]
        	);
        	$this->add_control(
				'th_blog_carousel_select_blog_layout',
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
        		'th_blog_carousel_blog_box_margin',
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
        		'th_blog_carousel_blog_box_padding',
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
        		'th_blog_carousel_blog_content_padding',
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
        		'th_blog_carousel_blog_box_border_radius',
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
        			'name' => 'th_blog_carousel_blog_course_box_shadow',
        			'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block',
        		]
        	);
        	$this->add_group_control(
        		\Elementor\Group_Control_Box_Shadow::get_type(),
        		[
        			'name' => 'th_blog_carousel_blog_course_box_shadow_hover',
        			'label' => esc_html__( 'Box Shadow on hover', 'ONE_CORE_SLUG' ),
        			'selector' => '{{WRAPPER}} .th-blog-block:hover',
        		]
        	);
        	$this->add_control(
        		'th_blog_carousel_blog_block_bg',
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
            'th_blog_carousel_blog_thumb_style_section',
	            [
	                'label' => esc_html__( 'Thumbnail', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	
			$this->add_control(
				'th_blog_carousel_show_blog_thumb',
				[
					'label' => esc_html__( 'Show thumbnail', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'th_blog_carousel_thumb_width',
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
        	$this->add_control(
        		'th_blog_carousel_blog_thumb_height',
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
        		'th_blog_carousel_blog_image_border_radius',
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
            'th_blog_carousel_blog_desc_style_section',
	            [
	                'label' => esc_html__( 'Content style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        
	        $this->add_control(
	        	'th_blog_carousel_th_blog_carousel_title_header_blog',
	        	[
	        		'label' => esc_html__('Title', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'th_blog_carousel_blog_title_typo',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-block-title',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_title_color',
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
	        	'th_blog_carousel_blog_title_hover_color',
	        	[
	        		'label' => esc_html__( 'Title Hover Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .blog-block-title:hover' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_title_margin',
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
	        	'th_blog_carousel_hr_desc_blog',
	        	[
	        		'type' => \Elementor\Controls_Manager::DIVIDER,
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_desc_header',
	        	[
	        		'label' => esc_html__('Description', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'th_blog_carousel_blog_desc_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-description',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_desc_typography_color',
	        	[
	        		'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::COLOR,
	        		
	        		'selectors' => [
	        			'{{WRAPPER}} .th-description' => 'color: {{VALUE}}',
	        		],
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_desc_margin',
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
	        	'th_blog_carousel_hr_desc_blog_2',
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
            'th_blog_carousel_blog_meta_style_section',
	            [
	                'label' => esc_html__( 'Meta Data', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_control(
        		'th_blog_carousel_blog_meta_spacing',
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
	        		'name' => 'th_blog_carousel_blog_meta_content_typography',
	        		'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .th-blog-details .th-elem-blog-meta i,{{WRAPPER}} .th-blog-details .th-elem-blog-meta a, {{WRAPPER}} .th-blog-details .th-elem-blog-meta span',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_meta_content_colors',
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
	        	'th_blog_carousel_blog_meta_spacing_between',
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
	        	'th_blog_carousel_blog_date_meta',
	        	[
	        		'label' => esc_html__( 'Date', 'plugin-name' ),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'separator' => 'before',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_date_format',
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
            'th_blog_carousel_blog_footer_style_section',
	            [
	                'label' => esc_html__( 'Footer', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
        	$this->add_responsive_control(
        		'th_blog_carousel_footerpadding',
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
        		'th_blog_carousel_display_footer_view',
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
        		'th_blog_carousel_display_footer_author',
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
	        	'th_blog_carousel_read_more_header',
	        	[
	        		'label' => esc_html__('Read more', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_read_more_text',
	        	[
	        		'label' => esc_html__( 'Read more text', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::TEXT,
	        		'default' => '',
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'th_blog_carousel_blog_read_more_typo',
	        		'label' => esc_html__( 'Read More Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-read-more',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_read_more',
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
	        	'th_blog_carousel_footer_auther_header',
	        	[
	        		'label' => esc_html__('Author', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'th_blog_carousel_blog_author_typography',
	        		'label' => esc_html__( 'Author Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-author a',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_author_color',
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
	        	'th_blog_carousel_view_count_header',
	        	[
	        		'label' => esc_html__('View Count', 'ONE_CORE_SLUG'),
	        		'type' => \Elementor\Controls_Manager::HEADING,
	        		'seperator' => 'before'
	        	]
	        );
	        $this->add_group_control(
	        	\Elementor\Group_Control_Typography::get_type(),
	        	[
	        		'name' => 'th_blog_carousel_blog_footer_view_typo',
	        		'label' => esc_html__( 'View Typography', 'ONE_CORE_SLUG' ),
	        		'selector' => '{{WRAPPER}} .blog-view',
	        	]
	        );
	        $this->add_control(
	        	'th_blog_carousel_blog_view_color',
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
    protected function render() {

    	$slider_sl = 'ec_mc_' . rand();

		$settings = $this->get_settings_for_display();

		$json_settings = array(
			'blog_post_order' 		=> $settings['th_blog_carousel_blog_post_order'],
			'blog_arrow_position' 	=> $settings['th_blog_carousel_blog_arrow_position'],
			'blog_carousel_arrow' 	=> $settings['th_blog_carousel_blog_carousel_arrow'],
			'blog_post_count' 		=> $settings['th_blog_carousel_blog_post_count'],
			'blog_date_format' 		=> $settings['th_blog_carousel_blog_date_format'],
			'blog_read_more_text'	=> $settings['th_blog_carousel_blog_read_more_text'],
			'select_blog_columns' 	=> $settings['th_blog_carousel_select_blog_columns'],
			'select_blog_layout' 	=> $settings['th_blog_carousel_select_blog_layout'],
			'display_category' 		=> $settings['th_blog_carousel_display_category'],
			'meta_position' 		=> $settings['th_blog_carousel_meta_position'],
			'display_comments' 		=> $settings['th_blog_carousel_display_comments'],
			'display_author' 		=> $settings['th_blog_carousel_display_author'],
			'display_views' 		=> $settings['th_blog_carousel_display_views'],
			'display_date_meta' 	=> $settings['th_blog_carousel_display_date_meta'],
			'blog_show_desc' 		=> $settings['th_blog_carousel_blog_show_desc'],
			'blog_word_count' 		=> $settings['th_blog_carousel_blog_word_count'],
			// 'blog_show_views' 		=> $settings['th_blog_carousel_blog_show_views'],
			'show_blog_thumb' 		=> $settings['th_blog_carousel_show_blog_thumb'],
			// 'show_blog_views' 		=> $settings['th_blog_carousel_show_blog_views'],
			'display_footer_view' 	=> $settings['th_blog_carousel_display_footer_view'],
			'display_footer_author' => $settings['th_blog_carousel_display_footer_author'],
		);
		$args = array(
			'posts_per_page' => $settings['th_blog_carousel_blog_post_count'],
		);
		if( 'popularity' == $settings['th_blog_carousel_blog_post_order'] ){
			$args['meta_key'] = 'tophive_get_post_view';
			$args['orderby'] = 'meta_value_num';
		}

		if( $settings['th_blog_carousel_blog_post_offset'] > 0 ){
			$args['offset'] = $settings['th_blog_carousel_blog_post_offset'];
		}

		if( !empty($settings['th_blog_carousel_select_blog_categories']) ){
			$args['category__in'] = $settings['th_blog_carousel_select_blog_categories'];
		}
		?>

		<div class="ec-swiper-fixed-width">
			<div class="ec-swiper-container ec-swiper-container-<?php echo $slider_sl . ' ' . $settings['th_blog_carousel_posts_layout']; ?>" id="ec-swiper-container-<?php echo $slider_sl ?>">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper ec-dynamic-slides">
			        <!-- Slides -->
			        <?php
			        	$displayflex = $settings['th_blog_carousel_select_blog_layout'] === 'thumb-left' || $settings['th_blog_carousel_select_blog_layout'] === 'thumb-right' ? 'ec-d-md-flex' : ''; 
			        	$html = '';
						$posts = new \WP_Query($args);
							if($posts->have_posts()){
								while ($posts->have_posts()) {
									$posts->the_post();
										$html .= '<div class="swiper-slide th-blog-block ' . $displayflex .'">';
											if( $json_settings['select_blog_layout'] === 'thumb-left' ){
												/*------- Blog Thumbnail -------*/
												$html .= '<div class="ec-d-flex ec-align-items-end ec-flex-column">';
				                            		$html .= OneElementorBase::renderBlogThumb($json_settings['show_blog_thumb']);
												$html .= '</div>';

												/*--------- Blog Content ---------*/
												$html .= '<div>';
													/*--------- Blog Single body  ---------*/
													$html .= OneElementorBase::getBlogBody( $json_settings, get_the_ID() );
													/* ---------Footer -----------*/
													$html .= OneElementorBase::getBlogFooter($json_settings['display_footer_author'], $json_settings['blog_read_more_text'], $json_settings['display_footer_view']);
												$html .= '</div>';
											}elseif( $json_settings['select_blog_layout'] === 'thumb-right' ){
												/*--------- Blog Content ---------*/
												$html .= '<div class="ec-d-flex ec-align-items-end ec-flex-column">';
													/*--------- Blog Single body  ---------*/
													$html .= OneElementorBase::getBlogBody( $json_settings, get_the_ID() );
													/* ---------Footer -----------*/
													$html .= OneElementorBase::getBlogFooter($json_settings['display_footer_author'], $json_settings['blog_read_more_text'], $json_settings['display_footer_view']);
												$html .= '</div>';
												/*------- Blog Thumbnail -------*/
												$html .= '<div>';
				                            		$html .= OneElementorBase::renderBlogThumb($json_settings['show_blog_thumb']);
												$html .= '</div>';
											}else{
												/*------- Blog Thumbnail -------*/
				                        		$html .= OneElementorBase::renderBlogThumb($json_settings['show_blog_thumb']);
												/*--------- Blog Content ---------*/
												/*--------- Blog Single body  ---------*/
												$html .= OneElementorBase::getBlogBody( $json_settings, get_the_ID() );
												/* ---------Footer -----------*/
												$html .= OneElementorBase::getBlogFooter($json_settings['display_footer_author'], $json_settings['blog_read_more_text'], $json_settings['display_footer_view']);
											}
										$html .= '</div>';
								}
							}
						echo $html;
					?>
			    </div>

			    

			</div>	
			<?php if( $settings['th_blog_carousel_hide_arrow'] !== 'yes' ){ ?>
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
			<?php if( $settings['th_blog_carousel_hide_navigation'] !== 'yes' ){ ?>
				<div class="ec-swiper-pagination ec-swiper-pagination-<?php echo $slider_sl?>"></div>
			<?php } ?>
		</div>
		<script>
			jQuery(document).ready(function(){
				var THslider = new Swiper ('#ec-swiper-container-<?php echo $slider_sl; ?>', {
			    // Optional parameters
				    slidesPerView: <?php echo $settings['th_blog_carousel_select_blog_columns'] ?>,
				    spaceBetween: 20,
				    slidesPerGroup: <?php echo $settings['th_blog_carousel_per_slide'] ?>,
				    loop: false,
				    autoplay : <?php echo $settings['th_blog_carousel_autoplay'] == 'yes' ? var_export(true) : var_export(false) ?>,
				    speed: <?php echo $settings['th_blog_carousel_play_speed'] ?>,
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
					      	slidesPerView: <?php echo $settings['th_blog_carousel_select_blog_columns'] ?>,
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
