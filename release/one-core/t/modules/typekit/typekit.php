<?php
OneCoreCustomizer()->register_module(
	'OneCoreCustomizer_Module_Typekit',
	array()
);

/**
 * Class OneCoreCustomizer_Module_Typekit
 */
class OneCoreCustomizer_Module_Typekit extends OneCoreCustomizer_Module_Base {
	/**
	 * Cache fonts Just load one time
	 *
	 * @var null
	 */
	private $fonts = null;

	function __construct() {
		add_filter( 'tophive/list-fonts', array( $this, 'add_custom_fonts' ), 30 );
		add_filter(
			'tophive/auto-css',
			array(
				$this,
				'maybe_load_custom_fonts',
			),
			99,
			2
		); // Always load typekit on the top of custom code.
		add_action( 'wp_head', array( $this, 'load_use_link_tag' ) );
	}

	/**
	 * Add Typekit font to list
	 *
	 * @param array $fonts
	 *
	 * @return mixed
	 */
	function add_custom_fonts( $fonts ) {
		$data = $this->get_settings();

		$custom_fonts = isset( $data['typekit_fonts'] ) ? $data['typekit_fonts'] : false;
		if ( ! empty( $custom_fonts ) ) {
			$new_fonts['typekit_fonts'] = array(
				'title' => __( 'TypeKit Fonts', 'tophive-pro' ),
				'fonts' => $custom_fonts,
			);

			foreach ( $fonts as $k => $f ) {
				$new_fonts[ $k ] = $f;
			}

			return $new_fonts;
		} else {
			return $fonts;
		}
	}

	function load_use_link_tag() {
		$data = $this->get_settings();
		$type = isset( $data['load_type'] ) ? $data['load_type'] : '';
		if ( ! is_customize_preview() && 'import' == $type ) {
			return;
		}
		$id = isset( $data['kit_id'] ) ? $data['kit_id'] : false;
		if ( $id ) {
			$url = "https://use.typekit.net/{$id}.css";
			?>
			<link rel='stylesheet' id='tophive-typekit-fonts' href='<?php echo esc_url( $url ); ?>' type='text/css' media='all' />
			<?php
		}
	}

	/**
	 * Filter to load custom font
	 *
	 * @param string $code
	 * @param object $class
	 *
	 * @return string
	 */
	function maybe_load_custom_fonts( $code, $class ) {
		$data  = $this->get_settings();
		$id    = isset( $data['kit_id'] ) ? $data['kit_id'] : false;
		$fonts = isset( $data['typekit_fonts'] ) ? $data['typekit_fonts'] : false;
		$type  = isset( $data['load_type'] ) ? $data['load_type'] : '';
		$load  = false;
		if ( is_customize_preview() ) {
			return $code;
		}

		if ( $id && ! empty( $fonts ) ) {
			foreach ( $fonts as $k => $name ) {
				if ( is_array( $class->fonts ) ) {
					if ( isset( $class->fonts[ $k ] ) ) {
						$load = true;
					}
					unset( $class->fonts[ $k ] ); // do not load google font if have same name
				}

				if ( is_array( $class->custom_fonts ) ) {
					if ( isset( $class->custom_fonts[ $k ] ) ) {
						$load = true;
					}
					unset( $class->custom_fonts[ $k ] ); // do not load google font if have same name
				}
			}
		}

		if ( $load && 'import' == $type ) {
			$code = "\r\n/* Tyekit Fonts */\r\n@import url(\"https://use.typekit.net/{$id}.css\");\r\n" . $code;
		}

		return $code;
	}

	function after_save( $class = null ) {

		$data = $this->get_settings();
		if ( ! isset( $data['kit_id'] ) ) {
			$data['kit_id'] = '';
		}

		$kit_id = $data['kit_id'];

		$fonts = $this->parse_fonts( $kit_id );

		if ( false === $fonts ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p><?php echo __( 'Could not load your font file.', 'tophive-pro' ); ?></p>
			</div>
			<?php
			$this->set_key_value( 'typekit_fonts', array() );
		} else {
			$this->set_key_value( 'typekit_fonts', $fonts );
		}

	}

