<?php

class OneBPProfileMedia extends WP_Widget
{

  public function __construct()
  {
    $widget_options = array(
      'classname' => 'tophive-one-profile-media-widget',
      'description' => esc_html__('BuddyPress - One Profile Media', 'ONE_CORE_SLUG')
    );
    parent::__construct('buddypress_profile_media', 'Buddypress profile media [one]', $widget_options);
  }
  public function widget($args, $instance)
  {
    // if ( bp_is_profile_component() ) {
    $html = $args['before_widget'];
    $html .= '<div>';
    $html .= '<h4 class="widget-title">' . $instance['title'] . '</h4>';

    global $wpdb;
    $user_id = bp_displayed_user_id();
    $all_images = [];
    $media_html = '';
    $activities = $wpdb->get_results("SELECT id from {$wpdb->base_prefix}bp_activity WHERE user_id={$user_id} and type='activity_update' ORDER BY id DESC", ARRAY_N);

    if (!empty($activities)) {
      foreach ($activities as $key => $value) {
        $images = bp_activity_get_meta($value[0], 'activity_media', false);
        if (!empty($images[0])) {
          $newImages = $images[0];
          foreach ($newImages as &$image) {
            $image['activity_id'] = $value[0];
          }
          array_push($all_images, ...$newImages);
        }
      }
      array_filter($all_images);
      $media_html .= '<div class="ec-row bp-image-previewer mesonry bp-member-photo-widget">';
      $i = 1;
      $upper_bound = 9;

      foreach ($all_images as $url) {
        if ($i > $upper_bound) {
          break;
        }

        if (!empty($url['thumb']) && isset($url['full']) && isset($url['attachment_id']) && isset($url['activity_id'])) {
          $media_html .= "<img class='media-popup-thumbnail bp-image-single' src='{$url['full']} ' alt='gm' href={$url['full']} data-id={$url['attachment_id']} data-activity={$url['activity_id']}>";
          $i++;
        }
      }
      if (empty($all_images)) {
        $media_html .= '<span class="no-photos">' . esc_html__('No photos', 'ONE_CORE_SLUG') . '</span>';
      }
      $media_html .= '</div>';

      if ($i > $upper_bound) {
        $template_file = 'page-images.php';

        $page = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => $template_file, 'number' => 1,]);

        $permalink = "#";
        if (! empty($page)) {
          $permalink = get_permalink($page[0]->ID);
        }

        $media_html .= "<a href='{$permalink}' class='view-more-media'>" . esc_html__("View All", "one")  . "</a>";
      }
    } else {
      $media_html .= '<span class="no-photos">' . esc_html__('No photos', 'ONE_CORE_SLUG') . '</span>';
    }
    $html .= $media_html;
    $html .= '</div>';
    $html .= $args['after_widget'];
    // }
    echo $html;
  }

  public function form($instance)
  {
    $title = ! empty($instance['title']) ? $instance['title'] : '';
?>
    <div class="mchimp-subs_form">
      <p>
        <label
          for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        <input
          id="<?php echo $this->get_field_id('title'); ?>"
          type="text"
          name="<?php echo $this->get_field_name('title'); ?>"
          value="<?php echo esc_attr($title); ?>" />
      </p>
    </div>
<?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }
}
