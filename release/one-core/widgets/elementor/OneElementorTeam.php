<?php 
	

	namespace ONECORE\widgets\elementor;
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	/**
	 **
	 * One elementor team class
	 * Since Version 1.0.0
	 * @package wordpress
	 * @subpackage MasterClass
	 *
	 *
	 */
	class OneElementorTeam extends \Elementor\Widget_base
	{
		public function get_title(){
			return esc_html__( 'Team', 'ONE_CORE_SLUG' );
		}
		public function get_name(){
			return 'th-team-block';
		}
		public function get_icon(){
			return 'eicon-person';
		}
		public function get_categories(){
	        return [ 'ONE_CORE_SLUG' ];
	    }
		public function get_keywords() {
			return [ 'team', 'teachers' ];
		}
		protected function register_controls(){

			/*
			** Team Content Section
			*
			* @register_controls
			*/

			$this->start_controls_section(
				'th_team_section',
				[
					'label' => esc_html__( 'Team Content', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'th_team_image',
				[
					'label' => esc_html__( 'Choose Image', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			$this->add_control(
				'th_team_title',
				[
					'label' => esc_html__( 'Name', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'John Doe', 'ONE_CORE_SLUG' ),
					'placeholder' => esc_html__( 'Type your name here', 'ONE_CORE_SLUG' ),
				]
			);
			$this->add_control(
				'th_team_designation',
				[
					'label' => esc_html__( 'Designation', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Designation', 'ONE_CORE_SLUG' ),
					'placeholder' => esc_html__( 'Designation', 'ONE_CORE_SLUG' ),
				]
			);
			$this->add_control(
				'th_team_description',
				[
					'label' => esc_html__( 'Desription', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'John Doe Creates Beautiful websites', 'ONE_CORE_SLUG' ),
					'placeholder' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
				]
			);

			// Social Profiles

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
			'th_team_social_icon',
				[
					'label' => __( 'Social Icons', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::ICON,
					'include' => [
						'fa fa-facebook',
						'fa fa-flickr',
						'fa fa-google-plus',
						'fa fa-instagram',
						'fa fa-linkedin',
						'fa fa-pinterest',
						'fa fa-reddit',
						'fa fa-twitch',
						'fa fa-twitter',
						'fa fa-vimeo',
						'fa fa-youtube',
					],
					'default' => 'fa fa-facebook',
				]
			);
			$repeater->add_control(
				'th_team_social_link', [
						'label' => esc_html__( 'Link', 'ONE_CORE_SLUG' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
					]
				);
			
			$this->add_control(
				'th_team_social_items',
				[
					'label' => esc_html__( 'Add Social Profiles', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'th_team_social_icon' => 'fa fa-facebook',
							'th_team_social_link' => 'https://www.facebook.com/facebook',
						]
					],
				]
			);

			

			$this->add_control(
				'th_team_text_align',
				[
					'label' => esc_html__( 'Alignment', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'th-text-left' => [
							'title' => esc_html__( 'Left', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-left',
						],
						'th-text-center' => [
							'title' => esc_html__( 'Center', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-center',
						],
						'th-text-right' => [
							'title' => esc_html__( 'Right', 'ONE_CORE_SLUG' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'th-text-center',
					'toggle' => true,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'th_team_section_style',
				[
					'label' => esc_html__( 'Box Styles', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'th_team_box',
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
						'{{WRAPPER}} .th-team-block' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'unit' => 'px',
						'size' => 3
					]
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'th_team_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-team-block',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'th_team_border',
					'label' => esc_html__( 'Border', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-team-block',
				]
			);
			$this->add_control(
				'th_team_color_bg',
				[
					'label' => esc_html__( 'Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .th-team-block' => 'background-color: {{VALUE}}',
					],
					'default' => '#ffffff'
				]
			);
			$this->add_control(
				'th_team_padding',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => 30,
						'right' => 30,
						'bottom' => 30,
						'left' => 30,
						'unit' => 'px',
						'isLinked' => true,
					]
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'th_team_image_style',
				[
					'label' => esc_html__( 'Image', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'hide_image_overflow',
				[
					'label' => esc_html__( 'Hide Image Overflow', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ONE_CORE_SLUG' ),
					'label_off' => __( 'Hide', 'ONE_CORE_SLUG' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'th_team_image_size',
				[
					'label' => esc_html__( 'Image Size', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 250,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .th-team-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
					],
					'default' => [
						'unit' => 'px',
						'size' => 90
					]
				]
			);
			$this->add_control(
				'th_team_image_margin',
				[
					'label' => esc_html__( 'Margin', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-thumbnail img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'th_team_bor_rad',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-thumbnail img, {{WRAPPER}} .th-team-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => 30,
						'right' => 30,
						'bottom' => 30,
						'left' => 30,
						'unit' => 'px',
						'isLinked' => true,
					]
				]
			);
			$this->end_controls_section();


			// Content Styles Section
			$this->start_controls_section(
				'th_team_content_style',
				[
					'label' => esc_html__( 'Content', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'th_team_title_head',
				[
					'label' => esc_html__( 'Title', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'th_team_title_typo',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-team-name',
				]
			);
			$this->add_control(
				'th_team_title_color',
				[
					'label' => esc_html__( 'Title Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-team-name' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'th_team_title_margin',
				[
					'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'th_team_designation_head',
				[
					'label' => esc_html__( 'Designation', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'th_team_designation_typo',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-team-designation',
				]
			);
			$this->add_control(
				'th_team_designation_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-team-designation' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_designation_margin',
				[
					'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-designation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'th_team_desc_head',
				[
					'label' => esc_html__( 'Description', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'th_team_desc_typo',
					'label' => esc_html__( 'Typography', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} .th-team-description',
				]
			);
			$this->add_control(
				'th_team_desc_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} .th-team-description' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_desc_margin',
				[
					'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .th-team-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'th_team_social_style',
				[
					'label' => esc_html__( 'Social Profiles', 'ONE_CORE_SLUG' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'th_team_social_link_color',
				[
					'label' => esc_html__( 'Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials li a i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_social_link_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials li a:hover i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_social_bg_color',
				[
					'label' => esc_html__( 'background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials li a i' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_social_font_size',
				[
					'label' => esc_html__( 'Font Size', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 8,
							'max' => 50,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials li a i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'th_team_social_br',
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
						'{{WRAPPER}} ul.th-team-socials li a i' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'th_team_social_items_padding',
				[
					'label' => esc_html__( 'Padding', 'ONE_CORE_SLUG' ),
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
						'{{WRAPPER}} ul.th-team-socials li a i' => 'padding: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'th_team_social_icons_spacing',
				[
					'label' => esc_html__( 'Spacing', 'ONE_CORE_SLUG' ),
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
						'{{WRAPPER}} ul.th-team-socials li' => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'th_team_social_items_bg',
				[
					'label' => esc_html__( 'Container Background', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'th_team_social_items_con_padding',
				[
					'label' => esc_html__( 'Container padding', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'th_team_social_border_rad',
				[
					'label' => esc_html__( 'Border Radius', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'th_team_socails_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ONE_CORE_SLUG' ),
					'selector' => '{{WRAPPER}} ul.th-team-socials',
				]
			);
			$this->add_responsive_control(
				'th_team_social_container_vertical_position',
				[
					'label' => esc_html__( 'Vertical Position', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 300,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'th_team_social_items_horizontal_position',
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
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul.th-team-socials' => 'right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

		}
		protected function tophiveTeamRepeaterAdditionalFields( $r ){
			$r->add_control(
				'th_team_additional_fields',
				[
					'label' => esc_html__( 'Additional text', 'ONE_CORE_SLUG' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'ONE_CORE_SLUG' ),
				]
			);
		}
		protected function render(){
			$team = $this->get_settings_for_display();

			$overflow = 'yes' == $team['hide_image_overflow'] ? ' o-hidden' : '';

			$html = '';
			$html .= '<div class="th-team-block '. $team['th_team_text_align'] .'">';
				$html .= '<div class="th-team-thumbnail'. $overflow .'">';
					$html .= '<img src="' . $team['th_team_image']['url'] . '" alt="team-people">';
				$html .= '</div>';
				$html .= '<div class="th-team-name">';
					$html .= $team['th_team_title'];
				$html .= '</div>';
				$html .= '<div class="th-team-designation">';
					$html .= $team['th_team_designation'];
				$html .= '</div>';
				$html .= '<div class="th-team-description">';
					$html .= $team['th_team_description'];
				$html .= '</div>';
				if( !empty($team['th_team_social_items']) ){
					$html .= '<ul class="th-team-socials">';
						foreach ($team['th_team_social_items'] as $item) {
							$html .= '<li><a href="'. $item['th_team_social_link'] .'"><i class="'. $item['th_team_social_icon'] .'"></i></a></li>';
						}
					$html .= '</ul>';
				}

			$html .= '</div>';

			echo $html;
		}
		
	}

?>
