<?php

class One_Imports_Controllers
{
  private $API_ROOT = "https://www.tophivetheme.com/wp-json/v1";
  private $API_ENDPOINT = "";
  private $API_ENDPOINT_UPDATE_CHECK = "";
  private $IMPORTER = null;

  function __construct()
  {
    add_action("wp_ajax_tophive/api/templates/{resource_type}", [$this, "get_templates"]);
    add_action("wp_ajax_tophive_import_resource", [$this, "import_resource"]);
    add_action("wp_ajax_tophive_import_plugin", [$this, "import_plugin"]);
    add_filter('site_transient_update_themes', [$this, "check_theme_update"]);

    $this->API_ENDPOINT = "{$this->API_ROOT}/templates/{resource_type}";
    $this->API_ENDPOINT_UPDATE_CHECK  = "{$this->API_ROOT}/product";
  }

  private function restrict_for_admin()
  {
    // Use capability rather than role name for robust permission checks
    if (! \current_user_can('manage_options')) {
      \wp_send_json("Not authorized", 401);
    }
  }

  private function verify_nonce($action = 'one_imports')
  {
    \check_ajax_referer($action, '_wpnonce');
  }

  private function get_product_id_key()
  {
    return get_option("stylesheet") . "_tophive_product_id";
  }

  private function get_licence_key()
  {
    return get_option("stylesheet") . "_tophive_license";
  }

  private function get_product_id()
  {
    return get_option($this->get_product_id_key(), "");
  }

  private function get_licence()
  {
    return get_option($this->get_licence_key(), "");
  }

  public function check_theme_update($transient)
  {
    if (!is_object($transient)) {
      $transient = new stdClass();
    }

    if (!isset($transient->response) || !is_array($transient->response)) {
      $transient->response = [];
    }

    $theme_slug = wp_get_theme()->get_stylesheet();
    $current_version = wp_get_theme($theme_slug)->get('Version');

    $license_value = $this->get_licence();
    $product_id =  $this->get_product_id();
    if (empty($license_value) || empty($product_id)) {
      return $transient;
    }
    $domain = get_site_url();
    $url = "{$this->API_ENDPOINT_UPDATE_CHECK}/{$product_id}?domain={$domain}";
    

    $remote_response  = wp_remote_request($url, [
      "method" => "GET",
      'timeout' => 60,
      "headers" => [
        'Authorization' => $license_value,
        'content-type' => 'application/json',
				'user-agent' => 'OneCore/1.0'
      ],
    ]);

    if (!is_wp_error($remote_response) && wp_remote_retrieve_response_code($remote_response) === 200) {
      $remote_data = json_decode(wp_remote_retrieve_body($remote_response), true)["product"];
      if ($remote_data && version_compare($current_version, $remote_data["version"], '<')) {
        $transient->response[$theme_slug] = [
          'theme'       => $theme_slug,
          'new_version' => $remote_data["version"],
          'url'         => "",
          'package'     => $remote_data["download_url"], // ZIP file URL
        ];
      }
    }

    return $transient;
  }

  public function import_plugin()
  {
    $this->restrict_for_admin();
    $this->verify_nonce();

    if (!isset($_POST["options"]) || empty($_POST["options"])) {
      wp_send_json("options is missing", 400);
    }
    $options = \map_deep($_POST["options"], "sanitize_text_field");
    if (!isset($options["download_link"]) || empty($options["download_link"]) || !isset($options["path"]) || empty($options["path"])) {
      wp_send_json("invalid options", 400);
    }
    $res = $this->IMPORTER->download_and_install_plugin(["download_link" => $options["download_link"], "path" => $options["path"]]);
    if (is_wp_error($res)) {
      wp_send_json("plugin install fail", 400);
    }

    wp_send_json("plugin installed", 200);
  }

