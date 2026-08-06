<?php
if (! defined('ABSPATH')) exit;

// Include WordPress plugin functions
if (!function_exists('is_plugin_active')) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// 1. Enqueue JS + Modal Styles + Localize Steps
add_action('admin_enqueue_scripts', function () {
  $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
  $tab = isset($_GET['tab']) ? sanitize_key(wp_unslash($_GET['tab'])) : 'dashboard';
  if ('one' !== $page || 'importer' !== $tab) {
    return;
  }

  $version = defined('WP_MF_CORE_VERSION') ? WP_MF_CORE_VERSION : null;
  wp_enqueue_script('bp-demo-import', plugin_dir_url(__FILE__) . '/demo-import.js', ['jquery'], $version, true);
  wp_enqueue_script('bp-demo-import-ui', plugin_dir_url(__FILE__) . '/demo-import-ui.js', ['wp-element', 'jquery'], $version, true);
  // Check if this is a fresh install - more comprehensive check
  $posts_count = wp_count_posts('post')->publish + wp_count_posts('page')->publish;
  $users_count = count_users()['total_users'];
  $is_fresh_install = ($posts_count <= 2 && $users_count <= 1) || get_option('one_theme_core_demo_imported') !== 'yes';
  
  wp_localize_script('bp-demo-import', 'BPDemoSteps', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('bp_demo_import_step'),
    'license_active' => \ONECORE\EntitlementBridge::has('demo_import'),
    'license_url' => admin_url('themes.php?page=one&tab=license'),
    // steps will be built dynamically by UI selections
    'default_steps' => [],
    'is_fresh_install' => $is_fresh_install,
    'plugin_map' => [
      'buddypress' => 'buddypress',
      'bbpress' => 'bbpress',
      'elementor' => 'elementor',
      'events' => 'the-events-manager',
      'woocommerce' => 'woocommerce',
      'directory' => 'directorist',
      'job_manager' => 'wp-job-manager',
      'tutor' => 'tutor',
      'pmp' => 'paid-memberships-pro',
    ],
    'defaults' => [
      'customizer' => true,
      'menus' => true,
      'buddypress' => true,
      'courses' => false,
      'directory' => false,
      'events' => false,
      'woocommerce' => false,
      'job_manager' => false,
      'forums' => false,
      'pmp' => false,
      'media_pages' => false,
    ]
  ]);

  wp_enqueue_style('bp-demo-import-style', plugin_dir_url(__FILE__) . '/demo-import.css', [], $version);
});

// 2. Add Admin Page with Import Button + Modal Container
add_action('tophive/admin/demo-content-container', 'bp_demo_import_page');

function bp_demo_import_page()
{
  if (!\ONECORE\EntitlementBridge::has('demo_import')) {
    echo '<section class="one-core-license-required">';
    echo '<h2>' . esc_html__('Activate One to import demo content', 'one') . '</h2>';
    echo '<p>' . esc_html__('Demo imports are available when this website has a valid One theme license or a signed grace entitlement.', 'one') . '</p>';
    echo '<p><a class="one-admin-button one-admin-button--primary" href="' . esc_url(admin_url('themes.php?page=one&tab=license')) . '">' . esc_html__('Open License', 'one') . '</a></p>';
    echo '</section>';
    return;
  }

  $home_url  = esc_url(home_url('/'));
  $admin_url = esc_url(admin_url('themes.php?page=one&tab=importer'));

  echo '<div id="bp-demo-modal" class="bp-demo-modal" style="display:none;">
        <div class="bp-demo-modal-content">
            <button id="bp-close-import" type="button" class="bp-demo-modal-close" aria-label="' . esc_attr__('Close importer', 'one') . '">✕</button>
            <script src="https://cdn.tailwindcss.com"></script>
            <div class="bp-demo-modal-heading">
              <span>' . esc_html__('Demo setup', 'one') . '</span>
              <h2>' . esc_html__('Choose what to import', 'one') . '</h2>
              <p>' . esc_html__('Select the content and integrations you want. Existing imported items stay protected.', 'one') . '</p>
            </div>
            <div id="one-demo-react-root"></div>
            <div id="bp-demo-log">
              <div id="bp-demo-log-text">' . esc_html__('Ready to import…', 'one') . '</div>
              <div class="bp-demo-progress" style="display:none;"><div class="bar"></div></div>
            </div>
            <div class="bp-demo-modal-actions">
                <button id="bp-cancel-import" class="button">' . esc_html__('Cancel', 'one') . '</button>
                <button id="bp-start-import" class="button button-primary">' . esc_html__('Start importing', 'one') . '</button>
            </div>
            <div id="bp-demo-final-buttons" class="bp-demo-final-actions" style="display:none;">
                <a href="' . $admin_url . '" class="button button-secondary">' . esc_html__('Back to demos', 'one') . '</a>
                <a href="' . $home_url . '" class="button button-primary" target="_blank" rel="noopener noreferrer">' . esc_html__('Visit website', 'one') . '</a>
            </div>
        </div>
    </div>';

  echo '<section class="one-core-demo-banner">
      <div class="one-core-demo-banner__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24"><path d="M12 3v11"/><path d="m8 10 4 4 4-4"/><path d="M5 15.5V20h14v-4.5"/></svg>
      </div>
      <div class="one-core-demo-banner__copy">
        <h3 class="one-core-demo-banner__title">' . esc_html__('One starter content', 'one') . '</h3>
        <p class="one-core-demo-banner__meta">' . esc_html__('Import the core structure, menus, widgets, and only the integrations you select.', 'one') . '</p>
      </div>
      <button id="start-demo-import" class="button button-primary">' . esc_html__('Choose content', 'one') . '</button>
    </section>';
}


