<?php

class OneCoreCustomizer_Multiple_Options {
	static $_instance;
	private $is_apply = null;
	private $is_apply_backup = null;
	private $options_post_id;
	private $options = array();
	private $cache = array();
	function __construct() {
		$theme_slug = get_option( 'stylesheet' );
		add_action( 'wp', array( $this, 'check_apply' ), 0 );
		if ( ! is_admin() ) {

		} else {
			$this->check_apply();
		}

		/**
		 * @see get_theme_mods
		 * @see get_theme_mod();
		 */
		add_filter( "option_theme_mods_{$theme_slug}", array( $this, 'filter_theme_mods' ), 999 );

	}


	function check_apply() {
		if ( is_customize_preview() || is_admin() ) {
			$id = isset( $_REQUEST['msid'] ) ? absint( $_REQUEST['msid'] ) : get_option( 'tophive_customizing_header' );
			$this->options_post_id = $id;
			$this->setup_options( $this->options_post_id );
			$this->is_apply = $this->options_post_id;
			return $id;
		} else {
			$this->options_post_id = $this->apply( true );
			$this->setup_options( $this->options_post_id );
			$this->is_apply = $this->options_post_id;
			return $this->options_post_id;
		}

	}

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function no_apply() {
		$this->is_apply_backup = $this->is_apply();
		$this->is_apply = false;
	}

	function apply( $force = false ) {
		if ( is_admin() ) {
			return $this->is_apply;
		}
		if ( $force ) {
			$this->is_apply = OneCoreCustomizer_Conditional::get_instance()->is();
			$this->is_apply_backup = $this->is_apply;
			return $this->is_apply;
		}

		if ( $this->is_apply_backup ) {
			return $this->is_apply_backup;
		}
		if ( is_null( $this->is_apply ) ) {
			$this->is_apply = OneCoreCustomizer_Conditional::get_instance()->is();
			$this->is_apply_backup = $this->is_apply;
		}
		return $this->is_apply;
	}

	function setup_options( $options_post_id ) {
		if ( isset( $this->options[ $this->options_post_id ] ) ) {
			return $this->options[ $this->options_post_id ];
		}
		$post = get_post( $options_post_id );
		if ( $post && get_post_type( $post ) == 'tophive_ms' ) {

			$keys = get_post_meta( $options_post_id, '_customize_fields', true );

			if ( ! is_array( $keys ) ) {
				$keys = array();
			}

			$current_lang = '';
			$default_lang = '';

			global $sitepress;
			if ( is_object( $sitepress ) ) {
				$current_lang = $sitepress->get_current_language();
				$default_lang = $sitepress->get_default_language();
			}

			// Save Current Settings.
			$settings = json_decode( $post->post_content, true );
			// For new version use serialize.
			if ( ! $settings ) {
				$settings = maybe_unserialize( $post->post_content, true );
			}

			if ( ! is_array( $settings ) ) {
				$settings = array();
			}

			if ( $default_lang != $current_lang ) {
				$lang_settings = get_post_meta( $post->ID, '_tophive_header_' . $current_lang, true );
				if ( is_array( $lang_settings ) && ! empty( $lang_settings ) ) {
					// Merge to current header settings.
					$settings = wp_parse_args( $lang_settings, $settings );
				}
			}

			if ( empty( $settings ) ) {
				$settings = array();
			}

			if ( is_array( $settings ) && is_array( $keys ) ) {
				$data = array();
				foreach ( $keys as $k => $ov ) {
					if ( isset( $settings[ $k ] ) && $settings[ $k ] !== false ) {
						$data[ $k ] = $settings[ $k ];
					} else {
						$data[ $k ] = null;
					}

					/**
					 * @see get_theme_mod()
					 */
					add_filter( "theme_mod_{$k}", array( $this, 'filter_theme_mod' ), 45 );
				}
				$this->options[ $this->options_post_id ] = $data;
			}
		}
	}

	function is_apply() {
		// $this->is_apply = OneCoreCustomizer_Conditional::get_instance()->is();
		// $this->is_apply_backup = $this->is_apply;
		return $this->is_apply;
	}

	function filter_theme_mod( $value ) {
		if ( true === $this->options_post_id ) {
			return $value;
		}
		if ( $this->is_apply() && $this->options_post_id > 0 ) {

			$key = substr( current_filter(), 10 ); // Because current filter has prefix is `theme_mod_` 10 characters.

			if ( isset( $_POST['wp_customize'], $_POST['customized'] ) && is_customize_preview() ) { // is rendering selective refresh content don't ned filter
				$customized = json_decode( wp_unslash( $_POST['customized'] ), true );
				if ( is_array( $customized ) ) {
					return $value;
				}
			} elseif ( isset( $this->cache[ $this->options_post_id  ] ) ) {

				if ( isset( $this->cache[ $this->options_post_id  ][ $key ] ) ) {
					$value = $this->cache[ $this->options_post_id  ][ $key ];
				}
			}
		}
		return $value;
	}


	/**
	 * @see get_theme_mod()
	 *
	 * @param array $values
	 * @return array
	 */
	function filter_theme_mods( $values = array() ) {
		if ( $this->options_post_id === true ) {
			return $values;
		}
		if ( $this->is_apply() ) {
			if ( isset( $this->cache[ $this->options_post_id  ] ) ) {
				return $this->cache[ $this->options_post_id  ];
			}
			if ( isset( $this->options[ $this->options_post_id ] ) ) {
				foreach ( $this->options[ $this->options_post_id ]  as $k => $v ) {

					$values[ $k ] = $v;
				}
				$this->cache[ $this->options_post_id  ] = $values;
			}
		}
		return $values;
	}
}

OneCoreCustomizer_Multiple_Options::get_instance();
