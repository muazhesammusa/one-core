<?php

namespace ONECORE\widgets\elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

class OneElementorActivity extends Widget_Base
{
  public function get_name()
  {
    return 'th-buddypress-activity';
  }

  public function get_title()
  {
    return __('One BuddyPress Activity', 'text-domain');
  }

  public function get_icon()
  {
    return 'eicon-posts-group';
  }

  public function get_keywords()
  {
    return ['activity', 'buddypress'];
  }

  public function get_script_depends(): array
  {
    return ['th-buddyrpess'];
  }

  public function get_categories()
  {
    return ['ONE_CORE_SLUG'];
  }

  protected function register_controls()
  {
    /** Content Controls */
    $this->start_controls_section('content_section', [
      'label' => __('Content', 'text-domain'),
    ]);

    $this->add_control('per_page', [
      'label' => __('Activities Per Page', 'text-domain'),
      'type' => Controls_Manager::SLIDER,
      'default' => [
        'size' => 5,
      ],
      'range' => [
        'px' => ['min' => 1, 'max' => 50],
      ],
    ]);

    $this->add_control('show_media', [
      'label' => __('Show Media in Activity', 'text-domain'),
      'type' => Controls_Manager::SWITCHER,
      'default' => 'yes',
    ]);

    $this->add_control('show_share', [
      'label' => __('Show Share Activity', 'text-domain'),
      'type' => Controls_Manager::SWITCHER,
      'default' => 'yes',
    ]);

    $this->end_controls_section();

    /** Style Controls */
    $this->start_controls_section('section_activity_card', [
      'label' => __('Activity Card', 'text-domain'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]);

    $this->add_control('activity_card_padding', [
      'label' => __('Padding', 'text-domain'),
      'type'  => Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #activity-stream .activity-list.bp-list .activity-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'activity_card_border',
        'selector' => '{{WRAPPER}} #activity-stream .activity-list.bp-list .activity-item',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'activity_card_bg',
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} #activity-stream .activity-list.bp-list .activity-item',
      ]
    );

    $this->end_controls_section();

    /** Avatar Style */
    $this->start_controls_section('section_activity_avatar', [
      'label' => __('Activity Avatar', 'text-domain'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]);

    $this->add_control('activity_avatar_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type'  => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} #buddypress .item-avatar img' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
      ],
    ]);

    $this->add_control('activity_avatar_spacing', [
      'label' => __('Spacing (Margin)', 'text-domain'),
      'type'  => Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #buddypress .item-avatar img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->end_controls_section();

    // Header section
    $this->start_controls_section('section_activity_header', [
      'label' => __('Activity Header', 'text-domain'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]);

    $this->add_control('activity_title_heading', [
      'label' => __('Title', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'activity_title_typography',
        'selector' => '{{WRAPPER}} .activity-list .activity-item .activity-header a',
      ]
    );

    $this->add_control('activity_title_color', [
      'label'     => __('Color', 'text-domain'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .activity-list .activity-item .activity-header a' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('activity_meta_heading', [
      'label' => __('Meta', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'activity_meta_typography',
        'selector' => '{{WRAPPER}} .activity-list .activity-item .activity-content p',
      ]
    );

    $this->add_control('activity_meta_color', [
      'label'     => __('Color', 'text-domain'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .activity-list .activity-item .activity-content p' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('activity_time_heading', [
      'label' => __('Timestamp', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'activity_time_typography',
        'selector' => '{{WRAPPER}} .activity-list .activity-item .activity-header .time-since',
      ]
    );

    $this->add_control('activity_time_color', [
      'label'     => __('Color', 'text-domain'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .activity-list .activity-item .activity-header .time-since' => 'color: {{VALUE}};',
      ],
    ]);

    $this->end_controls_section();

    $this->start_controls_section('section_activity_reactions', [
      'label' => __('Reactions', 'text-domain'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'reaction_typography',
        'selector' => '{{WRAPPER}} #buddypress .activity-footer-links .th-bp-footer-meta .reactions-meta .reaction-meta-container, {{WRAPPER}} #buddypress .activity-footer-links > div a',
      ]
    );

    $this->start_controls_tabs('reaction_style_tabs');

    $this->start_controls_tab('reaction_normal', ['label' => __('Normal', 'text-domain')]);

    $this->add_control('reaction_color', [
      'label' => __('Text Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-footer-links .th-bp-footer-meta .reactions-meta .reaction-meta-container, {{WRAPPER}} #buddypress .activity-footer-links > div a' => 'color: {{VALUE}};',
      ],
    ]);

    $this->end_controls_tab();

    $this->start_controls_tab('reaction_hover', ['label' => __('Hover', 'text-domain')]);

    $this->add_control('reaction_color_hover', [
      'label' => __('Hover Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-footer-links .th-bp-footer-meta .reactions-meta .reaction-meta-container:hover, {{WRAPPER}} #buddypress .activity-footer-links > div a:hover' => 'color: {{VALUE}};',
      ],
    ]);

    $this->end_controls_tab();

    $this->end_controls_tabs();
    $this->end_controls_section();

    // COMMEMTS
    $this->start_controls_section('section_activity_comments', [
      'label' => __('Comments', 'text-domain'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]);

    $this->add_control('comment_container_heading', [
      'label'     => __('Comments Container', 'text-domain'),
      'type'      => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'comment_container_bg',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments, {{WRAPPER}} .buddypress-wrap .activity-comments > ul > li.has-replies > .comment-replies > ul > li:last-child::after, {{WRAPPER}} .buddypress-wrap .activity-comments .comment-reply::after',
      ]
    );

    $this->add_control('comment_container_padding', [
      'label' => __('Padding', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em'],
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'comment_container_border',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments',
      ]
    );

    $this->add_control('comment_container_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'comment_container_shadow',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments',
      ]
    );


    // Comment Box
    $this->add_control('comment_box_style', [
      'label' => __('Comment Box', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_control('comment_spacing', [
      'label' => __('Spacing', 'text-domain'),
      'type'  => Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'comment_bg',
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'comment_border',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'comment_shadow',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content',
      ]
    );

    // Comment Avatar
    $this->add_control('comment_avatar_style', [
      'label' => __('Avatar', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_control('comment_avatar_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type'  => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}}  #buddypress .activity-comments-form img, {{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-avatar img' => 'border-radius: {{SIZE}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'comment_avatar_border',
        'selector' => '{{WRAPPER}}  #buddypress .activity-comments-form img, {{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-avatar img',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'comment_avatar_shadow',
        'selector' => '{{WRAPPER}}  #buddypress .activity-comments-form img, {{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-avatar img',
      ]
    );

    // Commentor Name
    $this->add_control('commentor_name_heading', [
      'label' => __('Commentor Name', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'commentor_typo',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content .comment-meta a',
      ]
    );

    $this->add_control('commentor_color', [
      'label' => __('Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content .comment-meta a' => 'color: {{VALUE}};',
      ],
    ]);

    // Comment Date
    $this->add_control('comment_date_heading', [
      'label' => __('Comment Date', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'comment_date_typo',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content .comment-meta .comment-date',
      ]
    );

    $this->add_control('comment_date_color', [
      'label' => __('Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content .comment-meta .comment-date' => 'color: {{VALUE}};',
      ],
    ]);

    // Comment Text
    $this->add_control('comment_text_heading', [
      'label' => __('Comment Text', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'comment_text_typo',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content p',
      ]
    );

    $this->add_control('comment_text_color', [
      'label' => __('Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-content p' => 'color: {{VALUE}};',
      ],
    ]);

    // Comment Meta Actions
    $this->add_control('comment_actions_heading', [
      'label' => __('Comment Actions', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'comment_actions_typo',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-meta-actions a',
      ]
    );

    $this->add_control('comment_action_color', [
      'label' => __('Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-meta-actions a' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('comment_action_color_hover', [
      'label' => __('Hover Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul li span.comment-meta-actions a:hover' => 'color: {{VALUE}};',
      ],
    ]);

    // View More Comments
    $this->add_control('view_more_comments_heading', [
      'label' => __('View More Comments', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'more_comments_typo',
        'selector' => '{{WRAPPER}} .buddypress-wrap .activity-comments ul + .show-more-comments',
      ]
    );

    $this->add_control('more_comments_color', [
      'label' => __('Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul + .show-more-comments' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('more_comments_color_hover', [
      'label' => __('Hover Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .buddypress-wrap .activity-comments ul + .show-more-comments:hover' => 'color: {{VALUE}};',
      ],
    ]);

    // Comment/Reply Input
    $this->add_control('comment_form_heading', [
      'label' => __('Comment Form', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::HEADING,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'comment_form_typo',
        'selector' => '{{WRAPPER}} .comments-text.editable-div',
      ]
    );

    $this->start_controls_tabs('comment_form_tabs');

    // --- Normal
    $this->start_controls_tab('comment_form_normal', [
      'label' => __('Normal', 'text-domain'),
    ]);

    $this->add_control('comment_form_text_color', [
      'label' => __('Text Color', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .comments-text.editable-div' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'comment_form_bg',
        'selector' => '{{WRAPPER}} .comments-text.editable-div',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'comment_form_border',
        'selector' => '{{WRAPPER}} .comments-text.editable-div',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'comment_form_shadow',
        'selector' => '{{WRAPPER}} .comments-text.editable-div',
      ]
    );

    $this->end_controls_tab();

    // --- Hover
    $this->start_controls_tab('comment_form_hover', [
      'label' => __('Hover', 'text-domain'),
    ]);

    $this->add_control('comment_form_text_color_hover', [
      'label' => __('Text Color (Hover)', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .comments-text.editable-div:hover' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'comment_form_bg_hover',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:hover',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'comment_form_border_hover',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:hover',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'comment_form_shadow_hover',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:hover',
      ]
    );

    $this->end_controls_tab();

    // --- Focus
    $this->start_controls_tab('comment_form_focus', [
      'label' => __('Focus', 'text-domain'),
    ]);

    $this->add_control('comment_form_text_color_focus', [
      'label' => __('Text Color (Focus)', 'text-domain'),
      'type'  => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .comments-text.editable-div:focus' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'comment_form_bg_focus',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:focus',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'comment_form_border_focus',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:focus',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'comment_form_shadow_focus',
        'selector' => '{{WRAPPER}} .comments-text.editable-div:focus',
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();


    // Comment Reactions Heading
    $this->add_control('comment_reaction_heading', [
      'label'     => __('Comment Reactions', 'text-domain'),
      'type'      => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'comment_reaction_bg',
        'selector' => '{{WRAPPER}} .comment-content .inner-reaction-content',
      ]
    );

    $this->add_control('comment_reaction_color', [
      'label' => __('Text Color', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .comment-content .inner-reaction-content' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('comment_reaction_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} .comment-content .inner-reaction-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'comment_reaction_border',
        'selector' => '{{WRAPPER}} .comment-content .inner-reaction-content',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'comment_reaction_shadow',
        'selector' => '{{WRAPPER}} .comment-content .inner-reaction-content',
      ]
    );


    $this->add_control('comment_reaction_position_right', [
      'label' => __('Position X', 'text-domain'),
      'type' => \Elementor\Controls_Manager::SLIDER,
      'range' => [
        'px' => ['min' => -200, 'max' => 200],
      ],
      'selectors' => [
        '{{WRAPPER}} .comment-content .inner-reaction-content' => 'right: {{SIZE}}{{UNIT}}; position: absolute;',
      ],
    ]);
    $this->add_control('comment_reaction_position_top', [
      'label' => __('Position Y', 'text-domain'),
      'type' => \Elementor\Controls_Manager::SLIDER,
      'range' => [
        'px' => ['min' => -200, 'max' => 200],
      ],
      'selectors' => [
        '{{WRAPPER}} .comment-content .inner-reaction-content' => 'bottom: {{SIZE}}{{UNIT}}; position: absolute;',
      ],
    ]);

    $this->end_controls_section();

    $this->start_controls_section('section_activity_extension_links', [
      'label' => __('Activity Extension Links', 'text-domain'),
      'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name'     => 'ext_links_bg',
        'selector' => '{{WRAPPER}} #buddypress .activity-extension-links ul',
      ]
    );

    $this->add_control('ext_links_padding', [
      'label' => __('Padding', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name'     => 'ext_links_border',
        'selector' => '{{WRAPPER}} #buddypress .activity-extension-links ul',
      ]
    );

    $this->add_control('ext_links_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type' => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'ext_links_shadow',
        'selector' => '{{WRAPPER}} #buddypress .activity-extension-links ul',
      ]
    );

    // Anchor Tag Styles
    $this->add_control('ext_links_anchor_heading', [
      'label' => __('Links', 'text-domain'),
      'type' => \Elementor\Controls_Manager::HEADING,
      'separator' => 'before',
    ]);

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'ext_links_anchor_typo',
        'selector' => '{{WRAPPER}} #buddypress .activity-extension-links ul li a',
      ]
    );
    $this->add_control('ext_links_anchor_margin', [
      'label' => __('Anchor Margin', 'text-domain'),
      'type' => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_control('ext_links_anchor_border_radius', [
      'label' => __('Border Radius', 'text-domain'),
      'type' => \Elementor\Controls_Manager::DIMENSIONS,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);


    $this->start_controls_tabs('ext_links_anchor_tabs');

    $this->start_controls_tab('ext_links_anchor_normal', [
      'label' => __('Normal', 'text-domain'),
    ]);

    $this->add_control('ext_links_text_color', [
      'label' => __('Main Text Color (h4)', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a h4' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('ext_links_anchor_color', [
      'label' => __('Text Color', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a p' => 'color: {{VALUE}};',
      ],
    ]);
    $this->add_control('ext_links_anchor_bg', [
      'label' => __('Background Color', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a' => 'background-color: {{VALUE}};',
      ],
    ]);
    $this->add_control('ext_links_icon_color', [
      'label' => __('Icon Stroke Color', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a svg' => 'stroke: {{VALUE}};',
      ],
    ]);

    $this->end_controls_tab();

    $this->start_controls_tab('ext_links_anchor_hover', [
      'label' => __('Hover', 'text-domain'),
    ]);

    $this->add_control('ext_links_text_color_hover', [
      'label' => __('Main Text Hover Color (h4)', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a:hover h4' => 'color: {{VALUE}};',
      ],
    ]);

    $this->add_control('ext_links_anchor_hover_color', [
      'label' => __('Text Color', 'text-domain'),
      'type'  => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a p:hover' => 'color: {{VALUE}};',
      ],
    ]);
    $this->add_control('ext_links_anchor_hover_bg', [
      'label' => __('Background Color', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a:hover' => 'background-color: {{VALUE}};',
      ],
    ]);
    $this->add_control('ext_links_icon_color_hover', [
      'label' => __('Icon Stroke Hover Color', 'text-domain'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #buddypress .activity-extension-links ul li a:hover svg' => 'stroke: {{VALUE}};',
      ],
    ]);




    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $per_page = !empty($settings['per_page']['size']) ? $settings['per_page']['size'] : 5;
    echo '<div id="buddypress" class="buddypress buddypress-wrap">';
    echo '<div id="activity-stream">';
    if (bp_has_activities(['per_page' => $per_page])) :
      echo '<ul class="activity-list item-list bp-list">';
      while (bp_activities()) :
        bp_the_activity();

        $content_class = bp_get_activity_type() === 'activity_share' ? ' activity-sharing' : '';


        $activity = new \BP_Activity_Activity((int)bp_get_activity_id());
        $visibility_type = bp_activity_get_meta(bp_get_activity_id(), 'activity_accessibility', true);
        $visibility_type = $visibility_type ?: 'public';

        $activity_visibility_svg = "";

        $activity_visibility = true;
        if ($visibility_type === 'onlyme' && bp_loggedin_user_id() !== bp_get_activity_user_id()) {
          $activity_visibility = false;
        }
        switch ($visibility_type) {
          case "public":
            $activity_visibility = true;
            $activity_visibility_svg = '<span class="ac-vi-co" data-vi="1"><span class="ac_vi_text">' . __('Public', 'tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="16" height="16" fill="#b6b0ae"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>';
            break;

          case "friends":
            $is_friend = BP_Friends_Friendship::check_is_friend(bp_loggedin_user_id(), bp_get_activity_user_id())  !== "not_friends";
            $activity_visibility = $is_friend === false ? bp_get_activity_user_id()  === get_current_user_id() : true;
            $activity_visibility_svg = '<span class="ac-vi-co" data-vi="2"><span class="ac_vi_text">' . __('Friends', 'tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#b6b0ae"><title>People</title><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg></span>';
            break;

          case "onlyme":
            $activity_visibility = bp_get_activity_user_id()  === get_current_user_id();
            $activity_visibility_svg = '<span class="ac-vi-co" data-vi="3"><span class="ac_vi_text">' . __('Only Me', 'tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" width="30px" height="30px">
                                <g id="surface67244366">
                                <path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/>
                                </g>
                                </svg></span>';
            break;

          default:
            $activity_visibility = true;
        }

        if ($activity_visibility || current_user_can('activate_plugins')) :
?>
          <li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>" data-bp-activity-id="<?php bp_activity_id(); ?>" data-bp-timestamp="<?php bp_nouveau_activity_timestamp(); ?>" <?php echo bp_get_activity_user_id()  === get_current_user_id() ? "data-canedite=true" : "data-canedite=false" ?>>
            <div class="activity-avatar item-avatar">
              <a href="<?php bp_activity_user_link(); ?>">
                <?php bp_activity_avatar(['type' => 'full']); ?>
              </a>
            </div>
            <div class="activity-content<?php echo $content_class; ?>">
              <div class="activity-header">
                <?php do_action('tophive/buddypress/activity/header', $activity_visibility_svg); ?>
                <?php if (is_user_logged_in()) { ?>
                  <div class="activity-extension-links">
                    <span class="open-button">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                      </svg>
                    </span>
                    <span class="more-option"> <?php esc_html_e("More Options", "one"); ?> </span>
                    <ul>
                      <?php if (bp_get_activity_is_favorite()): ?>
                        <li>
                          <a class="button bp-secondary-action bp-tooltip activity-remove-favourite" href="">
                            <div>
                              <h4><?php esc_html_e('Unsave', 'ONE_CORE_SLUG'); ?></h4>
                            </div>
                            <svg viewBox="0 0 212.045 212.045">
                              <path d="M167.871,0H44.84C34.82,0,26.022,8.243,26.022,18v182c0,3.266,0.909,5.988,2.374,8.091c1.752,2.514,4.573,3.955,7.598,3.954  c2.86,0,5.905-1.273,8.717-3.675l55.044-46.735c1.7-1.452,4.142-2.284,6.681-2.284c2.538,0,4.975,0.832,6.68,2.288l54.86,46.724  c2.822,2.409,5.657,3.683,8.512,3.683c4.828,0,9.534-3.724,9.534-12.045V18C186.022,8.243,177.891,0,167.871,0z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </li>
                      <?php else: ?>
                        <li>
                          <a class="button bp-secondary-action bp-tooltip activity-make-favourite" href="">
                            <div>
                              <h4><?php esc_html_e('Save', 'ONE_CORE_SLUG'); ?></h4>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" fill="none"></path>
                            </svg>
                          </a>
                        </li>
                      <?php endif; ?>


                      <?php if (bp_get_activity_user_id()  === get_current_user_id() && 'activity_update' == $activity->type): ?>
                        <li class="edit-current-activity">
                          <a class="edite-activity">
                            <div>
                              <h4><?php esc_html_e('Edit', 'ONE_CORE_SLUG'); ?></h4>
                            </div>
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                              <path d="M21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h6a1,1,0,0,0,0-2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM6,12.76V17a1,1,0,0,0,1,1h4.24a1,1,0,0,0,.71-.29l6.92-6.93h0L21.71,8a1,1,0,0,0,0-1.42L17.47,2.29a1,1,0,0,0-1.42,0L13.23,5.12h0L6.29,12.05A1,1,0,0,0,6,12.76ZM16.76,4.41l2.83,2.83L18.17,8.66,15.34,5.83ZM8,13.17l5.93-5.93,2.83,2.83L10.83,16H8Z" fill="currentColor" />
                            </svg>
                          </a>
                        </li>
                      <?php endif; ?>
                      <?php
                      if (bp_activity_user_can_delete($activity)) {
                      ?>
                        <li>
                          <a class="button button-activity-delete" href="#" data-id="<?php bp_activity_id(); ?>" data-action="delete">
                            <div>
                              <h4><?php esc_html_e('Delete', 'ONE_CORE_SLUG'); ?></h4>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <polyline points="3 6 5 6 21 6"></polyline>
                              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                              <line x1="10" y1="11" x2="10" y2="17"></line>
                              <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                          </a>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                <?php } ?>
              </div>
              <div class="activity-inner">
                <?php
                echo bp_get_activity_content_body();
                if ('yes' === $settings['show_media']) {
                  do_action('tophive/buddypress/activity/media', bp_get_activity_id());
                }
                if ('activity_share' === bp_get_activity_type() && 'yes' === $settings['show_share']) {
                  $share_id = bp_activity_get_meta(bp_get_activity_id(), 'shared_activity_id', true);
                  do_action('tophive/buddypress/activity/share-activity', $share_id);
                }
                ?>
              </div>
              <div class="activity-footer-links">
                <?php do_action('bp_footer_actions'); ?>
              </div>
            </div>
            <?php bp_nouveau_activity_hook('before', 'entry_comments'); ?>

            <?php if (bp_activity_get_comment_count() || (is_user_logged_in() && (bp_activity_can_comment() || bp_is_single_activity()))) : ?>

              <div class="activity-comments">

                <?php do_action('tophive/buddypress/activity/comments'); ?>

              </div>

            <?php endif; ?>

            <?php bp_nouveau_activity_hook('after', 'entry_comments'); ?>
          </li>
<?php
        endif;

      endwhile;
      echo '</ul>';

      bp_nouveau_pagination('bottom');

    else :
      bp_nouveau_user_feedback('activity-loop-none');
    endif;

    echo '</div>';
    echo '</div>';
  }
}
