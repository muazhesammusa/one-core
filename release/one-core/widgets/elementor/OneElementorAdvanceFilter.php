<?php

namespace ONECORE\widgets\elementor;

class OneElementorAdvanceFilter extends \Elementor\Widget_Base {

    public function get_name(){
        return 'thcoursesadvancedfilter';
    }
    public function get_title(){
        return esc_html__( 'Advanced Course Filter', 'ONE_CORE_SLUG' );
    }
    public function get_icon(){
        return 'eicon-search-results';
    }
    public function get_categories(){
        return [ 'ONE_CORE_SLUG' ];
    }
    protected function register_controls() {

    	/*
    	*
    	* ----------- Content Tab Starts ----------
    	*
		** Course Advanced Filter Settings
		** @package Masterclass
		** @subpackage Elementor
		*
		*
    	*/
		$this->start_controls_section(
			'filter_content_section',
				[
					'label' => esc_html__( 'Advanced Filter', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'filter_show_count',
				[
					'label' => esc_html__( 'Show Filter Count', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_sort',
				[
					'label' => esc_html__( 'Show Sort By Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_categories',
				[
					'label' => esc_html__( 'Show Category Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_level',
				[
					'label' => esc_html__( 'Show Level Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_skills',
				[
					'label' => esc_html__( 'Show Skills FIlter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_price',
				[
					'label' => esc_html__( 'Show Price Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'filter_show_rating',
				[
					'label' => esc_html__( 'Show Rating Filter', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			
		$this->end_controls_section();

        /*
    	*
    	* ----------- Style Tab Starts ----------
    	*
		*
    	*/
	    $this->start_controls_section(
            'dd_btn_style_section',
	            [
	                'label' => esc_html__( 'Dropdown Button Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
		    $this->add_group_control(
		    	\Elementor\Group_Control_Typography::get_type(),
		    	[
		    		'name' => 'filter_dd_typo',
		    		'label' => esc_html__( 'Typography', 'plugin-domain' ),
		    		
		    		'selector' => '{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle',
		    	]
		    );
		    $this->add_control(
		    	'filter_dd_color',
		    	[
		    		'label' => esc_html__( 'Color', 'plugin-domain' ),
		    		'type' => \Elementor\Controls_Manager::COLOR,
		    		
		    		'selectors' => [
		    			'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle' => 'color: {{VALUE}}',
		    		],
		    		'default' => '#888'
		    	]
		    );
	    	$this->add_control(
	    		'filter_dd_margin',
	    		[
	    			'label' => esc_html__( 'Filter Dropdown Margin', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::DIMENSIONS,
	    			'size_units' => [ 'px', '%', 'em' ],
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	    			],
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_padding',
	    		[
	    			'label' => esc_html__( 'Filter Dropdown Padding', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::DIMENSIONS,
	    			'size_units' => [ 'px', '%', 'em' ],
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	    			],
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_br',
	    		[
	    			'label' => esc_html__( 'Border Radius', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::DIMENSIONS,
	    			'size_units' => [ 'px', '%', 'em' ],
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	    			],
	    		]
	    	);
	    	$this->add_group_control(
	    		\Elementor\Group_Control_Border::get_type(),
	    		[
	    			'name' => 'filter_dd_border',
	    			'label' => __( 'Border', 'plugin-domain' ),
	    			'selector' => '{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle',
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_bg',
	    		[
	    			'label' => esc_html__( 'Background Color', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::COLOR,
	    			
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle' => 'background-color: {{VALUE}}',
	    			],
	    			'default' => '#fff'
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_bg_hover',
	    		[
	    			'label' => esc_html__( 'Hover Background Color', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::COLOR,
	    			
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle:hover' => 'background-color: {{VALUE}}',
	    			],
	    		]
	    	);
	    	$this->add_group_control(
	    		\Elementor\Group_Control_Box_Shadow::get_type(),
	    		[
	    			'name' => 'filter_dd_box_shadow',
	    			'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
	    			'selector' => '{{WRAPPER}}  .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle',
	    		]
	    	);
	    	$this->add_group_control(
	    		\Elementor\Group_Control_Box_Shadow::get_type(),
	    		[
	    			'name' => 'filter_dd_box_shadow_hover',
	    			'label' => esc_html__( 'Hover Box Shadow', 'plugin-domain' ),
	    			'selector' => '{{WRAPPER}}  .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter-toggle:hover',
	    		]
	    	);
        $this->end_controls_section();
	    $this->start_controls_section(
            'dd_btn_select_style_section',
	            [
	                'label' => esc_html__( 'Dropdown Select Style', 'ONE_CORE_SLUG' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	    	$this->add_control(
	    		'filter_dd_select_container_padding',
	    		[
	    			'label' => esc_html__( 'Filter Dropdown Container Padding', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::DIMENSIONS,
	    			'size_units' => [ 'px', '%', 'em' ],
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	    			],
	    		]
	    	);
	    	$this->add_group_control(
	    		\Elementor\Group_Control_Border::get_type(),
	    		[
	    			'name' => 'filter_dd_select_border',
	    			'label' => __( 'Border', 'plugin-domain' ),
	    			'selector' => '{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter',
	    		]
	    	);
	    	$this->add_group_control(
	    		\Elementor\Group_Control_Box_Shadow::get_type(),
	    		[
	    			'name' => 'filter_dd_select_container_box_shadow',
	    			'label' => esc_html__( 'Container Box Shadow', 'plugin-domain' ),
	    			'selector' => '{{WRAPPER}}  .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter',
	    		]
	    	);

	    	$this->add_control(
	    		'filter_dd_select_container_bg',
	    		[
	    			'label' => esc_html__( 'Container Background Color', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::COLOR,
	    			
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter' => 'background-color: {{VALUE}}',
	    			],
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_select_br',
	    		[
	    			'label' => esc_html__( 'Border Radius', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::DIMENSIONS,
	    			'size_units' => [ 'px', '%', 'em' ],
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	    			],
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_item_styling',
	    		[
	    			'label' => esc_html__( 'Dropdown Item Styling', 'plugin-name' ),
	    			'type' => \Elementor\Controls_Manager::HEADING,
	    			'separator' => 'before',
	    		]
	    	);
		    $this->add_group_control(
		    	\Elementor\Group_Control_Typography::get_type(),
		    	[
		    		'name' => 'filter_dd_select_typo',
		    		'label' => esc_html__( 'Typography', 'plugin-domain' ),
		    		
		    		'selector' => '{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter li',
		    	]
		    );
		    $this->add_control(
		    	'filter_dd_select_color',
		    	[
		    		'label' => esc_html__( 'Dropdown Item Color', 'plugin-domain' ),
		    		'type' => \Elementor\Controls_Manager::COLOR,
		    		
		    		'selectors' => [
		    			'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter li' => 'color: {{VALUE}}',
		    		],
		    	]
		    );
		    $this->add_control(
		    	'filter_dd_select_color_active',
		    	[
		    		'label' => esc_html__( 'Selected Item Color', 'plugin-domain' ),
		    		'type' => \Elementor\Controls_Manager::COLOR,
		    		
		    		'selectors' => [
		    			'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter li.selected' => 'color: {{VALUE}}',
		    		],
		    	]
		    );
	    	
	    	$this->add_control(
	    		'filter_dd_select_bg_color',
	    		[
	    			'label' => esc_html__( 'Item Background Color', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::COLOR,
	    			
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter li' => 'background-color: {{VALUE}}',
	    			],
	    		]
	    	);
	    	$this->add_control(
	    		'filter_dd_select_bg_selected_color',
	    		[
	    			'label' => esc_html__( 'Selected Item Background Color', 'plugin-domain' ),
	    			'type' => \Elementor\Controls_Manager::COLOR,
	    			
	    			'selectors' => [
	    				'{{WRAPPER}} .tophive-advanced-filter.tophive-advanced-filter-dropdown button.th-exclusive-course-filter li.selected' => 'background-color: {{VALUE}}',
	    			],
	    		]
	    	);
        $this->end_controls_section();
	}
    protected function render() {
    	$topics = get_terms( 'course_tag' );
    	$categories = get_terms( 'course_category' );
    	$uniqID = 'ec_mc_' . rand();

		$settings = $this->get_settings_for_display();

		$html = '';

		// if( 'yes' == $settings['filter_show_count'] ){
		// 	$html .= '<p class="advanced-filter-search-results ec-font-weight-bold">'. sprintf(esc_html__( 'Found %s courses', 'tophive' ), $num ) . '</p>';
		// }
		if( 'yes' == $settings['filter_show_sort'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/sort', '' );
		}
		if( 'yes' == $settings['filter_show_categories'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/category', $categories );
		}
		if( 'yes' == $settings['filter_show_level'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/level', '' );
		}
		if( 'yes' == $settings['filter_show_skills'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/topic', $topics );
		}
		if( 'yes' == $settings['filter_show_price'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/price', '' );
		}
		if( 'yes' == $settings['filter_show_rating'] ){
			$html .= apply_filters( 'tophive/learnpress/filter/rating', '' );
		}
		echo $html;
    }
    
}
