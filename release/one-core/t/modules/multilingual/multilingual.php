<?php
OneCoreCustomizer()->register_module(
	'OneCoreCustomizer_Module_Multilingual',
	array(
		'name' => __( 'Multilingual Integration', 'tophive-pro' ),
		'desc' => __( 'WPML multilingual plugin support, plus a fully customized language switcher header builder item.', 'tophive-pro' ),
		'doc_link' => '',
		'enable_default' => false,
	)
);


class OneCoreCustomizer_Module_Multilingual extends OneCoreCustomizer_Module_Base {

	static $_instance = null;
	public $key = '';
	public $stylesheet = '';

	function __construct() {
		if ( ! defined( 'WPML_PLUGIN_PATH' ) ) {
			return;
		}

		$this->stylesheet = get_option( 'stylesheet' );
		$this->key = 'tophive_theme_mods_' . $this->stylesheet . '_';

		add_filter( 'wpml_current_language', array( $this, 'current_lang' ) );
		add_filter( 'tophive_setup_lang', array( $this, 'current_lang' ) );

		add_action( 'wp', array( $this, 'load_settings' ), 1000 ); // Must happen before 10 when _wp_customize_include() fires.
		add_action( 'init', array( $this, 'check_redirect' ), 1000 ); // Must happen before 10 when _wp_customize_include() fires.

		add_action( 'admin_init', array( $this, 'load_settings' ), 1000 ); // Must happen before 10 when _wp_customize_include() fires.

		add_action( 'customize_save', array( $this, 'backup_customize_default' ), 2 );
		add_action( 'customize_save_after', array( $this, 'save_settings' ), 1000 );

		if ( is_admin() ) {
			if ( defined( 'WPML_PLUGIN_PATH' ) ) {
				require_once dirname( __FILE__ ) . '/customize.php';
			}
		}

		add_action( 'add_admin_bar_menus', array( $this, 'add_admin_bar_menus' ) );

	}

	function add_admin_bar_menus() {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_customize_menu', 40 );
		add_action( 'admin_bar_menu', array( $this, 'wp_admin_bar_customize_menu' ), 40 );
	}

	/**
	 * Adds the "Customize" link to the Toolbar.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance.
	 * @global WP_Customize_Manager $wp_customize
	 */
	function wp_admin_bar_customize_menu( $wp_admin_bar ) {
		global $wp_customize;

		// Don't show for users who can't access the customizer or when in the admin.
		if ( ! current_user_can( 'customize' ) || is_admin() ) {
			return;
		}

		// Don't show if the user cannot edit a given customize_changeset post currently being previewed.
		if ( is_customize_preview() && $wp_customize->changeset_post_id() && ! current_user_can( get_post_type_object( 'customize_changeset' )->cap->edit_post, $wp_customize->changeset_post_id() ) ) {
			return;
		}

		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		if ( is_customize_preview() && $wp_customize->changeset_uuid() ) {
			$current_url = remove_query_arg( 'customize_changeset_uuid', $current_url );
		}

		global $sitepress;
		$language = $sitepress->get_current_language();

		$customize_url = add_query_arg( 'url', urlencode( $current_url ), wp_customize_url() );
		$customize_url = add_query_arg( 'lang', $language, $customize_url );
		if ( is_customize_preview() ) {
			$customize_url = add_query_arg( array( 'changeset_uuid' => $wp_customize->changeset_uuid() ), $customize_url );
		}

		$wp_admin_bar->add_menu(
			array(
				'id'     => 'customize',
				'title'  => __( 'Customize', 'tophive-pro' ),
				'href'   => $customize_url,
				'meta'   => array(
					'class' => 'hide-if-no-customize',
				),
			)
		);
		add_action( 'wp_before_admin_bar_render', 'wp_customize_support_script' );
	}

	function check_redirect() {
		if ( is_customize_preview() ) {
			$current_previewing_lang = get_option( 'tophive_pro_customizing_lang' );
			global $sitepress;
			$language = $sitepress->get_current_language();
			if ( $language != $current_previewing_lang ) {
				$url = admin_url( 'customize.php?lang=' . $language );
				if ( isset( $_GET['msid'] ) && isset( $_GET['autofocus'] ) && isset( $_GET['autofocus']['control'] ) && 'multiple_headers' == $_GET['autofocus']['control'] ) {
					$url = admin_url( "customize.php?lang={$language}&msid={$_GET['msid']}&autofocus[control]={$_GET['autofocus']['control']}" ); // @codingStandardsIgnoreLine .
				}
				update_option( 'tophive_pro_customizing_lang', $language );
				ob_start();
				ob_clean();
				ob_start();
				?>
				<script type="text/javascript">
					top.location = <?php echo json_encode( $url ); ?>;
				</script>
				<?php
				die();
			}
		}
	}

	function backup_customize_default( $wp_customize ) {
		// Get options from the Customizer API.
		$data = array();
		$theme = get_option( 'stylesheet' );
		$data['mods'] = get_option( "theme_mods_$theme" );
		$data['options'] = array();

		$settings = $wp_customize->settings();
		foreach ( $settings as $key => $setting ) {
			if ( 'option' == $setting->type ) {
				switch ( $key ) {
					// Ignore these.
					case stristr( $key, 'widget_' ):
					case stristr( $key, 'sidebars_' ):
					case stristr( $key, 'nav_menus_' ):
						// continue.
						break;
					default:
						$data['options'] = get_option( $key );
						break;
				}
			}
		}

		update_option( 'tophive_lang_default_backup', $data );
	}