	public function parse_fonts( $kit_id ) {

		$res         = wp_remote_get( "https://use.typekit.net/{$kit_id}.css" );
		$code        = wp_remote_retrieve_response_code( $res );

		if ( 200 != $code ) {
			return false;
		}

		$css_content = $res['body'];

		$fontregex = '/@font-face\s*\{([\s\S][^}]*)}$/mi';
		preg_match_all( $fontregex, $css_content, $matches, PREG_SET_ORDER );
		$fonts = array();

		foreach ( $matches as $m ) {
			if ( isset( $m[1] ) ) {
				$array = explode( ';', $m[1] );
				$array_keys = array();
				foreach ( $array as $v ) {
					$vv = explode( ':', $v );
					$key = strtolower( trim( $vv[0] ) );
					$val = isset( $vv[1] ) ? $vv[1] : false;
					if ( 'font-family' == $key ) {
						$fv = explode( ',', $val );
						$val = trim( $fv[0] );
						$val = str_replace( '"', '', $val );
						$val = str_replace( '\'', '', $val );
					}

					if ( $key && 'src' != $key ) {
						$array_keys[ $key ] = $val;
					}
				}

				$fonts = $this->add_font_to_list( $fonts, $array_keys );

			}
		}

		return $fonts;
	}

	public function add_font_to_list( $fonts, $args ) {
		if ( ! isset( $args['font-family'] ) ) {
			return fonts;
		}

		$name = $args['font-family'];
		$style = isset( $args['font-style'] ) ? $args['font-style'] : false;
		$weight = isset( $args['font-weight'] ) ? $args['font-weight'] : false;

		if ( ! isset( $fonts[ $name ] ) ) {
			$fonts[ $name ] = array(
				'family' => $name,
				'category' => '',
				'variants' => array(),
				'subsets' => array(),
			);
		}

		$v = $weight . $style;

		if ( 400 == $v || '400normal' == $v ) {
			$v = 'regular';
		}

		if ( '400italic' == $v ) {
			$v = 'italic';
		}

		if ( ! in_array( $v, $fonts[ $name ]['variants'] ) ) {
			$fonts[ $name ]['variants'][] = $v;
		}

		return $fonts;
	}


	function after_form() {
		?>
		<br />
		<p class="description">
			<?php _e( 'After add the TypeKit information, you can go to Customizer -> Typography and the new fonts will appear in the Fonts selection dropdown list.', 'tophive-pro' ); ?>
		</p>
		<?php
	}

	function settings() {
		$data = $this->get_settings();

		$html_li = array();
		if ( isset( $data['typekit_fonts'] ) ) {
			foreach ( (array) $data['typekit_fonts'] as $f ) {
				$html_li[] = '<li>' . esc_html( is_string( $f ) ? $f : $f['family'] ) . '</li>';
			}
		}

		if ( ! empty( $html_li ) ) {
			$html_li = join( ' ', $html_li );
			$html_li = '<ul>' . $html_li . '</ul>';
		} else {
			$html_li = '';
		}

		$fields = array(

			array(
				'type'    => 'text',
				'name'    => 'kit_id',
				'label'   => __( 'Typekit Kit ID', 'tophive-pro' ),
				'desc'    => __( 'Paste your Typekit project ID to load your fonts. Click <a target="_blank" href="https://fonts.adobe.com/my_fonts#web_projects-section">here</a> get project ID.', 'tophive-pro' ),
			),
			array(
				'type'    => 'select',
				'name'    => 'load_type',
				'label'   => __( 'Embed', 'tophive-pro' ),
				'desc'    => __( 'Select type how to load Typekit fonts', 'tophive-pro' ),
				'options' => array(
					'link'   => __( 'Default - Use &lt;link&gt;tag to load fonts', 'tophive-pro' ),
					'import' => __( 'Import - Insert link inside &lt;style&gt; tag', 'tophive-pro' ),
				),
			),
		);

		if ( $html_li ) {
			$fields[] = array(
				'type'    => 'html',
				'name'    => 'html_1',
				'title'   => __( 'Fonts', 'tophive-pro' ),
				'content' => $html_li,
			);
		}

		return $fields;

	}

}
