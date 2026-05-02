<?php
OneCoreCustomizer()->register_module(
	'OneCoreCustomizer_Module_Advanced_Styling',
	array()
);

class OneCoreCustomizer_Module_Advanced_Styling extends OneCoreCustomizer_Module_Base {

	function __construct() {
		require_once dirname( __FILE__ ) . '/inc/page-header.php';
		require_once dirname( __FILE__ ) . '/inc/background.php';
		require_once dirname( __FILE__ ) . '/inc/footer-row.php';
	}
}
