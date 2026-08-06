<?php

/**
 * Plugin Name: One Core | By Tophive
 * Plugin URI: https://tophivetheme.com/
 * Description: One Wordpress theme core functionality
 * Version: 2.1.0
 * Author: Tophive
 * Author URI: https://themeforest.net/user/tophive
 * License: Envato
 * Text Domain: ONE_CORE_SLUG
 *
 */

namespace ONECORE;

use ONECORE\widgets\elementor\OneElementorBase;
use ONECORE\widgets\elementor\OneElementorTeam;
use ONECORE\widgets\elementor\OneElementorTeamCarousel;
use ONECORE\widgets\elementor\OneElementorBlog;
use ONECORE\widgets\elementor\OneElementorBlogCarousel;
use ONECORE\widgets\elementor\OneElementorCoursesGrid;
use ONECORE\widgets\elementor\OneElementorImageCarousel;
use ONECORE\widgets\elementor\OneElementorCoursesCarousel;
use ONECORE\widgets\elementor\OneElementorTestimonialCarousel;
use ONECORE\widgets\elementor\OneElementorInstructorFormPopup;
use ONECORE\widgets\elementor\OneElementorAdvanceSearch;
use ONECORE\widgets\elementor\OneElementorAdvanceFilter;
use ONECORE\widgets\elementor\OneElementorAdvancedTabs;
use ONECORE\widgets\elementor\OneElementorActivity;
use ONECORE\widgets\elementor\OneElementorActivityPostForm;
use ONECORE\widgets\elementor\OneElementorMembers;
use ONECORE\widgets\elementor\OneElementorGroups;
use ONECORE\widgets\elementor\OneElementorSearch;
use ONECORE\widgets\elementor\OneElementorCourseCategory;
use ONECORE\widgets\elementor\OneElementorForumTabs;
use ONECORE\widgets\elementor\OneElementorLoginSignup;
use ONECORE\widgets\elementor\OneElementorBBPressNewPost;
use ONECORE\widgets\elementor\OneElementorMemberCount;
use ONECORE\widgets\elementor\OneElementorStory;
use ONECORE\widgets\onewidgets\WidgetHelper;

class OneCore
{

  private static $instance = null;

