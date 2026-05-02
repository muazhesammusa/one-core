<?php

namespace ONECORE\widgets\elementor;

class OneElementorCourseCategory extends \Elementor\Widget_Base {
	public function get_name(){
        return 'thcoursescategory';
    }
    public function get_title(){
        return esc_html__( 'LP Course Category', 'ONE_CORE_SLUG' );
    }
    public function get_icon(){
        return 'eicon-single-post';
    }
    public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
    protected function register_controls() {
    	$this->start_controls_section(
			'content_section',
				[
					'label' => esc_html__( 'Course Category', 'ONE_CORE_SLUG' ),
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
				'select_columns',
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
					'default' => 'ec-col-md-4',
				]
			);
			$this->add_control(
				'category_count',
				[
					'label' => esc_html__( 'Category Count', 'ONE_CORE_SLUG' ),
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
	        	'show_course_count',
	        	[
	        		'label' => esc_html__( 'Show Course Count', 'ONE_CORE_SLUG' ),
	        		'type' => \Elementor\Controls_Manager::SWITCHER,
	        		'label_on' => esc_html__( 'Show', 'ONE_CORE_SLUG' ),
	        		'label_off' => esc_html__( 'Hide', 'ONE_CORE_SLUG' ),
	        		'return_value' => 'yes',
	        		'default' => 'yes',
	        	]
	        );
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_style',
				[
					'label' => esc_html__( 'Category Box', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'category_box_layout',
				[
					'label' => esc_html__( 'Select Layout', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'img-top',
					'options' => [
						'img-top'  => esc_html__( 'Image Top', 'ONE_CORE_SLUG' ),
						'img-left'  => esc_html__( 'Image Left', 'ONE_CORE_SLUG' ),
						'img-right'  => esc_html__( 'Image Right', 'ONE_CORE_SLUG' ),
					],
				]
			);
			$this->start_controls_tabs(
				'filter_content_box'
			);
				$this->start_controls_tab(
					'filter_content_box_normal',
						[
							'label' => esc_html__( 'Normal', 'ONE_CORE_SLUG' ),
						]
					);
					$this->add_control(
						'box_margin',
						[
							'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-category-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
					$this->add_control(
						'box_padding',
						[
							'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-category-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'box_border',
							'label' => __( 'Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-category-grid',
						]
					);
					$this->add_control(
						'box_br',
						[
							'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px' ],
							'selectors' => [
								'{{WRAPPER}} .th-course-category-grid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
					$this->add_control(
						'category_box_align',
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
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow_normal',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-category-grid',
						]
					);
				$this->end_controls_tab();				
				$this->start_controls_tab(
					'filter_content_box_hover',
						[
							'label' => esc_html__( 'Hover', 'ONE_CORE_SLUG' ),
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow_hover',
							'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-category-grid:hover',
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'box_border_hover',
							'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
							'selector' => '{{WRAPPER}} .th-course-category-grid:hover, {{WRAPPER}} .th-course-category-grid:hover .th-course-category-content',
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_image_style',
				[
					'label' => esc_html__( 'Image', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'thumb_height',
				[
					'label' => esc_html__( 'Thumbnail Height', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-thumb' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thumb_width',
				[
					'label' => esc_html__( 'Thumbnail Width', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-thumb' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thumb_img_height',
				[
					'label' => esc_html__( 'Icon/Image size', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-thumb img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'thumb_bg_width',
				[
					'label' => esc_html__( 'Background Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-thumb' => 'background-color: {{VALUE}}',
					],
					'default' => 'transparent'
				]
			);
			$this->add_control(
				'thumb_br',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();


		$this->start_controls_section(
			'content_section_content_style',
				[
					'label' => esc_html__( 'Content', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'elem_padding',
				[
					'label' => esc_html__( 'Content Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'label' => __( 'Content Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-course-category-grid .th-course-category-content',
				]
			);
			$this->add_control(
				'content_br',
				[
					'label' => esc_html__( 'Content Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'title_section_heading',
				[
					'label' => esc_html__( 'Category Title', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .th-course-category-grid .th-course-category-content h3',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content h3' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'title_hover_color',
				[
					'label' => esc_html__( 'Title Hover Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid:hover .th-course-category-content h3' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'title_padding',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'course_category_count_heading',
				[
					'label' => esc_html__( 'Course Counts', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'count_typography',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					
					'selector' => '{{WRAPPER}} .th-course-category-grid .th-course-category-content .course-count',
				]
			);
			$this->add_control(
				'count_color',
				[
					'label' => esc_html__( 'Course Count Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content .course-count' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'count_padding',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-course-category-grid .th-course-category-content .course-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
    }
    protected function render(){
    	$settings = $this->get_settings_for_display();
    	$columns = $settings['select_columns'];
    	$term_course_category = get_terms( 'course_category', array(
		    'hide_empty' => false,
		));

		if(is_wp_error($term_course_category)){
			return;
		}

    	$html = '<div class="ec-row">';
    	if( !empty($term_course_category) ){
    		$i = 0;
    		foreach ($term_course_category as $category) {
    			if( $i < $settings['category_count'] ){ 
	    			$image_id = get_term_meta ( $category->term_id, 'category-image-id', true );
		    		if( $category->count > 0 ){
		    			$html .= '<div class="'. $columns .'">';
			    			$html .= '<div class="th-course-category-grid '. $settings['category_box_align'] .'">';
			    				$html .= '<a href="'. get_term_link( $category->term_id ) .'" class="'. $settings['category_box_layout'] .'">';
				    				if( 'yes' == $settings['thumbnail_show_hide'] ){
					    				if( $image_id ){ 
					    					$html .= '<div class="th-course-category-thumb">';
					    						$html .= wp_get_attachment_image ( $image_id, 'thumbnail' );
						    				$html .= '</div>';
					    				}
				    				}

			    					$html .= '<div class="th-course-category-content">';
						    			$html .= '<h3>'. $category->name .'</h3>';		
						    			if( !empty($category->description && ('yes' == $settings['show_desc']) )){
						    				$html .= '<p>'. $category->description .'</p>';		
						    			}
						    			if( 'yes' == $settings['show_course_count'] ){
						    				$html .= '<p class="course-count">'. $category->count . esc_html__( ' Courses', 'ONE_CORE_SLUG' ) .'</p>';		
						    			}
			    					$html .= '</div>';
					    		$html .= '</a>';
				    		$html .= '</div>';
			    		$html .= '</div>';
		    		}
	    		}
	    		$i++;
    		}

    	}
    	$html .= '</div>';
    	echo $html;
    }
}
