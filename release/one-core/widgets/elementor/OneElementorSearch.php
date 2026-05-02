<?php

namespace ONECORE\widgets\elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

class OneElementorSearch extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'tophive_search_box';
  }

  public function get_title()
  {
    return __('One Search Box', 'ONE_CORE_SLUG');
  }

  public function get_icon()
  {
    return 'eicon-search';
  }

  public function get_categories()
  {
    return ['ONE_CORE_SLUG'];
  }

  protected function register_controls()
  {
    // Search Box Settings
    $this->start_controls_section(
      'section_search_settings',
      [
        'label' => __('Search Settings', 'ONE_CORE_SLUG'),
        'tab' => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'placeholder',
      [
        'label' => __('Placeholder Text', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::TEXT,
        'default' => __('Search...', 'ONE_CORE_SLUG'),
      ]
    );

    $this->end_controls_section();

    // Style Section
    $this->start_controls_section(
      'section_style_search',
      [
        'label' => __('Search Field', 'ONE_CORE_SLUG'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'width',
      [
        'label' => __('Width', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .search-form-fields' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'height',
      [
        'label' => __('Height', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::SLIDER,
        'range' => [
          'px' => ['min' => 25, 'max' => 100],
        ],
        'selectors' => [
          '{{WRAPPER}} .search-form-fields, {{WRAPPER}} .search-field' => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'typography',
        'label' => __('Typography', 'ONE_CORE_SLUG'),
        'selector' => '{{WRAPPER}} .search-field',
      ]
    );


    // STYLE SECTION - TABS (Normal, Hover, Focus)

    $this->start_controls_tabs('tabs_input_style');

    // NORMAL
    $this->start_controls_tab('tab_input_normal', ['label' => __('Normal', 'ONE_CORE_SLUG')]);

    $this->add_control('input_bg_color_normal', [
      'label'     => __('Background Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field' => 'background-color: {{VALUE}}'],
    ]);

    $this->add_control('input_text_color_normal', [
      'label'     => __('Text Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field' => 'color: {{VALUE}}'],
    ]);

    $this->add_control('input_placeholder_color_normal', [
      'label'     => __('Placeholder Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field::placeholder' => 'color: {{VALUE}}'],
    ]);

    $this->add_group_control(Group_Control_Border::get_type(), [
      'name'     => 'input_border_normal',
      'selector' => '{{WRAPPER}} .search-field',
    ]);

    $this->add_responsive_control('input_border_radius_normal', [
      'label'      => __('Border Radius', 'ONE_CORE_SLUG'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%'],
      'selectors'  => [
        '{{WRAPPER}} .search-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
      'name'     => 'input_box_shadow_normal',
      'selector' => '{{WRAPPER}} .search-field',
    ]);

    $this->end_controls_tab();

    // HOVER
    $this->start_controls_tab('tab_input_hover', ['label' => __('Hover', 'ONE_CORE_SLUG')]);

    $this->add_control('input_bg_color_hover', [
      'label'     => __('Background Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:hover' => 'background-color: {{VALUE}}'],
    ]);

    $this->add_control('input_text_color_hover', [
      'label'     => __('Text Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:hover' => 'color: {{VALUE}}'],
    ]);

    $this->add_control('input_placeholder_color_hover', [
      'label'     => __('Placeholder Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:hover::placeholder' => 'color: {{VALUE}}'],
    ]);

    $this->add_group_control(Group_Control_Border::get_type(), [
      'name'     => 'input_border_hover',
      'selector' => '{{WRAPPER}} .search-field:hover',
    ]);

    $this->add_responsive_control('input_border_radius_hover', [
      'label'      => __('Border Radius', 'ONE_CORE_SLUG'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%'],
      'selectors'  => [
        '{{WRAPPER}} .search-field:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
      'name'     => 'input_box_shadow_hover',
      'selector' => '{{WRAPPER}} .search-field:hover',
    ]);

    $this->end_controls_tab();

    // FOCUS
    $this->start_controls_tab('tab_input_focus', ['label' => __('Focus', 'ONE_CORE_SLUG')]);

    $this->add_control('input_bg_color_focus', [
      'label'     => __('Background Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:focus' => 'background-color: {{VALUE}}'],
    ]);

    $this->add_control('input_text_color_focus', [
      'label'     => __('Text Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:focus' => 'color: {{VALUE}}'],
    ]);

    $this->add_control('input_placeholder_color_focus', [
      'label'     => __('Placeholder Color', 'ONE_CORE_SLUG'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => ['{{WRAPPER}} .search-field:focus::placeholder' => 'color: {{VALUE}}'],
    ]);

    $this->add_group_control(Group_Control_Border::get_type(), [
      'name'     => 'input_border_focus',
      'selector' => '{{WRAPPER}} .search-field:focus',
    ]);

    $this->add_responsive_control('input_border_radius_focus', [
      'label'      => __('Border Radius', 'ONE_CORE_SLUG'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%'],
      'selectors'  => [
        '{{WRAPPER}} .search-field:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]);

    $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
      'name'     => 'input_box_shadow_focus',
      'selector' => '{{WRAPPER}} .search-field:focus',
    ]);

    $this->end_controls_tab();
    $this->end_controls_tabs();


    $this->end_controls_section();

    // Icon Style Section
    $this->start_controls_section(
      'section_style_icon',
      [
        'label' => __('Icon Button', 'ONE_CORE_SLUG'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'icon_size',
      [
        'label' => __('Icon Size', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::SLIDER,
        'selectors' => [
          '{{WRAPPER}} .search-submit svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'icon_position',
      [
        'label' => __('Icon Position Horizontal', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::SLIDER,
        'range' => [
          'px' => ['min' => -150, 'max' => 90],
        ],
        'selectors' => [
          '{{WRAPPER}} .search-submit' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->add_responsive_control(
      'icon_margin_top',
      [
        'label'      => __('Icon Vertical Position', 'ONE_CORE_SLUG'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => ['unit' => 'px'],
        'range'      => [
          'px' => [
            'min' => -100,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .search-submit' => 'margin-top: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'icon_color',
      [
        'label' => __('Icon Color', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .search-submit svg' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings    = $this->get_settings_for_display();
    $placeholder = esc_attr($settings['placeholder']);

    echo '<div class="header-social_search_box-item">';
    echo '<form role="search" class="header-search-form" action="' . esc_url(home_url('/')) . '">';
    echo '<div class="search-form-fields">';
    echo '<input type="search" class="search-field" placeholder="' . $placeholder . '" value="' . get_search_query() . '" name="s" />';
    echo '</div>';
    echo '<button type="submit" class="search-submit">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"><path fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"/></svg>';
    echo '</button>';
    echo '</form>';
    echo '<div class="search-box-result"></div>';
    echo '</div>';
  }
}