// 3. AJAX Endpoints
add_action('wp_ajax_bp_demo_import_step', function () {
  if ( ! current_user_can( 'manage_options' ) ) {
    wp_send_json_error( [ 'message' => 'Unauthorized' ], 403 );
  }
  check_ajax_referer( 'bp_demo_import_step', '_wpnonce' );
  if (!\ONECORE\EntitlementBridge::has('demo_import')) {
    wp_send_json_error([
      'message' => esc_html__('A valid One theme license is required for demo imports.', 'one'),
      'code' => 'one_license_required',
    ], 403);
  }
  $step = sanitize_text_field($_POST['step'] ?? '');
  $payload_slugs = isset($_POST['slugs']) && is_array($_POST['slugs']) ? array_map('sanitize_text_field', $_POST['slugs']) : [];

  // Guard instantiation to avoid diagnostics when class not loaded yet
  $Tophovive_License_Instance = class_exists('Tophive_Licence') ? new Tophive_Licence() : null;

  $ob_level = ob_get_level();
  ob_start();

  try {
    $response = null;

    switch ($step) {
      case 'install_plugins':
        bp_demo_install_plugins($payload_slugs);
        break;
      case 'import_exported_demo':
        // Import exported demo JSON based on a provided path and section keys
        $path = isset($_POST['path']) ? sanitize_text_field($_POST['path']) : '';
        $sections = isset($_POST['sections']) && is_array($_POST['sections']) ? array_map('sanitize_key', $_POST['sections']) : [];
        if (empty($path)) throw new Exception('Missing demo file path');
        require_once __DIR__ . '/one-extension-export.php';
        $map = [];
        foreach ($sections as $k) { $map[$k] = true; }
        $count = One_Extension_Export::import_from_file($path, $map);
        $response = ['message' => 'Demo data imported (' . intval($count) . ' items).'];
        break;
      case 'import_extension_demos':
        // Import demo content for Tutor LMS, Directorist, WP Events, WooCommerce, and WP Job Manager
        require_once __DIR__ . '/one-extension-export.php';
        $results = [];
        $results['tutor_lms'] = One_Extension_Export::import_tutor_demo_content();
        $results['directorist'] = One_Extension_Export::import_directorist_demo_content();
        $results['events'] = One_Extension_Export::import_events_demo_content();
        $results['woocommerce'] = One_Extension_Export::import_woocommerce_demo_content();
        $results['wp_job_manager'] = One_Extension_Export::import_wp_job_manager_demo_content();
        
        $total_created = 0;
        foreach ($results as $plugin => $count) {
          if (is_numeric($count)) {
            $total_created += $count;
          }
        }
        
        $response = [
          'message' => 'Extension demo content imported successfully (' . $total_created . ' items created).',
          'results' => $results
        ];
        break;
      case 'setup_homepage':
        bp_demo_setup_activity_home();
        break;
      case 'import_pages':
        bp_demo_import_pages();
        break;
      case 'import_users':
        bp_demo_import_users();
        break;
      case 'enable_groups_component':
        bp_demo_enable_groups_component_properly();
        break;
      case 'import_groups':
        bp_demo_import_groups();
        break;
      case 'import_activities':
        bp_demo_import_activities();
        break;
      case 'import_widgets':
        bp_demo_import_widgets_from_wie();
        break;
      case 'import_menus':
        bp_demo_import_menus();
        break;
      case 'import_customizer':
        $response = bp_demo_import_customizer();
        break;
      case 'import_blog_posts':
        bp_demo_import_blog_posts();
        break;
      case 'import_forums':
        bp_demo_import_forums();
        break;

      case 'create_media_pages':
        bp_demo_create_media_pages();
        break;


      default:
        throw new Exception('Invalid step.');
    }

    $extra_output = '';
    while (ob_get_level() > $ob_level) {
      $extra_output .= (string) ob_get_clean();
    }
    if (trim($extra_output) !== '') {
      error_log('bp_demo_import_step unexpected output: ' . wp_strip_all_tags($extra_output));
    }

    if (!is_array($response)) {
      $response = ['message' => ucfirst(str_replace('_', ' ', $step)) . ' complete.'];
    }

    wp_send_json_success($response);
  } catch (Exception $e) {
    $extra_output = '';
    while (ob_get_level() > $ob_level) {
      $extra_output .= (string) ob_get_clean();
    }
    if (trim($extra_output) !== '') {
      error_log('bp_demo_import_step unexpected output (error): ' . wp_strip_all_tags($extra_output));
    }

    wp_send_json_error(['message' => $e->getMessage()]);
  }
});


function bp_demo_import_menus()
{
  $menus_path = plugin_dir_path(__FILE__) . '/demo-data/menus.json';

  if (!file_exists($menus_path)) {
    throw new Exception('Menus JSON file not found.');
  }

  $json = file_get_contents($menus_path);
  $menus = json_decode($json, true);

  if (empty($menus)) {
    throw new Exception('No menu data to import.');
  }

  $menu_locations = [];

  foreach ($menus as $_menu) {
    //create menu term if not exist
    //update menu location so this menu get render on that location
    //insert menu item in post table with menu order and parent menu preservation
    $menu_name = $_menu["menu"]["name"];
    $menu_exist = wp_get_nav_menu_object($menu_name);

    if ($menu_exist == false) {
      $menu_id = wp_create_nav_menu($menu_name);
      if (is_wp_error($menu_id)) {
        error_log("Nav menu creation fail: {$menu_name}");
        continue;
      }



      $menu_obj = wp_get_nav_menu_object($menu_id);
      if ($menu_obj == false) {
        error_log("wp_get_nav_menu_object fail: {$menu_id}");
        continue;
      }

      $menu_locations[$_menu['menu']['slug']] = $menu_id;

      $oldid_map_newid = [];

      foreach ($_menu["items"] as $m) {
        if ($m["parent"] != "0") continue;
        $full_url = $m['url'];
        if (substr($full_url, 0, 1) === '/') {
          $full_url = rtrim(get_site_url(), '/') . $full_url;
        }
        $id = wp_update_nav_menu_item($menu_id, 0, [
          'menu-item-title' => $m['title'],
          'menu-item-url' => $full_url,
          'menu-item-status' => 'publish',
          'menu-item-position' => $m['order']
        ]);
        if (is_wp_error($id)) {
          error_log("wp_update_nav_menu_item fail: {$menu_id} title: {$m['title']}");
          continue;
        }
        // Add icon if available
        if (!empty($m['icon'])) {
          update_post_meta($id, '_menu_item_menu-icon-text', esc_url($m['icon']));
        }
        if (!empty($m['svg_icon'])) {
          update_post_meta($id, '_menu_item_menu-icon-svg', $m['svg_icon']);
        }
      
        $oldid_map_newid[$m["id"]] = $id;
      }



      foreach ($_menu["items"] as $m) {
        if ($m["parent"] == "0") continue;
        $full_url = $m['url'];
        if (substr($full_url, 0, 1) === '/') {
          $full_url = rtrim(get_site_url(), '/') . $full_url;
        }
        $id = wp_update_nav_menu_item($menu_id, 0, [
          'menu-item-title' => $m['title'],
          'menu-item-url' => $full_url,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $oldid_map_newid[$m["parent"]],
          'menu-item-position' => $m['order']
        ]);
        if (is_wp_error($id)) {
          error_log("wp_update_nav_menu_item fail: {$menu_id} title: {$m['title']}");
          continue;
        }
        // Add icon if available
        if (!empty($m['icon'])) {
          update_post_meta($id, '_menu_item_menu-icon-text', esc_url($m['icon']));
        }
        $oldid_map_newid[$m["id"]] = $id;
      }
    }
  }

  set_theme_mod("nav_menu_locations", $menu_locations);
  return true;
}
// Added By Lead Dev
// Main media sideloader
function one_sideload_media_from_url($image_url)
{

  // it allows us to use download_url() and wp_handle_sideload() functions
  require_once(ABSPATH . 'wp-admin/includes/file.php');

  // download to temp dir
  $temp_file = download_url($image_url);

  if (is_wp_error($temp_file)) {
    return false;
  }

  // move the temp file into the uploads directory
  $file = array(
    'name'     => basename($image_url),
    'type'     => mime_content_type($temp_file),
    'tmp_name' => $temp_file,
    'size'     => filesize($temp_file),
  );
  $sideload = wp_handle_sideload(
    $file,
    array(
      'test_form'   => false // no needs to check 'action' parameter
    )
  );

  if (! empty($sideload['error'])) {
    // you may return error message if you want
    return false;
  }

  // it is time to add our uploaded image into WordPress media library
  $attachment_id = wp_insert_attachment(
    array(
      'guid'           => $sideload['url'],
      'post_mime_type' => $sideload['type'],
      'post_title'     => basename($sideload['file']),
      'post_content'   => '',
      'post_status'    => 'inherit',
    ),
    $sideload['file']
  );

  if (is_wp_error($attachment_id) || ! $attachment_id) {
    return false;
  }

  // update medatata, regenerate image sizes
  require_once(ABSPATH . 'wp-admin/includes/image.php');

  wp_update_attachment_metadata(
    $attachment_id,
    wp_generate_attachment_metadata($attachment_id, $sideload['file'])
  );

  return [
    'attachment_id' => $attachment_id,
    'file_url' => wp_get_attachment_url($attachment_id)
  ];
}


