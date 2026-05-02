<?php
namespace ONECORE\widgets\elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OneElementorGroups extends Widget_Base
{
    public function get_name()
    {
        return 'th-buddypress-groups2';
    }

    public function get_title()
    {
        return __('One BuddyPress Groups', 'text-domain');
    }

    public function get_icon()
    {
        return 'eicon-posts-group';
    }

    public function get_keywords() {
		return [ 'groups' ];
	}

    public function get_categories()
    {
        return [ 'ONE_CORE_SLUG' ];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'text-domain'),
        ]);

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
                '{{WRAPPER}} .tophive-buddypress-groups #groups-list' => 'grid-template-columns: repeat({{SIZE}}, 1fr); display: grid;',
            ],
        ]);
        
        $this->add_control('per_page', [
            'label' => __('Groups Per Page', 'text-domain'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
        ]);

        $this->add_control('default_cover', [
            'label' => __('Default Cover Image', 'text-domain'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'description' => __('Select a fallback cover image for groups without a cover.', 'text-domain'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]);
        

        $this->end_controls_section();

        // Card Style Section
        $this->start_controls_section('section_card', [
            'label' => __('Card', 'text-domain'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_control('card_padding', [
            'label' => __('Padding', 'text-domain'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('gap', [
            'label' => __('Gap Between Cards', 'text-domain'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 100],
            ],
            'default' => [
                'size' => 20,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .tophive-buddypress-groups #groups-list' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);        
        
        $this->add_control('card_radius', [
            'label' => __('Border Radius', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .list-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'label' => __('Background', 'text-domain'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .list-wrap',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => __('Border', 'text-domain'),
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .list-wrap',
            ]
        );
        $this->add_control('cover_heading', [
            'label' => __('Cover', 'text-domain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('cover_height', [
            'label' => __('Cover Image Height', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .item-cover-img img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover; width: 100%;',
            ],
        ]);
        $this->add_control('cover_radius', [
            'label' => __('Cover Border Radius', 'text-domain'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .item-cover-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        

        $this->add_control('avatar_heading', [
            'label' => __('Avatar', 'text-domain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);        
        
        $this->add_control('avatar_size', [
            'label' => __('Avatar Width/Height', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} #buddypress .item-avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        $this->add_control('avatar_radius', [
            'label' => __('Avatar Border Radius', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} #buddypress .item-avatar img' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('avatar_offset_x', [
            'label' => __('Avatar Position X', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'default' => ['size' => 0],
            'selectors' => [
                '{{WRAPPER}}' => '--avatar-x: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        $this->add_control('avatar_offset_y', [
            'label' => __('Avatar Position Y', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -200,
                    'max' => 200,
                ],
            ],
            'default' => ['size' => 0],
            'selectors' => [
                '{{WRAPPER}}' => '--avatar-y: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        
        $this->end_controls_section();
        
        // GROUPS NAME
        $this->start_controls_section('section_group_name', [
            'label' => __('Group Name', 'text-domain'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'group_name_typography',
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .groups-title',
            ]
        );
        
        $this->add_control('group_name_color', [
            'label' => __('Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .groups-title a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('group_name_color_hover', [
            'label' => __('Hover Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .groups-title a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->end_controls_section();
        // GROUPS META
        
        $this->start_controls_section('section_group_meta', [
            'label' => __('Group Meta', 'text-domain'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_control('show_group_meta', [
            'label' => __('Show Group Meta', 'text-domain'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'group_meta_typography',
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-details',
            ]
        );
        
        $this->add_control('group_meta_color', [
            'label' => __('Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-details' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->end_controls_section();

        // MEMBERS AVATAR
        $this->start_controls_section('section_group_members', [
            'label' => __('Group Members Avatars', 'text-domain'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_control('show_members_avatars', [
            'label' => __('Show Members Avatars', 'text-domain'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        
        $this->add_control('members_avatar_size', [
            'label' => __('Avatar Size', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-members-dp img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        $this->add_control('members_avatar_radius', [
            'label' => __('Avatar Border Radius', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-members-dp img' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        $this->add_control('members_spacing', [
            'label' => __('Translate X', 'text-domain'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-members-dp img' => 'transform: translateX({{SIZE}}{{UNIT}});',
            ],
        ]);
        
        $this->add_control('members_avatar_margin', [
            'label' => __('Members Avatar Margin', 'text-domain'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-members-dp img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'members_avatar_border',
                'label' => __('Members Avatar Border', 'text-domain'),
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-members-dp img',
            ]
        );
        
        
        
        $this->end_controls_section();

        // BUTTON
        $this->start_controls_section('section_join_button', [
            'label' => __('Join Group Button', 'text-domain'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_control('show_join_button', [
            'label' => __('Show Join Button', 'text-domain'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'join_button_typography',
                'selector' => '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button',
            ]
        );
        
        $this->start_controls_tabs('join_button_tabs');
        
        $this->start_controls_tab('join_button_normal', [
            'label' => __('Normal', 'text-domain'),
        ]);
        
        $this->add_control('join_button_text_color', [
            'label' => __('Text Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->add_control('join_button_background', [
            'label' => __('Background Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button' => 'background-color: {{VALUE}};',
            ],
        ]);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('join_button_hover', [
            'label' => __('Hover', 'text-domain'),
        ]);
        
        $this->add_control('join_button_hover_text_color', [
            'label' => __('Text Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button:hover' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->add_control('join_button_hover_background', [
            'label' => __('Background Color', 'text-domain'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_control('join_button_padding', [
            'label' => __('Button Padding', 'text-domain'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} #buddypress .groups-list > li.item-entry .group-loops-footer .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();
        
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $columns = !empty($settings['columns']) ? $settings['columns'] : 3;
        $per_page = !empty($settings['per_page']) ? $settings['per_page'] : 6;

        ?>
        <div id="buddypress" class="buddypress buddypress-wrap tophive-buddypress-groups">
            <?php

            $args = [
                'per_page' => $per_page,
            ];

            if (bp_has_groups($args)) :

                bp_nouveau_pagination('top');
                ?>
                <ul id="groups-list" class="item-list groups-list bp-list">
                    <?php
                    while (bp_groups()) :
                        bp_the_group();
                        ?>
                        <li <?php bp_group_class(['item-entry']); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
                            <div class="list-wrap">
                                <?php
                                $group_cover_image_url = bp_attachments_get_attachment('url', [
                                    'object_dir' => 'groups',
                                    'item_id' => bp_get_group_id(),
                                    'type' => 'cover-image',
                                ]);
                                
                                // Fallback to Elementor control if cover is missing
                                if (empty($group_cover_image_url) && !empty($settings['default_cover']['url'])) {
                                    $group_cover_image_url = $settings['default_cover']['url'];
                                }
                                
                                ?>
                                <div class="item-media-wrap">
                                    <div class="item-cover-img">
                                        <img src="<?php echo esc_url($group_cover_image_url); ?>" alt="<?php esc_attr_e('Group Cover', 'text-domain'); ?>">
                                    </div>
                                    <?php if (!bp_disable_group_avatar_uploads()) : ?>
                                        <div class="item-avatar">
                                            <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar(bp_nouveau_avatar_args()); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="item">
                                    <div class="item-block">
                                        <h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>

                                        
                                        <?php if ($settings['show_group_meta'] == 'yes') : ?>
                                            <?php if (bp_nouveau_group_has_meta()) : ?>
                                                <p class="item-meta group-details"><?php bp_nouveau_group_meta(); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                                
                                        <div class="group-loops-footer">
                                                    
                                            <?php if ($settings['show_members_avatars'] == 'yes') : ?>
                                                <div class="group-members-dp">
                                                    <?php
                                                    $args = [
                                                        'group_id' => bp_get_group_id(),
                                                        'exclude_admins_mods' => false,
                                                    ];
                                                    $group_members_result = groups_get_group_members($args);
                                                    $group_members = $group_members_result['members'] ?? [];

                                                    $i = 0;
                                                    foreach ($group_members as $member) {
                                                        if ($i <= 3) {
                                                            echo get_avatar($member->ID, 25);
                                                        }
                                                        $i++;
                                                    }
                                                    $total_members = count($group_members);
                                                    $remaining = $total_members > 4 ? (int) $total_members - 4 : '';
                                                    if ($remaining) {
                                                        echo '<span class="remaining">+' . esc_html($remaining) . '</span>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($settings['show_join_button'] == 'yes') : ?>
                                                <?php bp_nouveau_groups_loop_buttons(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="group-desc">
                                        <p><?php bp_nouveau_group_description_excerpt(); ?></p>
                                    </div>

                                    <?php bp_nouveau_groups_loop_item(); ?>
                                </div>

                            </div>
                        </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
                <?php
                bp_nouveau_pagination('bottom');

            else :
                bp_nouveau_user_feedback('groups-loop-none');
            endif;
            ?>
        </div>
        <?php
    }
}
