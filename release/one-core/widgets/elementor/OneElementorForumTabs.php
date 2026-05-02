<?php

namespace ONECORE\widgets\elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;


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
class OneElementorForumTabs extends \Elementor\Widget_Base
{
  public function get_title()
  {
    return \esc_html__('BBPress Forum', 'ONE_CORE_SLUG');
  }

  public function get_name()
  {
    return 'th-forum-tabs';
  }
  public function get_icon()
  {
    return 'eicon-tabs';
  }
  public function get_categories()
  {
    return ['ONE_CORE_SLUG'];
  }
  public function get_keywords()
  {
    return ['tabs', 'forum'];
  }
  protected function register_controls()
  {
    $this->start_controls_section(
      'th_adv_tabs_section',
      [
        'label' => \esc_html__('Activity Tab', 'ONE_CORE_SLUG'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $tags = \get_terms(['taxonomy'   => 'topic-tag', 'hide_empty' => false]);

    $options = [];
    if (! empty($tags) && ! is_wp_error($tags)) {
      foreach ($tags as $tag) {
        $options[$tag->slug] = $tag->name;
      }
    }

    $this->add_control(
      'selected_tags',
      [
        'label' => \__('Select Tags', 'ONE_CORE_SLUG'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => $options,
        'label_block' => true,
      ]
    );

    $repeater = new Repeater();
    $repeater->add_control(
      'tab_key',
      [
        'label' => \esc_html__('Tab', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          "recent_activity" => \esc_html__("Recent Activity", "ONE_CORE_SLUG"),
          "forum" => \esc_html__("Forum", "ONE_CORE_SLUG"),
          "tag" => \esc_html__("Tag", "ONE_CORE_SLUG"),
          "my_topic" => \esc_html__("My Topic", "ONE_CORE_SLUG"),
          "fav" => \esc_html__("Favourite", "ONE_CORE_SLUG"),
          "sub" => \esc_html__("Subscription", "ONE_CORE_SLUG"),
          "eng" => \esc_html__("Engagement", "ONE_CORE_SLUG"),
          "search" => \esc_html__("Search", "ONE_CORE_SLUG"),

        ],
      ]
    );

    $this->add_control(
      'tabs_list',
      [
        'label' => __('Tabs', 'ONE_CORE_SLUG'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          ['tab_key' => 'recent_activity'],
          ['tab_key' => 'forum'],
          ['tab_key' => 'tag'],
          ['tab_key' => 'my_topic'],
          ['tab_key' => 'fav'],
          ['tab_key' => 'sub'],
          ['tab_key' => 'eng'],
          ['tab_key' => 'search'],
        ],
        'title_field' => '{{{ tab_key }}}',
      ]
    );
    $this->end_controls_section();
  }

  function forum_activity_post_markup($query)
  {
    echo '<div class="tophive-forum-recent-topics-tab-container" id="th_forums">';
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        $main_title = get_the_title();
        $main_desc = get_the_content();
        $forum_childs_args = array(
          'post_type'    => 'forum',
          'post_status'    => 'publish',
          'post_parent'    => get_the_ID(),
          'posts_per_page' => -1,
        );
        $forum_childs = new \WP_Query($forum_childs_args);

        if ($forum_childs->have_posts()) {
          echo '<h6 class="th-forum-main-heading">' . $main_title . '</h6>';
          echo '<p>' . $main_desc . '</p>';
          while ($forum_childs->have_posts()) {
            $forum_childs->the_post();
?>
            <div class="tophive-forum-topic-loop-single">
              <div class="tophive-forum-topic-loop-single-details tophive-forums">
                <h4>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4" d="M21.6601 10.44L20.6801 14.62C19.8401 18.23 18.1801 19.69 15.0601 19.39C14.5601 19.35 14.0201 19.26 13.4401 19.12L11.7601 18.72C7.59006 17.73 6.30006 15.67 7.28006 11.49L8.26006 7.30001C8.46006 6.45001 8.70006 5.71001 9.00006 5.10001C10.1701 2.68001 12.1601 2.03001 15.5001 2.82001L17.1701 3.21001C21.3601 4.19001 22.6401 6.26001 21.6601 10.44Z" fill="currentColor" />
                    <path d="M15.06 19.3901C14.44 19.8101 13.66 20.1601 12.71 20.4701L11.13 20.9901C7.15998 22.2701 5.06997 21.2001 3.77997 17.2301L2.49997 13.2801C1.21997 9.3101 2.27997 7.2101 6.24997 5.9301L7.82997 5.4101C8.23997 5.2801 8.62997 5.1701 8.99997 5.1001C8.69997 5.7101 8.45997 6.4501 8.25997 7.3001L7.27997 11.4901C6.29997 15.6701 7.58998 17.7301 11.76 18.7201L13.44 19.1201C14.02 19.2601 14.56 19.3501 15.06 19.3901Z" fill="currentColor" />
                    <path d="M17.49 10.51C17.43 10.51 17.37 10.5 17.3 10.49L12.45 9.26002C12.05 9.16002 11.81 8.75002 11.91 8.35002C12.01 7.95002 12.42 7.71002 12.82 7.81002L17.67 9.04002C18.07 9.14002 18.31 9.55002 18.21 9.95002C18.13 10.28 17.82 10.51 17.49 10.51Z" fill="currentColor" />
                    <path d="M14.56 13.8899C14.5 13.8899 14.44 13.8799 14.37 13.8699L11.46 13.1299C11.06 13.0299 10.82 12.6199 10.92 12.2199C11.02 11.8199 11.43 11.5799 11.83 11.6799L14.74 12.4199C15.14 12.5199 15.38 12.9299 15.28 13.3299C15.2 13.6699 14.9 13.8899 14.56 13.8899Z" fill="currentColor" />
                  </svg>
                  <a class="theme-secondary-color" href="<?php echo bbp_get_forum_permalink(get_the_ID()); ?>">
                    <?php the_title();
                    echo '<span>' . get_the_content() . '</span>'; ?>
                  </a>
                </h4>
              </div>

              <div class="tophive-forum-topic-loop-single-footer-meta">
                <div class="meta-item">
                  <?php
                  echo '<span>';
                  global $wpdb;
                  $post_ide = get_the_ID();
                  $topic_count = $wpdb->get_var(
                    $wpdb->prepare(
                      "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_parent = %d AND post_type = %s",
                      $post_ide,
                      'topic'
                    )
                  );
                  echo absint($topic_count);
                  echo '</span>';
                  \esc_html_e(' Topics', 'ONE_CORE_SLUG'); ?>
                </div>
                <div class="meta-item last-active-time">
                  <?php
                  echo '<span>';
                  echo bbp_forum_reply_count(get_the_ID());
                  echo '</span>';
                  \esc_html_e(' Replies', 'ONE_CORE_SLUG'); ?>
                </div>
              </div>
              <div class="tophive-forum-last-topic">
                <?php if (bbp_get_forum_topic_count(get_the_ID()) > 0) : ?>
                  <span class="bbp-topic-freshness-author">
                    <?php
                    bbp_author_link(array('post_id' => bbp_get_forum_last_active_id(get_the_ID()), 'size' => 45));
                    ?>
                  </span>
                  <span class="bbp-topic-freshness-details">
                    <span class="bbp-last-topic-title">
                      <?php echo '<a href="' . bbp_get_forum_last_topic_permalink(get_the_ID()) . '">' . bbp_get_forum_last_topic_title(get_the_ID()) . '</a>' ?>
                    </span>
                    <span class="last-active-time">
                      <?php echo bbp_get_forum_last_active_time(get_the_ID(), false); ?> •
                      <?php
                      echo bbp_author_link(array('post_id' => bbp_get_forum_last_active_id(get_the_ID()), 'type' => 'name'));
                      ?>
                    </span>
                  </span>
                <?php endif; ?>
              </div>
            </div>
          <?php
            //inner while 
          }
          //if no inner  if post
          //inner if 
        } else {
          ?>
          <div class="tophive-forum-topic-loop-single">
            <div class="tophive-forum-topic-loop-single-details tophive-forums">
              <h4>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.4" d="M21.6601 10.44L20.6801 14.62C19.8401 18.23 18.1801 19.69 15.0601 19.39C14.5601 19.35 14.0201 19.26 13.4401 19.12L11.7601 18.72C7.59006 17.73 6.30006 15.67 7.28006 11.49L8.26006 7.30001C8.46006 6.45001 8.70006 5.71001 9.00006 5.10001C10.1701 2.68001 12.1601 2.03001 15.5001 2.82001L17.1701 3.21001C21.3601 4.19001 22.6401 6.26001 21.6601 10.44Z" fill="currentColor" />
                  <path d="M15.06 19.3901C14.44 19.8101 13.66 20.1601 12.71 20.4701L11.13 20.9901C7.15998 22.2701 5.06997 21.2001 3.77997 17.2301L2.49997 13.2801C1.21997 9.3101 2.27997 7.2101 6.24997 5.9301L7.82997 5.4101C8.23997 5.2801 8.62997 5.1701 8.99997 5.1001C8.69997 5.7101 8.45997 6.4501 8.25997 7.3001L7.27997 11.4901C6.29997 15.6701 7.58998 17.7301 11.76 18.7201L13.44 19.1201C14.02 19.2601 14.56 19.3501 15.06 19.3901Z" fill="currentColor" />
                  <path d="M17.49 10.51C17.43 10.51 17.37 10.5 17.3 10.49L12.45 9.26002C12.05 9.16002 11.81 8.75002 11.91 8.35002C12.01 7.95002 12.42 7.71002 12.82 7.81002L17.67 9.04002C18.07 9.14002 18.31 9.55002 18.21 9.95002C18.13 10.28 17.82 10.51 17.49 10.51Z" fill="currentColor" />
                  <path d="M14.56 13.8899C14.5 13.8899 14.44 13.8799 14.37 13.8699L11.46 13.1299C11.06 13.0299 10.82 12.6199 10.92 12.2199C11.02 11.8199 11.43 11.5799 11.83 11.6799L14.74 12.4199C15.14 12.5199 15.38 12.9299 15.28 13.3299C15.2 13.6699 14.9 13.8899 14.56 13.8899Z" fill="currentColor" />
                </svg>
                <a href="<?php echo bbp_get_forum_permalink(get_the_ID()); ?>">
                  <?php the_title();
                  the_content(); ?>
                </a>

              </h4>
            </div>

            <div class="tophive-forum-topic-loop-single-footer-meta">
              <div class="meta-item">
                <?php
                echo '<span>';
                global $wpdb;
                $post_ide = get_the_ID();

                $topic_count = $wpdb->get_var(
                  $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_parent = %d AND post_type = %s",
                    $post_ide,
                    'topic'
                  )
                );

                echo absint($topic_count);
                echo '</span>';
                esc_html_e(' Topics', 'ONE_CORE_SLUG'); ?>
              </div>
              <div class="meta-item last-active-time">
                <?php
                echo '<span>';
                echo bbp_forum_reply_count(get_the_ID());
                echo '</span>';
                esc_html_e(' Replies', 'ONE_CORE_SLUG'); ?>
              </div>
            </div>
            <div class="tophive-forum-last-topic">
              <span class="bbp-topic-freshness-author">
                <?php
                bbp_author_link(array('post_id' => bbp_get_forum_last_active_id(get_the_ID()), 'size' => 45));
                ?>
              </span>
              <span class="bbp-topic-freshness-details">
                <span class="bbp-last-topic-title">
                  <?php echo bbp_get_forum_last_topic_title(get_the_ID()); ?>
                </span>
                <span class="last-active-time">
                  <?php echo bbp_get_forum_last_active_time(get_the_ID(), false); ?> •
                  <?php
                  echo bbp_author_link(array('post_id' => bbp_get_forum_last_active_id(get_the_ID()), 'type' => 'name'));
                  ?>
                </span>
              </span>
            </div>
          </div>
        <?php
        }
        //outer while 
      }
      //outer if
      //if no outer if post
    } else {
      echo \esc_html__("No Content", "ONE_CORE_SLUG");
    }

    //close container
    echo '</div>';
  }

  function topic_post_markup($query)
  {
    echo '<div class="tophive-forum-recent-topics-tab-container" id="bbpress-forums">';
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post(); ?>

        <div class="topic-lead-question">
          <div class="topic-lead-question-head">
            <?php
            echo '<h6>' . get_the_title() . '</h6>';
            echo \bbp_reply_post_date(\get_the_ID(), true);
            ?>
          </div>
          <div class="topic-lead-question-user">
            <?php
            bbp_reply_author_link(
              array(
                'post_id'  => get_the_ID(),
                'type'     => 'both',
                'size'     => 40,
                'show_role' => true
              )
            );
            ?>
          </div>
          <div class="topic-lead-question-details">
            <div class="topic-lead-question-details-gamipress">
              <?php
              $user_id = \bbp_get_reply_author_id(\get_the_ID());
              \do_action('th_bbp_gamipress_author', $user_id);
              ?>
            </div>
            <div class="topic-lead-question-content">
              <?php \the_content(); ?>
            </div>
          </div>
          <div class="topic-lead-question-meta">
            <?php
            $post_id = get_the_ID();
            $user_id = get_current_user_id();

            $likes = get_post_meta($post_id, '_bbp_likes', true) ?: [];
            $dislikes = get_post_meta($post_id, '_bbp_dislikes', true) ?: [];

            $is_liked = in_array($user_id, $likes);
            $is_disliked = in_array($user_id, $dislikes);
            ?>

            <?php
            $reply_ids = \get_posts([
              'post_type'   => 'reply',
              'post_parent' => $post_id,
              'numberposts' => 3,
              'orderby'     => 'date',
              'order'       => 'DESC',
              'fields'      => 'ids',
              'no_found_rows' => true,
            ]);

            // Collect unique user IDs
            $unique_user_ids = [];
            foreach ($reply_ids as $rid) {
              $uid = \get_post_field('post_author', $rid);
              $unique_user_ids[$uid] = $uid;
            }

            // Render reply avatars
            echo '<div class="one-topic-avatars d-flex gap-1">';
            foreach ($unique_user_ids as $uid) {
              echo \get_avatar($uid, 24, '', '', ['class' => 'one-participant-avatar']);
            }
            ob_start();
            \bbp_topic_reply_count(\get_the_ID());
            $topic_reply_count = ob_get_clean();

            if ($topic_reply_count !== "0") {
              echo tophive_sanitize_filter($topic_reply_count) . \esc_html__(' Replies', 'one');
            }
            echo '</div>';
            ?>
            <!-- reactions -->
            <div class="bbp-like-dislike" data-post="<?php echo \esc_attr($post_id); ?>">

              <button class="bbp-like-btn <?php echo tophive_sanitize_filter($is_liked) ? 'liked' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 8H4C2.89543 8 2 8.89543 2 10V19C2 20.1046 2.89543 21 4 21H6C7.10457 21 8 20.1046 8 19V10C8 8.89543 7.10457 8 6 8Z" fill="currentColor" />
                  <path opacity="0.4" d="M15.8769 21H12.2111C11.4214 21 10.6494 20.7662 9.9923 20.3282L8.4453 19.2969C8.1671 19.1114 8 18.7992 8 18.4648V10.2656C8 10.0915 8.04541 9.92052 8.13176 9.76943L11.7121 3.50386C11.8901 3.19229 12.2215 3 12.5803 3H13.3287C15.3254 3 16.5164 5.22536 15.4088 6.88675L14 9H19.4384C20.7396 9 21.6943 10.2228 21.3787 11.4851L19.7575 17.9701C19.3123 19.7508 17.7124 21 15.8769 21Z" fill="currentColor" />
                </svg>
                <span><?php echo count($likes); ?></span>
              </button>

              <button class="bbp-dislike-btn <?php echo tophive_sanitize_filter($is_disliked) ? 'disliked' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M18 15H20C21.1046 15 22 14.1046 22 13V6C22 4.89543 21.1046 4 20 4H18C16.8954 4 16 4.89543 16 6V13C16 14.1046 16.8954 15 18 15Z" fill="currentColor" />
                  <path opacity="0.4" d="M8.12309 3H11.7889C12.5786 3 13.3506 3.23375 14.0077 3.6718L15.5547 4.70313C15.8329 4.8886 16 5.20083 16 5.53518V13.7344C16 13.9085 15.9546 14.0795 15.8682 14.2306L12 21H10.6713C8.67453 21 7.48355 18.7746 8.59115 17.1133L9.99998 15H4.56153C3.26039 15 2.30567 13.7772 2.62125 12.5149L4.24252 6.02986C4.68768 4.24919 6.28761 3 8.12309 3Z" fill="currentColor" />
                </svg>
                <span><?php echo count($dislikes); ?></span>
              </button>

            </div>
            <?php
            $views = (int) \get_post_meta(\get_the_ID(), '_bbp_views', true);
            echo '<div class="bbp-views">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle opacity="0.4" cx="12" cy="12" r="10" fill="currentColor"/>
							<path d="M17 10C17 10.5523 16.5523 11 16 11C15.4477 11 15 10.5523 15 10C15 9.44772 15.4477 9 16 9C16.5523 9 17 9.44772 17 10Z" fill="#28303F"/>
							<path d="M9 10C9 10.5523 8.55228 11 8 11C7.44772 11 7 10.5523 7 10C7 9.44772 7.44772 9 8 9C8.55228 9 9 9.44772 9 10Z" fill="currentColor"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9.49455 14.4362C9.1849 14.1645 8.71354 14.1934 8.43945 14.5017C8.16426 14.8113 8.19215 15.2854 8.50174 15.5606L9.00001 15C8.50174 15.5606 8.5015 15.5604 8.50174 15.5606L8.5027 15.5614L8.50376 15.5624L8.50622 15.5645L8.51243 15.5699L8.53 15.5849C8.54398 15.5967 8.56252 15.612 8.58552 15.6303C8.6315 15.6668 8.6955 15.7154 8.77679 15.7719C8.93912 15.8849 9.17203 16.0306 9.46968 16.1749C10.065 16.4635 10.9268 16.75 12 16.75C13.0733 16.75 13.935 16.4635 14.5303 16.1749C14.828 16.0306 15.0609 15.8849 15.2232 15.7719C15.3045 15.7154 15.3685 15.6668 15.4145 15.6303C15.4375 15.612 15.456 15.5967 15.47 15.5849L15.4876 15.5699L15.4938 15.5645L15.4963 15.5624L15.4973 15.5614C15.4976 15.5612 15.4983 15.5606 15 15L15.4983 15.5606C15.8079 15.2854 15.8358 14.8113 15.5606 14.5017C15.2865 14.1934 14.8151 14.1645 14.5055 14.4362L14.5046 14.4369C14.5012 14.4398 14.4929 14.4466 14.4815 14.4557C14.4587 14.4739 14.4201 14.5034 14.3666 14.5406C14.2594 14.6152 14.0939 14.7195 13.8759 14.8251C13.44 15.0365 12.8018 15.25 12 15.25C11.1983 15.25 10.56 15.0365 10.1241 14.8251C9.90611 14.7195 9.74058 14.6152 9.63338 14.5406C9.57991 14.5034 9.54136 14.4739 9.5185 14.4557C9.50708 14.4466 9.49961 14.4404 9.4962 14.4376C9.49547 14.4369 9.49491 14.4365 9.49455 14.4362C9.49456 14.4362 9.49455 14.4362 9.49455 14.4362ZM14.5055 14.4362L14.5046 14.4369L14.5034 14.438L14.5026 14.4387C14.5037 14.4377 14.5044 14.4371 14.5055 14.4362Z" fill="currentColor"/>
						</svg>
						Views: ' . $views . '</div>';
            ?>
            <?php
            //$topic_id = bbp_get_topic_id();
            $tags = \bbp_get_topic_tags($post_id);

            if (! empty($tags) && ! is_wp_error($tags)) {
              echo '<div class="bbp-custom-tags"><strong>Tags:</strong> ';

              foreach ($tags as $tag) {
                // Random background color
                $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                $link  = \esc_url(\get_term_link($tag));
                $name  = \esc_html($tag->name);

                echo '<a href="' . $link . '" class="tag-box" style="border:1px solid ' . $color . ';color:' . $color . ';">' . $name . '</a>';
              }

              echo '</div>';
            }
            ?>
          </div>
        </div>

        <?php
        //end while
      }
      //end if
    } else {
      echo "<div> <p class='center'>" . esc_html__("No Content Found") . "</p></div>";
    }