function download_image_from_url(string $url)

{
  if (filter_var($url, FILTER_VALIDATE_URL) ==  false) {
    error_log("validation fail of url {$url}");
    return false;
  };

  $file_content = @file_get_contents($url);
  if ($file_content == false) {
    error_log("download fail of url {$url}");
    return false;
  }

  return $file_content;
}

function upload_raw_image_data($image_data, $url)
{
  // Get the filename from the URL
  $filename = basename(parse_url($url, PHP_URL_PATH));

  // Upload to WordPress
  $upload = wp_upload_bits($filename, null, $image_data);

  if ($upload['error']) {
    error_log("upload_raw_image_data fail url:--->{$url}");
    return false;
  }

  // Get the file type
  $wp_filetype = wp_check_filetype($upload['file'], null);

  // Prepare attachment data
  $attachment = [
    'post_mime_type' => $wp_filetype['type'],
    'post_title'     => sanitize_file_name($filename),
    'post_content'   => '',
    'post_status'    => 'inherit'
  ];

  // Insert the attachment into the Media Library
  $attach_id = wp_insert_attachment($attachment, $upload['file'], 0);
  if (is_wp_error($attach_id)) {
    error_log("wp_insert_attachment fail url:--->{$url}");
    return false;
  }

  // Include WordPress image functions
  require_once(ABSPATH . 'wp-admin/includes/image.php');

  // GENERATE ATTACHMENT METADATA AND UPDATE USE THIS LINE IF YOU WANT TO MAKE MULTIPLE RESULATION OF SAME IMAGE
  // $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
  // wp_update_attachment_metadata($attach_id, $attach_data);

  return [
    'attachment_id' => $attach_id,
    'file_url' => $upload['url']
  ];
}



add_filter('get_avatar_url', 'bp_demo_custom_avatar_url', 10, 2);
function bp_demo_custom_avatar_url($url, $id_or_email)
{
  if (is_admin()) return $url; // optional: skip in admin

  $user = false;

  if (is_numeric($id_or_email)) {
    $user = get_user_by('id', (int) $id_or_email);
  } elseif (is_object($id_or_email) && isset($id_or_email->user_id)) {
    $user = get_user_by('id', (int) $id_or_email->user_id);
  } elseif (is_string($id_or_email)) {
    $user = get_user_by('email', $id_or_email);
  }

  if ($user) {
    $custom_avatar = get_user_meta($user->ID, 'custom_avatar_url', true);
    if (!empty($custom_avatar)) {
      return esc_url($custom_avatar);
    }
  }
  return $url;
}

add_filter('bp_core_fetch_avatar', 'bp_demo_custom_avatar_for_buddypress', 10, 2);
function bp_demo_custom_avatar_for_buddypress($avatar, $args)
{
  if (isset($args['item_id'])) {
    $custom = get_user_meta($args['item_id'], 'custom_avatar_url', true);
    if (!empty($custom)) {
      $size = isset($args['width']) ? $args['width'] : 96;
      return '<img src="' . esc_url($custom) . '" class="avatar avatar-' . esc_attr($size) . ' photo" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" />';
    }
  }
  return $avatar;
}


function bp_demo_import_activities()
{
  $file_path = plugin_dir_path(__FILE__) . '/demo-data/buddypress_demo_activities.json';

  if (!file_exists($file_path)) {
    echo '<div class="notice notice-error"><p>JSON file not found.</p></div>';
    return;
  }

  $json = file_get_contents($file_path);
  $activities = json_decode($json, true);


  foreach ($activities as $activity) {
    $activity_id = bp_activity_add([
      'user_id'       => $activity['author'], // ← Use current user
      'content'       => $activity['content'],
      'component'     => 'activity',
      'type'          => 'activity_update',
      'recorded_time' => date('Y-m-d H:i:s', $activity['timestamp']),
    ]);

    if (!$activity_id) continue;

    // Reactions
    if (!empty($activity['reactions']) && is_array($activity['reactions'])) {
      $clean_reactions = [];
      foreach ($activity['reactions'] as $reaction => $data) {
        if (is_array($data) && isset($data['count']) && isset($data['users']) && is_array($data['users'])) {
          $clean_reactions[$reaction] = [
            'count' => (int) $data['count'],
            'users' => array_map('intval', $data['users']),
          ];
        }
      }
      bp_activity_add_meta($activity_id, 'tophive_activity_reactions', $clean_reactions);
    }

    // Media
    if (!empty($activity['media']) && is_array($activity['media'])) {
      $clean_media = array_filter($activity['media'], function ($item) {
        return is_array($item) && isset($item['full']);
      });
      bp_activity_add_meta($activity_id, 'activity_media', array_values($clean_media));
    }

    // Comments
    if (!empty($activity['comments']) && is_array($activity['comments'])) {
      $clean_comments = [];
      foreach ($activity['comments'] as $comment) {
        if (!is_array($comment) || !isset($comment['ID'], $comment['content'])) continue;

        $comment['reactions'] = (isset($comment['reactions']) && is_array($comment['reactions'])) ? $comment['reactions'] : [];
        $comment['replies'] = (isset($comment['replies']) && is_array($comment['replies'])) ? $comment['replies'] : [];

        foreach ($comment['replies'] as &$reply) {
          if (!is_array($reply) || !isset($reply['reactions'])) continue;
          $reply['reactions'] = is_array($reply['reactions']) ? $reply['reactions'] : [];
        }

        $clean_comments[] = $comment;
      }

      bp_activity_add_meta($activity_id, 'tophive_activity_comments', $clean_comments);
    }

    // Set visibility
    bp_activity_add_meta($activity_id, 'activity_accessibility', 'public');
  }

  // echo '<div class="notice notice-success"><p>Demo activities imported successfully!</p></div>';
}
function bp_demo_import_users()
{
  $file_path = plugin_dir_path(__FILE__) . '/demo-data/buddypress_demo_users.json';

  if (!file_exists($file_path)) {
    echo '<div class="notice notice-error"><p>Users JSON file not found.</p></div>';
    return;
  }

  $json = file_get_contents($file_path);
  $users = json_decode($json, true);

  foreach ($users as $user) {
    if (username_exists($user['username']) || email_exists($user['email'])) {
      continue; // Skip existing users
    }

    $user_id = wp_insert_user([
      'user_login'   => $user['username'],
      'user_pass'    => $user['password'],
      'user_email'   => $user['email'],
      'display_name' => $user['display_name'],
      'first_name'   => $user['first_name'],
      'last_name'    => $user['last_name'],
      'role'         => $user['role']
    ]);

    if (!is_wp_error($user_id)) {
      $avatar_url = esc_url_raw($user['avatar']);
      $upload_dir = wp_upload_dir();
      $avatar_dir = $upload_dir['basedir'] . "/avatars/{$user_id}";

      wp_mkdir_p($avatar_dir);

      $response = wp_remote_get($avatar_url);
      if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        if (!empty($body)) {
          file_put_contents("{$avatar_dir}/{$user_id}-bpfull.jpg", $body);
          file_put_contents("{$avatar_dir}/{$user_id}-bpthumb.jpg", $body);
        }
      }
    }
  }

  // echo '<div class="notice notice-success"><p>Demo users imported successfully (with avatars)!</p></div>';
}
function bp_demo_install_plugins($slugs = [])
{
  include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
  include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  include_once ABSPATH . 'wp-admin/includes/plugin.php';

  if (!class_exists('BP_Silent_Upgrader_Skin')) {
    class BP_Silent_Upgrader_Skin extends \WP_Upgrader_Skin
    {
      public function header() {}
      public function footer() {}
      public function feedback($string, ...$args) {}
    }
  }

  function get_main_plugin_file($slug)
  {
    $plugin_dir = WP_PLUGIN_DIR . '/' . $slug;
    if (!is_dir($plugin_dir)) return false;
    $files = scandir($plugin_dir);
    foreach ($files as $file) {
      if (strpos($file, '.php') !== false) {
        $contents = file_get_contents("$plugin_dir/$file");
        if (strpos($contents, 'Plugin Name:') !== false) {
          return "$slug/$file";
        }
      }
    }
    return false;
  }

  if (empty($slugs) || !is_array($slugs)) {
    $slugs = ['buddypress', 'bbpress', 'elementor'];
  }
  $to_activate = [];

  foreach ($slugs as $slug) {
    if (!file_exists(WP_PLUGIN_DIR . "/$slug")) {
      $api = plugins_api('plugin_information', ['slug' => $slug, 'fields' => ['sections' => false]]);
      if (!is_wp_error($api)) {
        $upgrader = new Plugin_Upgrader(new BP_Silent_Upgrader_Skin());
        $upgrader->install($api->download_link);
      }
    }

    $plugin_file = get_main_plugin_file($slug);
    if ($plugin_file && !is_plugin_active($plugin_file)) {
      $to_activate[] = $plugin_file;
    }
  }

  if (!empty($to_activate)) {
    activate_plugins($to_activate);
  }
}


