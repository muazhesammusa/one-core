<?php
class OneCoreCustomizer_Module_Hooks_Admin {

	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'metabox' ), 99 );
		add_action( 'save_post', array( $this, 'save_metabox' ) );

		add_action( 'edit_form_after_title', array( $this, 'tabs' ), 5 );
		add_action( 'edit_form_after_editor', array( $this, 'code_editor' ), 5 );

		add_filter( 'manage_' . OneCoreCustomizer_Module_Hooks::get_instance()->post_type . '_posts_columns', array( $this, 'listing_column_head' ), 10 );
		add_action( 'manage_' . OneCoreCustomizer_Module_Hooks::get_instance()->post_type . '_posts_custom_column', array( $this, 'listing_column_content' ), 10, 2 );
		// Remove metaboxes that no longer needed.
		add_action( 'do_meta_boxes', array( $this, 'remove_hook_metaboxes' ) );
	}

	/**
	 *  Remove metaboxes that no longer needed.
	 *
	 * @since 0.0.8
	 *
	 * @return void
	 */
	function remove_hook_metaboxes() {
		remove_meta_box( 'tophive_page_settings', 'tophive_hook', 'normal' );
	}

	function listing_column_head( $columns ) {
		$columns['hook'] = __( 'Hook', 'tophive-pro' );
		$columns['conditionals'] = __( 'Conditionals', 'tophive-pro' );
		$columns['role'] = __( 'User Role', 'tophive-pro' );
		unset( $columns['date'] );
		return $columns;
	}

	function listing_column_content( $column_name, $post_ID ) {
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings( $post_ID );
		switch ( $column_name ) {
			case 'hook':
				echo esc_html( $data['hook'] );
				break;
			case 'role':
				$basic = OneCoreCustomizer_Module_Hooks::get_instance()->get_basic_roles();
				$show = false;
				if ( isset( $basic[ $data['user_role'] ] ) ) {
					echo esc_html( $basic[ $data['user_role'] ] );
					$show = true;
				} else {
					$roles = OneCoreCustomizer_Module_Hooks::get_instance()->get_roles();
					if ( isset( $roles[ $data['user_role'] ] ) ) {
						echo esc_html( $roles[ $data['user_role'] ]['name'] );
						$show = true;
					}
				}

				if ( ! $show ) {
					_e( 'All', 'tophive-pro' );
				}

				break;
			case 'conditionals':
				$labels = array();
				foreach ( (array) $data['conditionals'] as $index => $cond ) {
					$labels[] = '<p>' . $this->readable_condition( $cond ) . '</p>';
				}

				echo join( '', $labels );
				break;
		}
	}

	/**
	 * Helper function to find a condition's readable name from a nested array.
	 *
	 * @param string $sub_name The key to search for.
	 * @param array  $haystack The array to search in.
	 * @return string The found name or an empty string.
	 */
	private function find_condition_name( $sub_name, $haystack ) {
		foreach ( $haystack as $key => $info ) {
			if ( $sub_name == $key && is_string( $info ) ) {
				return $info;
			}

			if ( isset( $info['options'] ) && is_array( $info['options'] ) ) {
				if ( isset( $info['options'][ $sub_name ] ) ) {
					return $info['options'][ $sub_name ];
				}
			}
		}

		return '';
	}

	/**
	 * Convert condition to human readable.
	 *
	 * @since unknown
	 * @since 0.0.8
	 *
	 * @param array $condition
	 * @return string
	 */
	function readable_condition( $condition ) {

		if ( ! is_array( $condition ) || 'general' == $condition['name'] ) {
			return __( 'All', 'tophive-pro' );
		}

		if ( 'archive' == $condition['name'] ) {
			$default = __( 'All Archives', 'tophive-pro' );
			switch ( $condition['sub_name'] ) {
				case 'author':
					return __( 'Author Archive', 'tophive-pro' );
					break;
				case 'date':
					return __( 'Date Archive', 'tophive-pro' );
					break;
				case 'search':
					return __( 'Search Results', 'tophive-pro' );
					break;
				default:
					$archives = OneCoreCustomizer_Conditional::get_instance()->get_all_archive();
					$name     = $this->find_condition_name( $condition['sub_name'], $archives );
					if ( $name ) {
						if ( $condition['sub_id_label'] ) {
							$name .= '/' . $condition['sub_id_label'];
						}
						return $name;
					}

					return $default;
			}
		} elseif ( 'singular' == $condition['name'] ) {

			$default = __( 'All Singular', 'tophive-pro' );

			switch ( $condition['sub_name'] ) {
				case 'front_page':
					return __( 'Front Page', 'tophive-pro' );
					break;
				case 'attachment':
					return __( 'Media', 'tophive-pro' );
					break;
				case 'not_found404':
					return __( '404', 'tophive-pro' );
					break;
				default:
					$all_singular = OneCoreCustomizer_Conditional::get_instance()->get_all_single();
					$name         = $this->find_condition_name( $condition['sub_name'], $all_singular );
					if ( $name ) {
						if ( $condition['sub_id_label'] ) {
							$name .= '/' . $condition['sub_id_label'];
						}

						return $name;
					}

					return $default;
			}
		}

	}

	/**
	 * Display tab settings
	 *
	 * @since 0.0.8
	 *
	 * @return void
	 */
	function tabs() {
		if ( get_post_type() != OneCoreCustomizer_Module_Hooks::get_instance()->post_type ) {
			return;
		}
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();
		?>
		<div id="tophive-hooks-settings-tabs-wrapper" class="nav-tab-wrapper">
			<a class="nav-tab <?php echo 'code' != $data['editor'] ? 'nav-tab-active' : ''; ?>" data-editor="default" href="#"><?php _e( 'Default Editor', 'tophive-pro' ); ?></a>
			<a class="nav-tab <?php echo 'code' == $data['editor'] ? 'nav-tab-active' : ''; ?>" href="#" data-editor="code"><?php _e( 'Code Editor', 'tophive-pro' ); ?></a>
		</div>
		<input type="hidden" id="tophive_current_editor" name="tophive_hook[editor]" value="<?php echo esc_attr( $data['editor'] ); ?>"/>
		<?php
	}

	function code_editor() {
		if ( get_post_type() != OneCoreCustomizer_Module_Hooks::get_instance()->post_type ) {
			return;
		}
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();
		?>
		<div id="hook-script-div">
			<div class="box-inner" id="hook-php-template">
				<div id="hook-php-template">
					<textarea style="width: 100%;" rows="40" name="tophive_hook[code]" id="newcontent_php" aria-describedby="editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4"><?php echo esc_textarea( $data['code'] ); ?></textarea>
				</div>
			</div>
		</div>
		<div id="hook-enable-php">
			<p>
				<label class="post-attributes-label"><input type="checkbox" name="tophive_hook[enable_php]" <?php checked( $data['enable_php'], 1 ); ?> value="1"> <?php _e( 'Enable PHP', 'tophive-pro' ); ?></label>
				<span class="description">
					<?php _e( 'Caution! This use <a target="_blank" href="http://php.net/manual/en/function.eval.php">eval()</a> function, it is very dangerous because it allows execution of arbitrary PHP code. Its use thus is discouraged.', 'tophive-pro' ); ?>
				</span>
			</p>
			<span class="description">
				<?php _e( 'Writing PHP scripts inside PHP tags <code>&lt;?php /* Your code here */ ?&gt;</code>, PHP closing tag is requried.', 'tophive-pro' ); ?>
			</span>
		</div>
		<?php
	}

	/**
	 * Add Meta box
	 */
	function metabox() {

		$post_type = OneCoreCustomizer_Module_Hooks::get_instance()->post_type;

		add_meta_box( 'hooks-list-div', __( 'Hook Settings', 'tophive-pro' ), array( $this, 'metabox_hooks_list' ), $post_type, 'advanced', 'high' );
		add_meta_box( 'hook-conditional-div', __( 'Conditionals', 'tophive-pro' ), array( $this, 'metabox_conditional' ), $post_type );
		add_meta_box( 'hook-roles-div', __( 'User Roles', 'tophive-pro' ), array( $this, 'metabox_roles' ), $post_type );

		remove_meta_box( 'slugdiv', array( $post_type ), 'normal' );
		remove_meta_box( 'tophive_page_settings', array( $post_type ), 'side' );
	}



	function metabox_roles( $post ) {
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();
		$basic = OneCoreCustomizer_Module_Hooks::get_instance()->get_basic_roles();

		?>
		<p>
			<label class="post-attributes-label"><?php _e( 'User Roles', 'tophive-pro' ); ?></label>
			<select name="tophive_hook[user_role]">
				<optgroup label="<?php esc_attr_e( 'Basic', 'tophive-pro' ); ?>">
					<?php foreach ( $basic as  $k => $l ) { ?>
						<option <?php selected( $data['user_role'], $k ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo $l; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="<?php esc_attr_e( 'Advanced', 'tophive-pro' ); ?>">
					<?php foreach ( OneCoreCustomizer_Module_Hooks::get_instance()->get_roles() as  $k => $l ) { ?>
						<option <?php selected( $data['user_role'], $k ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo $l['name']; ?></option>
					<?php } ?>
				</optgroup>
			</select>
		</p>
		<?php
	}

	/**
	 * Display hooks list
	 *
	 * @since unknown
	 * @since 0.0.8
	 *
	 * @param WP_Post $post
	 * @return void
	 */
	function metabox_hooks_list( $post ) {
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();
		?>
		<p class="cmt-align-label">
			<label class="post-attributes-label"><?php _e( 'Hook Location', 'tophive-pro' ); ?></label>

			<span>
			<select class="tophive_hook_name" name="tophive_hook[hook]">
				<option value=""><?php _e( 'Select a hook', 'tophive-pro' ); ?></option>
				<?php foreach ( OneCoreCustomizer_Module_Hooks::get_instance()->get_hook_locations() as $group ) { ?>
					<optgroup label="<?php echo esc_attr( $group['group_label'] ); ?>">
						<?php foreach ( $group['hooks'] as $k => $label ) { ?>
							<option <?php selected( $data['hook'], $k ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $label ); ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
				<option value="__custom" <?php selected( $data['hook'], '__custom' ); ?>><?php _e( 'Custom', 'tophive-pro' ); ?></option>
			</select>
			&nbsp;<a target="_blank" href="<?php echo add_query_arg( array( 'tophive_preview_hook' => '1' ), home_url( '/' ) ); ?>"><?php _e( 'View Hook Positions', 'tophive-pro' ); ?></a>
			</span>

		</p>
		<p class="cmt-align-label custom-hook-input tophive-hide-none">
			<label class="post-attributes-label"><?php _e( 'Custom Hook', 'tophive-pro' ); ?></label>
			<input type="text" name="tophive_hook[custom_hook]" class="input-text" value="<?php echo esc_attr( $data['custom_hook'] ); ?>" placeholder="<?php esc_attr_e( 'Enter your custom hook', 'tophive-pro' ); ?>">
		</p>
		<p class="cmt-align-label">
			<label class="post-attributes-label"><?php _e( 'Priority', 'tophive-pro' ); ?></label>
			<input type="number" name="tophive_hook[priority]" value="<?php echo esc_attr( $data['priority'] ); ?>" placeholder="10" style="width: 50px;">
		</p>
		<?php
	}

	/**
	 * Meta box display
	 *
	 * @param WP_Post $post
	 */
	function metabox_conditional( $post ) {
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();
		wp_nonce_field( 'tophive_hook_nonce', 'tophive_hook_nonce' );
		?>
		<input type="hidden" id="tophive_hook_conditionals" name="tophive_hook[conditionals]" value="<?php echo esc_attr( json_encode( $data['conditionals'] ) ); ?>">
		<div class="hook-conditionals"></div>
		<?php
	}

	function save_metabox( $post_id ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['tophive_hook_nonce'] ) ? $_POST['tophive_hook_nonce'] : '';
		$nonce_action = 'tophive_hook_nonce';

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$data = wp_unslash( $_POST['tophive_hook'] );
		$data['conditionals'] = json_decode( $data['conditionals'], true );

		update_post_meta( $post_id, '_tophive_hook', $data );

	}

	/**
	 * Load Scripts
	 *
	 * @since unknown
	 * @since 0.0.8
	 *
	 * @param string $hook
	 */
	function admin_scripts( $hook ) {

		if ( 'post-new.php' != $hook && 'post.php' != $hook && 'edit.php' != $hook ) {
			return;
		}

		$post_type = OneCoreCustomizer_Module_Hooks::get_instance()->post_type;
		if ( get_post_type() != $post_type ) {
			return;
		}

		OneCoreCustomizer_Module_Hooks::get_instance()->is_assets = true;

		$suffix = tophive_one()->get_asset_suffix();

		/**
		 * @see wp_enqueue_code_editor
		 */
		wp_enqueue_script( 'code-editor' );
		wp_enqueue_style( 'code-editor' );

		$settings_html = wp_enqueue_code_editor(
			array(
				'type' => 'text/html',
				'codemirror' => array(
					'indentUnit' => 2,
					'tabSize' => 2,
				),
			)
		);

		$settings_php = wp_enqueue_code_editor(
			array(
				'type' => 'php',
				'codemirror' => array(
					'indentUnit' => 2,
					'tabSize' => 2,
				),
			)
		);

		$settings_php['codemirror']['gutters'] = $settings_html['codemirror']['gutters'];

		wp_enqueue_script( 'wp-theme-plugin-editor' );
		wp_localize_script(
			'jquery',
			'tophiveHookCodeEditor_config',
			array(
				'html' => $settings_html,
				'php' => $settings_php,
			)
		);

		wp_enqueue_style( 'select2', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/css/select2.min.css', array(), false );
		wp_enqueue_style( 'tophive-pro-admin', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/css/admin/admin' . $suffix . '.css', array(), false );

		wp_enqueue_script( 'select2', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/js/select2.min.js', array( 'jquery' ), false );
		wp_enqueue_script( 'tophive-pro-condition', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/js/admin/condition' . $suffix . '.js', array( 'jquery', 'underscore' ) );

		wp_enqueue_script( 'tophive-pro-hooks', esc_url( OneCoreCustomizer_Module_Hooks::get_instance()->get_url() ) . '/assets/js/admin-script' . $suffix . '.js', array( 'jquery', 'underscore', 'tophive-pro-condition', 'wp-theme-plugin-editor' ) );

		wp_localize_script(
			'jquery',
			'OneCoreCustomizer_Hooks',
			array(
				'_nonce' => wp_create_nonce( 'tophive_pro_hooks' ),
			)
		);

		global $post;
		$data = OneCoreCustomizer_Module_Hooks::get_instance()->get_settings();

		OneCoreCustomizer_Conditional::get_instance()->scripts( $data['conditionals'] );

		add_action( 'admin_footer', array( OneCoreCustomizer_Conditional::get_instance(), 'form_tpl' ) );
	}
}