	function current_lang( $lang_code ) {
		if ( is_customize_preview() ) {
			$lang = get_option( 'tophive_pro_customizing_lang' );
			return $lang;
		}
		return $lang_code;
	}

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function save_settings( $wp_customize ) {

		global $sitepress;
		$language = get_option( 'tophive_pro_customizing_lang' );
		$default_lang = $sitepress->get_default_language();

		// Do not save settings in other option key if current lang is default.
		if ( $language == $default_lang ) {
			return false;
		}

		$data = get_option( $this->key . $language );
		if ( ! is_array( $data ) ) {
			$data = array();
		}
		$data = wp_parse_args(
			$data,
			array(
				'date' => '',
				'mods' => array(),
				'options' => array(),
			)
		);
		$data['date'] = date_i18n( 'Y-m-d H:i:s' );

		if ( empty( $data['mods'] ) ) {
			$data['mods'] = get_theme_mods();
		} else {
			// $data['mods'] = $old_data;
		}

		if ( function_exists( 'wp_get_custom_css_post' ) ) {
			$data['wp_css'] = wp_get_custom_css();
		}

		// Get options from the Customizer API.
		$changeset_setting_ids = $wp_customize->unsanitized_post_values(
			array(
				'exclude_post_data' => true,
				'exclude_changeset' => false,
			)
		);

		if ( isset( $_POST['customized'] ) ) {
			$fields = json_decode( wp_unslash( $_POST['customized'] ), true );
			if ( is_array( $fields ) ) {
				foreach ( $fields as $setting_id => $v ) {
					$changeset_setting_ids[ $setting_id ] = 1;
				}
			}
		}

		// $settings = $wp_customize->settings();
		foreach ( $changeset_setting_ids as $setting_id => $_v ) {
			$setting = $wp_customize->get_setting( $setting_id );
			if ( $setting ) {
				if ( 'option' == $setting->type ) {
					switch ( $setting_id ) {
						// ignore these.
						case stristr( $setting_id, 'widget_' ):
						case stristr( $setting_id, 'sidebars_' ):
						case stristr( $setting_id, 'nav_menus_' ):
							continue 2;
							break;
						default:
							// $data['options'][ $key ] = $setting->value();
							break;
					}
				} else {
					// $data['mods'][ $key ] = $setting->post_value();
					$data['mods'][ $setting_id ] = $setting->post_value();
				}
			}
		}

		// Restore default lang.
		$backup_data = get_option( 'tophive_lang_default_backup' );
		if ( ! is_array( $backup_data ) ) {
			$backup_data = array();
		}

		$backup_data = wp_parse_args(
			$backup_data,
			array(
				'mods' => array(),
				'options' => array(),
			)
		);

		$theme = get_option( 'stylesheet' );
		// Restore theme mods.
		update_option( "theme_mods_$theme", $backup_data['mods'] );

		// Restore options.
		foreach ( (array) $backup_data['options'] as $key => $val ) {
			update_option( $key, $val );
		}

		// Save new settings.
		update_option( $this->key . $language, $data );
	}

	function load_settings() {
		global $sitepress;
		$language = false;

		if ( is_customize_preview() ) {
			$language = isset( $_REQUEST['lang'] ) ? sanitize_text_field( $_REQUEST['lang'] ) : '';
		}
		if ( ! $language ) {
			$language = $sitepress->get_current_language();
		}

		$default_lang = $sitepress->get_default_language();
		if ( $default_lang == $language ) {
			return false;
		}

		$data       = get_option( $this->key . $language, false );
		$data = wp_parse_args(
			$data,
			array(
				'mods' => array(),
				'options' => array(),
			)
		);
		foreach ( (array) $data['mods'] as $k => $val ) {
			add_filter( "theme_mod_{$k}", array( $this, 'filter_theme_mod' ), 25 );
		}
	}

	function filter_theme_mod( $value ) {
		global $sitepress;

		// Previewing not need to filter.
		if ( is_customize_preview() && isset( $_POST['wp_customize'] ) && $_POST['wp_customize'] == 'on' ) {
			return $value;
		}

		// If current language is default language just return value.
		if ( $sitepress->get_current_language() == $sitepress->get_default_language() ) {
			// return $value;
		}

		if ( strpos( current_filter(), 'theme_mod_' ) !== false ) {
			$key = substr( current_filter(), 10 ); // because current filter has prefix is `theme_mod_` 10 characters.

			$language = $sitepress->get_current_language();
			$data = get_option( $this->key . $language, false );
			if ( ! is_array( $data ) ) {
				return $value;
			}
			$data = wp_parse_args(
				$data,
				array(
					'mods' => array(),
				)
			);

			if ( ! is_array( $data['mods'] ) ) {
				return $value;
			}

			if ( isset( $data['mods'][ $key ] ) ) {
				return $data['mods'][ $key ];
			}
		}
		return $value;
	}

}