function bp_demo_import_pages()
{
  $file_path = plugin_dir_path(__FILE__) . '/demo-data/pages.json';

  if (!file_exists($file_path)) {
    return ['success' => false, 'message' => 'Pages JSON file not found.'];
  }

  $json = file_get_contents($file_path);
  $pages = json_decode($json, true);

  if (empty($pages) || !is_array($pages)) {
    return ['success' => false, 'message' => 'Invalid pages data.'];
  }

  foreach ($pages as $page) {
    import_post($page, 'page');
  }

  return ['success' => true, 'message' => 'Pages imported successfully!'];
}

function bp_demo_import_forums()
{
  $file = plugin_dir_path(__FILE__) . '/demo-data/forums.json';
  if (!file_exists($file)) return ['success' => false, 'message' => 'Forums JSON not found.'];

  $json = file_get_contents($file);
  $forums = json_decode($json, true);

  if (empty($forums)) return ['success' => false, 'message' => 'Invalid forums data.'];

  foreach ($forums as $forum) {
    $topic_id = bbp_insert_topic([
      'post_title'   => $forum['title'],
      'post_content' => $forum['content'],
      'post_status'  => 'publish',
      'post_author'  => $forum['author'],
      'post_date'    => $forum['date'],
    ], [
      'forum_id' => $forum['forum_id'],
    ]);

    if (!$topic_id) continue;

    if (!empty($forum['replies'])) {
      foreach ($forum['replies'] as $reply) {
        bbp_insert_reply([
          'post_content' => $reply['content'],
          'post_status'  => 'publish',
          'post_author'  => $reply['author'],
          'post_date'    => $reply['date'],
          'post_parent'  => $topic_id,
        ], [
          'topic_id' => $topic_id,
          'forum_id' => $forum['forum_id'],
        ]);
      }
    }
  }

  return ['success' => true, 'message' => 'Forums imported.'];
}

function restore_post_meta($post_id, $meta)
{

  if (!is_array($meta)) {
    return false;
  }

  foreach ($meta as $key => $value) {
    if ($key === '_elementor_data' && is_array($value)) {
      $value = wp_slash(json_encode($value));
      update_post_meta($post_id, $key, $value);
    } else {
      update_post_meta($post_id, $key, $value);
    }
  }

  return true;
}



function recursively_replace_urls($data, $url_map)
{
  foreach ($data as $key => $value) {
    if (is_array($value)) {
      // Check for image object with 'url'
      if (isset($value['url']) && is_string($value['url'])) {
        foreach ($url_map as $old_url => $new_data) {
          if (strpos($value['url'], $old_url) !== false) {
            $data[$key]['url'] = $new_data['url'];
            $data[$key]['id'] = $new_data['attachment_id'];
            $data[$key]['source'] = 'library';
            break; // Skip deeper recursion for matched image
          }
        }
      } else {
        // Continue recursion
        $data[$key] = recursively_replace_urls($value, $url_map);
      }
    } elseif (is_string($value)) {
      foreach ($url_map as $old_url => $new_data) {
        if (strpos($value, $old_url) !== false) {
          $data[$key] = str_replace($old_url, $new_data['url'], $value);
        }
      }
    }
  }
  return $data;
}



function import_post(array $post, string $post_type, int $post_id)
{

  //images inside post content
  if (!empty($post["attachments"]) && is_array($post["attachments"])) {
    // 1. Replace in content
    $content = $post["content"];

    // Create a lookup of old_url => new_url
    $url_map = [];

    foreach ($post["attachments"] as $attachment) {
      if (empty($attachment["url"])) continue;

      $old_url = $attachment["url"];

      // Upload to media library
      $new_attachment = one_sideload_media_from_url($old_url);
      if ($new_attachment === false) continue;

      $new_url = $new_attachment["file_url"];
      $url_map[$old_url] = [
        'url' => $new_url,
        'attachment_id' => $new_attachment['attachment_id'],
      ];


      // Replace in content
      $content = str_replace($old_url, $new_url, $content);
    }


    $post["content"] = $content;

    // 2. Replace in _elementor_data
    if (!empty($post["meta"]["_elementor_data"])) {
      $raw = $post["meta"]["_elementor_data"];
      $decoded = is_string($raw) ? json_decode($raw, true) : $raw;

      if (is_array($decoded)) {
        $updated = recursively_replace_urls($decoded, $url_map);

        // var_dump($updated);
        $post["meta"]["_elementor_data"] = $updated;
      }
    }
  }


  //images in feature image or thumbnails
  if (isset($post["thumbnail"]) && !empty($post["thumbnail"]["url"])) {
    //upload to media directory
    $attachment = one_sideload_media_from_url($post["thumbnail"]["url"]);
    if ($attachment != false) {
      //update meta `_thumbnail_id` so this post thumbnail point this new image 
      $post["meta"]["_thumbnail_id"] = ["{$attachment['attachment_id']}"];
    };
  }

  $result = $post_id;

  if (is_wp_error($result)) {
    error_log("post insert fail id:-->{$post['id']}");
  }

  restore_post_meta($result, $post["meta"]);

  //if front page  or blog page update option
  foreach (["page_on_front", "page_for_posts"] as $key) {
    if (isset($post[$key]) && !empty($post[$key])) {
      update_option("page_on_front", $result);
    }
  }


  if (!empty($post["meta"]["_elementor_data"])) {
    $elementor_data = is_string($post["meta"]["_elementor_data"])
      ? json_decode($post["meta"]["_elementor_data"], true)
      : $post["meta"]["_elementor_data"];

    $custom_css = '';

    // Recursive walker
    $add_background_css = function ($elements) use (&$add_background_css, &$custom_css) {
      foreach ($elements as $el) {
        if (!empty($el['id']) && !empty($el['settings']['background_image']['url'])) {
          $selector = '.elementor-element.elementor-element-' . $el['id'];
          $url = esc_url_raw($el['settings']['background_image']['url']);
          $custom_css .= "{$selector} { background-image: url('{$url}'); }\n";
        }

        if (!empty($el['elements']) && is_array($el['elements'])) {
          $add_background_css($el['elements']);
        }
      }
    };

    $add_background_css($elementor_data);

    // Generate Elementor’s base CSS
    $css_file = Elementor\Core\Files\CSS\Post::create($result);
    $css_file->update();

    // Inject our own custom CSS into the generated file
    if (!empty($custom_css)) {
      $upload_dir = wp_upload_dir();
      $css_file_path = trailingslashit($upload_dir['basedir']) . "elementor/css/post-{$result}.css";

      if (file_exists($css_file_path) && is_writable($css_file_path)) {
        $existing_css = file_get_contents($css_file_path);
        $combined_css = $existing_css . "\n/* Custom background image injection */\n" . $custom_css;
        file_put_contents($css_file_path, $combined_css);
      }
    }
  }


  fix_elementor_svg_icons($result);

  return $result;
}

