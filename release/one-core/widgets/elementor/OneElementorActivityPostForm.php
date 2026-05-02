<?php

namespace ONECORE\widgets\elementor;

use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

class OneElementorActivityPostForm extends Widget_Base
{
  public function get_name()
  {
    return 'th-buddypress-activity-post-form';
  }

  public function get_title()
  {
    return __('One BuddyPress Activity Post Form', 'ONE_CORE_SLUG');
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
    return [];
  }

  public function get_categories()
  {
    return ['ONE_CORE_SLUG'];
  }

  protected function register_controls()
  {
    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Content', 'ONE_CORE_SLUG'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'select_option',
      [
        'label' => __('Select Form Type', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          'button' => __('Button', 'ONE_CORE_SLUG'),
          'form'   => __('Form', 'ONE_CORE_SLUG'),
        ],
        'default' => 'button',
      ]
    );

    $this->add_control(
      'svg_icon',
      [
        'label' => __('SVG Icon', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'media_types' => ['svg'],
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_control(
      'svg_width',
      [
        'label' => __('SVG Width', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 1,
            'max' => 500,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 24,
        ],
        'condition' => [
          'svg_icon[url]!' => '',
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_control(
      'svg_height',
      [
        'label' => __('SVG Height', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 1,
            'max' => 500,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 24,
        ],
        'condition' => [
          'svg_icon[url]!' => '',
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_control(
      'button_text',
      [
        'label' => __('Button Text', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Click Me', 'ONE_CORE_SLUG'),
        'placeholder' => __('Enter button text', 'ONE_CORE_SLUG'),
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_control(
      'button_text_color',
      [
        'label' => __('Button color ', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .one-elementor-activity-post-form-btn' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_control(
      'button_bg_color',
      [
        'label' => __('Button Background Color', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .one-elementor-activity-post-form-btn' => 'background-color: {{VALUE}};',
        ],
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_responsive_control(
      'button_padding',
      [
        'label' => __('Button Padding', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .one-elementor-activity-post-form-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_responsive_control(
      'button_border_radius',
      [
        'label' => __('Button Border Radius', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .one-elementor-activity-post-form-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'button_typography',
        'label'    => __('Button Typography', 'ONE_CORE_SLUG'),
        'selector' => '{{WRAPPER}} .one-elementor-activity-post-form-btn',
        'condition' => [
          'select_option' => 'button',
        ],
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    $selected_option = $settings['select_option'];
    $svg_url         = $settings['svg_icon']['url'] ?? '';
    $svg_width       = $settings['svg_width']['size'] ?? 24;
    $svg_height      = $settings['svg_height']['size'] ?? 24;
    $button_text     = $settings['button_text'] ?? 'Click Me';

    function isMobile()
    {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    if (isMobile()) {
      $submit_button_state = '';
    } else {
      $submit_button_state = 'disabled';
    }

?>


    <?php if (function_exists("bp_activity_post_form_action")): ?>

      <?php if ($selected_option === 'button'): ?>
        <button class="ac-post-form-showcase  one-elementor-activity-post-form-btn">
          <?php if (! empty($svg_url)): ?>
            <img src="<?php echo esc_url($svg_url); ?>" style="width:<?php echo esc_attr($svg_width); ?>px;height:<?php echo esc_attr($svg_height); ?>px;" alt="Icon" style="vertical-align:middle; margin-right:6px;" />
          <?php endif; ?>
          <?php echo esc_html($button_text); ?>
        </button>
      <?php elseif ($selected_option === 'form'): ?>

        <div class="ac-post-form-showcase">
          <?php echo get_avatar(get_current_user_id()); ?>
          <span><?php _e("What's on your mind?", "one") ?></span>
          <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="18" cy="18" r="18" fill="#F8F8F8" />
            <path d="M9 14.7059C9 14.3925 9 14.2358 9.01316 14.1038C9.14004 12.8306 10.1531 11.8234 11.4338 11.6973C11.5666 11.6842 11.7327 11.6842 12.065 11.6842C12.1931 11.6842 12.2571 11.6842 12.3114 11.6809C13.0055 11.6391 13.6134 11.2036 13.8727 10.5622C13.893 10.512 13.912 10.4554 13.95 10.3421C13.988 10.2289 14.007 10.1722 14.0273 10.122C14.2866 9.48058 14.8945 9.04506 15.5886 9.00327C15.6429 9 15.7029 9 15.823 9H20.177C20.2971 9 20.3571 9 20.4114 9.00327C21.1055 9.04506 21.7134 9.48058 21.9727 10.122C21.993 10.1722 22.012 10.2289 22.05 10.3421C22.088 10.4554 22.107 10.512 22.1273 10.5622C22.3866 11.2036 22.9944 11.6391 23.6886 11.6809C23.7429 11.6842 23.8069 11.6842 23.935 11.6842C24.2673 11.6842 24.4334 11.6842 24.5662 11.6973C25.8469 11.8234 26.86 12.8306 26.9868 14.1038C27 14.2358 27 14.3925 27 14.7059V21.7053C27 23.2086 27 23.9602 26.7057 24.5344C26.4469 25.0395 26.0338 25.4501 25.5258 25.7074C24.9482 26 24.1921 26 22.68 26H13.32C11.8079 26 11.0518 26 10.4742 25.7074C9.96619 25.4501 9.55314 25.0395 9.29428 24.5344C9 23.9602 9 23.2086 9 21.7053V14.7059Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M18 21.9737C19.9882 21.9737 21.6 20.3713 21.6 18.3947C21.6 16.4181 19.9882 14.8158 18 14.8158C16.0118 14.8158 14.4 16.4181 14.4 18.3947C14.4 20.3713 16.0118 21.9737 18 21.9737Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>

      <?php endif; ?>

      <div id="bp-nouveau-activity-form" class="activity-update-form">
        <form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">
          <div class="activity-post-form-header">
            <h4> <?php esc_html_e("Create post", "one"); ?> </h4>
            <span class="whats-new-close">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
              </svg>
            </span>
          </div>

          <?php


          /**
           * Fires before the activity post form.
           *
           * @since 1.2.0
           */
          do_action('bp_before_activity_post_form'); ?>

          <div id="whats-new-avatar">
            <a href="<?php echo bp_loggedin_user_domain(); ?>">
              <?php bp_loggedin_user_avatar('width=' . bp_core_avatar_thumb_width() . '&height=' . bp_core_avatar_thumb_height()); ?>
            </a>
            <?php $__text = "What\'s on your mind, " . bp_get_user_firstname(bp_get_loggedin_user_fullname()) . "?"; ?>
            <p class="whats-new-intro-header"><?php esc_html_e($__text, 'ONE_CORE_SLUG'); ?></p>
            <div class="whats-new-header-media-section">
              <p>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                  <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                  <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                </svg>
              </p>
            </div>
          </div>

          <div id="whats-new-content">
            <div id="whats-new-textarea">

              <div contenteditable="true"
                class="bp-suggestions advanced-th-bp-activity-form"
                <?php $_text = "What\'s on your mind, " . bp_get_user_firstname(bp_get_loggedin_user_fullname()) . "?"; ?>
                data-placeholder="<?php esc_html_e($_text, 'ONE_CORE_SLUG'); ?>"
                name="whats-new"
                id="th-bp-whats-new"
                cols="50"
                rows="10"
                <?php if (bp_is_group()) : ?>
                data-suggestions-group-id="<?php echo esc_attr((int) bp_get_current_group_id()); ?>"
                <?php endif; ?>><?php if (isset($_GET['r'])) : ?>@<?php echo esc_textarea($_GET['r']); ?> <?php endif; ?></div>
              <div class="whats-new-previewer">
                <p class="previewer-uploader">
                  <label for="upload-media">+</label>
                  <input type="file" name="upload-media" id="upload-media">
                </p>
              </div>
              <div class="text-formatter tooltip-formatting hidden">
                <span data-command="bold">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-type-bold" viewBox="0 0 16 16">
                    <path d="M8.21 13c2.106 0 3.412-1.087 3.412-2.823 0-1.306-.984-2.283-2.324-2.386v-.055a2.176 2.176 0 0 0 1.852-2.14c0-1.51-1.162-2.46-3.014-2.46H3.843V13zM5.908 4.674h1.696c.963 0 1.517.451 1.517 1.244 0 .834-.629 1.32-1.73 1.32H5.908V4.673zm0 6.788V8.598h1.73c1.217 0 1.88.492 1.88 1.415 0 .943-.643 1.449-1.832 1.449H5.907z" />
                  </svg>
                </span>
                <span data-command="italic">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-type-italic" viewBox="0 0 16 16">
                    <path d="M7.991 11.674 9.53 4.455c.123-.595.246-.71 1.347-.807l.11-.52H7.211l-.11.52c1.06.096 1.128.212 1.005.807L6.57 11.674c-.123.595-.246.71-1.346.806l-.11.52h3.774l.11-.52c-1.06-.095-1.129-.211-1.006-.806z" />
                  </svg>
                </span>
                <span data-command="underline">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-type-underline" viewBox="0 0 16 16">
                    <path d="M5.313 3.136h-1.23V9.54c0 2.105 1.47 3.623 3.917 3.623s3.917-1.518 3.917-3.623V3.136h-1.23v6.323c0 1.49-.978 2.57-2.687 2.57s-2.687-1.08-2.687-2.57zM12.5 15h-9v-1h9z" />
                  </svg>
                </span>
                <span data-command="insertUnorderedList">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                  </svg>
                </span>
                <span data-command="insertOrderedList">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                    <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z" />
                  </svg>
                </span>
              </div>
              <div id="whats-new-attachments">
                <p class="image has-tooltip">
                  <span class="new-post-tooltip"><?php esc_html_e('Photos', 'ONE_CORE_SLUG'); ?></span>
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 14.7059C9 14.3925 9 14.2358 9.01316 14.1038C9.14004 12.8306 10.1531 11.8234 11.4338 11.6973C11.5666 11.6842 11.7327 11.6842 12.065 11.6842C12.1931 11.6842 12.2571 11.6842 12.3114 11.6809C13.0055 11.6391 13.6134 11.2036 13.8727 10.5622C13.893 10.512 13.912 10.4554 13.95 10.3421C13.988 10.2289 14.007 10.1722 14.0273 10.122C14.2866 9.48058 14.8945 9.04506 15.5886 9.00327C15.6429 9 15.7029 9 15.823 9H20.177C20.2971 9 20.3571 9 20.4114 9.00327C21.1055 9.04506 21.7134 9.48058 21.9727 10.122C21.993 10.1722 22.012 10.2289 22.05 10.3421C22.088 10.4554 22.107 10.512 22.1273 10.5622C22.3866 11.2036 22.9944 11.6391 23.6886 11.6809C23.7429 11.6842 23.8069 11.6842 23.935 11.6842C24.2673 11.6842 24.4334 11.6842 24.5662 11.6973C25.8469 11.8234 26.86 12.8306 26.9868 14.1038C27 14.2358 27 14.3925 27 14.7059V21.7053C27 23.2086 27 23.9602 26.7057 24.5344C26.4469 25.0395 26.0338 25.4501 25.5258 25.7074C24.9482 26 24.1921 26 22.68 26H13.32C11.8079 26 11.0518 26 10.4742 25.7074C9.96619 25.4501 9.55314 25.0395 9.29428 24.5344C9 23.9602 9 23.2086 9 21.7053V14.7059Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 21.9737C19.9882 21.9737 21.6 20.3713 21.6 18.3947C21.6 16.4181 19.9882 14.8158 18 14.8158C16.0118 14.8158 14.4 16.4181 14.4 18.3947C14.4 20.3713 16.0118 21.9737 18 21.9737Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </p>
                <p class="play video has-tooltip">
                  <span class="new-post-tooltip"><?php esc_html_e('Video', 'ONE_CORE_SLUG'); ?></span>
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.0002 13L21.3184 18L28.0002 23V13Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19.4091 11H8.90909C7.85473 11 7 11.8954 7 13V23C7 24.1046 7.85473 25 8.90909 25H19.4091C20.4635 25 21.3182 24.1046 21.3182 23V13C21.3182 11.8954 20.4635 11 19.4091 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </p>
                <p class="documents rotate-45 has-tooltip">
                  <span class="new-post-tooltip"><?php esc_html_e('Documents', 'ONE_CORE_SLUG'); ?></span>
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 10H13.6C13.1757 10 12.7687 10.1686 12.4686 10.4686C12.1686 10.7687 12 11.1757 12 11.6V24.4C12 24.8243 12.1686 25.2313 12.4686 25.5314C12.7687 25.8314 13.1757 26 13.6 26H23.2C23.6243 26 24.0313 25.8314 24.3314 25.5314C24.6314 25.2313 24.8 24.8243 24.8 24.4V14.8L20 10Z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 10V14.8H24.8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.6 18.8H15.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.6 22H15.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16.8 15.6H16H15.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </p>
                <p class="emojipicker has-tooltip">
                  <span class="new-post-tooltip"><?php esc_html_e('Emoji', 'ONE_CORE_SLUG'); ?></span>
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.4 19.8C14.4 19.8 15.75 21.6 18 21.6C20.25 21.6 21.6 19.8 21.6 19.8M20.7 15.3H20.709M15.3 15.3H15.309M27 18C27 22.9706 22.9706 27 18 27C13.0294 27 9 22.9706 9 18C9 13.0294 13.0294 9 18 9C22.9706 9 27 13.0294 27 18ZM21.15 15.3C21.15 15.5485 20.9485 15.75 20.7 15.75C20.4515 15.75 20.25 15.5485 20.25 15.3C20.25 15.0515 20.4515 14.85 20.7 14.85C20.9485 14.85 21.15 15.0515 21.15 15.3ZM15.75 15.3C15.75 15.5485 15.5485 15.75 15.3 15.75C15.0515 15.75 14.85 15.5485 14.85 15.3C14.85 15.0515 15.0515 14.85 15.3 14.85C15.5485 14.85 15.75 15.0515 15.75 15.3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </p>
              </div>
            </div>
            <div id="whats-new-options">

              <input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
              <input type="hidden" id="whats-new-post-media" name="whats-new-post-media" value="" />
              <input type="hidden" id="whats-new-post-url-preview" name="whats-new-post-url-preview" value="" />
              <?php if (bp_is_active('groups') && !bp_is_my_profile() && !bp_is_group()) : ?>

                <div id="whats-new-post-in-box">

                  <label for="whats-new-post-in" class="bp-screen-reader-text"><?php
                                                                                /* translators: accessibility text */
                                                                                _e('Post in', 'ONE_CORE_SLUG');
                                                                                ?></label>
                  <select id="whats-new-post-in" name="whats-new-post-in">
                    <option selected="selected" value="0"><?php _e('My Profile', 'ONE_CORE_SLUG'); ?></option>

                    <?php if (bp_has_groups('user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0')) :
                      while (bp_groups()) : bp_the_group(); ?>
                        <?php echo bp_group_avatar(); ?>
                        <option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>
                    <?php endwhile;
                    endif; ?>

                  </select>
                </div>

              <?php elseif (bp_is_group_activity()) : ?>

                <input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
                <input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

              <?php endif; ?>

              <div id="whats-new-submit">
                <input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e('Post', 'ONE_CORE_SLUG'); ?>" <?php echo $submit_button_state; ?> />
              </div>

              <?php

              /**
               * Fires at the end of the activity post form markup.
               *
               * @since 1.2.0
               */
              do_action('bp_activity_post_form_options'); ?>

            </div><!-- #whats-new-options -->
            <div class="activity-emoji-container"></div>
          </div><!-- #whats-new-content -->

          <?php wp_nonce_field('post_update', '_wpnonce_post_update'); ?>
          <?php

          /**
           * Fires after the activity post form.
           *
           * @since 1.2.0
           */
          do_action('bp_after_activity_post_form'); ?>

        </form><!-- #whats-new-form -->
      </div>

    <?php else: ?>
      <p> <?php esc_html_e("Activate byddypress plugin", "one"); ?> </p>
    <?php endif; ?>
<?php
  }
}