    //end container dic
    echo '</div>';
  }


  protected function render()
  {
    $settings = $this->get_settings_for_display();

    $tag = isset($_GET['tag']) ? \sanitize_text_field($_GET['tag']) : '';
    $tab    = isset($_GET['tab']) ? \sanitize_text_field($_GET['tab']) : '';
    $search  = isset($_GET['search']) ? \sanitize_text_field($_GET['search']) : '';
    $fav  = isset($_GET['fav']) ? \sanitize_text_field($_GET['fav']) : '';
    $sub  = isset($_GET['sub']) ? \sanitize_text_field($_GET['sub']) : '';
    $engagement  = isset($_GET['engagement']) ? \sanitize_text_field($_GET['engagement']) : '';
    $my_topic  = isset($_GET['my-topic']) ? \sanitize_text_field($_GET['my-topic']) : '';
    $method = "forum_activity_post_markup"; //default

    $args = [
      "post_status" => "publish",
    ];

    if (in_array($tab, ["topic", "forum"])) {
      $args["post_type"] = $tab;
    } else {
      //default fallback
      $args["post_type"] = "topic";
    }

    if ($args["post_type"] == "topic") $method = "topic_post_markup";
    if ($args["post_type"] == "forum") $method = "forum_activity_post_markup";

    if (!empty($tag)) {
      $args['tax_query'] = [
        ['taxonomy' => 'topic-tag', 'field'    => 'slug', 'terms'    => $tag,],
      ];
    }

    if (!empty($search)) {
      $args["s"] = $search;
    }

    if (!empty($my_topic) && \is_user_logged_in()) {
      $args['author'] = \get_current_user_id();
    }

    if (!empty($fav)) {
      $args['meta_query'][] = ['key' => '_bbp_favorite', 'value' => \get_current_user_id()];
    }

    if (!empty($sub)) {
      $args['meta_query'][] = ['key' => '_bbp_subscription', 'value' => \get_current_user_id()];
    }

    if (!empty($engagement)) {
      $args['meta_query'][] = ['key' => '_bbp_engagement', 'value' => \get_current_user_id()];
    }

    $query = new \WP_Query($args);

    function helper_tab_active_class($match_string)
    {
      $url = $_SERVER['REQUEST_URI'];
      return (strpos($url, $match_string) !== false) ? 'active' : '';
    }

    $get_tab_item = function ($tab_key) use ($settings) {
      switch ($tab_key) {
        case "recent_activity": ?>
          <li><a class='<?php echo helper_tab_active_class("tab=topic"); ?>' href="?tab=topic"><?php echo \esc_html__('Recent Activity', 'ONE_CORE_SLUG'); ?></a></li>
        <?php
          break;
        case "forum": ?>
          <li><a class='<?php echo helper_tab_active_class("tab=forum"); ?>' href="?tab=forum"><?php echo \esc_html__('Forums', 'ONE_CORE_SLUG'); ?></a></li>
        <?php
          break;
        case "tag": ?>
          <?php if (!empty($settings["selected_tags"])): ?>
            <?php foreach ($settings["selected_tags"] as $value) : ?>
              <li><a class='<?php echo helper_tab_active_class("tag={$value}"); ?>' href=<?php echo "?tag={$value}";  ?>><?php echo (\get_term_by('slug', $value, 'topic-tag'))->name ?></a></li>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php
          break;
        case "my_topic": ?>
          <?php if (\is_user_logged_in()): ?>
            <li><a class='<?php echo helper_tab_active_class("my-topic=me"); ?>' href="?my-topic=me"><?php echo \esc_html__('My Topic', 'ONE_CORE_SLUG'); ?></a></li>
          <?php endif; ?>
        <?php
          break;
        case "fav": ?>
          <?php if (\is_user_logged_in()): ?>
            <li><a class='<?php echo helper_tab_active_class("fav=me"); ?>' href="?fav=me"><?php echo \esc_html__('Favourite', 'ONE_CORE_SLUG'); ?></a></li>
          <?php endif; ?>
        <?php
          break;
        case "sub": ?>
          <?php if (\is_user_logged_in()): ?>
            <li><a class='<?php echo helper_tab_active_class("sub=me"); ?>' href="?sub=me"><?php echo \esc_html__('Subscription', 'ONE_CORE_SLUG'); ?></a></li>
          <?php endif; ?>
        <?php
          break;
        case "eng": ?>
          <?php if (\is_user_logged_in()): ?>
            <li><a class='<?php echo helper_tab_active_class("engagement=me"); ?>' href="?engagement=me"><?php echo \esc_html__('Engagement', 'ONE_CORE_SLUG'); ?></a></li>
          <?php endif; ?>
        <?php
          break;
        case "search": ?>
          <li> <input type="search" placeholder="search" id="forum-search" /> </li>
    <?php
          break;
      }
    };

    //collect tabs settings
    $tabs = [];

    if (!empty($settings["tabs_list"])) {
      foreach ($settings["tabs_list"] as $tab) {
        if ($tab["tab_key"] !== "") {
          $tabs[] = $tab["tab_key"];
        }
      }
    }


    //TODO:
    //2.elementor control
    //4.topic posted in: blank
    ?>
    <style>
      .tophive-forum-tabs ul:not(:has(a.active)) li:first-child a {
        color: var(--brand-color, #4c6ef5);
      }

      .tophive-forum-tabs ul {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: scroll;

        li a {
          white-space: nowrap;
        }

        li input[type="search"] {
          min-width: 180px;
        }
      }

      .tophive-forum-tabs-container .center {
        text-align: center;
        font-size: var(--font-16, 16px);
      }
    </style>

    <div class="tophive-advanced-forum-tab-container">
      <div class="tophive-forum-tabs">
        <ul>
          <?php
          if (!empty($tabs)) {
            foreach ($tabs as $value) {
              $get_tab_item($value);
            }
          }
          ?>
        </ul>
      </div>

      <div class="tophive-forum-tabs-container">
        <?php $this->$method($query); ?>
      </div>
    </div>
<?php
  }
}

?>