function fix_elementor_svg_icons($post_id)
{
  $meta = get_post_meta($post_id, '_elementor_data', true);
  $data = is_array($meta) ? $meta : json_decode($meta, true);

  if (!is_array($data)) return;

  $updated = false;

  $traverse = function (&$elements) use (&$traverse, &$updated) {
    foreach ($elements as &$el) {
      if (isset($el['settings']['selected_icon']) && $el['settings']['selected_icon']['library'] === 'svg') {
        $icon_data = $el['settings']['selected_icon']['value'];

        if (!empty($icon_data['url'])) {
          $attachment = one_sideload_media_from_url($icon_data['url']);
          if ($attachment) {
            $el['settings']['selected_icon']['value'] = [
              'url' => $attachment['file_url'],
              'id' => $attachment['attachment_id']
            ];
            $updated = true;
          }
        }
      }

      if (!empty($el['elements'])) {
        $traverse($el['elements']);
      }
    }
  };

  $traverse($data);

  if ($updated) {
    update_post_meta($post_id, '_elementor_data', wp_slash(json_encode($data)));
  }
}


function bp_demo_import_widgets_from_wie()
{
  $file = plugin_dir_path(__FILE__) . '/demo-data/widgets.wie';

  if (!file_exists($file)) {
    echo '<div class="notice notice-error"><p>widgets.wie file not found.</p></div>';
    return;
  }

  $json = file_get_contents($file);
  $data = json_decode($json, true);

  if (!is_array($data)) {
    echo '<div class="notice notice-error"><p>Invalid .wie file format.</p></div>';
    return;
  }

  $sidebars_widgets = get_option('sidebars_widgets');
  if (!is_array($sidebars_widgets)) $sidebars_widgets = [];

  foreach ($data as $sidebar_id => $widgets) {
    if (!isset($sidebars_widgets[$sidebar_id])) {
      $sidebars_widgets[$sidebar_id] = [];
    }

    foreach ($widgets as $widget_id => $settings) {
      // Extract base widget type and index
      if (preg_match('/^(.+)-(\d+)$/', $widget_id, $matches)) {
        $base_id = $matches[1];
      } else {
        // fallback for block widgets
        $base_id = $widget_id;
      }

      // Prepare and update the widget option
      $widget_option = "widget_{$base_id}";
      $instances = get_option($widget_option, []);
      if (!is_array($instances)) $instances = [];

      // Append new instance
      $instances[] = $settings;
      end($instances); // move internal pointer to last element
      $new_key = key($instances);

      update_option($widget_option, $instances);

      // Add to sidebar_widgets
      $sidebars_widgets[$sidebar_id][] = "{$base_id}-{$new_key}";
    }
  }

  // Important: Ensure required keys exist
  if (!isset($sidebars_widgets['wp_inactive_widgets'])) {
    $sidebars_widgets['wp_inactive_widgets'] = [];
  }

  if (!isset($sidebars_widgets['array_version'])) {
    $sidebars_widgets['array_version'] = 3;
  }

  update_option('sidebars_widgets', $sidebars_widgets);

  // echo '<div class="notice notice-success"><p>Widgets imported from .wie successfully!</p></div>';
}

function bp_demo_import_block_widgets()
{
  $file = plugin_dir_path(__FILE__) . '/demo-data/widget_block.txt';


  if (!file_exists($file)) return;

  $data = file_get_contents($file);
  $block_widgets = @unserialize($data);

  if (!is_array($block_widgets)) {
    echo '<div class="notice notice-error"><p>Invalid block widget format.</p></div>';
    return;
  }

  update_option('widget_block', $block_widgets);

  // echo '<div class="notice notice-success"><p>Block widgets (Gutenberg) imported successfully.</p></div>';
}

function bp_demo_import_blog_posts()
{
  $file = plugin_dir_path(__FILE__) . '/demo-data/blog_posts.json';
  if (!file_exists($file)) {
    echo '<div class="notice notice-error"><p>Blog posts JSON file not found.</p></div>';
    return;
  }

  // Load dependencies required for media_handle_sideload
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $posts = json_decode(file_get_contents($file), true);
  if (!is_array($posts)) {
    echo '<div class="notice notice-error"><p>Invalid blog post JSON format.</p></div>';
    return;
  }

  foreach ($posts as $post_data) {
    $postarr = [
      'post_title'    => $post_data['post_title'],
      'post_content'  => $post_data['post_content'],
      'post_status'   => $post_data['post_status'],
      'post_author'   => $post_data['post_author'],
      'post_date'     => $post_data['post_date'],
      'post_category' => $post_data['post_category'] ?? []
    ];

    $post_id = wp_insert_post($postarr);

    if (!is_wp_error($post_id) && !empty($post_data['featured_image'])) {
      $image_url = esc_url_raw($post_data['featured_image']);
      $tmp = download_url($image_url);

      if (!is_wp_error($tmp)) {
        $filename = basename(parse_url($image_url, PHP_URL_PATH));

        // Get MIME type
        $filetype = wp_check_filetype($filename);

        $file_array = [
          'name'     => $filename,
          'tmp_name' => $tmp,
          'type'     => $filetype['type'] ?? 'image/jpeg' // fallback just in case
        ];

        $attachment_id = media_handle_sideload($file_array, $post_id);

        if (!is_wp_error($attachment_id)) {
          set_post_thumbnail($post_id, $attachment_id);
        } else {
          @unlink($tmp); // Clean up temp file
          error_log('Image sideload error: ' . $attachment_id->get_error_message());
        }
      } else {
        error_log('Download error: ' . $tmp->get_error_message());
      }
    }
  }
  $default_post = get_page_by_title('Hello world!', OBJECT, 'post');
  if ($default_post) {
    wp_delete_post($default_post->ID, true);
  }

  // echo '<div class="notice notice-success"><p>Demo blog posts (with featured images) imported successfully!</p></div>';
}
function bp_demo_enable_groups_component_properly()
{
  // Load BuddyPress global
  $bp = buddypress();

  // Load upgrade and schema functions
  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  require_once $bp->plugin_dir . '/bp-core/admin/bp-core-admin-schema.php';

  // Clone existing components and add 'groups'
  $submitted = get_option('bp-active-components', []);
  if (!isset($submitted['groups'])) {
    $submitted['groups'] = 1;

    // Activate in BP
    $bp->active_components = bp_core_admin_get_active_components_from_submitted_settings($submitted);

    // Install schema and page mappings
    bp_core_install($bp->active_components);
    bp_core_add_page_mappings($bp->active_components);
    bp_update_option('bp-active-components', $bp->active_components);

    // Refresh permalinks
    if (array_intersect_key($bp->active_components, bp_core_get_directory_page_ids('active'))) {
      bp_delete_rewrite_rules();
    }
  }
}

