<?php
class One_Builder_Header_Multiple {


	public $id = 'multiple_headers';

	function customize() {
		$section = 'multiple_headers';
		return array(
			array(
				'name' => $section,
				'type' => 'section',
				'panel' => 'header_settings',
				'priority' => 0,
				'title'   => __( 'Multiple Headers', 'tophive-pro' ),
			),

			array(
				'name' => 'multiple_headers',
				'type' => 'multiple_sections',
				'builder_id' => 'header',
				'no_setup' => true,
				'section' => $section,
				'theme_supports' => '',
				'title' => __( 'Multiple Headers', 'tophive-pro' ),
				'copy_text' => __( 'Copy settings from current header', 'tophive-pro' ),
				'description' => '',
			),
		);
	}
}

One_Customize_Layout_Builder()->register_item( 'header', 'One_Builder_Header_Multiple' );