  public function _get_templates($options)
  {
    if (empty($options)) {
      return new WP_Error(400, "params missing");
    }

    if (!isset($options["resource_type"]) || empty($options["resource_type"])) {
      return new WP_Error(400, "resource_type cant be blank");
    }

    $resource_type = $options["resource_type"];
    $page = 1;

    if (isset($options["page"]) && !empty($options["page"])) {
      $page = $options["page"];
    }
    $url = str_replace("{resource_type}", $resource_type, $this->API_ENDPOINT) . "?page={$page}";

    if (isset($options["id"]) && !empty($options["id"])) {
      $url .= "&id={$options['id']}";
    }

    //ADD LICENSE ADD PRODUCT_ID
    $license_value = $this->get_licence();
    $product_id = $this->get_product_id();
    if (empty($license_value) || empty($product_id)) {
      return new WP_Error(400, "license required");
    }
    $url .= "&product_id={$product_id}";
    $domain = get_site_url();
    $url .= "&domain={$domain}";

    // Cache by URL to avoid repeated network calls during browsing/imports
    $cache_key = 'one_core_templates_' . md5($url);
    $cached = \get_transient($cache_key);
    if ($cached) {
      return [
        "status_code" => 200,
        "data" => $cached,
      ];
    }

    $res = \wp_remote_request($url, [
      "method" => "GET",
      'timeout' => 60,
      "headers" => [
        'Authorization' => $license_value,
        'content-type' => 'application/json',
      ],
    ]);

    if (\is_wp_error($res)) {
      return new \WP_Error(400, "request fail", $res);
    }

    $status_code = \wp_remote_retrieve_response_code($res);
    $data = json_decode(\wp_remote_retrieve_body($res), true);
    if ($status_code === 200 && is_array($data)) {
      \set_transient($cache_key, $data, 5 * MINUTE_IN_SECONDS);
    }
    return [
      "status_code" => $status_code,
      "data" => $data,
    ];
  }

  public function get_templates()
  {
    $this->restrict_for_admin();
    // Nonce check is optional for GET requests, but consider adding if sensitive.
    $url = str_replace("{resource_type}", 'page', $this->API_ENDPOINT);

    //ADD LICENSE ADD PRODUCT_ID
    $license_value = $this->get_licence();
    $product_id = $this->get_product_id();
    if (empty($license_value) || empty($product_id)) {
      return [];
    }
    
    $url .= "?product_id={$product_id}";
    $domain = get_site_url();
    $url .= "&domain={$domain}";


    $res = wp_remote_request($url, [
      "method" => "GET",
      'timeout' => 60,
      "headers" => [
        'Authorization' => $license_value,
        'content-type' => 'application/json',
      ],
    ]);


    $body = wp_remote_retrieve_body($res);

    $data = json_decode($body, true);

    return $data['templates'] ?? [];
  }

  public function import_resource()
  {
    $this->restrict_for_admin();
    $this->verify_nonce();

    if (!isset($_POST["params"]) || empty($_POST["params"])) {
      wp_send_json("params missing", 400);
    }
    $params = \map_deep($_POST["params"], "sanitize_text_field");

    if (
      empty($params["resource_type"]) || empty($params["id"])
    ) {
      wp_send_json("resource_type or id missing", 400);
    }

    $id = \absint($params["id"]);
    $resource_type = $params["resource_type"];
    $res = $this->_get_templates(["resource_type" => $resource_type, "id" => $id]);

    if (is_wp_error($res)) {
      return wp_send_json([$res->get_error_message(), $res], 400);
    }

    if ($res["status_code"] !== 200) {
      return wp_send_json(["Fetch resource id:{$id} fail", $res], 400);
    }

    if (empty($res["data"]["templates"])) {
      return wp_send_json(["No resource found with id:{$id}", $res], 400);
    }

    $data = json_decode($res["data"]["templates"][0]["json_code"], true);


    //import resource based on their type
    //post,page,customizer,menu,fullsite
    if ($resource_type == "page" || $resource_type == "post") {
      $res = $this->IMPORTER->import_post($data, $resource_type);
      if ($res == false || is_wp_error($res)) {
        wp_send_json(["import fail check error log", $res], 400);
      }
      wp_send_json(["status" => "success", "data" => $res], 200);
    } elseif ($resource_type == "customizer") {
      $res = $this->IMPORTER->import_customizer($data);
      if ($res == false) {
        wp_send_json(["import customizer fail check error log", $res], 400);
      }
      wp_send_json(["status" => "success", "data" => $res], 200);
    } elseif ($resource_type == "menus") {
      $res = $this->IMPORTER->import_menus($data);
      if ($res == false) {
        wp_send_json(["import  menus fail check error log", $res], 400);
      }
      wp_send_json(["status" => "success", "data" => $res], 200);
    } else {
      wp_send_json("unknown resource_type ", 400);
    }
  }
}