function bp_demo_import_groups()
{

  if (!function_exists('groups_create_group')) {
    echo '<div class="notice notice-error"><p>Groups component not initialized properly. Please reload and try again.</p></div>';
    return;
  }

  $file = plugin_dir_path(__FILE__) . '/demo-data/buddypress_groups.json';
  if (!file_exists($file)) {
    echo '<div class="notice notice-error"><p>Groups JSON file not found.</p></div>';
    return;
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';

  $groups = json_decode(file_get_contents($file), true);
  if (!$groups) {
    echo '<div class="notice notice-error"><p>Invalid groups JSON format.</p></div>';
    return;
  }

  foreach ($groups as $group) {
    $group_id = groups_create_group([
      'creator_id'    => $group['creator_id'],
      'name'          => $group['name'],
      'description'   => $group['description'],
      'status'        => $group['status'],
      'enable_forum'  => false
    ]);

    if (!$group_id) continue;

    // Set created date
    global $wpdb;
    $wpdb->update(
      $wpdb->prefix . 'bp_groups',
      ['date_created' => $group['created_at']],
      ['id' => $group_id]
    );

    // Avatar setup
    $avatar_path = download_url($group['group_image']);
    if (!is_wp_error($avatar_path)) {
      $avatar_dir = bp_core_avatar_upload_path() . "/group-avatars/{$group_id}";
      wp_mkdir_p($avatar_dir);
      $avatar_filename = $avatar_dir . '/' . time() . '-bpfull.jpg';
      rename($avatar_path, $avatar_filename);
    }

    // Thumb setup
    $thumb_path = download_url($group['group_image']);
    if (!is_wp_error($thumb_path)) {
      $avatar_dir = bp_core_avatar_upload_path() . "/group-avatars/{$group_id}";
      wp_mkdir_p($avatar_dir);
      $avatar_filename = $avatar_dir . '/' . time() . '-bpthumb.jpg';
      rename($thumb_path, $avatar_filename);
    }

    // Cover image setup
    $cover_path = download_url($group['cover_image']);
    if (!is_wp_error($cover_path)) {
      $cover_dir = bp_core_avatar_upload_path() . "/buddypress/groups/{$group_id}/cover-image";
      wp_mkdir_p($cover_dir);
      $cover_filename = $cover_dir . '/' . uniqid() . '-bp-cover-image.jpg';
      rename($cover_path, $cover_filename);
    }

    // Add members (excluding creator)
    foreach ($group['members'] as $member_id) {
      if ($member_id != $group['creator_id']) {
        groups_join_group($group_id, $member_id);
      }
    }
  }

  // echo '<div class="notice notice-success"><p>BuddyPress groups imported successfully!</p></div>';
}


function bp_demo_import_customizer()
{
  $file = plugin_dir_path(__FILE__) . '/demo-data/customizer_one.dat';
  if (!file_exists($file)) {
    throw new Exception('Customizer data file not found.');
  }

  $raw = file_get_contents($file);
  if (!$raw) {
    throw new Exception('Customizer data file is empty.');
  }

  $mods = maybe_unserialize($raw);

  if (!is_array($mods)) {
    $trimmed = ltrim($raw);
    if ($trimmed !== '' && $trimmed[0] === '{') {
      $json = json_decode($raw, true);
      if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
        $mods = $json;
      }
    }
  }

  if (!is_array($mods)) {
    $decoded = base64_decode(trim($raw), true);
    if (is_string($decoded) && $decoded !== '') {
      $mods = maybe_unserialize($decoded);
      if (!is_array($mods) && $decoded[0] === '{') {
        $json = json_decode($decoded, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
          $mods = $json;
        }
      }
    }
  }

  if (is_array($mods) && isset($mods['mods']) && is_array($mods['mods'])) {
    $mods = $mods['mods'];
  } elseif (is_array($mods) && isset($mods['theme_mods']) && is_array($mods['theme_mods'])) {
    $mods = $mods['theme_mods'];
  }

  if (!is_array($mods) || empty($mods)) {
    throw new Exception('Invalid Customizer export file. Please use a Customizer Export/Import .dat export (serialized or JSON).');
  }

  unset($mods['nav_menu_locations']);
  foreach ($mods as $mod => $val) {
    set_theme_mod($mod, $val);
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $debug = [
    'custom_logo_before' => (int)get_theme_mod('custom_logo'),
    'custom_logo_after' => null,
    'custom_logo_source' => null,
    'custom_logo_url' => null,
    'custom_logo_error' => null,
  ];

  $upload_mimes_filter = static function ($mimes) {
    if (!is_array($mimes)) {
      $mimes = [];
    }
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
  };

  $wp_check_filetype_filter = static function ($data, $file, $filename, $mimes) {
    $ext = strtolower(pathinfo((string)$filename, PATHINFO_EXTENSION));
    if ($ext === 'svg' || $ext === 'svgz') {
      return [
        'ext' => 'svg',
        'type' => 'image/svg+xml',
        'proper_filename' => false,
      ];
    }
    return $data;
  };

  add_filter('upload_mimes', $upload_mimes_filter, 99, 1);
  add_filter('wp_check_filetype_and_ext', $wp_check_filetype_filter, 99, 4);

  $find_existing_attachment_id_from_url = static function ($url) {
    if (!is_string($url) || $url === '') {
      return 0;
    }
    $parts = wp_parse_url($url);
    $path = isset($parts['path']) && is_string($parts['path']) ? $parts['path'] : '';
    $basename = $path !== '' ? basename($path) : '';
    if ($basename === '') {
      return 0;
    }

    global $wpdb;
    if (!$wpdb) {
      return 0;
    }

    $like = '%' . $wpdb->esc_like($basename) . '%';
    $id = (int)$wpdb->get_var(
      $wpdb->prepare(
        "SELECT p.ID
         FROM {$wpdb->posts} p
         INNER JOIN {$wpdb->postmeta} pm
           ON pm.post_id = p.ID
          AND pm.meta_key = '_wp_attached_file'
         WHERE p.post_type = 'attachment'
           AND pm.meta_value LIKE %s
         ORDER BY p.ID DESC
         LIMIT 1",
        $like
      )
    );
    if ($id > 0) {
      return $id;
    }

    $id = (int)$wpdb->get_var(
      $wpdb->prepare(
        "SELECT p.ID
         FROM {$wpdb->posts} p
         WHERE p.post_type = 'attachment'
           AND p.guid LIKE %s
         ORDER BY p.ID DESC
         LIMIT 1",
        $like
      )
    );
    return $id > 0 ? $id : 0;
  };

  $sideload_image_id = static function ($url, &$error = null) {
    $error = null;
    if (!is_string($url) || $url === '') {
      return 0;
    }
    $url = esc_url_raw($url);
    if ($url === '') {
      return 0;
    }
    $id = media_sideload_image($url, 0, null, 'id');
    if (!is_wp_error($id)) {
      return (int)$id;
    }
    $error = $id->get_error_message();
    if (function_exists('one_sideload_media_from_url')) {
      $attachment = one_sideload_media_from_url($url);
      if (is_array($attachment) && !empty($attachment['attachment_id'])) {
        $error = null;
        return (int)$attachment['attachment_id'];
      }
    }
    return 0;
  };

  $current_logo_id = (int)get_theme_mod('custom_logo');
  $has_current_logo = $current_logo_id > 0 && wp_get_attachment_url($current_logo_id);

  if (!$has_current_logo) {
    $logo_candidates = [];
    if (isset($mods['custom_logo_url']) && is_string($mods['custom_logo_url'])) {
      $logo_candidates[] = $mods['custom_logo_url'];
    }
    if (isset($mods['header_logo_retina']['url']) && is_string($mods['header_logo_retina']['url'])) {
      $logo_candidates[] = $mods['header_logo_retina']['url'];
    }
    if (isset($mods['header_logo_dark']['url']) && is_string($mods['header_logo_dark']['url'])) {
      $logo_candidates[] = $mods['header_logo_dark']['url'];
    }
    if (isset($mods['vertical_nav_v_nav_collapsed_logo']['url']) && is_string($mods['vertical_nav_v_nav_collapsed_logo']['url'])) {
      $logo_candidates[] = $mods['vertical_nav_v_nav_collapsed_logo']['url'];
    }
    $logo_candidates[] = 'https://one.tophivetheme.com/wp-content/uploads/2025/08/fav-2-1.svg';

    foreach ($logo_candidates as $logo_url) {
      $logo_id = $find_existing_attachment_id_from_url($logo_url);
      if ($logo_id > 0) {
        set_theme_mod('custom_logo', $logo_id);
        $debug['custom_logo_source'] = 'existing';
        $debug['custom_logo_url'] = $logo_url;
        break;
      }

      $err = null;
      $logo_id = $sideload_image_id($logo_url, $err);
      if ($logo_id > 0) {
        set_theme_mod('custom_logo', $logo_id);
        $debug['custom_logo_source'] = 'sideload';
        $debug['custom_logo_url'] = $logo_url;
        break;
      }
      if (is_string($err) && $err !== '') {
        $debug['custom_logo_error'] = $err;
      }
    }

    $logo_after_attempt = (int)get_theme_mod('custom_logo');
    if ($logo_after_attempt <= 0 || !wp_get_attachment_url($logo_after_attempt)) {
      $site_name = get_bloginfo('name');
      $label = is_string($site_name) && $site_name !== '' ? $site_name : 'ONE';
      $label = wp_strip_all_tags($label);
      if (function_exists('mb_substr')) {
        $label = mb_substr($label, 0, 16);
      } else {
        $label = substr($label, 0, 16);
      }
      $label_esc = esc_html($label);

      $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="240" height="60" viewBox="0 0 240 60" role="img" aria-label="' . $label_esc . '"><rect width="240" height="60" rx="12" fill="#111827"/><text x="120" y="38" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="26" fill="#ffffff">' . $label_esc . '</text></svg>';
      $upload = wp_upload_bits('one-logo.svg', null, $svg);
      if (is_array($upload) && empty($upload['error']) && !empty($upload['file'])) {
        $attachment_id = wp_insert_attachment([
          'post_mime_type' => 'image/svg+xml',
          'post_title' => $label,
          'post_content' => '',
          'post_status' => 'inherit',
        ], $upload['file']);
        if (!is_wp_error($attachment_id) && $attachment_id) {
          set_theme_mod('custom_logo', (int)$attachment_id);
          $debug['custom_logo_source'] = 'generated';
          $debug['custom_logo_url'] = $upload['url'] ?? null;
          $debug['custom_logo_error'] = null;
        }
      }
    }
  }

  $current_site_icon = (int)get_option('site_icon');
  if ($current_site_icon <= 0 && isset($mods['site_icon_url']) && is_string($mods['site_icon_url'])) {
    $err = null;
    $site_icon_id = $sideload_image_id($mods['site_icon_url'], $err);
    if ($site_icon_id > 0) {
      update_option('site_icon', $site_icon_id);
    }
  }

  remove_filter('upload_mimes', $upload_mimes_filter, 99);
  remove_filter('wp_check_filetype_and_ext', $wp_check_filetype_filter, 99);

  $debug['custom_logo_after'] = (int)get_theme_mod('custom_logo');
  if ($debug['custom_logo_after'] > 0) {
    $fallback_logo_id = (int)$debug['custom_logo_after'];
    $maybe_set_logo_mod = static function ($key) use ($fallback_logo_id) {
      $current = (int)get_theme_mod($key);
      if ($current <= 0) {
        set_theme_mod($key, $fallback_logo_id);
      }
    };
    $maybe_set_logo_mod('header_logo_sticky');
    $maybe_set_logo_mod('header_logo_sticky_retina');
    $maybe_set_logo_mod('header_logo_tran');
    $maybe_set_logo_mod('header_logo_tran_retina');
  }

  $elem_global_data_path = plugin_dir_path(__FILE__) . '/demo-data/elementor-global.json';

  if (file_exists($elem_global_data_path)) {
    $json = file_get_contents($elem_global_data_path);
    $data = json_decode($json, true); // Decode to array

    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
      import_elementor_global_settings($data);
    } else {
      error_log('Elementor global settings JSON is invalid.');
    }
  }

  upgrade_elementor_to_fontawesome_5();

  update_option('one_theme_core_demo_imported', 'yes');
  update_option('elementor_experiment-e_font_icon_svg', 'default');
  update_option('elementor_experiment-e_local_google_fonts', 'default');
  update_option('elementor_unfiltered_files_upload', true);

  $logo_after = (int)$debug['custom_logo_after'];
  $logo_url_after = $logo_after > 0 ? wp_get_attachment_url($logo_after) : '';

  if ($logo_after > 0 && $logo_url_after) {
    return [
      'message' => 'Customizer imported. Logo set (ID ' . $logo_after . ').',
      'logo' => [
        'id' => $logo_after,
        'url' => $logo_url_after,
        'source' => $debug['custom_logo_source'],
      ],
    ];
  }

  return [
    'message' => 'Customizer imported, but logo not set. Current custom_logo=' . (int)get_theme_mod('custom_logo') . '.',
    'logo' => [
      'id' => (int)get_theme_mod('custom_logo'),
      'url' => $logo_url_after,
      'source' => $debug['custom_logo_source'],
      'attempted_url' => $debug['custom_logo_url'],
      'error' => $debug['custom_logo_error'],
    ],
  ];
}

