<?php

class OneThemeUpdater{
	private static $instance = null;
	public function __construct(){
		add_action( 'tophive_core_dynamic_update', array( $this, 'themePlaceHolder' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );
		add_action( 'wp_ajax_update_theme', array($this, 'updateTheme') );

	}
	public function admin_scripts(){

		$update = ( $this->getCurrentVersion() > $this->getInstalledVersion() ) ? true : false;

		wp_enqueue_script( 'th-theme-updater', WP_MF_CORE_URL . 'updater/assets/js/script.js', array('jquery') );
		wp_localize_script( 'th-theme-updater', 'th_theme_updater_ajax',
	        array(
	            'ajaxurl' => admin_url( 'admin-ajax.php' ),
	            'btn_text' => esc_html__( 'Update Fundocean', 'ONE_CORE_SLUG' ),
	            'updating' => esc_html__( 'Updating...', 'ONE_CORE_SLUG' ),
	            'update_failed' => esc_html__( 'Theme Update Failed.Please try again after few moments', 'ONE_CORE_SLUG' ),
	            'update_success' => esc_html__( 'Theme Updated Successfully', 'ONE_CORE_SLUG' ),
	            'update_available' => $update,
	            'nonce' => wp_create_nonce( 'update_theme_nonce' ),
	        )
	    );
	}
	private static function getFileUrl(){}
	private static function isThemeActive(){
		$key = get_theme_mod( 'fo_activation_key' );
		if( isset($key) && !empty($key) ){
			$verify = self::verify_purchase_code( get_theme_mod( 'fo_activation_key' ) );
			if( $verify == 'activated' ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	private static function verify_purchase_code( $key ){
		$request = wp_remote_get( 'https://api.tophivetheme.com/themes/one-data.php?type=activation&key=' . $key );
		$body = wp_remote_retrieve_body( $request );
		return $body;
	}
	public function updateTheme(){
		// Capability and nonce checks to prevent unauthorized updates
		if ( ! current_user_can( 'update_themes' ) ) {
			wp_send_json_error( __( 'Unauthorized', 'ONE_CORE_SLUG' ), 403 );
		}

		check_ajax_referer( 'update_theme_nonce' );

		$upload_dir = wp_upload_dir();

		$updated_theme_url = $this->getThemeUrl();

		$theme = $this->downloadTheme( $updated_theme_url );

		$geturl = $this->write_to_file( $theme, $upload_dir['path'] . '/fundocean.zip' );

		$path = get_theme_root();

		$unzip =  unzip_file( $geturl, $path );

		wp_send_json( $unzip );
	}
	private function downloadTheme( $url ){
		if ( empty( $url ) ) {
			return new \WP_Error(
				'missing_url',
				esc_html__( 'Missing Download URL!', 'fundocean' )
			);
		}

		$response = wp_remote_get(
			$url,
			array( 'timeout' => 20 )
		);

		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
			$response_error = $this->get_error_from_response( $response );

			return esc_html__( 'An error occured while downloading theme', 'fundocean' );
		}

		return wp_remote_retrieve_body( $response );
	}
	private function write_to_file( $content, $file_path ) {
		global $wp_filesystem;

		if ( ! $wp_filesystem->put_contents( $file_path, $content ) ) {
			return new \WP_Error(
				'failed_writing_theme_to_server',
				sprintf(
					esc_html__( 'An error occurred while writing file to your server! Tried to write a file to: %s%s.', 'fundocean' ),
					'<br>',
					$file_path
				)
			);
		}

		// Return the file path on successful file write.
		return $file_path;
	}
	public function themePlaceHolder(){
		if( version_compare( $this->getCurrentVersion(), $this->getInstalledVersion(), '>') ){
			?>
				<h3 class="tophive-section-heading"><?php esc_html_e( 'A new version of one is available', 'ONE_CORE_SLUG' ); ?></h3>
				<a href="" class="tophive-admin-big-button tophive-update-theme"><?php esc_html_e( 'Update One', 'ONE_CORE_SLUG' ); ?></a>
				<span class="tophive-messages"></span>
			<?php
		}else{
			?>
				<h1></h1>
				<svg width="8em" height="8em" viewBox="0 0 16 16" class="bi bi-check-circle-fill" fill="#4cd137" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
					</svg>
				<h3 class="tophive-section-heading"><?php esc_html_e( 'Yahoo!! Your theme is up-to-date.', 'fundocean' ) ?></h3>	
			<?php
		}
	}

	public function getInstalledVersion(){
		$tophive_theme_version = wp_get_theme();
		return $tophive_theme_version->get( 'Version' );
	}
	public function getThemeUrl(){
		$key = get_theme_mod( 'fo_activation_key' );
		$request = wp_remote_get( 'https://api.tophivetheme.com/themes/one-data.php?type=theme_data&key=' . $key );
		$body = wp_remote_retrieve_body( $request );
		$theme_data = json_decode($body);
		return $theme_data->theme_url;
	}
	public function getCurrentVersion(){
		// $request = wp_remote_get( 'https://api.tophivetheme.com/themes/one-data.php?type=theme_data' );
		// $body = wp_remote_retrieve_body( $request );
		// $theme_data = json_decode($body);
		return 4.0;
	}
	private static function isUrlValid(){}
	public static function getInstance(){
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
new OneThemeUpdater();
