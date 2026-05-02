<?php

namespace ONECORE\widgets\elementor;

if (! class_exists('bbPress')) {
  return;
}

/**
 **
 * One elementor Forum tabs
 * Since Version 1.0.0
 * @package wordpress
 * @subpackage MasterClass
 *
 *
 */
class OneElementorBBPressNewPost extends \Elementor\Widget_base
{
  public function get_title()
  {
    return esc_html__('BBPress Post Topic', 'ONE_CORE_SLUG');
  }
  public function get_name()
  {
    return 'th-bbpress-topic-post';
  }
  public function get_icon()
  {
    return 'eicon-time-line';
  }
  public function get_categories()
  {
    return ['ONE_CORE_SLUG'];
  }
  public function get_keywords()
  {
    return ['topic'];
  }
  protected function register_controls()
  {
    $this->start_controls_section(
      'th_new_post_section',
      [
        'label' => esc_html__('New Post Form', 'ONE_CORE_SLUG'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );
    $this->add_control(
      'bbp_new_post_title',
      [
        'label' => esc_html__('Title', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Write New Post', 'ONE_CORE_SLUG'),
        'placeholder' => esc_html__('Type your title here', 'ONE_CORE_SLUG'),
      ]
    );
    $this->add_control(
      'bbp_new_post_text',
      [
        'label' => __('Description', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'rows' => 10,
        'placeholder' => __('Type your description here', 'ONE_CORE_SLUG'),
      ]
    );
    $this->end_controls_section();
    $this->start_controls_section(
      'th_new_post_section_style',
      [
        'label' => esc_html__('Styles', 'ONE_CORE_SLUG'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_control(
      'bbp_new_post_title_font_size',
      [
        'label' => esc_html__('Font Size', 'plugin-domain'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
          'px' => [
            'min' => 10,
            'max' => 50,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .form-title' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->add_control(
      'bbp_new_post_desc_font_size',
      [
        'label' => esc_html__('Description Font Size', 'plugin-domain'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
          'px' => [
            'min' => 10,
            'max' => 50,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .form-description' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();

    //btn
    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Form Type', 'ONE_CORE_SLUG'),
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
          '{{WRAPPER}} .bbp_forum_post_btn' => 'color: {{VALUE}};',
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
          '{{WRAPPER}} .bbp_forum_post_btn' => 'background-color: {{VALUE}};',
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
          '{{WRAPPER}} .bbp_forum_post_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
          '{{WRAPPER}} .bbp_forum_post_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        'selector' => '{{WRAPPER}} .bbp_forum_post_btn',
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

    $forum_args = array(
      'post_type' => 'forum',
      'post_status' => 'publish',
      'posts_per_page' => -1
    );
    $forum = new \WP_Query($forum_args);

    $selected_forum_id = isset($_GET['forum_id']) ? absint($_GET['forum_id']) : 0;

    ob_start();
?>
    <div class="tophive-bbpress-new-post-form">
      <h2 class="form-title">
        <?php echo $settings['bbp_new_post_title']; ?>
        <span class="whats-new-close bbp-close-form">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
          </svg>
        </span>
      </h2>
      <div class="form-description"><?php echo $settings['bbp_new_post_text']; ?></div>
      <form>
        <div class="form-group">
          <label for="thbbpressposttitle"><?php esc_html_e('Title', 'ONE_CORE_SLUG'); ?></label>
          <input type="text" id="thbbpressposttitle" name="thbbpressposttitle" placeholder="<?php esc_html_e('Provide a short and descriptive title', 'ONE_CORE_SLUG'); ?>">
        </div>
        <div class="form-group">
          <label for="thbbpresspostdesc"><?php esc_html_e('Description', 'ONE_CORE_SLUG'); ?></label>
          <div id="thbbpresspostdesc"></div>
        </div>
        <div class="form-group">
          <label for="thbbpressposttopics"><?php esc_html_e('Forum (required)', 'ONE_CORE_SLUG'); ?></label>
          <select id="thbbpressposttopics" name="thbbpressposttopics" required>
            <?php
            if ($forum->have_posts()) {
              while ($forum->have_posts()) {
                $forum->the_post();
                $current_id = get_the_ID();
                $selected = selected($selected_forum_id, $current_id, false);
                echo '<option value="' . esc_attr($current_id) . '" ' . $selected . '>' . esc_html(get_the_title()) . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="thbbpressposttags"><?php esc_html_e('Tags (optional)', 'ONE_CORE_SLUG'); ?></label>
          <input type="text" id="thbbpressposttags" name="thbbpressposttags" placeholder="<?php esc_html_e('Input tags seperated by commas', 'ONE_CORE_SLUG'); ?>">
        </div>
        <div class="form-group">
          <?php if (is_user_logged_in()) { ?>
            <input type="submit" class="thbbpresspostsubmit" name="thbbpresspostsubmit" value="<?php echo esc_html_e('Submit', 'ONE_CORE_SLUG'); ?>">
          <?php } else { ?>
            <input type="button" class="show-signin-form-modal" value="<?php echo esc_html_e('Submit', 'ONE_CORE_SLUG'); ?>">
          <?php } ?>
        </div>

      </form>
      <div class="response-text ec-mt-3 strong"></div>
    </div>
    <?php
    $markup = ob_get_clean();
    $id = uniqid();
    ?>

    <style>
      .activity-post-form-popup.elmen.none {
        opacity: 0;
        z-index: -99;
        transition: opacity 300ms ease-in;
      }

      .activity-post-form-popup .tophive-bbpress-new-post-form .form-title {
        display: flex;
        align-items: center;
        justify-content: space-between;

        span.bbp-close-form {
          position: relative !important;
          display: block;
        }
      }

      span.bbp-close-form {
        display: none;
      }
    </style>

    <?php if ($selected_option === "button") : ?>
      <div class="activity-post-form-popup elmen none">
        <?php echo $markup; ?>
      </div>
      <button class="bbp_forum_post_btn" id="<?php echo $id; ?>">
        <?php if (! empty($svg_url)): ?>
          <img src="<?php echo esc_url($svg_url); ?>" style="width:<?php echo esc_attr($svg_width); ?>px;height:<?php echo esc_attr($svg_height); ?>px;" alt="Icon" style="vertical-align:middle; margin-right:6px;" />
        <?php endif; ?>
        <?php echo esc_html($button_text); ?>
      </button>

      <script>
        let btn = document.getElementById("<?php echo $id; ?>");
        if (btn && btn.previousElementSibling) {
          btn.addEventListener("click", () => {
            btn.previousElementSibling.classList.toggle("none");
            //fixed text form width
            let textForm = btn.previousElementSibling.querySelector("#thbbpresspostdesc");
            if (textForm) textForm.style.width = `${textForm.offsetWidth}px`;
          });
          //close  btn 
          let close = btn.previousElementSibling.querySelector(".bbp-close-form");
          if (close) close.addEventListener("click", () => btn.previousElementSibling.classList.toggle("none"));
        }
      </script>

    <?php else: ?>
      <?php echo $markup; ?>
    <?php endif; ?>


<?php }
}
?>