function upgrade_elementor_to_fontawesome_5()
{
  // Remove the upgrade-needed flag
  delete_option('elementor_icon_manager_needs_update');

  // Optionally enable FA4 shim for compatibility
  update_option('elementor_load_fa4_shim', 'yes');

  // Optional: clear Elementor cache to regenerate CSS with updated icons
  if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
  }
}


function import_elementor_global_settings(array $data)
{
  if (!empty($data['elementor_global_settings'])) {
    // Save global settings to current active kit
    $kit_id = get_option('elementor_active_kit');
    if ($kit_id) {
      update_post_meta($kit_id, '_elementor_page_settings', $data['elementor_global_settings']);
    }
  }

  if (!empty($data['elementor_theme_settings'])) {
    $kit_id = get_option('elementor_active_kit');
    if ($kit_id) {
      update_post_meta($kit_id, '_elementor_site_settings', $data['elementor_theme_settings']);
    }
  }

  if (!empty($data['global_css']['post_content'])) {
    // Create new global CSS post
    $css_post_id = wp_insert_post([
      'post_type'    => 'elementor_global_css',
      'post_status'  => 'publish',
      'post_title'   => $data['global_css']['post_title'] ?? 'Global CSS',
      'post_content' => $data['global_css']['post_content'],
    ]);
    if (!is_wp_error($css_post_id)) {
      update_option('elementor_active_kit', $css_post_id);
    }
  }

  // Optional: regenerate global CSS
  if (class_exists('\\Elementor\\Core\\Files\\CSS\\Global_CSS')) {
    \Elementor\Core\Files\CSS\Global_CSS::get_instance()->update();
  }
}


