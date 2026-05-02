<?php
class One_Customizer_Control_Multiple_Sections extends One_Customizer_Control_Base {
	public $copy_text = null;
	public $builder_id = null;
	static $_is_loaded = null;
	public function enqueue() {
		if ( is_null( self::$_is_loaded ) ) {
			self::$_is_loaded = true;
			parent::enqueue();
			$suffix = tophive_one()->get_asset_suffix();
			wp_enqueue_style( 'select2', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/css/select2.min.css', array(), false );
			wp_enqueue_style( 'tophive-pro-admin', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/css/admin/admin' . $suffix . '.css', array(), false );

			wp_enqueue_script( 'select2', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/js/select2.min.js', array( 'jquery' ), false );
			wp_enqueue_script( 'tophive-pro-condition', esc_url( OneCoreCustomizer()->get_url() ) . '/assets/js/admin/condition' . $suffix . '.js', array( 'jquery' ), false, true );

			wp_enqueue_script( 'tophive-pro-multiple-sections', esc_url( OneCoreCustomizer()->get_url('/modules/multiple-headers') ) . '/js/control' . $suffix . '.js', array( 'tophive-customizer-control' ), false, true );
			$id = isset( $_REQUEST['msid'] ) ? absint( $_REQUEST['msid'] ) : 0;
			wp_localize_script(
				'tophive-pro-multiple-sections',
				'OneCoreCustomizer_MS',
				array(
					'id' => $id,
					'l10n' => array(
						'multiple_text' => __( 'Multiple Headers', 'tophive-pro' ),
						'display' => __( 'Display Conditions', 'tophive-pro' ),
					),
					'_nonce' => wp_create_nonce( 'tophive_multiple_sections' ),
				)
			);
		}
	}
	public function to_json() {
		parent::to_json();
		$this->json['device_settings'] = false;
		$this->json['copy_text'] = $this->copy_text;
		$this->json['builder_id'] = $this->builder_id;
		$this->json['value'] = '';
	}

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		?>
		<div class="tophive--settings-wrapper">
			<?php if ( $this->label ) { ?>
				<div data-control="<?php echo esc_attr( $this->id ); ?>" class="tophive-control-field-header tophive-field-heading">
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
					</label>
				</div>
			<?php } ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="tophive-field-settings-inner">
				<ul data-builder-id="<?php echo esc_attr( $this->builder_id ); ?>" data-control-id="<?php echo esc_attr( $this->id ); ?>" class="multiple-section-list list-boxed">
					<li><?php _e( 'Loading...', 'tophive-pro' ); ?></li>
				</ul>
				<div class="multiple-section-action">
					<span class="customize-control-title"><?php _e( 'Create New Header', 'tophive-pro' ); ?></span>
					<div class="flex-form">
						<input type="text" placeholder="<?php esc_attr_e( 'Enter name...', 'tophive-pro' ); ?>" data-builder-id="<?php echo esc_attr( $this->builder_id ); ?>" data-control-id="<?php echo esc_attr( $this->id ); ?>" class="new-input-name change-by-js">
					</div>
					<p><label><input type="checkbox" class="new-copy change-by-js" checked><?php echo esc_html( $this->copy_text ); ?></label></p>
					<button type="button"  class="button new-button"><?php _e( 'Add New', 'tophive-pro' ); ?></button>
				</div>
			</div>

		</div>
		<?php
	}

	static function field_template() {

	}
}
