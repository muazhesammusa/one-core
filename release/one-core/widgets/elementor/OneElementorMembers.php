<?php
namespace ONECORE\widgets\elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OneElementorMembers extends Widget_Base {

    public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		// Ensure BuddyPress is active before trying to load its assets
        if (function_exists('buddypress')) {
            wp_enqueue_style(
                'bp-nouveau',
                plugins_url('buddypress/bp-templates/bp-nouveau/css/buddypress.min.css'),
                [],
                '14.3.4'
            );
        }
	}

	public function get_name() {
		return 'th-buddypress-members';
	}

	public function get_title() {
		return __( 'BuddyPress Members', 'your-plugin' );
	}

	public function get_icon() {
		return 'eicon-users';
	}

	public function get_categories() {
		return [ 'th-buddyrpess' ];
	}

    public function get_style_depends(){
        return ['bp-nouveau'];
    }

	public function get_keywords() {
		return [ 'buddypress', 'members', 'profile', 'community' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'your-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'members_count',
			[
				'label' => __( 'Number of Members', 'your-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'placeholder' => '6',
			]
		);

		$this->add_control('columns', [
            'label' => __('Columns', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 3,
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 6,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .buddypress-wrap .grid.bp-list.members-list' => 'grid-template-columns: repeat({{SIZE}}, 1fr); display: grid;',
            ],
        ]);

        $this->add_control('columns_gap', [
            'label' => __('Columns gap', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 60,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .buddypress-wrap .grid.bp-list.members-list' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        

		$this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => __( 'Box Styles', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap',
            ]
        );
        
        $this->add_responsive_control(
            'box_height',
            [
                'label' => __( 'Height', 'your-plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->start_controls_tabs( 'box_style_tabs' );
        
        $this->start_controls_tab( 'box_normal', [ 'label' => __( 'Normal', 'your-plugin' ) ] );
        
        $this->add_control(
            'box_radius_normal',
            [
                'label' => __( 'Border Radius', 'your-plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_normal',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'box_hover', [ 'label' => __( 'Hover', 'your-plugin' ) ] );
        
        $this->add_control(
            'box_radius_hover',
            [
                'label' => __( 'Border Radius (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap:hover',
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        /**
         * 2. Cover Image
         */
        $this->start_controls_section(
            'cover_image_style',
            [
                'label' => __( 'Cover Image', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'cover_height',
            [
                'label' => __( 'Height', 'your-plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #buddypress .members-list > li .list-wrap .item-cover-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        
        $this->add_control(
            'cover_radius',
            [
                'label' => __( 'Border Radius', 'your-plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} #buddypress .members-list > li .list-wrap .item-cover-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        
        /**
         * 3. Avatar
         */
        $this->start_controls_section(
            'avatar_style',
            [
                'label' => __( 'Avatar', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'avatar_size',
            [
                'label' => __( 'Size', 'your-plugin' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap .item-avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'avatar_radius',
            [
                'label' => __( 'Border Radius', 'your-plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap .item-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'avatar_margin',
            [
                'label' => __( 'Margin (Top & Left)', 'your-plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap .item-avatar img' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'avatar_shadow',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap .item-avatar img',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'avatar_border',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap .item-avatar img',
            ]
        );
        $this->end_controls_section();
        
        /**
         * 4. Name
         */
        $this->start_controls_section(
            'name_style',
            [
                'label' => __( 'Member Name', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'selector' => '{{WRAPPER}} .directory.members #members-list li .list-wrap .list-title.member-name a',
            ]
        );
        
        $this->start_controls_tabs( 'name_color_tabs' );
        
        $this->start_controls_tab( 'name_normal', [ 'label' => __( 'Normal', 'your-plugin' ) ] );
        $this->add_control(
            'name_color_normal',
            [
                'label' => __( 'Text Color', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap .list-title.member-name a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'name_hover', [ 'label' => __( 'Hover', 'your-plugin' ) ] );
        $this->add_control(
            'name_color_hover',
            [
                'label' => __( 'Text Color (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .directory.members #members-list li .list-wrap .list-title.member-name a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        /**
         * 5. User Facts
         */
        $this->start_controls_section(
            'user_facts_style',
            [
                'label' => __( 'User Facts', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count_typo',
                'label' => 'Count Typography',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .user-facts p span:first-of-type',
            ]
        );
        
        $this->add_control(
            'count_color',
            [
                'label' => 'Count Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .user-facts p span:first-of-type' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typo',
                'label' => 'Label Typography',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .user-facts p span:last-of-type',
            ]
        );
        
        $this->add_control(
            'label_color',
            [
                'label' => 'Label Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .user-facts p span:last-of-type' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'follow_btn_style',
            [
                'label' => __( 'Follow Button', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'follow_btn_tabs' );
        
        // Normal
        $this->start_controls_tab(
            'follow_btn_normal',
            [
                'label' => __( 'Normal', 'your-plugin' ),
            ]
        );
        
        $this->add_control(
            'follow_btn_text_color',
            [
                'label' => __( 'Text Color', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'follow_btn_bg_color',
            [
                'label' => __( 'Background Color', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'follow_btn_border',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'follow_btn_shadow',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button',
            ]
        );
        
        $this->end_controls_tab();
        
        // Hover
        $this->start_controls_tab(
            'follow_btn_hover',
            [
                'label' => __( 'Hover', 'your-plugin' ),
            ]
        );
        
        $this->add_control(
            'follow_btn_text_color_hover',
            [
                'label' => __( 'Text Color (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_control(
            'follow_btn_bg_color_hover',
            [
                'label' => __( 'Background Color (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'follow_btn_border_hover',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button:hover',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'follow_btn_shadow_hover',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button:hover',
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    
        // ** MESSAGE BUTTON **

        $this->start_controls_section(
            'message_btn_style',
            [
                'label' => __( 'Message Button', 'your-plugin' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'message_btn_tabs' );
        
        // Normal
        $this->start_controls_tab(
            'message_btn_normal',
            [
                'label' => __( 'Normal', 'your-plugin' ),
            ]
        );
        
        $this->add_control(
            'message_btn_text_color',
            [
                'label' => __( 'Text Color', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button)' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'message_btn_bg_color',
            [
                'label' => __( 'Background Color', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button)' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'message_btn_border',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button)',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'message_btn_shadow',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button)',
            ]
        );
        
        $this->end_controls_tab();
        
        // Hover
        $this->start_controls_tab(
            'message_btn_hover',
            [
                'label' => __( 'Hover', 'your-plugin' ),
            ]
        );
        
        $this->add_control(
            'message_btn_text_color_hover',
            [
                'label' => __( 'Text Color (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button):hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'message_btn_bg_color_hover',
            [
                'label' => __( 'Background Color (Hover)', 'your-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button):hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'message_btn_border_hover',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button):hover',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'message_btn_shadow_hover',
                'selector' => '{{WRAPPER}} .buddypress-wrap .members-list li .members-action-buttons a:not(.bp-th-follow-button):hover',
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $members_count = $settings['members_count'];



        bp_nouveau_before_loop(); ?>

        <div class="directory members tophive-buddypress-members">
            <div id="buddypress" class="buddypress-wrap one bp-dir-hori-nav">
                
                <div id="members-dir-list" class="members dir-list" data-bp-list="members" style="">
                    <?php if ( bp_get_current_member_type() ) : ?>
                        <p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
                    <?php endif; ?>

                    <?php if ( bp_has_members( [ 'per_page' => $members_count ] ) ) : ?>

                        <?php bp_nouveau_pagination( 'top' ); ?>

                        <ul id="members-list" class="item-list members-list bp-list grid">

                        <?php while ( bp_members() ) : bp_the_member(); ?>

                            <li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
                                <div class="list-wrap">
                                    <?php
                                        $member_cover_image_url = bp_attachments_get_attachment('url', array(
                                            'object_dir' => 'members',
                                            'item_id' => bp_get_member_user_id(),
                                        ));
                                    ?>
                                    <div class="item-media-wrap">
                                        <?php 
                                            if( empty($member_cover_image_url) ){ 
                                                $member_cover_image_url = 'https://i.ibb.co/dbDssWW/placeholder.png';
                                            }
                                        ?>
                                        <div class="item-cover-img">
                                            <img src="<?php echo tophive_sanitize_filter($member_cover_image_url); ?>" alt="bp-member-cover">
                                        </div>
                                        <div class="item-avatar">
                                            <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
                                        </div>
                                    </div>
                                    

                                    <div class="item">

                                        <div class="item-block">

                                            <h2 class="list-title member-name">
                                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                                            </h2>
                                            <?php 
                                                if( get_user_meta( bp_get_member_user_id(), 'designation', true ) ){
                                                    ?>
                                                        <p class="bp-user-designation"><small><?php echo get_user_meta( bp_get_member_user_id(), 'designation', true ); ?></small></p>
                                                    <?php
                                                }
                                            ?>
                                            <?php if ( bp_nouveau_member_has_meta() ) : ?>
                                                <p class="item-meta last-activity">
                                                    <?php bp_nouveau_member_meta(); ?>
                                                </p><!-- .item-meta -->
                                            <?php endif; ?>

                                            <div class="item-extra-content">
                                                <?php bp_nouveau_member_extra_content() ; ?>
                                            </div><!-- .item-extra-content -->
                                        
                                        </div>

                                    </div><!-- // .item -->
                                </div>
                            </li>

                        <?php endwhile; ?>

                        </ul>

                        <?php bp_nouveau_pagination( 'bottom' ); ?>

                    <?php
                    else :

                        bp_nouveau_user_feedback( 'members-loop-none' );

                    endif;
                    ?>

                </div>
            </div>
        </div>

        <?php bp_nouveau_after_loop(); ?>
        <?php
	}
}