add_filter('image_sideload_extensions', function ($accepted_extensions) {
  $accepted_extensions[] = 'svg';
  return $accepted_extensions;
});





function bp_demo_setup_activity_home()
{
  // Make sure BuddyPress is active and activity component is enabled
  if (function_exists('bp_is_active') && bp_is_active('activity')) {
    $bp_pages = get_option('bp-pages');

    if (!empty($bp_pages['activity'])) {
      $activity_page_id = (int) $bp_pages['activity'];

      update_option('show_on_front', 'page');
      update_option('page_on_front', $activity_page_id);
    } else {
      echo '<div class="notice notice-error"><p>Activity page is not assigned in BuddyPress settings (bp-pages).</p></div>';
    }

    $bp_apperances = 'a:26:{s:12:"avatar_style";i:1;s:15:"user_front_page";i:1;s:14:"user_front_bio";i:0;s:16:"user_nav_display";i:0;s:13:"user_nav_tabs";i:0;s:16:"user_subnav_tabs";i:0;s:14:"user_nav_order";a:0:{}s:14:"members_layout";i:3;s:20:"members_group_layout";i:2;s:22:"members_friends_layout";i:2;s:19:"activity_dir_layout";i:0;s:17:"activity_dir_tabs";i:0;s:18:"members_dir_layout";i:0;s:16:"members_dir_tabs";i:0;s:17:"groups_dir_layout";i:0;s:16:"group_front_page";i:1;s:17:"group_front_boxes";i:1;s:23:"group_front_description";i:0;s:17:"group_nav_display";i:0;s:14:"group_nav_tabs";i:0;s:17:"group_subnav_tabs";i:0;s:18:"groups_create_tabs";i:1;s:15:"group_nav_order";a:0:{}s:13:"groups_layout";i:4;s:15:"groups_dir_tabs";i:0;s:16:"global_alignment";s:9:"alignnone";}';

    $bp_app_arr = unserialize($bp_apperances);

    // Save to wp_options table
    update_option('bp_nouveau_appearance', $bp_app_arr);
  } else {
    // echo '<div class="notice notice-error"><p>BuddyPress or the Activity component is not active.</p></div>';
  }

  create_custom_css_post();

  if (get_option('permalink_structure') !== '/%postname%/') {
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules(); // Regenerate permalinks
  }
}
function create_custom_css_post()
{
  $css_content = <<<CSS
  /* hover-card */
  .hover-card{
      transition: all 0.4s ease;
  }
  .hover-card:hover{
      transform: translateY(-5px);
  }
  
  /* perspective-card */
  .ct-x {
      transform: rotate(-3deg);
  }
  .ct-x:hover {
      transform: perspective(500px) rotateY(calc(3deg * var(--_i, -1)));
      outline-offset: 0.1em;
      transition: 0.3s;
  }
  .ct-y {
      transform: rotate(3deg);
  }
  .ct-xy {
      transform: rotate(-3deg);
  }
  
  /* card-carousel-slider */
  .uai-scroll-horizontal-inner {
    padding-block: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem !important;
  }
  
  .uai-scroll-horizentall-con {
    overflow: hidden !important;
    -webkit-mask: linear-gradient(
      90deg,
      transparent,
      white 20%,
      white 80%,
      transparent
    );
    mask: linear-gradient(90deg, transparent, white 20%, white 80%, transparent);
  }
  
  .uai-scroll-horizentall-con .uai-scroll-horizontal-inner {
    width: max-content !important;
    flex-wrap: nowrap !important;
    animation: uai_hr_scroll var(--_animation-duration, 40s)
      var(--_animation-direction, forwards) linear infinite;
  }
  
  .scroll_to_right{
      animation-direction: reverse !important;
  }
  @keyframes uai_hr_scroll {
    to {
      transform: translate(calc(-50% - 0.5rem));
    }
  }
  
  .selector svg{
      animation: rotate 20s linear infinite;
  }
  @-webkit-keyframes rotate {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  @keyframes rotate {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  CSS;

  $post_data = [
    'post_title'    => 'Imported Custom CSS',
    'post_content'  => $css_content,
    'post_status'   => 'publish',
    'post_type'     => 'custom_css',
    'post_author'   => 1,
  ];

  $post_id = wp_insert_post($post_data);

  if (!is_wp_error($post_id)) {
    echo "Custom CSS post created with ID: {$post_id}";
    set_theme_mod('custom_css_post_id', $post_id);
  } else {
    error_log('Failed to create custom_css post: ' . $post_id->get_error_message());
  }
}

/**
 * Create media pages (Photos, Videos, Documents) with specific templates
 */
function bp_demo_create_media_pages() {
  $media_pages = [
    [
      'title' => 'Photos',
      'slug' => 'photos',
      'template' => 'page-images.php',
      'content' => 'This is the Photos page where users can view and manage their photo galleries.'
    ],
    [
      'title' => 'Videos',
      'slug' => 'videos',
      'template' => 'page-videos.php',
      'content' => 'This is the Videos page where users can view and manage their video collections.'
    ],
    [
      'title' => 'Documents',
      'slug' => 'documents',
      'template' => 'page-documents.php',
      'content' => 'This is the Documents page where users can view and manage their document files.'
    ]
  ];

  $created_pages = [];
  
  foreach ($media_pages as $page_data) {
    // Check if page already exists
    $existing_page = get_page_by_path($page_data['slug']);
    
    if ($existing_page) {
      $created_pages[] = [
        'title' => $page_data['title'],
        'id' => $existing_page->ID,
        'status' => 'already_exists'
      ];
      continue;
    }

    // Create the page
    $page_id = wp_insert_post([
      'post_title' => $page_data['title'],
      'post_name' => $page_data['slug'],
      'post_content' => $page_data['content'],
      'post_status' => 'publish',
      'post_type' => 'page',
      'post_author' => 1,
      'comment_status' => 'closed',
      'ping_status' => 'closed'
    ]);

    if (!is_wp_error($page_id)) {
      // Set the page template
      update_post_meta($page_id, '_wp_page_template', $page_data['template']);
      
      $created_pages[] = [
        'title' => $page_data['title'],
        'id' => $page_id,
        'status' => 'created',
        'url' => get_permalink($page_id)
      ];
    } else {
      $created_pages[] = [
        'title' => $page_data['title'],
        'status' => 'failed',
        'error' => $page_id->get_error_message()
      ];
    }
  }

  return $created_pages;
}