  public static function constants()
  {
    define('WP_MF_CORE_VERSION',   '2.1.0');
    define('WP_MF_CORE_PREFIX',   'thcore');
    define('ONE_CORE_SLUG',   'ONE_CORE_SLUG');

    // Need to add extra links on plugin activation
    define('WP_MF_CORE_BASENAME', plugin_basename(__FILE__));

    define('WP_MF_CORE_ROOT', __FILE__);
    define('WP_MF_CORE_ROOT_DIR', dirname(WP_MF_CORE_ROOT));

    define('WP_MF_CORE_PATH', plugin_dir_path(WP_MF_CORE_ROOT));
    define('WP_MF_CORE_URL', plugin_dir_url(WP_MF_CORE_ROOT));

    define('WP_MF_CORE_JS_URL',   trailingslashit(WP_MF_CORE_URL . 'js'));
    define('WP_MF_CORE_CSS_URL',   trailingslashit(WP_MF_CORE_URL . 'css'));
    define('WP_MF_CORE_FONTS_URL',   trailingslashit(WP_MF_CORE_URL . 'fonts'));
    define('WP_MF_CORE_IMAGES_URL', trailingslashit(WP_MF_CORE_URL . 'images'));
  }
  public static function init()
  {
    self::constants();
    add_action('wp_enqueue_scripts', array(self::getInstance(), 'frontendassets'));
    \add_action('after_setup_theme', array(self::getInstance(), 'fix_theme_directorist_compat_fatal'), 20);
    add_filter('user_contactmethods', array(self::getInstance(), 'tophiveCutsomContacts'));
    add_action('show_user_profile', array(self::getInstance(), 'tophive_profile_designation'));
    add_action('edit_user_profile', array(self::getInstance(), 'tophive_profile_designation'));
    add_action('personal_options_update', array(self::getInstance(), 'tophive_save_profile_designation'));
    add_action('edit_user_profile_update', array(self::getInstance(), 'tophive_save_profile_designation'));
    add_action('widgets_init', array(self::getInstance(), 'widgetRegistrar'));
    add_action('admin_enqueue_scripts', array(self::getInstance(), 'adminassets'));

    remove_filter('bbp_get_reply_content', 'wp_make_content_images_responsive', 60);
    remove_filter('bbp_get_topic_content', 'wp_make_content_images_responsive', 60);
    // Request Background Image
    add_action('wp_ajax_nopriv_course_grid_pull_cats', array(OneElementorBase::getInstance(), 'deliverCoursesAjaxRequest'));
    add_action('wp_ajax_course_grid_pull_cats', array(OneElementorBase::getInstance(), 'deliverCoursesAjaxRequest'));

    add_action('wp_ajax_pull_course_paged', array(OneElementorBase::getInstance(), 'deliverCoursesAjaxRequest'));
    add_action('wp_ajax_nopriv_pull_course_paged', array(OneElementorBase::getInstance(), 'deliverCoursesAjaxRequest'));

    add_action('wp_ajax_pull_posts_paged', array(OneElementorBase::getInstance(), 'deliverPostsAjaxRequest'));
    add_action('wp_ajax_nopriv_pull_posts_paged', array(OneElementorBase::getInstance(), 'deliverPostsAjaxRequest'));

    add_action('wp_ajax_th_advanced_search', array(OneElementorBase::getInstance(), 'tophiveAdvancedSearch'));
    add_action('wp_ajax_nopriv_th_advanced_search', array(OneElementorBase::getInstance(), 'tophiveAdvancedSearch'));

    add_action('wp_ajax_th_post_topic', array(OneElementorBase::getInstance(), 'tophivePostTopicSubmit'));
    add_action('wp_ajax_nopriv_th_post_topic', array(OneElementorBase::getInstance(), 'tophivePostTopicSubmit'));

    add_action('wp_ajax_mailchimpsubscribe', array(WidgetHelper::getInstance(), 'TH_ajax_subscribe'));
    add_action('wp_ajax_nopriv_mailchimpsubscribe', array(WidgetHelper::getInstance(), 'TH_ajax_subscribe'));
    if (did_action('elementor/loaded')) {
      add_action('elementor/widgets/widgets_registered', array(self::getInstance(), 'OneElementorWidgetInit'));
      add_action('elementor/elements/categories_registered', array(self::getInstance(), 'OneElementorCat'));
    }
    add_action('elementor/preview/enqueue_scripts', function () {
      wp_enqueue_script(
        'tophive-elementor-scripts',
        get_theme_file_uri('assets/js/compatibility/buddypress.js'),
        ['jquery'],
        defined('TH_ELEMENTOR_PLUGIN_VERSION') ? TH_ELEMENTOR_PLUGIN_VERSION : false,
        true
      );
    });

    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'learn_press_print_custom_styles');
  }

  function tophiveCutsomContacts($contactmethods)
  {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['youtube'] = 'Youtube';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['linkedin'] = 'LinkedIn';
    $contactmethods['slack'] = 'Slack';
    return $contactmethods;
  }
  function tophive_profile_designation($user)
  {
?>
    <h3><?php echo esc_html__('Extra profile information', 'tophive'); ?></h3>
    <table class="form-table">
      <tr>
        <th><label for="designation"><?php echo esc_html__('Designation', 'tophive'); ?></label></th>
        <td>
          <input type="text" name="designation" id="designation" class="regular-text"
            value="<?php echo esc_attr(get_the_author_meta('designation', $user->ID)); ?>" /><br />
          <span class="description"><?php echo esc_html__('Please enter your designation.', 'tophive'); ?></span>
        </td>
      </tr>
    </table>
<?php
  }
  public function tophive_save_profile_designation($user_id)
  {
    $saved = false;
    if (current_user_can('edit_user', $user_id)) {
      update_user_meta($user_id, 'designation', $_POST['designation']);
      $saved = true;
    }
    return true;
  }

  public static function OneElementorWidgetInit()
  {
    // $this->includesElem();
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorTeam());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorTeamCarousel()); //HAS AN FIX
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorBlog());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorBlogCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorCoursesGrid());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorImageCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorCoursesCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorTestimonialCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorCourseCategory());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorInstructorFormPopup());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorAdvanceSearch());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorAdvanceFilter());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorAdvancedTabs());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorActivity());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorActivityPostForm());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorMembers());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorGroups());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorSearch());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorForumTabs());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorBBPressNewPost());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorLoginSignup());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorMemberCount());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new OneElementorStory());
  }
  public static function OneElementorCat($elements_manager)
  {
    $elements_manager->add_category(
      'ONE_CORE_SLUG',
      [
        'title' => esc_html__('One Widgets', 'ONE_CORE_SLUG'),
        'icon' => 'eicon-t-letter',
      ]
    );
  }
  public static function inlineStyles() {}

  public static function frontendassets()
  {

    wp_register_style('th-style', false);
    wp_enqueue_script(
      'th-elementor-lazy-js',
      WP_MF_CORE_URL . 'widgets/elementor/assets/jquery.lazy.min.js',
      array('jquery')
    );
    wp_enqueue_script('th-widget-js', WP_MF_CORE_URL . 'widgets/onewidgets/assets/js/frontend.js');
    wp_enqueue_style('th-wp-widget-styles', WP_MF_CORE_URL . 'widgets/wordpress/assets/styles.css');
    wp_enqueue_style('th-elementor-css', WP_MF_CORE_URL . 'widgets/elementor/assets/style.min.css');
    wp_enqueue_style('th-widget-css', WP_MF_CORE_URL . 'widgets/onewidgets/assets/css/frontend.css');
    wp_localize_script(
      'th-elementor-js',
      'th_elem_ajax_obj',
      array('ajaxurl' => admin_url('admin-ajax.php'))
    );
    add_action('wp_ajax_course_grid_pull_cats', array(OneElementorBase::getInstance(), 'AjaxCourseRequest'));
    add_action('wp_ajax_nopriv_course_grid_pull_cats', array(OneElementorBase::getInstance(), 'AjaxCourseRequest'));
    wp_enqueue_script('rich-text-quill', WP_MF_CORE_URL . 'widgets/elementor/assets/quill.min.js', array(), '4.0.6');

    wp_enqueue_style('rich-text-quill-css', WP_MF_CORE_URL . 'widgets/elementor/assets/quill.snow.min.css');
    wp_enqueue_script('th-elementor-js', WP_MF_CORE_URL . 'widgets/elementor/assets/script.js', array('jquery'));
  }
  public static function widgetRegistrar()
  {
    require_once('widgets/onewidgets/OneRecentPostsWidget.php');
    require_once('widgets/onewidgets/OneSidebarMenuWidget.php');
    require_once('widgets/onewidgets/OneMailChimpWidget.php');
    require_once('widgets/onewidgets/OneBPGroupsInfo.php');
    require_once('widgets/onewidgets/OneBPProfileInfo.php');
    require_once('widgets/onewidgets/OneBPGroupMembers.php');
    require_once('widgets/onewidgets/OneBPProfileMedia.php');

    register_widget('OneRecentPostsWidget');
    register_widget('OneSidebarMenuWidget');
    register_widget('OneMailChimpWidget');
    register_widget('OneBPGroupsInfo');
    register_widget('OneBPGroupMembers');
    register_widget('OneBPProfileInfo');
    register_widget('OneBPProfileMedia');
  }

  public function fix_theme_directorist_compat_fatal()
  {
    if (!\function_exists('one_enqueue_compat_assets')) {
      return;
    }

    if (\has_action('wp_enqueue_scripts', 'one_enqueue_compat_assets')) {
      \remove_action('wp_enqueue_scripts', 'one_enqueue_compat_assets');
    }

    \add_action('wp_enqueue_scripts', array($this, 'enqueue_compat_assets_safe'));
  }

  private function request_uri_contains(array $needles)
  {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? strtolower((string) $_SERVER['REQUEST_URI']) : '';
    foreach ($needles as $needle) {
      $needle = strtolower((string) $needle);
      if ($needle !== '' && strpos($request_uri, $needle) !== false) {
        return true;
      }
    }
    return false;
  }

  public function enqueue_compat_assets_safe()
  {
    $is_event_context = \function_exists('tribe_is_event_query') && \tribe_is_event_query();
    if ($is_event_context || $this->request_uri_contains(array('/events', '/event/'))) {
      \wp_enqueue_style('th-event-calender', \get_template_directory_uri() . '/assets/css/compatibility/event-calender.css', array(), false, 'all');
    }

    $is_tutor_context = (\function_exists('learn_press_is_course') && \learn_press_is_course()) || (\function_exists('learn_press_is_courses') && \learn_press_is_courses());
    if ($is_tutor_context || $this->request_uri_contains(array('/courses', 'lp-course', 'learnpress', 'tutor'))) {
      \wp_enqueue_style('tutor-lms', \get_template_directory_uri() . '/assets/css/compatibility/tutor.min.css', array(), false, 'all');
    }

    $is_pmpro_context = \function_exists('pmpro_is_checkout') && (\pmpro_is_checkout() || \pmpro_is_account_page() || \pmpro_is_billing_page() || \pmpro_is_levels_page());
    if ($is_pmpro_context || $this->request_uri_contains(array('/membership', '/memberships', 'pmpro'))) {
      \wp_enqueue_style('pmpro', \get_template_directory_uri() . '/assets/css/compatibility/pmpro.min.css', array(), false, 'all');
    }

    $is_directorist_context = false;
    if (\defined('ATBDP_POST_TYPE')) {
      $is_directorist_context = (\function_exists('is_singular') && \is_singular(\ATBDP_POST_TYPE)) || (\function_exists('is_post_type_archive') && \is_post_type_archive(\ATBDP_POST_TYPE));
    }
    if (!$is_directorist_context && \defined('ATBDP_DIRECTORY_TYPE')) {
      $is_directorist_context = \function_exists('is_tax') && \is_tax(\ATBDP_DIRECTORY_TYPE);
    }
    if ($is_directorist_context || $this->request_uri_contains(array('/directory', '/listing', '/directorist'))) {
      \wp_enqueue_style('directorist', \get_template_directory_uri() . '/assets/css/compatibility/directorist.min.css', array(), false, 'all');
    }

    $needs_swiper = \function_exists('is_page_template') && (\is_page_template('page-images.php') || \is_page_template('page-videos.php') || \is_page_template('page-documents.php'));
    if ($needs_swiper || $this->request_uri_contains(array('swiper', 'carousel'))) {
      \wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0', true);
    }
  }
  public static function adminassets()
  {
    wp_enqueue_media();
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('tophive-select2', WP_MF_CORE_URL . 'widgets/elementor/assets/select2.min.js', array(), '4.0.6');

    wp_enqueue_script('enhanced-colorpicker', WP_MF_CORE_URL . 'widgets/onewidgets/assets/js/colorpicker.js', array('wp-color-picker'), '1.0', true);
    wp_enqueue_script('tophive-widgets-scripts', WP_MF_CORE_URL . 'widgets/onewidgets/assets/js/admin.js', array(), '4.0.6');
    wp_enqueue_script('tophive-elementor', WP_MF_CORE_URL . 'widgets/elementor/assets/script.js', array('jquery'), '1.0.0');

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('enhanced-colorpicker', WP_MF_CORE_URL . 'widgets/onewidgets/assets/css/colorpicker.css');
    wp_enqueue_style('tophive-select2', WP_MF_CORE_URL . 'widgets/elementor/assets/select2.min.css');
    wp_enqueue_style('tophive-widgets-style', WP_MF_CORE_URL . 'widgets/onewidgets/assets/css/admin.css');
  }

  /**
   * Load plugin textdomain.
   *
   * @since 1.0.0
   */
  public static function OneLoadTextdomain()
  {
    load_plugin_textdomain('ONE_CORE_SLUG', false, basename(dirname(__FILE__)) . '/languages');
  }

  public static function getInstance()
  {
    if (empty(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}

spl_autoload_register(__NAMESPACE__ . '\\autoload');


add_action('plugins_loaded', array(OneCore::getInstance(), 'init'));

require_once('inc/class-entitlement-bridge.php');
require_once('MailChimp.php');
require_once('t/class-tophive-modules.php');
require_once('inc/admin/demo-import.php');
require_once('inc/admin/one-extension-export.php');

function autoload($class = '')
{
  if (!strstr($class, 'ONECORE')) {
    return;
  }
  $result = str_replace('ONECORE\\', '', $class);
  $result = str_replace('\\', '/', $result);
  require $result . '.php';
}
remove_action('shutdown', 'wp_ob_end_flush_all', 1);
